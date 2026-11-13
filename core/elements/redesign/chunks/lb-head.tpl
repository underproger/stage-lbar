{* Подключения редизайна в <head>. Версию ?v= поднимаем при изменениях. *}
<link rel="preload" href="/assets/templates/redesign/fonts/playfair-display-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/templates/redesign/fonts/montserrat-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
{* старые стили сайта (reset / template / blog / fonts / media / slimmenu) — на страницах нового дизайна вместо 6 файлов один legacy.css
   с нужными им правилами (шаг 66, _dev/tools/legacy_css.js); «Категория NEW» (19, удаление тату — старые блоки) — tz-legacy.css до
   redesign.css и tz-study.css (вместо study.css) после него (шаг 71, _dev/tools/tz_css.js); «Обучение» (15, курс) — course.css до
   redesign.css (вместо study.css + slimmenu.css + Google Fonts Montserrat из чанка head-study; шаг 74, _dev/tools/course_css.js).
   Шаблоны 19 и 15: фон баннера (study.css, .banner; с шага 73 — WebP 9 КБ вместо PNG 199 КБ) — главная картинка первого экрана (LCP) —
   грузим сразу, не дожидаясь стилей. *}
{if $_modx->resource.template in [15, 19]}
<link rel="preload" as="image" href="/assets/templates/redesign/img/tz-bg-banner.webp" type="image/webp" fetchpriority="high">
{/if}
{if $_modx->resource.template == 19}
<link rel="stylesheet" href="/assets/templates/redesign/css/tz-legacy.css?v=1.51.0">
{elseif $_modx->resource.template == 15}
<link rel="stylesheet" href="/assets/templates/redesign/css/course.css?v=1.51.0">
{else}
<link rel="stylesheet" href="/assets/templates/redesign/css/legacy.css?v=1.51.0">
{/if}
<link rel="stylesheet" href="/assets/templates/redesign/css/redesign.css?v=1.51.0">
{if $_modx->resource.template == 19}<link rel="stylesheet" href="/assets/templates/redesign/css/tz-study.css?v=1.51.0">{/if}
