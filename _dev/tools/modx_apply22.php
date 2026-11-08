<?php
// Шаг 22: блог — список статей (шаблон «Блог - список статей», 4: ресурс 31) и статьи (шаблон «Блог - статья», 5: дети 31) — в новом дизайне.
// В <head> списка остаётся head-blog-list (свои title/description), добавляется lb-head. Статья обёрнута в itemscope schema.org/Article
// (раньше — div.blog-schema-wrapper-inst вокруг крошек, H1 и текста). Чанки категории Redesign пересохраняются. Повторный запуск ничего не меняет.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$desc = [
    'lb-bloglist' => 'Редизайн: список статей блога', 'lb.blogCard' => 'Редизайн: карточка статьи (tpl pdoPage)',
    'lb-article' => 'Редизайн: статья блога (текст, автор, соседние статьи, боковая колонка)', 'lb.blogSide' => 'Редизайн: статья в боковой колонке',
    'lb.blogPrev' => 'Редизайн: предыдущая статья (pdoNeighbors)', 'lb.blogNext' => 'Редизайн: следующая статья (pdoNeighbors)',
    'lb-comments' => 'Редизайн: комментарии статьи (EasyComm)', 'lb.commentRow' => 'Редизайн: комментарий (tpl ecMessages)',
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
$conv = [
    4 => ['[[$head-blog-list]]', "    [[\$header]]\n    [[\$content-blog-list]]\n    [[\$footer-blog]]\n",
          "    [[\$lb-header]]\n    [[\$lb-shero]]\n    [[\$lb-bloglist]]\n    [[\$lb-footer]]\n"],
    5 => ['[[$head]]', "    [[\$header]]\n    [[\$content-blog]]\n    [[\$footer-blog]]\n",
          "    [[\$lb-header]]\n    <div class=\"lb-artscope\" itemscope itemtype=\"http://schema.org/Article\">\n    [[\$lb-shero]]\n    [[\$lb-article]]\n    [[*migx_questions:notempty=`[[\$lb-faq]]`]]\n    [[\$lb-comments]]\n    </div>\n    [[\$lb-footer]]\n"],
];
foreach ($conv as $id => $c3) {
    $t = $modx->getObject('modTemplate', $id);
    $c = $t->get('content');
    if (strpos($c, '[[$lb-head]]') === false) $c = str_replace('    ' . $c3[0] . "\n", '    ' . $c3[0] . "\n    [[\$lb-head]]\n", $c);
    if (strpos($c, '[[$lb-scripts]]') === false) $c = str_replace("    [[\$script]]\n", "    [[\$script]]\n    [[\$lb-scripts]]\n", $c);
    $c = str_replace($c3[1], $c3[2], $c);
    if ($c !== $t->get('content')) { $t->set('content', $c); echo "template $id: ", $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template $id: no change\n";
}
$modx->cacheManager->refresh();
