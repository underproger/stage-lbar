<?php
// Шаг 47: страница «О нас» в новом дизайне — шаблон «О нас» (категория Redesign, копия «Внутренней» (3) с блоками lb-ahero,
// lb-astory, lb-asteps, lb-avalues, lb-aculise, lb-areasons, FAQ, запись, контакты), доступ к тем же TV, что у шаблона 3,
// назначение ресурсам 102 / 298 / 1102. SQL _dev/patches/step47-about.sql (вопросы и ответы — TV migx_questions / title-bl-faq)
// — до скрипта. Здесь же: пересохранение чанков Redesign и сброс кэша.
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
$src = $modx->getObject('modTemplate', 3)->get('content');
$blocks = "    [[\$lb-header]]\n    [[\$lb-ahero]]\n    [[\$lb-astory]]\n    [[\$lb-asteps]]\n    [[\$lb-avalues]]\n    [[\$lb-aculise]]\n    [[\$lb-areasons]]\n"
    . "    [[*migx_questions:notempty=`[[\$lb-faq]]`]]\n    [[\$lb-book]]\n    [[\$lb-contact]]\n    [[\$lb-footer]]\n";
$c = preg_replace('~    \[\[\$lb-header\]\]\n.*?    \[\[\$lb-footer\]\]\n~s', $blocks, $src, 1, $cnt);
if (!$cnt) { echo "template 3: блоки не найдены\n"; exit(1); }
// у .wrapper старый CSS ставит overflow: hidden — номер шага в «Шести шагах» не прилипает; класс lb-apage → overflow: clip
$c = str_replace('<div class="wrapper interial main-[[++cultureKey]]">', '<div class="wrapper interial lb-apage main-[[++cultureKey]]">', $c);
$name = 'О нас';
$t = $modx->getObject('modTemplate', ['templatename' => $name]) ?: $modx->newObject('modTemplate');
$isNew = $t->isNew();
if ($isNew || $t->get('content') !== $c) {
    $t->fromArray(['templatename' => $name, 'description' => 'Страница «О нас» в новом дизайне (шаг 47)', 'category' => $cat->get('id'), 'content' => $c]);
    echo 'template «', $name, '»: ', $t->save() ? 'ok' : 'FAIL', ' id ', $t->get('id'), "\n";
}
$tid = $t->get('id');
foreach ($modx->getCollection('modTemplateVarTemplate', ['templateid' => 3]) as $tvt) {
    if (!$modx->getObject('modTemplateVarTemplate', ['tmplvarid' => $tvt->get('tmplvarid'), 'templateid' => $tid])) {
        $n = $modx->newObject('modTemplateVarTemplate');
        $n->fromArray(['tmplvarid' => $tvt->get('tmplvarid'), 'templateid' => $tid, 'rank' => $tvt->get('rank')], '', true, true);
        $n->save();
    }
}
foreach ([102, 298, 1102] as $id) {
    $r = $modx->getObject('modResource', $id);
    if ($r && $r->get('template') != $tid) { $r->set('template', $tid); echo "resource $id: ", $r->save() ? 'ok' : 'FAIL', "\n"; }
}
$modx->cacheManager->refresh();
echo "ok\n";
