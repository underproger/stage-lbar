import json,re,sys,collections
for f in sys.argv[1:]:
    d=json.load(open(f)); agg=collections.OrderedDict()
    errs=[u for u,v in d.items() if v and v[0]['id']=='ERR']
    for u,vs in d.items():
        for v in vs:
            if v['id']=='ERR': continue
            for n in v['nodes']:
                key=(v['id'], re.sub(r':nth-child\(\d+\)','',re.sub(r'\d+','#',n['t']))[:140])
                a=agg.setdefault(key,{'pages':set(),'h':n['h'][:200],'s':n['s'][:200],'imp':v['impact']})
                a['pages'].add(u[38:] or '/')
    print('=====',f,'pages',len(d),'errors',len(errs), errs[:3])
    for (rid,t),a in sorted(agg.items(), key=lambda x:(x[0][0],-len(x[1]['pages']))):
        print(f"[{rid}] {a['imp']} x{len(a['pages'])} {t}\n     {a['h']}\n     e.g. {sorted(a['pages'])[:4]}")
