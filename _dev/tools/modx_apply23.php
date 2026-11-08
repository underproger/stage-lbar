<?php
// Шаг 23: страница «Контакты» (шаблон «Контакты», 9: ресурсы RO 3, RU 194) — в новом дизайне: шапка, блок «Контакты» в режиме
// страницы (H1 — pagetitle, крошки, карта, карточка контактов), «Запись», подвал. Вместо header + banner-interial-contact +
// bl-contact-page + bl8-form + footer. Новый вид блока «Контакты» (чанк lb-contact) — на всех страницах. Статья — снова строка
// сведений под H1 (lb-shero). Чанки категории Redesign пересохраняются. Повторный запуск ничего не меняет.
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
$c = $t->get('content');
if (strpos($c, '[[$lb-head]]') === false) $c = str_replace("    [[\$head]]\n", "    [[\$head]]\n    [[\$lb-head]]\n", $c);
if (strpos($c, '[[$lb-scripts]]') === false) $c = str_replace("    [[\$script]]\n", "    [[\$script]]\n    [[\$lb-scripts]]\n", $c);
$c = str_replace(
    "    <div class=\"header-wrap-main\">\n        [[\$header]]\n        [[\$banner-interial-contact]]\n    </div>\n    [[\$bl-contact-page]]\n    [[\$bl8-form]]\n    [[\$footer]]\n",
    "    [[\$lb-header]]\n    [[\$lb-contact]]\n    [[\$lb-book]]\n    [[\$lb-footer]]\n", $c);
if ($c !== $t->get('content')) { $t->set('content', $c); echo "template 9: ", $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 9: no change\n";
$modx->cacheManager->refresh();
