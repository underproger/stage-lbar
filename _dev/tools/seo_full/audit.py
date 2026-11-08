# audit.py — сравнение всех страниц эталона: orig/ (исходная база, старые шаблоны) и new/ (текущий стейдж).
# Пишет report.json и печатает сводку.
import json, re, html as H, sys, os
from bs4 import BeautifulSoup
from urllib.parse import urlparse, unquote

ORIG, NEW = '/home/claude/b31/orig', '/home/claude/b31/new'
HOSTS = ('lbar.ro', 'www.lbar.ro', 'stage-lbar.touchit.vinnica.ua')

def norm(s):
    return re.sub(r'\s+', ' ', H.unescape(s or '')).strip()

def path_of(href, base_ctx):
    if not href:
        return None
    href = href.strip()
    if href.startswith(('mailto:', 'tel:', 'javascript:', 'viber:', 'whatsapp:', 'tg:')):
        return href.replace(' ', '')
    if href.startswith('#'):
        return href
    u = urlparse(href)
    if u.netloc and u.netloc not in HOSTS:
        return href  # внешняя
    p = unquote(u.path)
    if not u.netloc and not p.startswith('/'):
        p = ('/ru/' if base_ctx == 'ru' else '/') + p  # <base href> контекста
    return p + (('#' + u.fragment) if u.fragment else '')

def info(src, ctx):
    s = BeautifulSoup(src, 'html.parser')
    def meta(name, attr='name'):
        return [norm(m.get('content')) for m in s.find_all('meta', attrs={attr: name})]
    heads = [(int(h.name[1]), norm(h.get_text())) for h in s.find_all(re.compile(r'^h[1-6]$'))]
    ld = []
    for sc in s.find_all('script', type='application/ld+json'):
        t = sc.string or sc.get_text()
        try:
            ld.append(json.loads(t))
        except Exception:
            ld.append({'_raw_invalid': norm(t)[:200]})
    micro = []
    for e in s.find_all(attrs={'itemprop': True}):
        if e.has_attr('itemscope'):
            v = '[scope ' + (e.get('itemtype') or '') + ']'   # значение вложенного объекта — его собственные свойства
        else:
            v = e.get('content') or e.get('href') or e.get('src') or norm(e.get_text(' '))
        micro.append((e.get('itemprop'), norm(v)))
    faq = []
    for q in s.select('[itemtype*="schema.org/Question"]'):
        n = q.select_one('[itemprop=name]'); t = q.select_one('[itemprop=text]')
        faq.append((norm(n.get_text(' ')) if n else None, norm(t.get_text(' ')) if t else None))
    types = sorted(set(e.get('itemtype') for e in s.find_all(attrs={'itemtype': True})))
    crumbs = [norm(x.get_text()) for x in s.select('[itemtype*="BreadcrumbList"] [itemprop=name]')]
    links = set()
    for a in s.find_all('a', href=True):
        p = path_of(a['href'], ctx)
        if p:
            links.add(p)
    imgs = []
    for im in s.find_all('img'):
        src_ = im.get('src') or ''
        if src_.startswith('data:'):
            continue
        imgs.append((path_of(src_, ctx), im.get('alt')))
    for sc in s(['script', 'style', 'noscript', 'svg']):
        sc.decompose()
    text = norm(s.body.get_text(' ') if s.body else '')
    words = set(w.lower() for w in re.findall(r'[\wăâîșțşţ]{4,}', text, re.U))
    canon = [l.get('href') for l in s.find_all('link', rel='canonical')]
    alt_ = sorted((l.get('hreflang'), l.get('href')) for l in s.find_all('link', rel='alternate') if l.get('hreflang'))
    htm = s.find('html')
    return {
        'title': norm(s.title.get_text()) if s.title else None,
        'description': meta('description'), 'keywords': meta('keywords'), 'robots': meta('robots'),
        'viewport': meta('viewport'), 'og': sorted((m.get('property'), norm(m.get('content'))) for m in s.find_all('meta', property=re.compile('^og:'))),
        'canonical': canon, 'alternate': alt_, 'lang': htm.get('lang') if htm else None,
        'base': [b.get('href') for b in s.find_all('base')],
        'headings': heads, 'faq': faq, 'jsonld': ld, 'micro_types': types, 'micro': sorted(micro), 'crumbs': crumbs,
        'links': links, 'imgs': imgs, 'words': words, 'textlen': len(text),
    }

def strip_host(x):
    return json.loads(json.dumps(x).replace('https://stage-lbar.touchit.vinnica.ua/', 'https://lbar.ro/'))

meta_o = json.load(open(ORIG + '/_meta.json'))
meta_n = json.load(open(NEW + '/_meta.json'))
report = {}
for key in sorted(meta_o):
    mo, mn = meta_o[key], meta_n[key]
    r = {'url': mo['url'].replace('https://lbar.ro', ''), 'status': [mo['status'], mn['status']]}
    if mo['status'] != 200 or mn['status'] != 200:
        if mo['status'] != mn['status'] or mo['location'] != mn['location']:
            r['redirect_diff'] = [mo, mn]
        report[key] = r
        continue
    ctx = key.split('-')[0]
    a = info(open(f'{ORIG}/{key}.html', encoding='utf-8', errors='replace').read(), ctx)
    b = info(open(f'{NEW}/{key}.html', encoding='utf-8', errors='replace').read().replace('https://stage-lbar.touchit.vinnica.ua/', 'https://lbar.ro/'), ctx)
    diff = {}
    for f in ('title', 'description', 'keywords', 'robots', 'viewport', 'og', 'canonical', 'alternate', 'lang', 'base', 'micro_types', 'crumbs', 'faq'):
        va, vb = strip_host(a[f]), strip_host(b[f])
        if va != vb:
            diff[f] = [va, vb]
    if a['headings'] != b['headings']:
        diff['headings'] = [a['headings'], b['headings']]
    ja, jb = strip_host(a['jsonld']), strip_host(b['jsonld'])
    if ja != jb:
        diff['jsonld'] = [ja, jb]
    ma, mb = strip_host(a['micro']), strip_host(b['micro'])
    if ma != mb:
        diff['micro'] = [[x for x in ma if x not in mb], [x for x in mb if x not in ma]]
    la, lb = set(strip_host(sorted(a['links']))), set(strip_host(sorted(b['links'])))
    diff['links_lost'] = sorted(la - lb)
    diff['links_new'] = sorted(lb - la)
    wa, wb = a['words'], b['words']
    diff['words_lost'] = sorted(wa - wb)
    diff['words_new_count'] = len(wb - wa)
    diff['textlen'] = [a['textlen'], b['textlen']]
    ia, ib = a['imgs'], b['imgs']
    diff['img_noalt'] = [sum(1 for x in ia if not (x[1] or '').strip()), sum(1 for x in ib if not (x[1] or '').strip())]
    diff['img_count'] = [len(ia), len(ib)]
    sa = {}; sb = {}
    for src_, alt in ia: sa.setdefault(src_, alt)
    for src_, alt in ib: sb.setdefault(src_, alt)
    diff['img_lost'] = sorted(((k, sa[k] or '') for k in sa if k not in sb), key=str)
    diff['img_alt_changed'] = sorted(((k, sa[k], sb[k]) for k in sa if k in sb and (sa[k] or '').strip() != (sb[k] or '').strip()), key=str)
    diff['h1_count'] = [sum(1 for h in a['headings'] if h[0] == 1), sum(1 for h in b['headings'] if h[0] == 1)]
    r['diff'] = diff
    report[key] = r

def enc(o):
    if isinstance(o, set):
        return sorted(o)
    raise TypeError
json.dump(report, open('/home/claude/b31/report.json', 'w'), ensure_ascii=False, indent=1, default=enc)
print('pages', len(report))
