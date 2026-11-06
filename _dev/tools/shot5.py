# shot5.py URL OUT W H SELECTOR [wait] [css-file|-] — скрин блока (intl-tel-input подставляется локально)
import sys, asyncio
sys.path.insert(0, __import__('os').path.dirname(__file__))
from itiroute import route
from playwright.async_api import async_playwright
async def main():
    url, out, w, h, sel = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4]), sys.argv[5]
    wait = int(sys.argv[6]) if len(sys.argv) > 6 else 4000
    css = open(sys.argv[7]).read() if len(sys.argv) > 7 and sys.argv[7] != '-' else ''
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mob = w < 700
        ctx = await b.new_context(viewport={'width': w, 'height': h}, ignore_https_errors=True, device_scale_factor=2 if mob else 1, is_mobile=mob, has_touch=mob)
        pg = await ctx.new_page()
        errs = []
        pg.on('pageerror', lambda e: errs.append('PAGEERROR: ' + str(e)))
        await pg.route('**/*', route)
        await pg.goto(url, wait_until='load', timeout=40000)
        if css: await pg.add_style_tag(content=css)
        await pg.wait_for_timeout(800)
        await pg.evaluate("s=>{const e=document.querySelector(s); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset)}", sel)
        await pg.wait_for_timeout(wait)
        await pg.add_style_tag(content='.lb-header{visibility:hidden !important}')
        await pg.mouse.move(5, 5)
        await pg.wait_for_timeout(300)
        el = await pg.query_selector(sel)
        await el.screenshot(path=out)
        for e in errs: print(e)
        await b.close()
asyncio.run(main())
