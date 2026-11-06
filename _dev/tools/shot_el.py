# usage: shot_el.py URL OUT.png W H selector [waitms]  — скриншот блока (с прокруткой к нему)
import sys, asyncio
from playwright.async_api import async_playwright
async def main():
    url, out, w, h, sel = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4]), sys.argv[5]
    wait = int(sys.argv[6]) if len(sys.argv) > 6 else 3500
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mob = w < 700
        ctx = await b.new_context(viewport={'width': w, 'height': h}, ignore_https_errors=True, device_scale_factor=2 if mob else 1, is_mobile=mob, has_touch=mob)
        pg = await ctx.new_page()
        errs = []
        pg.on('pageerror', lambda e: errs.append('PAGEERROR: ' + str(e)))
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua') or host.endswith('lbar.ro'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        await pg.goto(url, wait_until='load', timeout=30000)
        await pg.wait_for_timeout(800)
        await pg.evaluate("s=>{const e=document.querySelector(s); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset)}", sel)
        await pg.wait_for_timeout(wait)
        if len(sys.argv) > 7 and sys.argv[7] == 'click':
            await pg.click(sel + ' .lb-about__more'); await pg.wait_for_timeout(1200)
        await pg.add_style_tag(content='.lb-header{visibility:hidden !important} /*hidehdr*/')
        el = await pg.query_selector(sel)
        await el.screenshot(path=out)
        for e in errs:
            if 'intlTelInput' not in e: print(e)
        await b.close()
asyncio.run(main())
