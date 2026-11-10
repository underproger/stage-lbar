<?php
// Шаг 62: удаление тату (шаблон 19) — блок «Цена на примерах» под таблицей цен: TV tz_price_examples-title (заголовок H3) и
// tz_price_examples (MIGX: фото, что удаляем, цена, примечание; правится в админке — вкладка «Блок 5 - Цены»), доступ — шаблонам 19 и
// «Удаление тату»; начальные значения у RO 625 / RU 321 / EN 1625 — по категориям таблицы цен страницы, без фото (фото — от пользователя).
// Идемпотентный: TV создаются один раз, значения перезаписываются только если их ещё нет (или --force).
define('MODX_API_MODE', true);
require '/home/impua/lbar.ro/www/config.core.php';
require MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX(); $modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR); $modx->setLogTarget('ECHO');
$force = in_array('--force', $argv);
$cat = 126; // «Блок 5 - Цены»
$formtabs = [['caption' => 'Пример', 'fields' => [
    ['field' => 'image', 'caption' => 'Фото (квадратное, от 600×600)', 'inputTVtype' => 'image'],
    ['field' => 'title', 'caption' => 'Что удаляем (зона, размер)'],
    ['field' => 'price', 'caption' => 'Цена (напр. «de la 150 RON»)'],
    ['field' => 'note', 'caption' => 'Примечание (необязательно: сеансы, метод)'],
]]];
$columns = [['header' => 'Фото', 'dataIndex' => 'image', 'renderer' => 'this.renderImage'],
            ['header' => 'Что удаляем', 'dataIndex' => 'title'], ['header' => 'Цена', 'dataIndex' => 'price']];
$defs = [
    'tz_price_examples-title' => ['type' => 'text', 'caption' => 'Примеры цен — заголовок (H3)', 'rank' => 2, 'props' => []],
    'tz_price_examples' => ['type' => 'migx', 'caption' => 'Примеры цен — фото и цена (5–6 шт.)', 'rank' => 3, 'props' => [
        'configs' => '', 'formtabs' => json_encode($formtabs, JSON_UNESCAPED_UNICODE), 'columns' => json_encode($columns, JSON_UNESCAPED_UNICODE),
        'btntext' => 'Добавить пример', 'previewurl' => '', 'jsonvarkey' => '', 'autoResourceFolders' => 'false']],
];
$tplIds = [19];
if ($t = $modx->getObject('modTemplate', ['templatename' => 'Удаление тату'])) $tplIds[] = $t->get('id');
$tvs = [];
foreach ($defs as $name => $d) {
    $tv = $modx->getObject('modTemplateVar', ['name' => $name]) ?: $modx->newObject('modTemplateVar');
    $tv->fromArray(['name' => $name, 'caption' => $d['caption'], 'type' => $d['type'], 'category' => $cat, 'rank' => $d['rank'],
                    'description' => 'Удаление тату: блок «Цена на примерах» под таблицей цен (шаг 62)', 'input_properties' => $d['props']]);
    $tv->save();
    foreach ($tplIds as $tid) {
        if (!$modx->getObject('modTemplateVarTemplate', ['tmplvarid' => $tv->get('id'), 'templateid' => $tid])) {
            $l = $modx->newObject('modTemplateVarTemplate');
            $l->fromArray(['tmplvarid' => $tv->get('id'), 'templateid' => $tid, 'rank' => $d['rank']], '', true, true);
            $l->save();
        }
    }
    $tvs[$name] = $tv;
    echo "TV $name id ", $tv->get('id'), "\n";
}
$data = [
    625 => ['Cât costă îndepărtarea: exemple', [
        ['Tatuaj mic, până la 5 cm²', 'de la 150 RON', ''],
        ['Tatuaj 5–15 cm²', 'de la 250 RON', ''],
        ['Tatuaj 15–20 cm²', 'de la 400 RON', ''],
        ['Tatuaj mare, peste 20 cm²', 'de la 450 RON', ''],
        ['Machiaj permanent sprâncene', '300 RON', ''],
        ['Machiaj permanent buze', '300 RON', 'cu soluție Remover — 400 RON'],
    ]],
    321 => ['Сколько стоит удаление: примеры', [
        // цены — из RU-таблицы этой страницы (у RU свои: татуаж 250 RON, у RO / EN — 300 / 400)
        ['Небольшое тату до 5 см²', '150 RON', ''],
        ['Тату 5–15 см²', '250 RON', ''],
        ['Тату 15–20 см²', '400 RON', ''],
        ['Крупное тату больше 20 см²', 'от 450 RON', ''],
        ['Татуаж бровей', '250 RON', ''],
        ['Татуаж губ', '250 RON', 'лазером или ремувером'],
    ]],
    1625 => ['How much removal costs: examples', [
        ['Small tattoo, up to 5 cm²', 'from 150 RON', ''],
        ['Tattoo 5–15 cm²', 'from 250 RON', ''],
        ['Tattoo 15–20 cm²', 'from 400 RON', ''],
        ['Large tattoo, over 20 cm²', 'from 450 RON', ''],
        ['Eyebrow permanent makeup', '300 RON', ''],
        ['Lip permanent makeup', '300 RON', 'with Remover solution — 400 RON'],
    ]],
];
foreach ($data as $id => [$title, $items]) {
    $r = $modx->getObject('modResource', $id);
    if (!$r) { echo "no resource $id\n"; continue; }
    if (!$force && trim($r->getTVValue('tz_price_examples'))) { echo "$id: уже заполнено\n"; continue; }
    $list = []; $i = 0;
    foreach ($items as [$t, $p, $n]) $list[] = ['MIGX_id' => (string)++$i, 'image' => '', 'title' => $t, 'price' => $p, 'note' => $n];
    $r->setTVValue('tz_price_examples-title', $title);
    $r->setTVValue('tz_price_examples', json_encode($list));
    echo "$id ok\n";
}
