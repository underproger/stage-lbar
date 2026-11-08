<?php
// Шаг 24: страницы 404 (шаблон «404 eror page», 2: RO 20, RU 206) и «Спасибо» (шаблон «Success-Page-RU», 6: RO 40, RU 269) — в новом дизайне:
// шапка, блок lb-404 / lb-thanks, подвал. В <head> остаются прежние мета-строки шаблона (title, Canonical, autor, copyright, favicon;
// у «Спасибо» — google-tag-head/body); добавлены <base href> (страница 404 отдаётся по любому адресу — относительные ссылки шапки/подвала
// без base ломаются), общие CSS старого сайта (как в чанке head), загрузка лексикона и lb-head; viewport — как на остальных страницах.
// Вместо 404.css / success.css и старых скриптов — [[$script]] (jQuery, окно «Заказать звонок», телефонный ввод) и lb-scripts.
// Чанки категории Redesign пересохраняются. Повторный запуск ничего не меняет.
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$cat = $modx->getObject('modCategory', ['category' => 'Redesign']);
$desc = ['lb-404' => 'Редизайн: страница 404', 'lb-thanks' => 'Редизайн: страница «Спасибо» после отправки формы'];
foreach (glob(MODX_BASE_PATH . 'core/elements/redesign/chunks/*.tpl') as $path) {
    $name = basename($path, '.tpl'); $file = 'core/elements/redesign/chunks/' . $name . '.tpl';
    $ch = $modx->getObject('modChunk', ['name' => $name]) ?: $modx->newObject('modChunk');
    $isNew = $ch->isNew();
    $ch->fromArray(['name' => $name, 'category' => $cat->get('id'), 'static' => 1, 'source' => 1, 'static_file' => $file, 'snippet' => file_get_contents($path)]);
    if ($isNew) $ch->set('description', $desc[$name] ?? 'Редизайн');
    $ok = $ch->save();
    if ($isNew || !$ok) echo $name, ($isNew ? ' (new)' : ''), ': ', $ok ? 'ok' : 'FAIL', "\n";
}
$css = <<<'CSS'
    <link rel="stylesheet" href="/assets/templates/css/reset.css" />
    <link rel="stylesheet" href="/assets/templates/css/template.css?ver=1.0.2"/>
    <link rel="stylesheet" href="/assets/templates/css/blog.css?ver=17.02.2403"/>
    <link rel="stylesheet" href="/assets/templates/css/fonts.css"/>
    <link rel="stylesheet" href="/assets/templates/css/media.css"/>
    <link rel="stylesheet" href="/assets/templates/css/slimmenu.css"/>
    {$_modx->lexicon->load('babel:translate')}
    [[$lb-head]]
CSS;
$tpl = [
2 => <<<TPL
<!doctype html>
<html lang="[[++cultureKey]]">
<head>
    <meta charset="[[++modx_charset]]" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <base href="[[!++site_url]]" />
    [[Canonical]]
    <title>[[*pagetitle]]</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="autor" content="[[++autor]]">
	<meta name="copyright" content="Copyright (c) [[+phx:input=`now`:strtotime:date=`%Y`]] by [[++site_name]]" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
$css
</head>
<body>
<div class="wrapper interial main-[[++cultureKey]]">
    [[\$lb-header]]
    [[\$lb-404]]
    [[\$lb-footer]]
</div>
    [[\$script]]
    [[\$lb-scripts]]
</body>
</html>
TPL,
6 => <<<TPL
<!doctype html>
<html lang="[[++cultureKey]]">
<head>
    <meta charset="[[++modx_charset]]" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <base href="[[!++site_url]]" />
    <title>[[*longtitle:default=`[[*pagetitle]]`]]</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="autor" content="[[++autor]]">
	<meta name="copyright" content="Copyright (c) [[+phx:input=`now`:strtotime:date=`%Y`]] by [[++site_name]]" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
$css
    {ignore}[[++google-tag-head]]{/ignore}
</head>
<body>
[[++google-tag-body]]
<div class="wrapper interial main-[[++cultureKey]]">
    [[\$lb-header]]
    [[\$lb-thanks]]
    [[\$lb-footer]]
</div>
    [[\$script]]
    [[\$lb-scripts]]
</body>
</html>
TPL,
];
foreach ($tpl as $id => $c) {
    $t = $modx->getObject('modTemplate', $id);
    if ($c !== $t->get('content')) { $t->set('content', $c); echo "template $id: ", $t->save() ? 'ok' : 'FAIL', "\n"; } else echo "template $id: no change\n";
}
$modx->cacheManager->refresh();
