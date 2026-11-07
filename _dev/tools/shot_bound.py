# shot_bound.py URL OUT W H SELECTOR — скрин стыка: верх блока SELECTOR по центру экрана (анимации отработаны)
import sys, asyncio
from playwright.async_api import async_playwright
async def main():
    url, out, w, h, sel = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4]), sys.argv[5]
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mob = w < 700
        ctx = await b.new_context(viewport={'width': w, 'height': h}, ignore_https_errors=True, device_scale_factor=2 if mob else 1, is_mobile=mob, has_touch=mob)
        pg = await ctx.new_page()
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        await pg.goto(url, wait_until='load')
        await pg.wait_for_timeout(600)
        for s in ('#lb-about', '#lb-services', '#lb-implica'):
            await pg.evaluate("s=>{const e=document.querySelector(s); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset)}", s)
            await pg.wait_for_timeout(1300)
        await pg.wait_for_timeout(2500)
        await pg.evaluate("s=>{const e=document.querySelector(s); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset - window.innerHeight/2)}", sel)
        await pg.add_style_tag(content='.lb-header{visibility:hidden !important} .lb-hero__bg img{transform:none !important}')
        await pg.wait_for_timeout(1200)
        await pg.screenshot(path=out)
        await b.close()
asyncio.run(main())
