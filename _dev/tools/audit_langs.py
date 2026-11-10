# все опубликованные страницы трёх контекстов (без weblink/служебных): hreflang, lang, canonical, title/description, язык текста
import json,re,subprocess,html as H,collections,sys
from concurrent.futures import ThreadPoolExecutor
q="SELECT id,context_key,uri,template,class_key,searchable FROM Impulse_Digital_X_site_content WHERE published=1 AND deleted=0 AND class_key='modDocument' AND uri NOT LIKE '%.xml'"
rows=[l.split('\t') for l in subprocess.run(['sudo','mysql','-N','-B','lbar','-e',q],capture_output=True,text=True).stdout.strip().split('\n') if l.count('\t')>=5]
BASE='https://stage-lbar.touchit.vinnica.ua/'
def url(r):
    i,c,u=r[0],r[1],r[2]
    pre={'web':'','ru':'ru/','en':'en/'}[c]
    return BASE+pre+u.replace(' ','%20')
def fetch(r):
    u=url(r)
    for _ in range(3):
        p=subprocess.run(['curl','-sk','--noproxy','*','-w','\n%{http_code}',u],capture_output=True,text=True)
        body,_,code=p.stdout.rpartition('\n')
        if code.strip()!='500': break
    if code.strip()=='500': open('/tmp/err500-'+r[0]+'.html','w').write(body)
    return r,u,int(code or 0),body
out={}
with ThreadPoolExecutor(4) as ex:
    for r,u,code,body in ex.map(fetch,rows):
        d={'id':r[0],'ctx':r[1],'tpl':r[3],'searchable':r[5],'code':code}
        if code==200:
            d['lang']=(re.search(r'<html[^>]*\blang="([^"]*)"',body) or [None,None])[1]
            d['title']=H.unescape((re.search(r'<title>(.*?)</title>',body,re.S) or [None,''])[1].strip())
            d['desc']=H.unescape((re.search(r'<meta name="description" content="([^"]*)"',body) or [None,''])[1])
            d['canon']=(re.search(r'<link rel="canonical" href="([^"]*)"',body) or [None,None])[1]
            d['robots']=(re.search(r'<meta name="robots" content="([^"]*)"',body) or [None,None])[1]
            d['alt']=re.findall(r'<link rel="alternate" hreflang="([^"]*)" href="([^"]*)"',body)
            t=re.sub(r'<(script|style|noscript|svg)[^>]*>.*?</\1>',' ',body,flags=re.S)
            t=re.sub(r'<header.*?</header>|<footer.*?</footer>',' ',t,flags=re.S)
            t=H.unescape(re.sub(r'<[^>]+>',' ',t)); t=re.sub(r'\s+',' ',t)
            d['cyr']=len(re.findall(r'[а-яА-ЯёЁ]',t)); d['lat']=len(re.findall(r'[a-zA-ZăâîșțĂÂÎȘȚşţ]',t))
            d['ro_diac']=len(re.findall(r'[ăâîșțĂÂÎȘȚşţ]',t))
            d['h1']=[H.unescape(re.sub(r'<[^>]+>','',x)).strip() for x in re.findall(r'<h1[^>]*>(.*?)</h1>',body,re.S)]
            d['text']=t[:200000]
        out[u]=d
json.dump(out,open('pages.json','w'),ensure_ascii=False)
print(len(out), collections.Counter(v['code'] for v in out.values()))
