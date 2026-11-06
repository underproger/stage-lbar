<?php

/** @var array $scriptProperties */
$corePath = $modx->getOption('msfavorites_core_path', null,
    $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/msfavorites/');
/** @var msFavorites $msFavorites */
$msFavorites = $modx->getService('msfavorites', 'msFavorites', $corePath . 'model/msfavorites/',
    array('core_path' => $corePath));
if (!$msFavorites OR !($msFavorites instanceof msFavorites)) {
    return 'Could not load msFavorites class!';
}

$list = $modx->getOption('list', $scriptProperties, 'default', true);
$uid = $modx->getOption('uid', $scriptProperties, $modx->user->id, true);
$sortby = $modx->getOption('sortby', $scriptProperties);
if (empty($uid)) {
    $uid = session_id();
}

$query = array(
    'list' => $list,
    'uid'  => $uid,
);

$data = $msFavorites->getFavoritesOutput($query, true, $sortby);
$msFavorites->setPlaceholders($data);

$data = @$data['list'][$list];
if (empty($data)) {
    $data = '-0';
}

if (!empty($toPlaceholder)) {
    $modx->setPlaceholder($toPlaceholder, $data);

    return '';
}

return $data;

