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

$msFavorites->initialize($modx->context->key, $scriptProperties);