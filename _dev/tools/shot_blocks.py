# usage: shot_blocks.py URL PREFIX W H — скрины всех блоков редизайна (анимации доиграны, шапка скрыта), кроме hero (со шапкой)
import sys, asyncio
from playwright.async_api import async_playwright
SEL = ['#lb-hero', '#lb-about', '#lb-services', '#lb-implica', '#lb-consult', '#lb-master']
async def main():
    url, pre, w, h = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4])
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
        await pg.goto(url, wait_until='load'); await pg.wait_for_timeout(4500)
        for sel in SEL:
            await pg.evaluate("s=>{const e=document.querySelector(s); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset)}", sel)
            await pg.wait_for_timeout(2800)
        await pg.evaluate("()=>window.scrollTo(0,0)"); await pg.wait_for_timeout(800)
        await pg.screenshot(path=f'{pre}-hero.png')
        await pg.add_style_tag(content='.lb-header{visibility:hidden !important}')
        for sel in SEL[1:]:
            el = await pg.query_selector(sel)
            await el.scroll_into_view_if_needed(); await pg.wait_for_timeout(400)
            await el.screenshot(path=f'{pre}-{sel[4:]}.png')
        await b.close()
asyncio.run(main())
