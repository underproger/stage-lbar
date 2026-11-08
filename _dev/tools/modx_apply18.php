<?php
// Шаг 18: страницы услуг (шаблон «Категория», id 8) — все блоки в новом дизайне: старые чанки шаблона заменены на lb-*
// (условия по TV сохранены), подуслуги — lb-subservices, подвал — lb-footer. Чанки категории Redesign пересохраняются из файлов.
// Шаблоны «Категория NEW» (19, удаление тату) и обучения — не трогаем. Повторный запуск ничего не меняет.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$desc = [
    'lb-shero' => 'Редизайн: баннер страниц услуг (шаблон «Категория»)',
    'lb-subservices' => 'Редизайн: подуслуги на странице услуги (дочерние ресурсы)',
    'lb.subserviceCard' => 'Редизайн: карточка подуслуги (tpl pdoResources)',
    'lb.accent' => 'Редизайн: заголовок с курсивом после тире / двоеточия',
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
$tpl = $modx->getObject('modTemplate', 8);
$c = $tpl->get('content');
$map = [
    '[[*title_bl1_about:notempty=`[[$bl1-about-us]]`]]' => '[[*title_bl1_about:notempty=`[[$lb-about]]`]]',
    '[[$bl2-category-inerial]]' => '[[$lb-subservices]]',
    '[[*title-main-bl3:notempty=`[[$bl3-text]]`]]' => '[[*title-main-bl3:notempty=`[[$lb-implica]]`]]',
    '[[$bl4-form]]' => '[[$lb-consult]]',
    '[[*hide-bl2-study:isnot=`hide`:then=`[[$bl2-study-trener]]`]]' => '[[*hide-bl2-study:isnot=`hide`:then=`[[$lb-master]]`]]',
    '[[*title-bl6:notempty=`[[$bl6-portfolio]]`]]' => '[[*title-bl6:notempty=`[[$lb-portfolio]]`]]',
    '[[*title-bl7:notempty=`[[$bl7-price]]`]]' => '[[*title-bl7:notempty=`[[$lb-price]]`]]',
    '[[$bl8-form]]' => '[[$lb-book]]',
    '[[*title-bl9:notempty=`[[$bl9-reviews]]`]]' => '[[*title-bl9:notempty=`[[$lb-reviews]]`]]',
    '[[*migx_questions:notempty=`[[$bl-faq]]`]]' => '[[*migx_questions:notempty=`[[$lb-faq]]`]]',
    '[[*title-bl-seo:notempty=`[[$bl-seo]]`]]' => '[[*title-bl-seo:notempty=`[[$lb-seo]]`]]',
    '[[*title-blog-bl12:notempty=`[[$bl-blog]]`]]' => '[[*title-blog-bl12:notempty=`[[$lb-blog]]`]]',
    '[[$bl-contact]]' => '[[$lb-contact]]',
    '[[$footer]]' => '[[$lb-footer]]',
];
$n = str_replace(array_keys($map), array_values($map), $c);
$left = array_filter(array_keys($map), fn($k) => strpos($n, $k) !== false);
if ($left) echo "не заменено: ", implode(' ', $left), "\n";
if ($n !== $c) { $tpl->set('content', $n); echo 'template 8: ', $tpl->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 8: no change\n";
$modx->cacheManager->refresh();
