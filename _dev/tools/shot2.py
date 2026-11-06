# usage: shot2.py URL OUT.png W H [full] [waitms]
import sys, asyncio
from playwright.async_api import async_playwright
async def main():
    url, out, w, h = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4])
    full = len(sys.argv) > 5 and sys.argv[5] == 'full'
    wait = int(sys.argv[6]) if len(sys.argv) > 6 else 4500
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        mob = w < 700
        ctx = await b.new_context(viewport={'width': w, 'height': h}, ignore_https_errors=True, device_scale_factor=2 if mob else 1, is_mobile=mob, has_touch=mob)
        pg = await ctx.new_page()
        errs = []
        pg.on('console', lambda m: errs.append(m.type + ': ' + m.text) if m.type in ('error','warning') else None)
        pg.on('pageerror', lambda e: errs.append('PAGEERROR: ' + str(e)))
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua') or host.endswith('lbar.ro'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        try: await pg.goto(url, wait_until='load', timeout=30000)
        except Exception as e: print('goto:', e)
        await pg.mouse.move(-10, -10)
        await pg.wait_for_timeout(wait)
        await pg.screenshot(path=out, full_page=full)
        for e in errs:
            if 'Failed to load resource' not in e: print(e)
        await b.close()
asyncio.run(main())
