<?php

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');
$modx->getService('error', 'error.modError', '', '');

// Если  запрос не AJAX (XMLHttpRequest), то завершить работу
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit();
}

if (empty($_POST['action'])) {
    exit();
}

$output = array();

switch ($_POST['action']) {

    case 'setRating':

        if (empty($_POST['title']) || empty($_POST['id'])) {
            break;
        }

        $ratingValue = 0.0;
        $ratingCount = 0;
        $ratingIps = array();

        $title = (int)$_POST['title'];
        $id = (int)$_POST['id'];

        $modx->addPackage('simplerating', $modx->getOption('core_path') . 'components/simplerating/model/');

        $simpleRating = $modx->getObject('SimpleRating', array(
            'resource' => $id,
        ));

        if (is_object($simpleRating)) {
            $ratingValue = $simpleRating->get('rating_value');
            $ratingCount = $simpleRating->get('rating_count');
            $ratingIps = $simpleRating->get('rating_ips');
        } else {
            $simpleRating = $modx->newObject('SimpleRating');
            $simpleRating->set('resource', $id);
        }

        $modx->getRequest();
        $ip = $modx->request->getClientIp();

        // проверка IP
        if ($modx->getOption('simplerating_ip')) {
            $modx->getRequest();
            $ip = $modx->request->getClientIp();
            if (in_array($ip['ip'], $ratingIps)) {
                break;
            }
        }
        $ratingNewValue = ($ratingValue * $ratingCount + $title) / ($ratingCount + 1);
        $simpleRating->set('rating_value', $ratingNewValue);
        $simpleRating->set('rating_count', $ratingCount + 1);
        if ($modx->getOption('simplerating_ip')) {
            $ratingIps[] = $ip['ip'];
            $simpleRating->set('rating_ips', $ratingIps);
        }
        $simpleRating->save();

        $output = array(
            'rating_value' => $ratingNewValue,
            'rating_count' => $ratingCount + 1
        );

        break;
}

header('Content-Type: application/json');
$output = json_encode($output);
exit($output);