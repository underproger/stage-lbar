# perf.py W URL... — вес страницы по типам ресурсов, CLS, элемент LCP, картинки без width/height, lazy выше сгиба
import sys, asyncio, json
sys.path.insert(0, '/home/claude/stage-lbar/_dev/tools')
from itiroute import route
from playwright.async_api import async_playwright
async def main():
    w = int(sys.argv[1])
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mob = w < 700
        for u in sys.argv[2:]:
            ctx = await b.new_context(viewport={'width': w, 'height': 844 if mob else 1000}, ignore_https_errors=True, is_mobile=mob, has_touch=mob, device_scale_factor=2 if mob else 1)
            pg = await ctx.new_page(); await pg.route('**/*', route)
            sizes = {}
            async def on_resp(r):
                try:
                    body = await r.body(); t = r.request.resource_type
                    sizes.setdefault(t, [0, 0]); sizes[t][0] += len(body); sizes[t][1] += 1
                except Exception: pass
            pg.on('response', lambda r: asyncio.ensure_future(on_resp(r)))
            await pg.add_init_script("""window.__cls=0;window.__lcp=null;new PerformanceObserver(l=>{for(const e of l.getEntries()){if(!e.hadRecentInput)window.__cls+=e.value}}).observe({type:'layout-shift',buffered:true});new PerformanceObserver(l=>{const e=l.getEntries().pop();window.__lcp=e&&(e.element?(e.element.tagName+'.'+(e.element.className||'').toString().slice(0,40)+' '+(e.url||'').split('/').pop()):e.url)}).observe({type:'largest-contentful-paint',buffered:true});""")
            await pg.goto('https://stage-lbar.touchit.vinnica.ua/' + u, wait_until='load', timeout=60000)
            await pg.wait_for_timeout(2500)
            res = await pg.evaluate("""() => { const H = innerHeight; const noWH=[], lazyTop=[];
              document.querySelectorAll('img').forEach(i => { const r=i.getBoundingClientRect(); if(!r.width) return;
                if(!i.getAttribute('width')||!i.getAttribute('height')) noWH.push((i.currentSrc||i.src).split('/').pop());
                if(i.loading==='lazy' && r.top < H && r.bottom > 0) lazyTop.push((i.currentSrc||i.src).split('/').pop()); });
              return {cls: +window.__cls.toFixed(3), lcp: window.__lcp, noWH: noWH.slice(0,8), noWHn: noWH.length, lazyTop}; }""")
            kb = {k: f"{v[0]//1024}KB/{v[1]}" for k, v in sorted(sizes.items())}
            tot = sum(v[0] for v in sizes.values()) // 1024
            print(f'== {u or "/"} @{w}: total {tot}KB', kb, json.dumps(res, ensure_ascii=False))
            await ctx.close()
        await b.close()
asyncio.run(main())
