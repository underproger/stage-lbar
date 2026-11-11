# crawl_all.py — все опубликованные страницы RO / RU / EN по одной (без параллели) → HTML в папку. python3 crawl_all.py OUTDIR [база]
# все опубликованные страницы RO / RU / EN по одной (без параллели), HTML → папка
import sys, os, re, pymysql, subprocess, hashlib
out=sys.argv[1]; os.makedirs(out,exist_ok=True)
P='Impulse_Digital_X_'
db=pymysql.connect(unix_socket='/run/mysqld/mysqld.sock',user='root',database=sys.argv[2] if len(sys.argv)>2 else 'lbar',charset='utf8mb4'); c=db.cursor()
c.execute(f"SELECT id,context_key,uri,class_key FROM {P}site_content WHERE published=1 AND deleted=0 AND class_key IN ('modDocument','msCategory','msProduct','CollectionContainer') ORDER BY id")
base={'web':'/','ru':'/ru/','en':'/en/'}
import requests, urllib3; urllib3.disable_warnings()
s=requests.Session(); s.trust_env=False
for rid,ctx,uri,ck in c.fetchall():
    u='https://stage-lbar.touchit.vinnica.ua'+base.get(ctx,'/')+(uri or '')
    try:
        r=s.get(u,verify=False,allow_redirects=False,timeout=60)
        open(f"{out}/{ctx}-{rid}.html",'w').write(f"<!--{r.status_code} {u}-->\n"+r.text)
    except Exception as e:
        open(f"{out}/{ctx}-{rid}.html",'w').write(f"<!--ERR {u} {e}-->")
print('done', len(os.listdir(out)))
