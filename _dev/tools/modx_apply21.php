<?php
// Шаг 21: «О нас», вакансии (шаблон «Внутренняя», 3 — на нём же «Gift Voucher» / сертификат и неопубликованные «Акции»),
// «Цены» (шаблон «Цены», 14) и «Отзывы» (шаблон «Отзывы», 16) — в новом дизайне. Чанки категории Redesign пересохраняются.
// Повторный запуск ничего не меняет.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$desc = [
    'lb.ptable' => 'Редизайн: таблица цен (общая для блока «Цены» и страницы «Цены»)',
    'lb-prices' => 'Редизайн: страница «Цены» — таблицы table-price-N',
];
foreach (glob(MODX_BASE_PATH . 'core/elements/redesign/chunks/*.tpl') as $path) {
    $name = basename($path, '.tpl'); $file = 'core/elements/redesign/chunks/' . $name . '.tpl';
    $ch = $modx->getObject('modChunk', ['name' => $name]) ?: $modx->newObject('modChunk');
    $isNew = $ch->isNew();
    $ch->fromArray(['name' => $name, 'category' => $cat->get('id'), 'static' => 1, 'source' => 1, 'static_file' => $file, 'snippet' => file_get_contents($path)]);
    if ($isNew) $ch->set('description', $desc[$name] ?? 'Редизайн');
    $ok = $ch->save();
    if ($isNew || !$ok) echo $name, ($isNew ? ' (new)' : ''), ': ', $ok ? 'ok' : 'FAIL', "\n";
}
$common = [
    '[[*main-title-bl2:notempty=`[[$bl2-category-inerial-2]]`]]' => '[[*main-title-bl2:notempty=`[[$lb-subservices]]`]]',
    '[[*gallery_select:notempty=`[[$bl6-portfolio-interial-2]]`]]' => '[[$lb-pgallery]]',
    '[[$bl8-form]]' => '[[$lb-book]]',
    '[[-$bl8-form]]' => '[[-$lb-book]]',
    '[[*title-bl9:notempty=`[[$bl9-reviews]]`]]' => '[[*title-bl9:notempty=`[[$lb-reviews]]`]]',
    '[[*migx_questions:notempty=`[[$bl-faq]]`]]' => '[[*migx_questions:notempty=`[[$lb-faq]]`]]',
    '[[*title-bl-seo:notempty=`[[$bl-seo]]`]]' => '[[*title-bl-seo:notempty=`[[$lb-seo]]`]]',
    '[[$bl-contact]]' => '[[$lb-contact]]',
    '[[$footer]]' => '[[$lb-footer]]',
];
function lb_conv($c, $banner, $after, $common) {
    if (strpos($c, '[[$lb-head]]') === false) $c = preg_replace('~^(\s*)\[\[\$head\]\]\n~m', "$0$1[[\$lb-head]]\n", $c, 1);
    if (strpos($c, '[[$lb-scripts]]') === false) $c = str_replace("    [[\$script]]\n", "    [[\$script]]\n    [[\$lb-scripts]]\n", $c);
    $c = preg_replace('~<div class="header-wrap-main">\s*\[\[\$header\]\]\s*\[\[\$' . preg_quote($banner, '~') . '\]\]\s*</div>~', "[[\$lb-header]]\n    [[\$lb-shero]]" . $after, $c);
    return str_replace(array_keys($common), array_values($common), $c);
}
foreach ([3 => ['banner-interial', ''], 14 => ['banner-interial-price', "\n    [[\$lb-prices]]"], 16 => ['banner-interial', '']] as $id => $b) {
    $t = $modx->getObject('modTemplate', $id);
    $c = lb_conv($t->get('content'), $b[0], $b[1], $common);
    if ($c !== $t->get('content')) { $t->set('content', $c); echo "template $id: ", $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template $id: no change\n";
}
$modx->cacheManager->refresh();
