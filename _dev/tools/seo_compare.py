# Сравнение SEO главных RO/RU с эталоном (до редизайна)
import json, re, requests, urllib3
from bs4 import BeautifulSoup
urllib3.disable_warnings()
s = requests.Session(); s.trust_env = False
base = json.load(open('/home/claude/stage-lbar/_dev/seo-baseline/seo.json', encoding='utf-8'))
norm = lambda x: re.sub(r'https://(lbar\.ro|stage-lbar\.touchit\.vinnica\.ua)', 'https://SITE', x) if isinstance(x, str) else x
def links(soup, sel):
    out = set()
    for el in soup.select(sel):
        for a in el.select('a[href]'):
            out.add(norm(a['href'].strip()))
    return out
for ctx, url, oldfile in (('web', 'https://stage-lbar.touchit.vinnica.ua/', 'web-root'), ('ru', 'https://stage-lbar.touchit.vinnica.ua/ru/', 'ru-root')):
    old = next(r for r in base if r['ctx'] == ctx and r['id'] == '0')
    html = s.get(url, verify=False).text
    soup = BeautifulSoup(html, 'html.parser')
    new = {
        'title': soup.title.get_text(strip=True),
        'description': [t.get('content') for t in soup.select('meta[name=description]')],
        'robots': [t.get('content') for t in soup.select('meta[name=robots]')],
        'canonical': [norm(t.get('href')) for t in soup.select('link[rel=canonical]')],
        'alternate': sorted(norm(f"{t.get('hreflang')}={t.get('href')}") for t in soup.select('link[rel=alternate][hreflang]')),
        'h1': [t.get_text(' ', strip=True) for t in soup.find_all('h1')],
        'h2': [t.get_text(' ', strip=True) for t in soup.find_all('h2')],
        'jsonld': len(soup.select('script[type="application/ld+json"]')),
        'lang': soup.html.get('lang'),
    }
    print('=====', ctx)
    for k, v in new.items():
        o = old[k]; o = [norm(x) for x in o] if isinstance(o, list) else norm(o)
        print(('OK   ' if o == v else 'DIFF ') + k, '' if o == v else f'\n     было: {o}\n     стало: {v}')
    oldsoup = BeautifulSoup(open(f'/home/claude/stage-lbar/_dev/seo-baseline/html/{oldfile}.html', encoding='utf-8').read(), 'html.parser')
    om = links(oldsoup, 'nav.menu'); nm = links(soup, 'nav.lb-nav')
    print('menu links: было', len(om), 'стало', len(nm), '| пропали:', sorted(om - nm), '| новые:', sorted(nm - om))
    oa = {norm(a['href'].strip()) for a in oldsoup.select('a[href]')}; na = {norm(a['href'].strip()) for a in soup.select('a[href]')}
    print('все ссылки страницы: пропали:', sorted(oa - na)[:20], '| новые:', sorted(na - oa)[:20])
