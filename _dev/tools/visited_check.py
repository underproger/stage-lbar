# Проверка цветов посещённых ссылок: python3 -I _dev/tools/visited_check.py URL ШИРИНА — пустой {} = посещённые выглядят как обычные
# Эмуляция :visited (headless Chrome посещённые ссылки не подсвечивает): в reset.css и redesign.css «:visited» заменяется
# на класс «.vv» (та же специфичность и место в каскаде), всем ссылкам добавляется класс vv; сравниваем цвета с обычными.
# Ссылки-картинки галереи (lb-gallery__item) без текста — их цвет не виден, в выводе пропускаются, как и скрытые (display:none) — например мобильное меню на десктопе.
import sys, asyncio, json
sys.path.insert(0, '/home/claude/stage-lbar/_dev/tools')
from itiroute import route
from playwright.async_api import async_playwright
import os
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
RESET = open(ROOT + '/assets/templates/css/reset.css').read()
RD = ROOT + '/assets/templates/redesign/css/redesign.css'
async def main():
    url, w = sys.argv[1], int(sys.argv[2])
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        ctx = await b.new_context(viewport={'width': w, 'height': 900}, ignore_https_errors=True)
        pg = await ctx.new_page()
        async def r(rt):
            u = rt.request.url.split('?')[0]
            if u.endswith('/css/reset.css'):
                body = RESET.replace('a:visited{color:#a78e85;}', 'a.vv{color:#a78e85;}')
                await rt.fulfill(status=200, body=body, headers={'content-type': 'text/css'})
            elif u.endswith('/redesign/css/redesign.css'):
                body = open(RD).read().replace(':visited', '.vv')
                await rt.fulfill(status=200, body=body, headers={'content-type': 'text/css'})
            else:
                await route(rt)
        await pg.route('**/*', r)
        await pg.goto(url, wait_until='load', timeout=40000)
        await pg.wait_for_timeout(1500)
        await pg.add_style_tag(content='*,*::before,*::after{transition:none !important}')
        js = """(()=>{const as=[...document.querySelectorAll('a')].filter(a=>(a.closest('[class*="lb-"]')||/lb-/.test(a.className))&&!a.classList.contains('lb-gallery__item')&&a.getClientRects().length>0);
          const before=as.map(a=>[getComputedStyle(a).color, ...[...a.querySelectorAll('*')].slice(0,2).map(e=>getComputedStyle(e).color)]);
          as.forEach(a=>a.classList.add('vv'));
          const out={};
          as.forEach((a,i)=>{const after=[getComputedStyle(a).color, ...[...a.querySelectorAll('*')].slice(0,2).map(e=>getComputedStyle(e).color)];
            if(JSON.stringify(after)!==JSON.stringify(before[i])){const k=(a.className.replace(/\\bvv\\b/,'').trim()||'(no class) in .'+(a.closest('[class*="lb-"]')||{}).className?.split(' ')[0]); out[k]=out[k]||[before[i][0],after[0],0,(before[i][1]||'')+' -> '+(after[1]||'')]; out[k][2]++;}});
          as.forEach(a=>a.classList.remove('vv'));
          return out})()"""
        print(json.dumps(await pg.evaluate(js), ensure_ascii=False, indent=0))
        await b.close()
asyncio.run(main())
