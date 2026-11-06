<?php
// Шаг 2: блок «О микропигментации» на главной.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$name = 'lb-about'; $file = 'core/elements/redesign/chunks/' . $name . '.tpl';
$ch = $modx->getObject('modChunk', ['name' => $name]) ?: $modx->newObject('modChunk');
$ch->fromArray(['name' => $name, 'description' => 'Редизайн: блок «О микропигментации» (главная)', 'category' => $cat->get('id'),
    'static' => 1, 'source' => 1, 'static_file' => $file, 'snippet' => file_get_contents(MODX_BASE_PATH . $file)]);
echo $name, ': ', $ch->save() ? 'ok' : 'FAIL', "\n";
$tpl = $modx->getObject('modTemplate', 1);
$c = $tpl->get('content');
$n = str_replace('[[$bl1-about-us]]', '[[$lb-about]]', $c);
if ($n !== $c) { $tpl->set('content', $n); echo 'template 1: ', $tpl->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 1: no change\n";
$modx->cacheManager->refresh();
