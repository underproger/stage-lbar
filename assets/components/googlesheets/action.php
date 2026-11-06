<?php

define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

if (!$GoogleSheets = $modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/')) {
    echo 'Could not load GoogleSheets class!';
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    if($modx->getOption('googlesheets_auth_code') !== $_REQUEST['auth_code']) {
        echo $GoogleSheets->error('googlesheets_err_token');    
    } elseif($_REQUEST['table']) {
        $response = $GoogleSheets->getValues($_REQUEST['table'], $_REQUEST['range']);
    } else {
        $response = $GoogleSheets->process($_REQUEST['mode'], $_REQUEST['id']);
    }
    echo json_encode($response);
}

@session_write_close();