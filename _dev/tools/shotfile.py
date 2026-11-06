import sys, asyncio
from playwright.async_api import async_playwright
async def main():
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server'])
        pg = await b.new_page(viewport={'width': int(sys.argv[3]) if len(sys.argv)>3 else 1320, 'height': 800})
        await pg.goto(sys.argv[1]); await pg.wait_for_timeout(500)
        await pg.screenshot(path=sys.argv[2], full_page=True); await b.close()
asyncio.run(main())
