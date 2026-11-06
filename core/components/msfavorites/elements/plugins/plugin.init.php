<?php

/** @var array $scriptProperties */
if ($modx->event->name != 'OnMODXInit') {
    return;
}

$path = $modx->getOption('msfavorites_core_path', null, MODX_CORE_PATH . 'components/msfavorites/model/', true);
$modx->addPackage('msfavorites', $path);

$classSession = 'modSession';
$modx->loadClass($classSession);

$modx->map[$classSession]['composites']['Favorites'] = array(
    'class'       => 'msFavorite',
    'local'       => 'id',
    'foreign'     => 'uid',
    'cardinality' => 'many',
    'owner'       => 'local',
);