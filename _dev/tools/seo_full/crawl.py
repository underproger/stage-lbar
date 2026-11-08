# crawl.py OUTDIR HOST — скачать все страницы эталона (seo.json) с хоста HOST (lbar.ro / stage), сохранить HTML и статус
import json, subprocess, sys, os
out, host = sys.argv[1], sys.argv[2]
d = json.load(open('/home/claude/stage-lbar/_dev/seo-baseline/seo.json'))
meta = {}
for i, p in enumerate(d):
    url = p['url'].replace('https://lbar.ro/', f'https://{host}/')
    key = f"{p['ctx']}-{p['id']}" if p['id'] != '0' else f"{p['ctx']}-root"
    r = subprocess.run(['curl', '-sk', '--noproxy', '*', '-o', f'{out}/{key}.html', '-w', '%{http_code} %{redirect_url}', url], capture_output=True, text=True)
    code, _, loc = r.stdout.partition(' ')
    meta[key] = {'url': url, 'status': int(code), 'location': loc.replace(f'https://{host}/', 'https://lbar.ro/') or None}
json.dump(meta, open(f'{out}/_meta.json', 'w'), ensure_ascii=False, indent=1)
print(len(meta), sum(1 for m in meta.values() if m['status'] == 200))
