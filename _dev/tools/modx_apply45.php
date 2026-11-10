<?php
// Шаг 45: новый логотип; баннер общих страниц без кнопок и без графики справа; карточки статей без рубрики; статья без баннера
// (крошки, H1 и сведения — в lb-article; из шаблона 5 убран [[$lb-shero]]); адрес в мобильном меню — как в подвале.
// Здесь: пересохранение чанков Redesign, шаблон 5, сброс кэша. БД (кроме шаблона 5) не меняется.
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
$t = $modx->getObject('modTemplate', 5);
$c = str_replace("    [[\$lb-shero]]\n", '', $t->get('content'));
if ($c !== $t->get('content')) { $t->set('content', $c); echo "template 5: ", $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 5: no change\n";
$modx->cacheManager->refresh();
echo "ok\n";
