import warnings
from bs4 import XMLParsedAsHTMLWarning
warnings.filterwarnings('ignore', category=XMLParsedAsHTMLWarning)
# SEO snapshot of all published resources. usage: seo_crawl.py OUTDIR
import sys, json, subprocess, os, re, hashlib
import requests, urllib3
from bs4 import BeautifulSoup
urllib3.disable_warnings()
out = sys.argv[1]; os.makedirs(out + '/html', exist_ok=True)
P = 'Impulse_Digital_X_'
sql = f"SELECT id,context_key,uri,template,searchable,richtext,class_key,content_type,hidemenu FROM {P}site_content WHERE published=1 AND deleted=0 ORDER BY context_key,id"
rows = ['0\tweb\tNULL\t-\t-\t-\tmodDocument\t-\t-','0\tru\tNULL\t-\t-\t-\tmodDocument\t-\t-'] + subprocess.run(['mysql','--default-character-set=utf8mb4','-N','-B','lbar','-e',sql],capture_output=True,text=True).stdout.strip().split('\n')
s = requests.Session(); s.trust_env = False
res, missing = [], {}
for r in rows:
    id_, ctx, uri, tpl, srch, rt, ck, ct, hm = r.split('\t')
    if ck in ('modWebLink','modSymLink'):
        continue
    base = 'https://lbar.ro/' + ('ru/' if ctx == 'ru' else '')
    url = base + ('' if uri in ('index','index.html','NULL') else requests.utils.quote(uri))
    try:
        resp = s.get(url, verify=False, allow_redirects=False, timeout=60)
    except Exception as e:
        res.append({'id': id_, 'ctx': ctx, 'url': url, 'error': str(e)}); continue
    html = resp.text
    open(f"{out}/html/{ctx}-{id_ if id_!='0' else 'root'}.html", 'w', encoding='utf-8').write(html)
    soup = BeautifulSoup(html, 'html.parser')
    g = lambda sel, attr: [t.get(attr) for t in soup.select(sel)]
    item = {
        'id': id_, 'ctx': ctx, 'uri': uri, 'url': url, 'template': tpl, 'status': resp.status_code,
        'location': resp.headers.get('Location'),
        'title': soup.title.get_text(strip=True) if soup.title else None,
        'description': g('meta[name=description]', 'content'),
        'keywords': g('meta[name=keywords]', 'content'),
        'robots': g('meta[name=robots]', 'content'),
        'canonical': g('link[rel=canonical]', 'href'),
        'alternate': sorted(f"{t.get('hreflang')}={t.get('href')}" for t in soup.select('link[rel=alternate][hreflang]')),
        'og': {t.get('property'): t.get('content') for t in soup.select('meta[property^="og:"]')},
        'h1': [t.get_text(' ', strip=True) for t in soup.find_all('h1')],
        'h2': [t.get_text(' ', strip=True) for t in soup.find_all('h2')],
        'jsonld': len(soup.select('script[type="application/ld+json"]')),
        'lang': soup.html.get('lang') if soup.html else None,
        'text_hash': hashlib.md5(soup.get_text(' ', strip=True).encode()).hexdigest(),
    }
    res.append(item)
    for t in soup.find_all(['img','source','link','script','a']):
        for a in ('src','href','data-src','srcset','data-srcset'):
            v = t.get(a)
            if not v: continue
            for part in v.split(','):
                u = part.strip().split(' ')[0]
                if u.startswith('https://lbar.ro/'): u = u[len('https://lbar.ro'):]
                if u.startswith('//') or re.match(r'^[a-z]+:', u) or u.startswith('#') or not u: continue
                if not u.startswith('/'): u = '/' + u
                u = u.split('?')[0].split('#')[0]
                if re.search(r'\.(jpe?g|png|gif|svg|webp|css|js|woff2?|ttf|pdf|mp4|ico)$', u, re.I):
                    if not os.path.exists('/home/claude/stage-lbar' + requests.utils.unquote(u)):
                        missing.setdefault(u, set()).add(url)
json.dump(res, open(out + '/seo.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
json.dump({k: sorted(v)[:3] for k, v in sorted(missing.items())}, open(out + '/missing-files.json', 'w'), ensure_ascii=False, indent=1)
print('pages', len(res), 'missing files', len(missing))
from collections import Counter
print(Counter(r.get('status') for r in res))
print(Counter('/'.join(k.split('/')[:3]) for k in missing).most_common(30))
