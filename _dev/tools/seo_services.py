# Сверка SEO страниц шаблона: снимки HTML до правки против текущего рендера.
# Снимок: pages.tsv (SELECT id, context_key, uri … WHERE template=8) + curl каждой страницы в <id>.html. Запуск: python3 -I seo_services.py ПАПКА
import sys, re, json, subprocess, html as H
from bs4 import BeautifulSoup
BASE = sys.argv[1] if len(sys.argv) > 1 else '/home/claude/b19/base'  # снимки HTML до правки (<id>.html) + pages.tsv (id, контекст, uri)
def norm(s): return re.sub(r'\s+', ' ', H.unescape(s or '')).strip()
def info(src):
    s = BeautifulSoup(src, 'html.parser')
    m = lambda n: norm((s.find('meta', attrs={'name': n}) or {}).get('content', '')) if s.find('meta', attrs={'name': n}) else ''
    crumbs = [norm(x.get_text()) for x in s.select('[itemtype*="BreadcrumbList"] [itemprop=name]')]
    return {
        'title': norm(s.title.get_text() if s.title else ''),
        'description': m('description'), 'robots': m('robots'),
        'canonical': (s.find('link', rel='canonical') or {}).get('href', '') if s.find('link', rel='canonical') else '',
        'hreflang': sorted((l.get('hreflang'), l.get('href')) for l in s.find_all('link', rel='alternate') if l.get('hreflang')),
        'h1': [norm(h.get_text(' ')) for h in s.find_all('h1')],
        'h2': [norm(h.get_text(' ')) for h in s.find_all('h2')],
        'jsonld': len(s.find_all('script', type='application/ld+json')),
        'crumbs': crumbs,
        'links': set(a.get('href') for a in s.find_all('a', href=True)),
    }
bad = 0
for line in open(BASE + '/pages.tsv'):
    pid, ctx, uri = line.rstrip('\n').split('\t')
    if uri.endswith(' '): continue
    url = 'https://stage-lbar.touchit.vinnica.ua/' + ('ru/' if ctx == 'ru' else '') + uri
    new = subprocess.run(['curl', '-sk', '--noproxy', '*', url], capture_output=True, text=True).stdout
    a, b = info(open(f'{BASE}/{pid}.html', encoding='utf-8').read()), info(new)
    diffs = [k for k in a if k != 'links' and a[k] != b[k]]
    lost = sorted(a['links'] - b['links']); added = sorted(b['links'] - a['links'])
    print(pid, 'OK' if not diffs else 'DIFF ' + ', '.join(f"{k}: {a[k]} -> {b[k]}" for k in diffs))
    print('   links lost:', lost[:12], '| new:', len(added))
    bad += bool(diffs)
print('pages with diffs:', bad)
