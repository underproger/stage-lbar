<?php
// Шаг 40: шапка и баннер (новый логотип, меню без «Главной» / «Вакансий», «Curs» и «Recenzii» в корне, язык в мобильной шапке,
// кнопки баннера как на исходном сайте, новое фото мастера). Данные меню — SQL _dev/patches/step40-menu.sql (применять до скрипта).
// Здесь: пересохранение чанков категории Redesign и сброс кэша. Повторный запуск ничего не меняет.
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
$r = $modx->getObject('modResource', 60);
echo 'resource 60: ', $r ? $r->get('class_key') . ' -> ' . $r->get('content') : 'missing', "\n";
$modx->cacheManager->refresh();
