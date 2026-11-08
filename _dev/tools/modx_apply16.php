<?php
// Шаг 16: языки выпадающим списком (lb-header, lb.babelLink), ссылки карточек статей (новый чанк lb.blogHref,
// TV link-st-1..3 главной RO → опубликованные статьи 597 / 598 / 596; старые значения вели на удалённые 137 / 135 / 131).
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
// пересохраняем все статичные чанки редизайна из файлов (чтобы копия в БД совпадала с git)
$desc = ['lb.blogHref' => 'Редизайн: URL статьи для карточки lb-blog по значению TV link-st-N (id или путь), только опубликованные'];
foreach (glob(MODX_BASE_PATH . 'core/elements/redesign/chunks/*.tpl') as $path) {
    $name = basename($path, '.tpl'); $file = 'core/elements/redesign/chunks/' . $name . '.tpl';
    $ch = $modx->getObject('modChunk', ['name' => $name]) ?: $modx->newObject('modChunk');
    $isNew = $ch->isNew();
    $ch->fromArray(['name' => $name, 'category' => $cat->get('id'), 'static' => 1, 'source' => 1, 'static_file' => $file, 'snippet' => file_get_contents($path)]);
    if ($isNew) $ch->set('description', $desc[$name] ?? 'Редизайн');
    echo $name, ($isNew ? ' (new)' : ''), ': ', $ch->save() ? 'ok' : 'FAIL', "\n";
}
// ссылки карточек статей главной RO
$links = ['link-st-1' => '/cum-sa-deveniti-master-de-machiaj-semipermanent', 'link-st-2' => '/cat-timp-dureaza-efectul-machiajului-semipermanent', 'link-st-3' => '/reguli-pentru-elaborarea-schemei-sprancenelor-cu-marcare-pe-puncte'];
$res = $modx->getObject('modResource', 1);
foreach ($links as $tv => $val) { $res->setTVValue($tv, $val); echo "resource 1 $tv = $val\n"; }
$modx->cacheManager->refresh();
