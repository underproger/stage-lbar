# Снимок вычисленных стилей всех элементов (и ::before/::after) страниц → JSON. python3 snap.py OUTDIR W url1 url2 ...
import asyncio, sys, json, os
from playwright.async_api import async_playwright
if __name__=='__main__': OUT=sys.argv[1]; W=int(sys.argv[2]); urls=sys.argv[3:]; os.makedirs(OUT,exist_ok=True)
PROPS=['display','position','top','right','bottom','left','float','clear','width','height','min-width','max-width','min-height','max-height',
'margin-top','margin-right','margin-bottom','margin-left','padding-top','padding-right','padding-bottom','padding-left',
'border-top-width','border-right-width','border-bottom-width','border-left-width','border-top-style','border-top-color','border-radius',
'box-sizing','font-family','font-size','font-weight','font-style','line-height','letter-spacing','text-transform','text-align','text-decoration-line',
'color','background-color','background-image','list-style-type','z-index','overflow-x','overflow-y','white-space','vertical-align',
'flex-direction','flex-wrap','justify-content','align-items','gap','grid-template-columns','object-fit','cursor','outline-style','box-shadow','content']
JS="""(props)=>{const out={};let i=0;
for(const el of document.querySelectorAll('body *')){ if(el.closest('svg')&&el.tagName!=='svg') continue;
 const key=i+++':'+el.tagName.toLowerCase()+(el.id?'#'+el.id:'')+(el.className&&typeof el.className=='string'?'.'+el.className.trim().split(/\\s+/).slice(0,3).join('.'):'');
 for(const ps of [null,'::before','::after']){const cs=getComputedStyle(el,ps); if(ps&&(cs.content==='none'||cs.content==='normal')) continue;
  const v={}; for(const p of props){ if(!ps&&p==='content') continue; v[p]=cs.getPropertyValue(p);} out[key+(ps||'')]=v;}}
return out;}"""
async def main():
    async with async_playwright() as p:
        b=await p.chromium.launch(executable_path='/usr/bin/google-chrome',args=['--no-sandbox','--no-proxy-server','--ignore-certificate-errors'])
        for url in urls:
            ctx=await b.new_context(viewport={'width':W,'height':900},ignore_https_errors=True,is_mobile=W<500,has_touch=W<500,reduced_motion='reduce')
            pg=await ctx.new_page()
            async def route(r):
                u=r.request.url
                if not u.startswith('https://stage-lbar.touchit.vinnica.ua'): await r.abort()
                else: await r.continue_()
            await pg.route('**/*',route)
            await pg.goto('https://stage-lbar.touchit.vinnica.ua/'+url,wait_until='load'); await pg.wait_for_timeout(1000)
            res=await pg.evaluate(JS,PROPS)
            css=await pg.evaluate("[...document.querySelectorAll('link[rel=stylesheet]')].map(l=>l.getAttribute('href'))")
            json.dump({'css':css,'st':res},open(f"{OUT}/{(url or 'home').replace('/','_')}-{W}.json",'w'))
            await ctx.close()
        await b.close()
if __name__ == "__main__": asyncio.run(main())
