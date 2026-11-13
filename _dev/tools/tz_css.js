// tz_css.js — шаг 71: то же, что legacy_css.js (шаг 66), для «Категория NEW» (19: удаление тату RO / RU / EN — 625 / 321 / 1625).
// Старые стили (reset / template / blog / fonts / media / slimmenu — до redesign.css, и study.css — после него; 7 блокирующих
// запросов, ~112 КБ) → два файла с правилами, которые встречаются на этих страницах: tz-legacy.css (до redesign.css) и tz-study.css
// (после). Относительные адреса шрифтов study.css (../fonts/) → абсолютные; у текстовых @font-face — font-display: swap;
// фон баннера bg-banner.png → assets/templates/redesign/img/tz-bg-banner.webp (шаг 73).
// Подключает lb-head (шаблон 19). Источники: HTML трёх страниц (обход — _dev/tools/crawl_all.py), чанки редизайна,
// чанки форм / easyComm из базы (chunks.tpl), классы, которые добавляет старый main.js / custom.js (jstokens.tpl), JS редизайна,
// AjaxForm, easyComm. Порядок правил и файлов — как был (вырезаются только неиспользуемые правила).
// Запуск: node _dev/tools/tz_css.js <папка_с_html> <папка_с_chunks.tpl_и_jstokens.tpl>; затем csso <папка>/tz-legacy.css и
//   <папка>/tz-study.css → assets/templates/redesign/css/. Проверка — style_snap.py / style_cmp.py (3 страницы × 4 ширины).
const { PurgeCSS } = require('/home/claude/build/node_modules/purgecss');
const fs = require('fs');
const path = require('path');
const S = path.resolve(__dirname, '../..') + '/';
const HTML = process.argv[2], AUX = process.argv[3];
const OLD = ['reset.css', 'template.css', 'blog.css', 'fonts.css', 'media.css', 'slimmenu.css'].map(f => S + 'assets/templates/css/' + f);
const only = /-(321|625|1625)\.html$/;
const html = fs.readdirSync(HTML).filter(f => only.test(f)).map(f => HTML + '/' + f);
const STUDY = S + 'assets/templates/css/study.css';
// + старые main.js / custom.js целиком: на этих страницах их плагины добавляют классы (restables-origin / -clone таблицы цен и т. п.)
const js = ['assets/templates/redesign/js/redesign.js', 'assets/templates/js/main.js', 'assets/templates/js/custom.js',
  'assets/components/ajaxform/js/default.js', 'assets/components/easycomm/js/web/ec.default.js'].map(f => S + f);
const tpl = fs.readdirSync(S + 'core/elements/redesign/chunks').map(f => S + 'core/elements/redesign/chunks/' + f);
(async () => {
  const out = [], study = [];
  for (const css of [...OLD, STUDY]) {
    const r = await new PurgeCSS().purge({
      content: [...html, ...js, AUX + '/chunks.tpl', AUX + '/jstokens.tpl'],
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
    let c = r[0].css.replace(/url\((['"]?)\.\.\/fonts\//g, 'url($1/assets/templates/fonts/');
    // шаг 73: фон баннера (.banner, главная картинка первого экрана на мобильном) — WebP 9 КБ вместо PNG 199 КБ
    c = c.replace(/\/images\/design\/bg-banner\.png/g, '/assets/templates/redesign/img/tz-bg-banner.webp');
    // текстовые шрифты — font-display: swap (текст виден сразу системным шрифтом); иконочный themify — как был
    c = c.replace(/@font-face\s*\{([^}]*)\}/g, (m, body) => /font-display/.test(body) || /themify/i.test(body) ? m : '@font-face{' + body.replace(/;?\s*$/, ';') + 'font-display:swap}');
    (css === STUDY ? study : out).push('/* ' + css.split('/').pop() + ' */\n' + c);
    console.log(css.split('/').pop(), fs.statSync(css).size, '->', c.length);
  }
  fs.writeFileSync(AUX + '/tz-legacy.css', out.join('\n'));
  fs.writeFileSync(AUX + '/tz-study.css', study.join('\n'));
})();
