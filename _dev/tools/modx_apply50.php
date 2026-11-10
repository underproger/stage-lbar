<?php
// Шаг 50: новые шапка и подвал на старых шаблонах «Обучение» (15: курс 182) и «Категория NEW» (19: удаление тату лазером 625 / RU 321) —
// в <head> добавляется lb-head (CSS редизайна), старая шапка (.header-wrap-main + чанк header) → lb-header, footer-study → lb-footer,
// в конец — lb-scripts (redesign.js). Остальные блоки страниц и старые скрипты — без изменений. Скрипт идемпотентный.
// Страницы услуг (8, 19): 135 отзывов в микроразметке — lb-script / lb-schema-series вместо script / script-creativeworkseries-scheme.
// Здесь же: пересохранение чанков Redesign. Значения TV (тексты) — SQL _dev/patches/step50-texts.sql.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
foreach (glob(MODX_BASE_PATH . 'core/elements/redesign/chunks/*.tpl') as $path) {
    $name = basename($path, '.tpl'); $file = 'core/elements/redesign/chunks/' . $name . '.tpl';
    $ch = $modx->getObject('modChunk', ['name' => $name]) ?: $modx->newObject('modChunk');
    $isNew = $ch->isNew();
    $ch->fromArray(['name' => $name, 'category' => $cat->get('id'), 'static' => 1, 'source' => 1, 'static_file' => $file, 'snippet' => file_get_contents($path)]);
    if ($isNew) $ch->set('description', 'Редизайн');
    $ok = $ch->save();
    if ($isNew || !$ok) echo $name, ($isNew ? ' (new)' : ''), ': ', $ok ? 'ok' : 'FAIL', "\n";
}
$edits = [
    19 => [
        ["    [[\$head]]\n", "    [[\$head]]\n    [[\$lb-head]]\n"],
        ["    <div class=\"header-wrap-main\">\n        [[\$header? &color=`white`]]\n    </div>\n", "    [[\$lb-header]]\n"],
        ["    [[\$footer-study]]\n", "    [[\$lb-footer]]\n"],
        ["    [[\$script]]\n", "    [[\$lb-script? &reviews=`135`]]\n    [[\$lb-scripts]]\n"],
        ["    [[ecThreadRatingMicro:isnot=`0`:then=`[[\$script-creativeworkseries-scheme]]`:else=``]]\n", "    [[\$lb-schema-series? &reviews=`135`]]\n"],
        // старая страница с новой шапкой: шапка сразу с подложкой, контент — под ней (_header.scss, .lb-oldpage)
        ["<div class=\"wrapper category-page category-page-new category-inner main-[[++cultureKey]]\">", "<div class=\"wrapper category-page category-page-new category-inner lb-oldpage main-[[++cultureKey]]\">"],
    ],
    // страницы услуг: в микроразметке 135 отзывов (новые чанки lb-script / lb-schema-series вместо script / script-creativeworkseries-scheme)
    8 => [
        ["    [[\$script]]\n", "    [[\$lb-script? &reviews=`135`]]\n"],
        ["    [[ecThreadRatingMicro:isnot=`0`:then=`[[\$script-creativeworkseries-scheme]]`:else=``]]\n", "    [[\$lb-schema-series? &reviews=`135`]]\n"],
    ],
    15 => [
        ["    [[\$head-study]]\n", "    [[\$head-study]]\n    [[\$lb-head]]\n"],
        // нет template.css (основа окна «Заказать звонок» в подвале) и custom.js (открывает окно) — класс для CSS / JS редизайна
        ["<body class=\"wrapper main-[[++cultureKey]]\">", "<body class=\"wrapper lb-oldpage lb-legacy main-[[++cultureKey]]\">"],
        ["    <div class=\"header-wrap-main header-study\">\n        [[\$header]]\n    </div>\n", "    [[\$lb-header]]\n"],
        ["    [[\$footer-study]]\n", "    [[\$lb-footer]]\n"],
        ["[[ecThreadRatingMicro:isnot=`0`:then=`[[\$script-creativeworkseries-scheme]]`:else=``]]\n</body>", "[[ecThreadRatingMicro:isnot=`0`:then=`[[\$script-creativeworkseries-scheme]]`:else=``]]\n[[\$lb-scripts]]\n</body>"],
    ],
];
foreach ($edits as $id => $list) {
    $t = $modx->getObject('modTemplate', $id);
    $c = str_replace("\r\n", "\n", $t->get('content'));
    foreach ($list as [$from, $to]) {
        if (strpos($c, $to) !== false) continue; // уже применено
        if (substr_count($c, $from) !== 1) { echo "template $id: не найдено: ", trim($from), "\n"; exit(1); }
        $c = str_replace($from, $to, $c);
    }
    if ($c !== $t->get('content')) { $t->set('content', $c); echo "template $id: ", $t->save() ? 'ok' : 'FAIL', "\n"; }
}
$modx->cacheManager->refresh();
echo "ok\n";
