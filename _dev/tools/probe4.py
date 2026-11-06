import sys, asyncio, json
from playwright.async_api import async_playwright
async def main():
    url, w = sys.argv[1], int(sys.argv[2]); sels = sys.argv[3:]
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        ctx = await b.new_context(viewport={'width': w, 'height': 1080}, ignore_https_errors=True)
        pg = await ctx.new_page()
        async def route(r):
            host = r.request.url.split('/')[2]
            if host.endswith('touchit.vinnica.ua'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        await pg.goto(url, wait_until='load')
        await pg.wait_for_timeout(800)
        await pg.evaluate("()=>{const e=document.querySelector('#lb-implica'); window.scrollTo(0, e.getBoundingClientRect().top+window.pageYOffset)}")
        await pg.wait_for_timeout(4500)
        for sel in sels:
            r = await pg.evaluate("""s=>{const e=document.querySelector(s); if(!e) return null; const c=getComputedStyle(e); const sec=document.querySelector('#lb-implica').getBoundingClientRect(); const r=e.getBoundingClientRect();
              return {color:c.color, bg:c.backgroundImage.slice(0,60), fw:c.fontWeight, fs:c.fontSize, ff:c.fontFamily.slice(0,30), lh:c.lineHeight, ls:c.letterSpacing, x:Math.round(r.left-sec.left), y:Math.round(r.top-sec.top), w:Math.round(r.width), h:Math.round(r.height)}}""", sel)
            print(sel, json.dumps(r, ensure_ascii=False))
        await b.close()
asyncio.run(main())
