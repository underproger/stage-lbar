# axe.py OUT.json W — axe-core по всем страницам эталона + EN (как PageSpeed: правила Lighthouse)
import asyncio, sys, json
from playwright.async_api import async_playwright
OUT, W = sys.argv[1], int(sys.argv[2])
meta = json.load(open('/home/claude/b57/after/_meta.json'))
urls = [m['url'] for m in meta.values() if m['status'] == 200 and not m['url'].endswith('.xml')]
urls += ['https://stage-lbar.touchit.vinnica.ua/en/' + u for u in ['', 'prices', 'about-us', 'reviews', 'portfolio', 'services', 'eyebrow-micropigmentation', 'laser-hair-removal', 'contact', 'blog']]
if len(sys.argv) > 3: urls = [u for u in urls if any(x in u for x in sys.argv[3].split(','))]
LH = "accesskeys aria-allowed-attr aria-allowed-role aria-command-name aria-conditional-attr aria-deprecated-role aria-dialog-name aria-hidden-body aria-hidden-focus aria-input-field-name aria-meter-name aria-progressbar-name aria-prohibited-attr aria-required-attr aria-required-children aria-required-parent aria-roles aria-text aria-toggle-field-name aria-tooltip-name aria-treeitem-name aria-valid-attr-value aria-valid-attr button-name bypass color-contrast definition-list dlitem document-title duplicate-id-aria empty-heading form-field-multiple-labels frame-title heading-order html-has-lang html-lang-valid html-xml-lang-mismatch identical-links-same-purpose image-alt image-redundant-alt input-button-name input-image-alt label-content-name-mismatch label landmark-one-main link-in-text-block link-name list listitem meta-refresh meta-viewport nested-interactive object-alt select-name skip-link tabindex table-duplicate-name table-fake-caption target-size td-has-header td-headers-attr th-has-data-cells valid-lang video-caption".split()
async def main():
    res = {}
    async with async_playwright() as p:
        b = await p.chromium.launch(executable_path='/usr/bin/google-chrome', args=['--no-sandbox', '--no-proxy-server', '--ignore-certificate-errors'])
        ctx = await b.new_context(viewport={'width': W, 'height': 900}, ignore_https_errors=True, is_mobile=W < 500, has_touch=W < 500, device_scale_factor=2 if W < 500 else 1)
        pg = await ctx.new_page()
        async def route(r):
            if r.request.url.split('/')[2].endswith('vinnica.ua'): await r.continue_()
            else: await r.abort()
        await pg.route('**/*', route)
        for u in urls:
            try:
                await pg.goto(u, wait_until='load', timeout=40000); await pg.wait_for_timeout(2500)
                await pg.add_script_tag(path='/home/claude/build/node_modules/axe-core/axe.min.js')
                r = await pg.evaluate("(rules)=>axe.run(document,{runOnly:{type:'rule',values:rules},resultTypes:['violations']}).then(r=>r.violations.map(v=>({id:v.id,impact:v.impact,help:v.help,nodes:v.nodes.map(n=>({t:n.target.join(' '),h:n.html.slice(0,300),s:n.failureSummary.slice(0,300)}))})))", LH)
                res[u] = r
            except Exception as e:
                res[u] = [{'id': 'ERR', 'help': str(e)[:200], 'nodes': []}]
        await b.close()
    json.dump(res, open(OUT, 'w'), ensure_ascii=False, indent=1)
asyncio.run(main())
