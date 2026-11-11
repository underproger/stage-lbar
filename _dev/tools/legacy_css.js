// legacy_css.js — шаг 66: старые стили (reset / template / blog / fonts / media / slimmenu, ~41 КБ gzip, 6 блокирующих запросов) → один файл
// assets/templates/redesign/css/legacy.css только с правилами, которые встречаются на страницах нового дизайна (PurgeCSS + csso).
// Подключает lb-head на всех шаблонах, кроме «Обучение» (15) и «Категория NEW» (19) — там старые блоки и полные старые файлы.
// Источники: HTML всех опубликованных страниц (обход — /home/claude/b65/crawl_all.py, без курса и удаления тату), чанки редизайна,
// чанки форм / easyComm из базы (chunks.tpl), классы, которые добавляет старый main.js / custom.js (jstokens.tpl), JS редизайна,
// AjaxForm, easyComm. Порядок правил и файлов — как был (вырезаются только неиспользуемые правила).
// Запуск: node _dev/tools/legacy_css.js <папка_с_html> <папка_с_chunks.tpl_и_jstokens.tpl>; затем
//   csso <папка>/legacy.css -o assets/templates/redesign/css/legacy.css
// Проверка — вычисленные стили всех элементов до / после совпадают (/home/claude/b66/snap.py + cmp.py, 32 страницы × 2 ширины).
const { PurgeCSS } = require('/home/claude/build/node_modules/purgecss');
const fs = require('fs');
const path = require('path');
const S = path.resolve(__dirname, '../..') + '/';
const HTML = process.argv[2], AUX = process.argv[3];
const OLD = ['reset.css', 'template.css', 'blog.css', 'fonts.css', 'media.css', 'slimmenu.css'].map(f => S + 'assets/templates/css/' + f);
const skip = /-(182|1182|321|625|1625)\.html$/;
const html = fs.readdirSync(HTML).filter(f => f.endsWith('.html') && !skip.test(f)).map(f => HTML + '/' + f);
const js = ['assets/templates/redesign/js/redesign.js',
  'assets/components/ajaxform/js/default.js', 'assets/components/easycomm/js/web/ec.default.js'].map(f => S + f);
const tpl = fs.readdirSync(S + 'core/elements/redesign/chunks').map(f => S + 'core/elements/redesign/chunks/' + f);
(async () => {
  const out = [];
  for (const css of OLD) {
    const r = await new PurgeCSS().purge({
      content: [...html, ...js, ...tpl, AUX + '/chunks.tpl', AUX + '/jstokens.tpl'],
      css: [css],
      extractors: [
        { extensions: ['html', 'tpl', 'txt'], extractor: (c) => {
            const out = new Set();
            for (const m of c.matchAll(/<([a-zA-Z][\w-]*)/g)) out.add(m[1].toLowerCase());
            for (const m of c.matchAll(/\s([a-zA-Z][\w:-]*)=/g)) out.add(m[1].toLowerCase());
            for (const m of c.matchAll(/(?:class|id|type|data-[\w-]+|role|name)\s*=\s*["']([^"']*)["']/gi)) m[1].split(/[^\w-]+/).forEach(t => t && out.add(t));
            return [...out]; } },
        { extensions: ['js'], extractor: (c) => {
            const out = new Set();
            for (const m of c.matchAll(/(["'`])((?:\\.|(?!\1).){1,400}?)\1/g)) m[2].split(/[^\w-]+/).forEach(t => t && out.add(t));
            return [...out]; } }
      ],
      fontFace: false, keyframes: false, variables: false,
      safelist: { standard: [/^body_fixed$/, /^active$/, /^open/, /^show/, /^is-/, /^has-/, /^error/, /^success/, /^hidden$/, /^visible$/, /^fixed$/, /fancybox/, /^iti/, /jGrowl/, /^af[-_]/, /^ec-/, /^lb-/],
                  greedy: [] }
    });
    const c = r[0].css;
    out.push('/* ' + css.split('/').pop() + ' */\n' + c);
    console.log(css.split('/').pop(), fs.statSync(css).size, '->', c.length);
  }
  fs.writeFileSync(AUX + '/legacy.css', out.join('\n'));
})();
