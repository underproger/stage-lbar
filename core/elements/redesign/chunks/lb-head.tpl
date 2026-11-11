{* Подключения редизайна в <head>. Версию ?v= поднимаем при изменениях. *}
<link rel="preload" href="/assets/templates/redesign/fonts/playfair-display-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/templates/redesign/fonts/montserrat-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
{* старые стили сайта (reset / template / blog / fonts / media / slimmenu) — на страницах нового дизайна вместо 6 файлов один legacy.css
   с нужными им правилами (шаг 66, _dev/tools/legacy_css.js); «Обучение» (15) и «Категория NEW» (19) — старые блоки, там полные файлы (чанки head / head-study) *}
{if !($_modx->resource.template in [15, 19])}<link rel="stylesheet" href="/assets/templates/redesign/css/legacy.css?v=1.47.1">{/if}
<link rel="stylesheet" href="/assets/templates/redesign/css/redesign.css?v=1.47.1">
