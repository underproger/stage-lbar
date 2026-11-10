<?php
// Шаг 54: страница «Удаление тату лазером» (RO 625 / RU 321) в новом дизайне — шаблон «Удаление тату» (категория Redesign, копия
// «Категории» (8) со своим набором блоков): lb-shero / lb-about / lb-consult в режиме tz (TV старых блоков шаблона «Категория NEW» (19)),
// новые lb-tzequip (оборудование), lb-tzteam (специалисты), lb-tzprice (цены из HTML-таблицы TV), далее — как у услуг: галерея, запись,
// отзывы, FAQ, контакты. Порядок — как на страницах услуг: о процедуре → оборудование (место «implică») → консультация →
// специалисты (место «Мастера») → галерея → цены → запись → отзывы → FAQ. Доступ к TV — шаблонов 19 и 8 (объединение),
// назначение ресурсам 625 / 321. Шаблон 19 не меняется. Скрипт идемпотентный. Здесь же: пересохранение чанков Redesign.
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
$src = str_replace("\r\n", "\n", $modx->getObject('modTemplate', 8)->get('content'));
$blocks = "    [[\$lb-header]]\n"
    . "    [[\$lb-shero? &tz=`1`]]\n"
    . "    [[\$lb-about? &tz=`1`]]\n"
    . "    [[*bl3_service_equipment-title:notempty=`[[\$lb-tzequip]]`]]\n"
    . "    [[\$lb-consult? &tz=`1`]]\n"
    . "    [[*bl7_service_specialists-title:notempty=`[[\$lb-tzteam]]`]]\n"
    . "    [[*title-bl6:notempty=`[[\$lb-portfolio]]`]]\n"
    . "    [[*bl5_services_prices-title:notempty=`[[\$lb-tzprice]]`]]\n"
    . "    [[\$lb-book]]\n"
    . "    [[*title-bl9:notempty=`[[\$lb-reviews]]`]]\n"
    . "    [[*migx_questions:notempty=`[[\$lb-faq]]`]]\n"
    . "    [[\$lb-contact]]\n"
    . "    [[\$lb-footer]]\n";
$c = preg_replace('~    \[\[\$lb-header\]\]\n.*?    \[\[\$lb-footer\]\]\n~s', $blocks, $src, 1, $cnt);
if (!$cnt) { echo "template 8: блоки не найдены\n"; exit(1); }
$c = str_replace('<div class="wrapper category-page main-[[++cultureKey]]">', '<div class="wrapper category-page lb-tzpage main-[[++cultureKey]]">', $c);
$name = 'Удаление тату';
$t = $modx->getObject('modTemplate', ['templatename' => $name]) ?: $modx->newObject('modTemplate');
if ($t->isNew() || $t->get('content') !== $c) {
    $t->fromArray(['templatename' => $name, 'description' => 'Удаление тату лазером в новом дизайне (шаг 54)', 'category' => $cat->get('id'), 'content' => $c]);
    echo 'template «', $name, '»: ', $t->save() ? 'ok' : 'FAIL', ' id ', $t->get('id'), "\n";
}
$tid = $t->get('id');
foreach ([19, 8] as $from) {
    foreach ($modx->getCollection('modTemplateVarTemplate', ['templateid' => $from]) as $tvt) {
        if (!$modx->getObject('modTemplateVarTemplate', ['tmplvarid' => $tvt->get('tmplvarid'), 'templateid' => $tid])) {
            $n = $modx->newObject('modTemplateVarTemplate');
            $n->fromArray(['tmplvarid' => $tvt->get('tmplvarid'), 'templateid' => $tid, 'rank' => $tvt->get('rank')], '', true, true);
            $n->save();
        }
    }
}
foreach ([625, 321] as $id) {
    $r = $modx->getObject('modResource', $id);
    if ($r && $r->get('template') != $tid) { $r->set('template', $tid); echo "resource $id: ", $r->save() ? 'ok' : 'FAIL', "\n"; }
}
$modx->cacheManager->refresh();
echo "ok\n";
