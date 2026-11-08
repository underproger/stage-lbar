<?php
// Шаг 39: английская версия (контекст en, /en/). Данные (контекст, настройки, Babel, 32 EN-страницы с id = RO id + 1000, TV, связи Babel) —
// SQL _dev/patches/step39-en.sql (применять до этого скрипта: mysql lbar < _dev/patches/step39-en.sql; генерируется _dev/tools/en_build.py).
// Здесь: пересохранение чанков категории Redesign (новый lb.roId; правки lb-header, lb-contact, lb-reviews, lb.navMega и др. под EN)
// и сброс кэша (контексты, лексикон). Повторный запуск ничего не меняет.
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
// шаблон 8: скрытая картинка для сниппета поиска (TV search_snippet_img) — у EN-копий значение относительное, как в RO (images/…),
// а base href у EN — /en/ (картинка уходила под /en/…, 404): в EN — от корня; RO и RU (у RU значения уже от корня) — без изменений
$t = $modx->getObject('modTemplate', 8);
$c = str_replace('<img src="[[++base_url:is=`/`:then=``:else=`/`]][[*search_snippet_img]]"', '<img src="[[*search_snippet_img]]"', $t->get('content'));
$old = '<img src="[[*search_snippet_img]]"';
$new = '<img src="[[++cultureKey:is=`en`:then=`/`:else=``]][[*search_snippet_img]]"';
$c = str_replace($old, $new, $c);
if ($c !== $t->get('content')) { $t->set('content', $c); echo "template 8: ", $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 8: no change\n";
$ctx = $modx->getObject('modContext', 'en');
echo 'context en: ', $ctx ? 'ok' : 'MISSING (import step39-en.sql first)', "\n";
$modx->cacheManager->refresh();
