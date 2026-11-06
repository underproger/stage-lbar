<?php
$modx->regClientCSS(MODX_ASSETS_URL . 'components/simplerating/css/web/default.css');
$modx->regClientScript(MODX_ASSETS_URL . 'components/simplerating/js/web/default.js');

/** @var array $scriptProperties */
$tpl_option = $modx->getOption('tpl', $scriptProperties, 'tplSimpleRating');
$id = $modx->getOption('id', $scriptProperties);

if (empty($id)) {
    $id = $modx->resource->id;
}

$rating_value = 0.0;
$rating_count = 0;
$rating_ips = array();
$rating_active_class = ' rating_active';

$modx->addPackage('simplerating', MODX_CORE_PATH . 'components/simplerating/model/');

$simple_rating = $modx->getObject('SimpleRating', array(
    'resource' => $id
));

if (is_object($simple_rating)) {
    $rating_value = $simple_rating->get('rating_value');
    $rating_count = $simple_rating->get('rating_count');
    $rating_ips = $simple_rating->get('rating_ips');
}

// проверка IP
if ($modx->getOption('simplerating_ip')) {
    $modx->getRequest();
    $ip = $modx->request->getClientIp();
    if (in_array($ip['ip'], $rating_ips)) {
        $rating_active_class = '';
    }
}

$width = 130 * $rating_value / 5;

$output = $modx->getChunk($tpl_option, array(
    'id' => $id,
    'rating_best' => 5,
    'rating_value' => $rating_value,
    'rating_count' => $rating_count,
    'rating_active' => $rating_active_class,
    'rating_width' => str_replace(',', '.', $width)
));

return $output;