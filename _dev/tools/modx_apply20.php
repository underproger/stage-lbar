<?php
// Шаг 20: «Портфолио» — общая страница (шаблон «Портфолио», id 10: ресурсы 100 / 198) и внутренние галереи
// (шаблон «Внутренняя - Галерея», id 13: только дети 100 / 198) — в новом дизайне. Оба шаблона только у этих страниц.
// Чанки категории Redesign пересохраняются из файлов. Повторный запуск ничего не меняет.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$desc = [
    'lb-pfhub' => 'Редизайн: портфолио — карточки мастеров и разделов',
    'lb-pgallery' => 'Редизайн: портфолио — галерея внутренней страницы с вкладками разделов',
    'lb.galleryPage' => 'Редизайн: tpl ms2Gallery для галереи страницы портфолио',
    'lb.pfTab' => 'Редизайн: вкладка раздела портфолио (tpl pdoResources)',
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
$tail = [
    '[[$bl8-form]]' => '[[$lb-book]]',
    '[[*title-bl9:notempty=`[[$bl9-reviews]]`]]' => '[[*title-bl9:notempty=`[[$lb-reviews]]`]]',
    '[[*migx_questions:notempty=`[[$bl-faq]]`]]' => '[[*migx_questions:notempty=`[[$lb-faq]]`]]',
    '[[*title-bl-seo:notempty=`[[$bl-seo]]`]]' => '[[*title-bl-seo:notempty=`[[$lb-seo]]`]]',
    '[[$bl-contact]]' => '[[$lb-contact]]',
    '[[$footer]]' => '[[$lb-footer]]',
];
function lb_wrap($c) {
    if (strpos($c, '[[$lb-head]]') === false) $c = preg_replace('~^(\s*)\[\[\$head\]\]\n~m', "$0$1[[\$lb-head]]\n", $c, 1);
    if (strpos($c, '[[$lb-scripts]]') === false) $c = str_replace("    [[\$script]]\n", "    [[\$script]]\n    [[\$lb-scripts]]\n", $c);
    return $c;
}
// шаблон «Портфолио» (10)
$t = $modx->getObject('modTemplate', 10);
$c = lb_wrap($t->get('content'));
$c = preg_replace('~\[\[\$header\]\]\s*\[\[\$banner-interial-portfolio\]\]~', "[[\$lb-header]]\n    [[\$lb-shero]]\n    [[\$lb-pfhub]]", $c);
$c = str_replace(array_keys($tail), array_values($tail), $c);
if ($c !== $t->get('content')) { $t->set('content', $c); echo 'template 10: ', $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 10: no change\n";
// шаблон «Внутренняя - Галерея» (13)
$t = $modx->getObject('modTemplate', 13);
$c = lb_wrap($t->get('content'));
$c = preg_replace('~<div class="header-wrap-main">\s*\[\[\$header\]\]\s*\[\[\$banner-interial\]\]\s*</div>~', "[[\$lb-header]]\n    [[\$lb-shero]]", $c);
$c = str_replace('[[$bl6-portfolio-interial]]', '[[$lb-pgallery]]', $c);
$c = str_replace(array_keys($tail), array_values($tail), $c);
if ($c !== $t->get('content')) { $t->set('content', $c); echo 'template 13: ', $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 13: no change\n";
$modx->cacheManager->refresh();
