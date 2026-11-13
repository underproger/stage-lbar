// course_css.js — шаг 74: то же, что tz_css.js (шаг 71), для «Внутренняя - Обучение» (15: курс RO / RU / EN — 182 / 295 / 1182).
// Старые стили чанка head-study (study.css + slimmenu.css, до redesign.css) и Google Fonts Montserrat (блокирующий запрос к
// fonts.googleapis.com + ~120 КБ шрифтов с fonts.gstatic.com) → один файл course.css: только правила, которые встречаются на этих
// страницах, и в начале — @font-face «Montserrat» на те же файлы, что «LB Text» редизайна (тот же шрифт Montserrat, вариативный
// 100–900; latin / ro / cyrillic; font-display: swap) — старые блоки пишут font-family: 'Montserrat', а файлы уже загружены
// (montserrat-latin — с предзагрузкой в lb-head). Относительные адреса шрифтов (../fonts/) → абсолютные; у текстовых @font-face —
// font-display: swap; фон баннера bg-banner.png → tz-bg-banner.webp (как на «Удалении тату», шаг 73).
// Подключает lb-head (шаблон 15). Источники: HTML трёх страниц (обход — _dev/tools/crawl_all.py), JS страницы (редизайн, script.js,
// lightbox.js, owl.carousel), AjaxForm, easyComm, chunks.tpl / jstokens.tpl.
// Запуск: node _dev/tools/course_css.js <папка_с_html> <папка_с_chunks.tpl_и_jstokens.tpl> [имя_семейства]; затем csso
//   <папка>/course.css → assets/templates/redesign/css/course.css. Третий параметр — только для проверки стилей (style_snap.py):
//   до шага Google Fonts в проверке заблокирован, поэтому «после» снимается с другим именем семейства, чтобы 'Montserrat' так же
//   был запасным шрифтом.
const { PurgeCSS } = require('/home/claude/build/node_modules/purgecss');
const fs = require('fs');
const path = require('path');
const S = path.resolve(__dirname, '../..') + '/';
const HTML = process.argv[2], AUX = process.argv[3];
const OLD = ['study.css', 'slimmenu.css'].map(f => S + 'assets/templates/css/' + f);
const FAMILY = process.argv[4] || 'Montserrat';
const only = /-(182|295|1182)\.html$/;
const html = fs.readdirSync(HTML).filter(f => only.test(f)).map(f => HTML + '/' + f);
// JS страницы целиком: их плагины добавляют классы (owl-stage / owl-item, lightbox и т. п.)
const js = ['assets/templates/redesign/js/redesign.js', 'assets/templates/js/script.js', 'assets/templates/js/lightbox.js',
  'assets/templates/js/owl.carousel.min.js',
  'assets/components/ajaxform/js/default.js', 'assets/components/easycomm/js/web/ec.default.js'].map(f => S + f);
(async () => {
  const F = '/assets/templates/redesign/fonts/montserrat-';
  const face = (file, range) => `@font-face{font-family:"${FAMILY}";src:url(${F}${file}.woff2) format("woff2");font-weight:100 900;font-style:normal;font-display:swap;unicode-range:${range}}`;
  const out = ['/* Montserrat для старых блоков — файлы редизайна (вместо Google Fonts) */\n' + [
    face('latin-wght-normal', 'U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD'),
    face('latin-ext-ro-normal', 'U+0102-0103,U+015E-015F,U+0162-0163,U+0218-021B'),
    face('cyrillic-wght-normal', 'U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116')].join('\n')];
  for (const css of OLD) {
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
    out.push('/* ' + css.split('/').pop() + ' */\n' + c);
    console.log(css.split('/').pop(), fs.statSync(css).size, '->', c.length);
  }
  fs.writeFileSync(AUX + '/course.css', out.join('\n'));
})();
