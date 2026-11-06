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

$uid = $modx->getOption('uid', $scriptProperties, $modx->user->id, true);
$rid = $modx->getOption('rid', $scriptProperties, $modx->resource->id, true);
$list = $modx->getOption('list', $scriptProperties, 'default', true);

if (empty($uid)) {
    $uid = session_id();
}

$query = array(
    'uid'  => $uid,
    'rid'  => $rid,
    'list' => $list,
);

$data = array();
$c = $modx->newQuery('msFavorite', $query);
/** @var msFavorite $instance */
if ($instance = $modx->getObject('msFavorite', $c)) {
    $data = $instance->get('properties');
}

$output = "";
switch ($scriptProperties["return"]) {
    case "data":
        $output = $data;
        break;
    case "json":
        $output = json_encode($data, true);
        break;
    default:
        /** @var pdoFetch $pdoFetch */
        $fqn = $modx->getOption("pdoFetch.class", null, "pdotools.pdofetch", true);
        $path = $modx->getOption("pdofetch_class_path", null, MODX_CORE_PATH . "components/pdotools/model/", true);
        if ($pdoClass = $modx->loadClass($fqn, $path, false, true)) {
            $pdoFetch = new $pdoClass($modx, $scriptProperties);
        } else {
            return false;
        }

        if (is_array($data)) {
            $output .= $pdoFetch->getChunk($tpl, $data);
        }
        break;
}

if ($modx->user->hasSessionContext("mgr") AND !empty($showLog)) {
    $modx->log(1, print_r($output, 1));
}

return $output;