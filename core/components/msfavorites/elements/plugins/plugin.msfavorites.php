<?php

/** @var array $scriptProperties */
$corePath = $modx->getOption('msfavorites_core_path', null,
    $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/msfavorites/');
/** @var msFavorites $msFavorites */
$msFavorites = $modx->getService('msfavorites', 'msFavorites', $corePath . 'model/msfavorites/',
    array('core_path' => $corePath));
if (!$msFavorites OR !($msFavorites instanceof msFavorites)) {
    return false;
}

$className = 'msFavorites' . $modx->event->name;
$modx->loadClass('msFavoritesPlugin', $msFavorites->getOption('modelPath') . 'msfavorites/systems/', true,
    true);
$modx->loadClass($className, $msFavorites->getOption('modelPath') . 'msfavorites/systems/', true, true);
if (class_exists($className)) {
    /** @var msFavoritesPlugin $handler */
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}
return;