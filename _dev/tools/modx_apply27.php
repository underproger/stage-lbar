<?php
// Шаг 27: «Контакты» — снова без баннера (шаблон 9: lb-header, lb-contact в режиме страницы, lb-book, lb-footer); заголовок блока — H1
// с исходным текстом (pagetitle). Главная — H1 из TV title-banner с исходным текстом (UPDATE — _dev/patches/step26-h1.sql, применять
// отдельно: mysql lbar < _dev/patches/step26-h1.sql). Чанки категории Redesign пересохраняются. Повторный запуск ничего не меняет.
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
$t = $modx->getObject('modTemplate', 9);
$c = str_replace("    [[\$lb-header]]\n    [[\$lb-shero]]\n    [[\$lb-contact]]\n", "    [[\$lb-header]]\n    [[\$lb-contact]]\n", $t->get('content'));
if ($c !== $t->get('content')) { $t->set('content', $c); echo "template 9: ", $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 9: no change\n";
$modx->cacheManager->refresh();
