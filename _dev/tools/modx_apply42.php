<?php
// Шаг 42: без надзаголовков (eyebrow) во всех блоках, новые преимущества в баннере главной и в блоке «О микропигментации»,
// новый фон этого блока (фото пользователя, без печати), «Citește mai mult» под текстом, «Doar cu programare», «Вакансии» в подвале.
// Данные подвала — SQL _dev/patches/step42-footer.sql (до скрипта). Здесь: пересохранение чанков Redesign и сброс кэша.
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
$modx->cacheManager->refresh();
echo "ok\n";
