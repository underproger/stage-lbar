# missing.py — все страницы эталона: какие картинки (img, srcset, фоны из CSS) запрашиваются и отдают 404 на стейдже (локально)
import sys, asyncio, json
sys.path.insert(0, '/home/claude/stage-lbar/_dev/tools')
from itiroute import route
from playwright.async_api import async_playwright
HOST = 'https://stage-lbar.touchit.vinnica.ua/'
meta = json.load(open('/home/claude/b31/new/_meta.json'))
async def main():
    res = {}
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        for w in (1920, 390):
            mob = w < 700
            ctx = await b.new_context(viewport={'width': w, 'height': 1000}, ignore_https_errors=True, is_mobile=mob, has_touch=mob)
            for key, m in sorted(meta.items()):
                if m['status'] != 200: continue
                url = m['url']
                pg = await ctx.new_page(); await pg.route('**/*', route)
                bad = set()
                def on_resp(r):
                    if r.request.resource_type in ('image', 'media') and r.status >= 400 and r.url.startswith(HOST):
                        bad.add(r.url[len(HOST) - 1:].split('?')[0])
                pg.on('response', on_resp)
                try:
                    await pg.goto(url, wait_until='load', timeout=60000)
                    h = await pg.evaluate("document.documentElement.scrollHeight")
                    for y in range(0, h, 900):
                        await pg.evaluate(f"window.scrollTo(0,{y})"); await pg.wait_for_timeout(80)
                    await pg.wait_for_timeout(800)
                    # img без запроса (lazy не сработал) — проверим src напрямую
                    srcs = await pg.evaluate("""() => [...document.querySelectorAll('img')].map(i => i.getAttribute('src')).filter(s => s && !s.startsWith('data:'))""")
                except Exception as e:
                    srcs = []
                res.setdefault(key, {'url': url, 'bad': set(), 'srcs': set()})
                res[key]['bad'] |= bad
                res[key]['srcs'] |= set(srcs)
                await pg.close()
            await ctx.close()
        await b.close()
    json.dump({k: {'url': v['url'], 'bad': sorted(v['bad']), 'srcs': sorted(v['srcs'])} for k, v in res.items()}, open('/home/claude/b31/missing.json', 'w'), ensure_ascii=False, indent=1)
    print(len(res), sum(1 for v in res.values() if v['bad']))
asyncio.run(main())
