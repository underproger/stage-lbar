<?php
// Шаг 17: баннер страниц услуг (шаблон «Категория», id 8): новые шапка lb-header + баннер lb-shero (с хлебными крошками) вместо
// header / banner-interial-category(-with-img) / breadcrumb-wrap; в <head> — lb-head, перед </body> — lb-scripts.
// Остальные блоки шаблона не меняются. Шаблоны «Категория NEW» (19, удаление тату) и обучения — не трогаем.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$desc = ['lb-shero' => 'Редизайн: баннер страниц услуг (шаблон «Категория»)'];
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
$n = $c;
if (strpos($n, '[[$lb-head]]') === false) $n = str_replace("    [[\$head]]\n", "    [[\$head]]\n    [[\$lb-head]]\n", $n);
$a = strpos($n, '<div class="header-wrap-main">');
$b = strpos($n, '<div class="breadcrumb-wrap category">');
if ($a !== false && $b !== false) {
    $end = "        ]]\n    </div>";            // конец вызова pdoCrumbs и блока breadcrumb-wrap
    $e = strpos($n, $end, $b) + strlen($end);
    $n = substr($n, 0, $a) . "[[\$lb-header]]\n    [[\$lb-shero]]" . substr($n, $e);
}
if (strpos($n, '[[$lb-scripts]]') === false) $n = str_replace("    [[\$script]]\n", "    [[\$script]]\n    [[\$lb-scripts]]\n", $n);
if ($n !== $c) { $tpl->set('content', $n); echo 'template 8: ', $tpl->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 8: no change\n";
$modx->cacheManager->refresh();
