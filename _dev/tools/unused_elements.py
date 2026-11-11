#!/usr/bin/env python3
# unused_elements.py — какие чанки и шаблоны сайт реально использует (для чистки перед переносом на прод, шаг 65).
# Корни: шаблоны живых ресурсов, их поля и TV, все сниппеты / плагины / настройки / MIGX / прочие таблицы, свои файлы core/elements.
# Чанк «используется», если его имя встречается в достижимом тексте как вызов: [[$имя]], `имя`, 'имя', @CHUNK имя, getChunk("имя"),
# а в коде / настройках — и "имя". Дальше — по цепочке (содержимое используемого чанка — тоже корень). Только чанки сайта
# (категории пакетов — AjaxForm, FormIt, easyComm, ms2Gallery, mSearch2, miniShop2 … — не трогаем).
# Запуск: python3 _dev/tools/unused_elements.py [база] → JSON в stdout (unused_chunks, unused_tpl, why).
import re, json, os, sys, pymysql
P='Impulse_Digital_X_'
DB=sys.argv[1] if len(sys.argv)>1 else 'lbar'
ROOT=os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
db=pymysql.connect(unix_socket='/run/mysqld/mysqld.sock',user='root',database=DB,charset='utf8mb4')
c=db.cursor(pymysql.cursors.DictCursor)
def rows(q): c.execute(q); return c.fetchall()
SITE_CATS={0,15,17,18,33,44,51,64,67,68,69,89,90,110,119,128}
chunks={r['name']:r for r in rows(f"SELECT id,name,category,snippet,static,static_file FROM {P}site_htmlsnippets")}
for n,r in chunks.items():
    if r['static'] and r['static_file']:
        f=os.path.join(ROOT,r['static_file'])
        if os.path.exists(f): r['snippet']=(r['snippet'] or '')+'\n'+open(f,encoding='utf8',errors='ignore').read()
tpls={r['id']:r for r in rows(f"SELECT id,templatename,content,category FROM {P}site_templates")}
DROP_RES=(191,)  # тестовая страница «Тест» (шаблон «Тестовый шаблон», не опубликована) — удаляется вместе с шаблоном
used_tpl={r['template'] for r in rows(f"SELECT DISTINCT template FROM {P}site_content WHERE deleted=0 AND id NOT IN {DROP_RES + (0,)}")}
roots=[]  # (label, text, strict)  strict=True — HTML/Fenom (без "двойных кавычек"), False — код/настройки
for t in used_tpl:
    if t in tpls: roots.append(('tpl:'+tpls[t]['templatename'], tpls[t]['content'] or '', True))
for r in rows(f"SELECT id,content,introtext,longtitle,description FROM {P}site_content WHERE deleted=0 AND id NOT IN {DROP_RES + (0,)}"):
    roots.append((f"res:{r['id']}", ' '.join(str(r[k] or '') for k in ('content','introtext','longtitle','description')), True))
for r in rows(f"SELECT v.contentid,v.value FROM {P}site_tmplvar_contentvalues v JOIN {P}site_content c ON c.id=v.contentid WHERE c.deleted=0 AND c.id NOT IN {DROP_RES + (0,)}"):
    roots.append((f"tv@{r['contentid']}", r['value'] or '', True))
for r in rows(f"SELECT name,default_text,elements,input_properties,output_properties FROM {P}site_tmplvars"):
    roots.append(('tvdef:'+r['name'], ' '.join(str(r[k] or '') for k in ('default_text','elements','input_properties','output_properties')), False))
for r in rows(f"SELECT name,snippet,properties FROM {P}site_snippets"):
    roots.append(('snip:'+r['name'], (r['snippet'] or '')+' '+str(r['properties'] or ''), False))
for r in rows(f"SELECT name,plugincode,properties FROM {P}site_plugins"):
    roots.append(('plug:'+r['name'], (r['plugincode'] or '')+' '+str(r['properties'] or ''), False))
for q in (f"SELECT CONCAT_WS(' ',`key`,value) t FROM {P}system_settings", f"SELECT CONCAT_WS(' ',`key`,value) t FROM {P}context_setting",
          f"SELECT properties t FROM {P}property_set", f"SELECT CONCAT_WS(' ',`key`,value) t FROM {P}clientconfig_setting",
          f"SELECT value t FROM {P}lexicon_entries"):
    for r in rows(q): roots.append(('cfg', str(r['t'] or ''), False))
c.execute(f"SELECT * FROM {P}migx_configs"); 
for r in c.fetchall(): roots.append(('migx', ' '.join(str(v or '') for v in r.values()), True))
for tbl in ('migx_formtabs','migx_formtab_fields'):
    c.execute(f"SELECT * FROM {P}{tbl}")
    for r in c.fetchall(): roots.append(('migx', ' '.join(str(v or '') for v in r.values()), True))
# все прочие таблицы (свойства веток easyComm, правила seoFilter, настройки пакетов и т.п.) — как код (кавычки любые)
SKIP={'site_htmlsnippets','site_templates','site_content','site_tmplvar_contentvalues','site_tmplvars','site_snippets','site_plugins',
      'stat_online_users','stat_page_statistics','session','manager_log','mse2_words','mse2_intro','formit_forms','ec_messages',
      'lexicon_entries','system_settings','context_setting','property_set','clientconfig_setting','migx_configs','migx_formtabs','migx_formtab_fields',
      'transport_packages','register_messages','ms2_resource_files'}
c.execute("SELECT table_name, column_name FROM information_schema.columns WHERE table_schema=%s AND data_type IN ('text','mediumtext','longtext','varchar','tinytext')", (DB,))
cols={}
for t,col in c.fetchall():
    if t.startswith(P) and t[len(P):] not in SKIP: cols.setdefault(t,[]).append(col)
for t,cl in cols.items():
    c.execute(f"SELECT CONCAT_WS(' ',{','.join('`'+x+'`' for x in cl)}) FROM `{t}`")
    for (txt,) in c.fetchall(): roots.append(('tbl:'+t[len(P):], txt or '', False))
# свои php/tpl вне пакетов (core/elements/**)
for dp,dn,fn in os.walk(os.path.join(ROOT,'core/elements')):
    if dp.endswith('redesign/chunks'): continue  # это содержимое статичных чанков — уже в chunks[...]
    for f in fn:
        if f.endswith(('.php','.tpl','.html')): roots.append(('file:'+f, open(os.path.join(dp,f),encoding='utf8',errors='ignore').read(), False))
NC=r'[A-Za-z0-9_.\-]'
def mentions(name, text, strict):
    e=re.escape(name.rstrip())  # MySQL сравнивает имена без хвостовых пробелов: getChunk('tpl.next') находит «tpl.next »
    pats=[r'\$'+e+r'(?!'+NC+')', r'`'+e+r'`', r"'"+e+r"'", r'@CHUNK\s+'+e+r'(?!'+NC+')', r'(?:getChunk|parseChunk|chunk)\s*\(?\s*"'+e+'"']
    if not strict: pats.append(r'"'+e+r'"')
    return any(re.search(p,text) for p in pats)
# проверено вручную: «header» — ключ массива в сниппете migxHookAftercollectmigxitems, «content» — слово в плагине MobileDetect;
# сами чанки header / content выводит только шаблон «Блог - Результаты поиска» (без страниц) — не используются
FALSE_POS={'header','content'}
used=set(); why={}
queue=list(roots)
site=[n for n,r in chunks.items() if r['category'] in SITE_CATS]
pending=set(site)
while queue:
    lab,text,strict=queue.pop()
    for n in list(pending):
        if n.rstrip() in text and mentions(n,text,strict) and not (n in FALSE_POS and not lab.startswith(('tpl:','chunk:','res:'))):
            pending.discard(n); used.add(n); why[n]=lab
            queue.append(('chunk:'+n, chunks[n]['snippet'] or '', True))
unused=sorted(pending)
# шаблоны
unused_tpl=[(t, tpls[t]['templatename'], tpls[t]['category']) for t in tpls if t not in used_tpl]
print(json.dumps({'unused_chunks':unused,'unused_tpl':[t[1] for t in unused_tpl],'drop_res':list(DROP_RES),'why':why},ensure_ascii=False,indent=1))
