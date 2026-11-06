# usage: probe.py URL W H "js expression"
import sys, asyncio, json
from playwright.async_api import async_playwright
async def main():
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        ctx = await b.new_context(viewport={'width': int(sys.argv[2]), 'height': int(sys.argv[3])}, ignore_https_errors=True)
        pg = await ctx.new_page()
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua') or host.endswith('lbar.ro'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        await pg.goto(sys.argv[1], wait_until='load'); await pg.wait_for_timeout(4000)
        print(json.dumps(await pg.evaluate(sys.argv[4]), ensure_ascii=False, indent=1))
        await b.close()
asyncio.run(main())
