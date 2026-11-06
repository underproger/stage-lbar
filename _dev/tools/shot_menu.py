import sys, asyncio
from playwright.async_api import async_playwright
async def main():
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mode = sys.argv[3]
        if mode == 'mobile':
            ctx = await b.new_context(viewport={'width': 390, 'height': 844}, ignore_https_errors=True, device_scale_factor=2, is_mobile=True, has_touch=True)
        else:
            ctx = await b.new_context(viewport={'width': 1920, 'height': 1080}, ignore_https_errors=True)
        pg = await ctx.new_page()
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua') or host.endswith('lbar.ro'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        await pg.goto(sys.argv[1], wait_until='load'); await pg.wait_for_timeout(3500)
        if mode == 'mobile':
            await pg.click('.lb-header__burger'); await pg.wait_for_timeout(600)
            await pg.click('.lb-mnav .lb-nav__list > li:nth-child(2) > .lb-nav__toggle'); await pg.wait_for_timeout(1200)
        else:
            await pg.hover('.lb-nav__list > li:nth-child(2) > a'); await pg.wait_for_timeout(500)
            await pg.hover('.lb-nav__sub > li:first-child > a'); await pg.wait_for_timeout(700)
        await pg.screenshot(path=sys.argv[2])
        await b.close()
asyncio.run(main())
