# svgshot.py SVG OUT W H [bg] — растеризация SVG в браузере (как на сайте)
import sys, asyncio, os, tempfile
from playwright.async_api import async_playwright
async def main():
    svg, out, w, h = sys.argv[1], sys.argv[2], int(sys.argv[3]), int(sys.argv[4])
    bg = sys.argv[5] if len(sys.argv) > 5 else '#f9f2ed'
    html = os.path.join(tempfile.mkdtemp(), 'v.html')
    open(html, 'w').write(f'<body style="margin:0;background:{bg}"><img src="file://{svg}" style="width:{w}px;height:{h}px;display:block"></body>')
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox', '--allow-file-access-from-files'])
        pg = await (await b.new_context(viewport={'width': w, 'height': h})).new_page()
        await pg.goto('file://' + html)
        await pg.wait_for_timeout(600)
        await pg.screenshot(path=out)
        await b.close()
asyncio.run(main())
