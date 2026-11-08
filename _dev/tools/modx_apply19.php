<?php
// Шаг 19: общие страницы «Услуги» (RO 80 /servicii, RU 302 /ru/uslugi) и «Обучение» (RO 60 /obuchenie) — в новом дизайне.
// «Услуги»: шаблон «Внутренняя» (3) общий с «О нас», вакансиями, сертификатом — его не трогаем; создаётся отдельный шаблон
// «Услуги - общая» (категория Redesign) с доступом к тем же TV, что у шаблона 3, и назначается ресурсам 80 и 302.
// «Обучение»: шаблон «Внутренняя - Обучение» (21) — только у ресурса 60, правится сам (по просьбе пользователя; шаблон курсов 15 не трогаем).
// Чанки категории Redesign пересохраняются из файлов. Повторный запуск ничего не меняет.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$desc = [
    'lb.hubCard' => 'Редизайн: карточка услуги на общей странице «Услуги» (tpl pdoResources)',
    'lb-courses' => 'Редизайн: курсы на общей странице «Обучение»',
    'lb.courseCard' => 'Редизайн: карточка курса (tpl pdoResources)',
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
// общая часть замен (шапка/баннер/подвал, как в шаблоне 8)
function lb_common($c) {
    if (strpos($c, '[[$lb-head]]') === false) $c = str_replace("    [[\$head]]\n", "    [[\$head]]\n    [[\$lb-head]]\n", $c);
    $c = preg_replace('~<div class="header-wrap-main">\s*\[\[\$header\]\]\s*\[\[\$banner-interial\]\]\s*</div>~', "[[\$lb-header]]\n    [[\$lb-shero]]", $c);
    $c = str_replace(['[[$bl-contact]]', '[[$footer]]'], ['[[$lb-contact]]', '[[$lb-footer]]'], $c);
    if (strpos($c, '[[$lb-scripts]]') === false) $c = str_replace("    [[\$script]]\n", "    [[\$script]]\n    [[\$lb-scripts]]\n", $c);
    return $c;
}
// 1) «Услуги — общая»
$name = 'Услуги - общая'; // в имени элемента MODX нельзя скобки
$src = $modx->getObject('modTemplate', 3)->get('content');
$c = lb_common($src);
$c = str_replace([
    '[[*main-title-bl2:notempty=`[[$bl2-category-inerial-2]]`]]',
    '[[$bl8-form]]',
    '[[*title-bl9:notempty=`[[$bl9-reviews]]`]]',
    '[[*migx_questions:notempty=`[[$bl-faq]]`]]',
    '[[*title-bl-seo:notempty=`[[$bl-seo]]`]]',
], [
    '[[*main-title-bl2:notempty=`[[$lb-subservices]]`]]',
    '[[$lb-book]]',
    '[[*title-bl9:notempty=`[[$lb-reviews]]`]]',
    '[[*migx_questions:notempty=`[[$lb-faq]]`]]',
    '[[*title-bl-seo:notempty=`[[$lb-seo]]`]]',
], $c);
$t = $modx->getObject('modTemplate', ['templatename' => $name]) ?: $modx->newObject('modTemplate');
$isNew = $t->isNew();
if ($isNew || $t->get('content') !== $c) {
    $t->fromArray(['templatename' => $name, 'description' => 'Общая страница «Услуги» в новом дизайне (копия «Внутренней» с блоками lb-*)', 'category' => $cat->get('id'), 'content' => $c]);
    echo 'template «', $name, '»: ', $t->save() ? 'ok' : 'FAIL', ' id ', $t->get('id'), "\n";
}
$tid = $t->get('id');
// доступ к TV — как у шаблона 3
foreach ($modx->getCollection('modTemplateVarTemplate', ['templateid' => 3]) as $tvt) {
    if (!$modx->getObject('modTemplateVarTemplate', ['tmplvarid' => $tvt->get('tmplvarid'), 'templateid' => $tid])) {
        $n = $modx->newObject('modTemplateVarTemplate');
        $n->fromArray(['tmplvarid' => $tvt->get('tmplvarid'), 'templateid' => $tid, 'rank' => $tvt->get('rank')], '', true, true);
        $n->save();
    }
}
foreach ([80, 302] as $id) {
    $r = $modx->getObject('modResource', $id);
    if ($r && $r->get('template') != $tid) { $r->set('template', $tid); echo "resource $id: ", $r->save() ? 'ok' : 'FAIL', "\n"; }
}
// 2) «Внутренняя - Обучение» (21)
$t21 = $modx->getObject('modTemplate', 21);
$c = lb_common($t21->get('content'));
$c = str_replace(['[[$bl2-category-study]]', '[[*title-bl-seo:notempty=`[[$bl-seo]]`]]'], ['[[$lb-courses]]', '[[*title-bl-seo:notempty=`[[$lb-seo]]`]]'], $c);
if ($c !== $t21->get('content')) { $t21->set('content', $c); echo 'template 21: ', $t21->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 21: no change\n";
$modx->cacheManager->refresh();
