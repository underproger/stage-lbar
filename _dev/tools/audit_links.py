# внутренние ссылки всех страниц: битые (4xx/5xx), на редирект, ссылки EN/RU-страниц на другой язык
import json,re,subprocess,html as H,collections
from urllib.parse import urljoin, urlparse, unquote
from concurrent.futures import ThreadPoolExecutor
d=json.load(open('pages.json'))
B='https://stage-lbar.touchit.vinnica.ua/'
pages={u:v for u,v in d.items() if v['code']==200}
links=collections.defaultdict(set); imgs=collections.defaultdict(set)
def get(u): return u,subprocess.run(['curl','-sk','--noproxy','*',u],capture_output=True,text=True).stdout
with ThreadPoolExecutor(4) as ex:
    for u,body in ex.map(get,pages):
        base=(re.search(r'<base href="([^"]*)"',body) or [None,u])[1]
        for h in re.findall(r'<a\b[^>]*\bhref="([^"#][^"]*)"',body):
            h=H.unescape(h)
            if h.startswith(('mailto:','tel:','viber:','javascript:','whatsapp:')): continue
            a=urljoin(base,h)
            if urlparse(a).netloc==urlparse(B).netloc: links[a.split('#')[0]].add(u)
        for s in re.findall(r'<img\b[^>]*\bsrc="([^"]+)"',body)+re.findall(r'\bsrcset="([^" ,]+)',body):
            a=urljoin(base,H.unescape(s))
            if urlparse(a).netloc==urlparse(B).netloc: imgs[a].add(u)
def code(u):
    r=subprocess.run(['curl','-sk','--noproxy','*','-o','/dev/null','-w','%{http_code} %{redirect_url}',u],capture_output=True,text=True).stdout
    c,_,loc=r.partition(' '); return u,int(c or 0),loc
res={}
with ThreadPoolExecutor(4) as ex:
    for u,c,loc in ex.map(code,list(links)): res[u]=(c,loc)
bad=[(u,c,loc,sorted(links[u])[:3],len(links[u])) for u,(c,loc) in res.items() if c!=200]
print('внутренних ссылок',len(links),'не 200:',len(bad))
for b in sorted(bad,key=lambda x:-x[4]): print('  ',b[1],b[0][38:],'→',b[2][38:] if b[2] else '','| со страниц:',b[4],[x[38:] for x in b[3]])
# межъязыковые ссылки
def lang_of(u):
    p=urlparse(u).path
    return 'ru' if p.startswith('/ru/') or p=='/ru' else ('en' if p.startswith('/en/') or p=='/en' else 'web')
cross=collections.Counter()
for t,src in links.items():
    if res.get(t,(0,))[0]!=200 or t.endswith(('.jpg','.png','.pdf','.webp','.xml')) or '/assets/' in t or '/images/' in t: continue
    for s in src:
        if lang_of(s)!=lang_of(t): cross[(lang_of(s),lang_of(t),t[38:])]+=1
print('межъязыковые ссылки (без переключателя языка — он ведёт на двойник):')
for (a,b,t),n in sorted(cross.items(),key=lambda x:-x[1])[:40]: print('  ',a,'→',b,t,n)
json.dump({'imgs':{k:sorted(v) for k,v in imgs.items()}},open('imgs.json','w'))
