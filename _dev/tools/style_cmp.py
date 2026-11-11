# style_cmp.py — сравнение снимков style_snap.py: python3 style_cmp.py ДО ПОСЛЕ [сколько отличий печатать]
import json,sys,os,glob
A,B=sys.argv[1:3]; tot=0
for fa in sorted(glob.glob(A+'/*.json')):
    fb=B+'/'+os.path.basename(fa)
    if not os.path.exists(fb): print('MISSING',fb); continue
    a=json.load(open(fa)); b=json.load(open(fb))
    d=[]
    for k,v in a['st'].items():
        if k not in b['st']: d.append((k,'missing')); continue
        dd={p:(v[p],b['st'][k].get(p)) for p in v if v[p]!=b['st'][k].get(p)}
        if dd: d.append((k,dd))
    extra=[k for k in b['st'] if k not in a['st']]
    print(f"== {os.path.basename(fa)}: {len(a['st'])} el, diff {len(d)}, extra {len(extra)}; css {len(a['css'])}->{len(b['css'])}")
    for k,dd in d[:int(sys.argv[3]) if len(sys.argv)>3 else 8]: print('   ',k[:80],json.dumps(dd,ensure_ascii=False)[:260])
    tot+=len(d)+len(extra)
print('TOTAL',tot)
