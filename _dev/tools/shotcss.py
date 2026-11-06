# shotcss.py URL OUT W H SELECTOR CSSFILE|'-' [wait] — скрин блока с добавленным CSS (для подбора)
import sys, asyncio
from playwright.async_api import async_playwright
async def main():
    url, out, w, h, sel, cssf = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4]), sys.argv[5], sys.argv[6]
    wait = int(sys.argv[7]) if len(sys.argv) > 7 else 3500
    css = open(cssf).read() if cssf != '-' else ''
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mob = w < 700
        ctx = await b.new_context(viewport={'width': w, 'height': h}, ignore_https_errors=True, device_scale_factor=2 if mob else 1, is_mobile=mob, has_touch=mob)
        pg = await ctx.new_page()
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua') or host.endswith('lbar.ro') or host == 'fonts.local': await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        await pg.goto(url, wait_until='load', timeout=30000)
        if css: await pg.add_style_tag(content=css)
        await pg.wait_for_timeout(600)
        await pg.evaluate("s=>{const e=document.querySelector(s); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset)}", sel)
        await pg.wait_for_timeout(wait)
        await pg.add_style_tag(content='.lb-header{visibility:hidden !important}')
        el = await pg.query_selector(sel)
        await el.screenshot(path=out)
        await b.close()
asyncio.run(main())
