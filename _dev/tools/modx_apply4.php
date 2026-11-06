<?php
// Шаг 4: блок «Micropigmentarea … implică» на главной.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
// пересохраняем все статичные чанки редизайна из файлов (чтобы копия в БД совпадала с git)
$desc = ['lb-implica' => 'Редизайн: блок «Micropigmentarea … implică» (главная)'];
foreach (glob(MODX_BASE_PATH . 'core/elements/redesign/chunks/*.tpl') as $path) {
    $name = basename($path, '.tpl'); $file = 'core/elements/redesign/chunks/' . $name . '.tpl';
    $ch = $modx->getObject('modChunk', ['name' => $name]) ?: $modx->newObject('modChunk');
    $isNew = $ch->isNew();
    $ch->fromArray(['name' => $name, 'category' => $cat->get('id'), 'static' => 1, 'source' => 1, 'static_file' => $file, 'snippet' => file_get_contents($path)]);
    if ($isNew) $ch->set('description', $desc[$name] ?? 'Редизайн');
    echo $name, ($isNew ? ' (new)' : ''), ': ', $ch->save() ? 'ok' : 'FAIL', "\n";
}
$tpl = $modx->getObject('modTemplate', 1);
$c = $tpl->get('content');
$n = str_replace('[[*title-main-bl3:notempty=`[[$bl3-text]]`]]', '[[*title-main-bl3:notempty=`[[$lb-implica]]`]]', $c);
if ($n !== $c) { $tpl->set('content', $n); echo 'template 1: ', $tpl->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 1: no change\n";
$modx->cacheManager->refresh();
