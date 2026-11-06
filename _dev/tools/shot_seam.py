# usage: shot_seam.py URL OUT W H — кадр на стыке #lb-about / #lb-services (анимации доиграны, шапка скрыта)
import sys, asyncio
from playwright.async_api import async_playwright
async def main():
    url, out, w, h = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4])
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mob = w < 700
        ctx = await b.new_context(viewport={'width': w, 'height': h}, ignore_https_errors=True, device_scale_factor=2 if mob else 1, is_mobile=mob, has_touch=mob)
        pg = await ctx.new_page()
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua') or host.endswith('lbar.ro'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        await pg.goto(url, wait_until='load')
        await pg.add_style_tag(content='.lb-header{visibility:hidden !important}')
        for sel in ('#lb-about', '#lb-services'):
            await pg.evaluate("s=>{const e=document.querySelector(s); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset)}", sel)
            await pg.wait_for_timeout(2600)
        await pg.evaluate("()=>{const e=document.querySelector('#lb-services'); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset - innerHeight/2)}")
        await pg.wait_for_timeout(1200)
        await pg.screenshot(path=out)
        await b.close()
asyncio.run(main())
