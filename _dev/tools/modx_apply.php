<?php
// Применение изменений редизайна в БД через MODX API (локально). Запуск: php modx_apply.php
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('ECHO');

// категория
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
if (!$cat) { $cat = $modx->newObject('modCategory'); $cat->set('category', 'Redesign'); $cat->save(); }

$chunks = [
    'lb-head' => 'Редизайн: подключения в head (шрифты, CSS)',
    'lb-scripts' => 'Редизайн: скрипты перед </body>',
    'lb-header' => 'Редизайн: шапка + мобильное меню',
    'lb-banner-main' => 'Редизайн: главный баннер',
    'lb.babelLink' => 'Редизайн: tpl переключателя языка',
];
foreach ($chunks as $name => $desc) {
    $file = 'core/elements/redesign/chunks/' . $name . '.tpl';
    $ch = $modx->getObject('modChunk', ['name' => $name]);
    if (!$ch) $ch = $modx->newObject('modChunk');
    $ch->fromArray([
        'name' => $name, 'description' => $desc, 'category' => $cat->get('id'),
        'static' => 1, 'source' => 1, 'static_file' => $file,
        'snippet' => file_get_contents(MODX_BASE_PATH . $file),
    ]);
    echo $name, ': ', $ch->save() ? 'ok' : 'FAIL', "\n";
}

// шаблон «Главная»: новая шапка и баннер + подключения
$tpl = $modx->getObject('modTemplate', 1);
$c = $tpl->get('content');
$orig = $c;
$c = str_replace("    [[\$head]]\n", "    [[\$head]]\n    [[\$lb-head]]\n", $c);
$c = preg_replace('~\s*<div class="header-wrap-main">\s*\[\[\$header\]\]\s*\[\[\$banner-main\]\]\s*</div>~', "\n    [[\$lb-header]]\n    [[\$lb-banner-main]]", $c);
$c = str_replace("    [[\$script]]\n", "    [[\$script]]\n    [[\$lb-scripts]]\n", $c);
if ($c !== $orig) { $tpl->set('content', $c); echo 'template 1: ', $tpl->save() ? 'ok' : 'FAIL', "\n"; } else echo "template 1: no change\n";
echo $c, "\n";

// TV главной (RO id 1, RU id 193)
$tvs = [
    1   => ['title-banner' => 'Micropigmentare|premium|în București', 'suptitle-banner' => 'Rezultate naturale. Eleganță care rămâne.'],
    193 => ['title-banner' => 'Перманентный макияж|premium|в Бухаресте', 'suptitle-banner' => 'Естественный результат. Элегантность, которая остаётся.'],
];
foreach ($tvs as $rid => $vals) {
    $r = $modx->getObject('modResource', $rid);
    foreach ($vals as $tv => $v) { $r->setTVValue($tv, $v); }
    echo "resource $rid tvs ok\n";
}
$modx->cacheManager->refresh();
