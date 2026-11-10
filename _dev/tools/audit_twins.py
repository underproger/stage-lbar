# сверка двойников RO/RU/EN: таблицы цен (MIGX), числа в ключевых TV и тексте страниц
import json,re,subprocess,collections,html as H
def q(sql):
    r=subprocess.run(['sudo','mysql','-N','-B','lbar','-e',sql],capture_output=True,text=True).stdout
    return [l.split('\t') for l in r.split('\n') if l]
links={}
for cid,v in q("SELECT contentid,value FROM Impulse_Digital_X_site_tmplvar_contentvalues WHERE tmplvarid=304"):
    m=dict(x.split(':') for x in v.split(';') if ':' in x)
    links[frozenset(m.items())]=m
groups=list(links.values())
pub={r[0]:r for r in q("SELECT id,context_key,uri,published,deleted,class_key,template FROM Impulse_Digital_X_site_content")}
groups=[g for g in groups if all(i in pub and pub[i][3]=='1' and pub[i][4]=='0' for i in g.values())]
print('групп', len(groups), collections.Counter(len(g) for g in groups))
# MIGX-таблицы цен
tvs=dict((r[1],r[0]) for r in q("SELECT id,name FROM Impulse_Digital_X_site_tmplvars"))
def tv(name,cid):
    r=q(f"SELECT value FROM Impulse_Digital_X_site_tmplvar_contentvalues WHERE tmplvarid={tvs[name]} AND contentid={cid}")
    if not r: return ''
    s=r[0][0]
    return re.sub(r'\\\\u([0-9a-f]{4})',lambda m:chr(int(m.group(1),16)),s).replace('\\\\n','\n').replace('\\\\','\\')
def nums(s): return re.findall(r'\d[\d\s.,]*\d|\d',s)
out=[]
for g in groups:
    for name in ('table-res-bl7','table-bl7','table-bl7-1','table-bl7-2','table-bl7-3'):
        if name not in tvs: continue
        vals={c:tv(name,i) for c,i in g.items()}
        if not any(vals.values()): continue
        rows={}
        for c,v in vals.items():
            try: data=json.loads(v) if v else []
            except Exception: data=None
            if data is None: rows[c]=('BADJSON',); continue
            rows[c]=tuple(tuple(re.sub(r'\s','',x) for x in nums(' | '.join(str(r.get(k,'')) for k in ('col-2','col-3','col-4')))) for r in data)
        if len(set(rows.values()))>1:
            out.append((name,g,rows))
for name,g,rows in out:
    print('==',name,g)
    for c,r in rows.items(): print('   ',c,r)
