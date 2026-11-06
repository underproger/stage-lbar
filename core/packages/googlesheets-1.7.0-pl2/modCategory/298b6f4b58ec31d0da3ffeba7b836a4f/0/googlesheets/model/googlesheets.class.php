<?php

/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

class GoogleSheets
{
    /** @var modX $modx */
    public $modx;

    public $responce = array(
        'status' => false,
        'type' => 'text',
        'msg' => 'Unknown error',
    );

    /** @var Sheets $sheets */
    public $sheets;

    /** @var gsResource $resource */
    public $resource;
    /** @var gsProduct $product */
    public $product;
    /** @var gsCategory $category */
    public $category;
    /** @var gsOrder $order */
    public $order;
    /** @var gsVendor $vendor */
    public $vendor;
    /** @var gsUser $user */
    public $user;
    /** @var gsOptionsPrice2 $optionsprice2 */
    public $optionsprice2;
    /** @var gsRemains $remains */
    public $remains;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = MODX_CORE_PATH . 'components/googlesheets/';
        $assetsUrl = MODX_ASSETS_URL . 'components/googlesheets/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('googlesheets', $this->config['modelPath']);
        $this->modx->lexicon->load('googlesheets:default');
        $this->initialize();
    }

    public function initialize()
    {
        // Get the API client and construct the service object.
        $client = $this->getClient();
        if(is_object($client)) {
            $this->responce['msg'] = $this->modx->lexicon('googlesheets_auth_success');
            $this->responce['status'] = true;
            $this->sheets = new Google\Service\Sheets($client);
        } else {
            if (filter_var($client, FILTER_VALIDATE_URL) !== FALSE) {
                $this->responce['type'] = 'uri';
                $this->responce['uri'] = $client;
            } else {
                if(empty($this->responce['msg'])) {
                    $this->responce['msg'] = 'Authorisation Error';
                }
            }
        }

        $this->loadServices();

        return true;
    }

    // Запускаем процесс
    public function process($mode = 'export', $id = 'null') {

        if(!$id) {
            $msg = $this->modx->lexicon('googlesheets_'.$mode.'_err_id');
            $this->modx->log(modX::LOG_LEVEL_ERROR, $msg);
            return array(
                'status' => false,
                'msg' => $msg
            );
        }

//        if(!$this->getStatus()) {
//            $this->modx->log(modX::LOG_LEVEL_ERROR, $this->getResponce('msg'));
//            return array(
//                'status' => false,
//                'msg' => $this->getResponce('msg')
//            );
//        }

        switch($mode) {
            case 'export':
                $response = $this->modx->runProcessor('export/export', array(
                    'ids' => '['.$id.']',
                ), array(
                    'processors_path' => $this->config['processorsPath'] . 'mgr/'
                ));
                break;
            case 'import':
                $response = $this->modx->runProcessor('import/getvalues', array(
                    'ids' => '['.$id.']',
                ), array(
                    'processors_path' => $this->config['processorsPath'] . 'mgr/'
                ));

                if (!$response->isError()) {
                    $object = $response->getObject();
                    foreach($object['values'] as $value) {
                        $import = $this->modx->runProcessor('import/import', array(
                            'object' => json_encode($object),
                            'value' => json_encode($value),
                        ), array(
                            'processors_path' => $this->config['processorsPath'] . 'mgr/'
                        ));
                        if($import->isError()) {
                            $this->modx->log(modX::LOG_LEVEL_ERROR, $import->getMessage());
                        }
                    }
                }
                break;
            case 'migxExport':
                $response = $this->modx->runProcessor('migx/export', array(
                    'ids' => '['.$id.']',
                ), array(
                    'processors_path' => $this->config['processorsPath'] . 'mgr/'
                ));
                break;
            case 'migxImport':
                $response = $this->modx->runProcessor('migx/import', array(
                    'ids' => '['.$id.']',
                ), array(
                    'processors_path' => $this->config['processorsPath'] . 'mgr/'
                ));
                break;
        }


        if ($response->isError()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $response->getMessage());
            return array(
                'status' => false,
                'msg' => $response->getMessage()
            );
        }
        $responce = $response->response;
        return json_encode(array_merge(array(
            'status' => true,
            'message' => $responce['message'],
        ), $responce['object']));
    }


    // Загружаем другие классы
    public function loadServices()
    {
        // Default classes
        if (!class_exists('gsResource')) {
            require_once dirname(__FILE__) . '/gsresource.class.php';
        }
        if (!class_exists('gsProduct')) {
            require_once dirname(__FILE__) . '/gsproduct.class.php';
        }
        if (!class_exists('gsCategory')) {
            require_once dirname(__FILE__) . '/gscategory.class.php';
        }
        if (!class_exists('gsOrder')) {
            require_once dirname(__FILE__) . '/gsorder.class.php';
        }
        if (!class_exists('gsVendor')) {
            require_once dirname(__FILE__) . '/gsvendor.class.php';
        }
        if (!class_exists('gsUser')) {
            require_once dirname(__FILE__) . '/gsuser.class.php';
        }
        if (!class_exists('gsOptionsPrice2')) {
            require_once dirname(__FILE__) . '/gsoptionsprice2.class.php';
        }
        if (!class_exists('gsRemains')) {
            require_once dirname(__FILE__) . '/gsremains.class.php';
        }

        $this->resource = new gsResource($this->modx, $this->config);
        $this->product = new gsProduct($this->modx, $this->config);
        $this->category = new gsCategory($this->modx, $this->config);
        $this->order = new gsOrder($this->modx, $this->config);
        $this->vendor = new gsVendor($this->modx, $this->config);
        $this->user = new gsUser($this->modx, $this->config);
        $this->optionsprice2 = new gsOptionsPrice2($this->modx, $this->config);
        $this->remains = new gsRemains($this->modx, $this->config);

        return true;
    }

    /**
     * Get status
     * @return mixed
     */
    public function getStatus()
    {
        return $this->responce['status'];
    }

    /**
     * Get responce
     * @return array
     */
    public function getResponce()
    {
        return $this->responce;
    }

    /**
     * Get sheets id
     * @param $table
     * @return mixed|string
     */
    public function getSreadSheetsId($table)
    {
        return explode('/', explode('spreadsheets/d/', $table)[1])[0];
    }

    /**
     * @return string[]
     */
    public function getABC()
    {
        return ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    }

    // Синхронизация
    public function getSyncTable($classKey = 'modResource')
    {
        $syncTable = [];
        foreach(['GoogleSheetsExport'] as $objectKey) {
            $query = $this->modx->newQuery($objectKey, array('type' => $classKey));
            $query->select($this->modx->getSelectColumns($objectKey, $objectKey, '', '', false));
            $query->prepare();
            $query->stmt->execute();
            $result = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $idx => $res) {

                $syncTable[$idx] = array(
                    'mode' => str_replace('GoogleSheets','',$objectKey),
                    'table' => $res['name'],
                    'range' => $res['range'],
                    'fields' => explode(',',$res['export_fields']),
                    'header_table' => $res['header_table'],
                    'unique' => $res['unique'],
                    'create' => $res['create'],
                    'update' => $res['update'],
                    'remove' => $res['remove'],
                );
            }
        }

        return $syncTable;
    }

    public function formattingValue($st, $object = false)
    {

        if($object) {
            $values = array_map(function($field) use ($object){
                return $object[$field];
            },$st['fields']);

            $values = [array_combine($st['fields'], $values)];

            $this->modx->invokeEvent('gsOnBeforeExportValues', array(
                'values' => &$values,
                'range' => $st['range'],
            ));

            $values = $values[0];

        } else {
            $values = $st['value'];
        }

        $values = array_map(function($v){
            return empty($v) ? ' ' : $v;
        },$values);

        return [$values];
    }

    public function getRangeSearch($st, $object, $type = 'xz')
    {
        $values = $this->getValues($st['table'], $st['range']);
        foreach($values as $key => $value) {
            if($key == 0 && $st['header_table']) {
                continue;
            }

            if(count($st['fields']) > count($value)) {
                $value = array_pad($value, count($st['fields']), '');
            }
            if(count($st['fields']) < count($value)) {
                $value = array_slice($value, 0, count($st['fields']));
            }
            $value = array_combine($st['fields'], $value);

            $id = ($type == 'order') ? $object['order'][$st['unique']] : $object[$st['unique']];
            if(in_array($st['unique'], $st['fields'])) {
                if($value[$st['unique']] != $id) {
                    continue;
                }
            } else {
                if($type == 'order' && in_array('num', $st['fields']) ) {
                    if($value['num'] != $object['order']['num']) {
                        continue;
                    }
                } else {
                    continue;
                }
            }

            $ABC = $this->getABC();
            // Получаем диапазаон листа для обновления
            $range = $st['range'] . '!A' . ++$key . ':' . $ABC[count($value) - 1] . $key;
            return $range;
        }

        return false;
    }

    /**
     * Remove code & token
     * @return bool
     */
    public function logout()
    {
        $ss = ['googlesheets_auth_code', 'googlesheets_token'];
        foreach ($ss as $name) {
            $s = $this->modx->getObject('modSystemSetting', $name);
            $s->set('value', '');
            $s->save();
        }
        $this->initialized = [];
        $this->modx->cacheManager->refresh(['system_settings' => []]);

        return true;
    }

    /**
     * Get client
     * @return false|\Google\Client|string
     * @throws \Google\Exception
     */
    private function getClient()
    {
        $client_id = $this->modx->getObject('modSystemSetting','googlesheets_client_id');
        $client_secret = $this->modx->getObject('modSystemSetting','googlesheets_client_secret');
        $auth_token = $this->modx->getObject('modSystemSetting','googlesheets_token');
        $auth_code = $this->modx->getObject('modSystemSetting','googlesheets_auth_code');

        $credentials = [
            'client_id' => trim($client_id->value),
            'client_secret' => trim($client_secret->value),
            'redirect_uri' => 'https://' . $_SERVER['HTTP_HOST'] . MODX_MANAGER_URL."?a=home&namespace=googlesheets",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            'token' => trim($auth_token->value),
            'code' => trim($auth_code->value),
        ];

        if (empty($credentials['client_id'])) {
            $this->responce['msg'] = $this->modx->lexicon('googlesheets_auth_error_client_id');
            return false;
        }

        if (empty($credentials['client_secret'])) {
            $this->responce['msg'] = $this->modx->lexicon('googlesheets_auth_error_client_secret');
            return false;
        }

        $client = new Google\Client();
        $client->setAuthConfig($credentials);
        $client->setRedirectUri($credentials['redirect_uri']);
        $client->setAccessType('offline');
        $client->addScope("https://www.googleapis.com/auth/drive");

        if (empty($credentials['code'])) {
            return $client->createAuthUrl();
        }

        if (empty($credentials['token'])) {
            $creds = $client->fetchAccessTokenWithAuthCode($credentials['code']);
            $token = json_encode($creds,1);
            $client->setAccessToken($token);

            $auth_token->set('value', $token);
            if ($auth_token->save()) {
                $this->modx->cacheManager->refresh(['system_settings' => []]);
            }
        }

        if (!$token = $client->getAccessToken()) {
            $client->setAccessToken($credentials['token']);
        }

        // Check token
        if ($client->isAccessTokenExpired()) {

//            if ($refresh_token = $client->getRefreshToken()) {
//                $client->fetchAccessTokenWithRefreshToken($refresh_token);
//            }
//
//            if ($token = $client->getAccessToken()) {
//                $auth_token->set('value', json_encode($token,1));
//                if ($auth_token->save()) {
//                    $this->modx->cacheManager->refresh(['system_settings' => []]);
//                }
//            }
        }

        return $client;
    }



    public function hasError($result) {
        if(is_array($result) && $result['status'] == 'error') {
            $this->responce['msg'] = $result['message'];
            return true;
        }
        return false;
    }

    public function error($msg = '') {
        return empty($msg) ? '' : $this->modx->lexicon($msg);
    }

    /**
     * Get values
     * @param $table
     * @param $range
     * @return false
     */
    public function getValues($table, $range)
    {
        if (empty($table)) {
            $this->responce['msg'] = $this->modx->lexicon('googlesheets_auth_error_table_uri');
            return false;
        }

        if (empty($range)) {
            $this->responce['msg'] = $this->modx->lexicon('googlesheets_auth_error_range');
            return false;
        }

        $spreadsheetId = $this->getSreadSheetsId($table);
        $result = $this->sheets->spreadsheets_values->get($spreadsheetId, $range);
        return $this->hasError($result) ? false : $result->getValues();
    }

    /**
     * Append values
     * @param $table
     * @param $range
     * @param $valueInputOption
     * @param $values
     * @return false|string
     */
    public function appendValues($table, $range, $valueInputOption, $values)
    {
        $body = new Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => $valueInputOption
        ];

        $spreadsheetId = $this->getSreadSheetsId($table);
        $result = $this->sheets->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
        return $this->hasError($result) ? false : $result->getUpdates()->getUpdatedCells() . " cells updated. Range: " . $range;
    }

    /**
     * Update values
     * @param $table
     * @param $range
     * @param $valueInputOption
     * @param $values
     * @return false|string
     */
    public function updateValues($table, $range, $valueInputOption, $values)
    {
        $body = new Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => $valueInputOption
        ];
        $spreadsheetId = $this->getSreadSheetsId($table);

        if (!$this->clearValues($table, $range)) {
            return false;
        }

        $result = $this->sheets->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
        return $this->hasError($result) ? false : $result->getUpdatedCells() . " cells updated. Range: " . $range;
    }

    /**
     * Clear table sheet
     * @param $table
     * @param $range
     * @return bool
     */
    public function clearValues($table, $range)
    {
        $requestBody = new Google\Service\Sheets\ClearValuesRequest;
        $spreadsheetId = $this->getSreadSheetsId($table);
        $result = $this->sheets->spreadsheets_values->clear($spreadsheetId, $range, $requestBody);
        return $this->hasError($result) ? false : true;
    }

    // batchClearValues - еще не реализовано
//    public function batchClearValues($spreadsheetId,$ranges)
//    {
//        $service = $this->service;
//        $requestBody = new Google_Service_Sheets_BatchClearValuesRequest([
//            'ranges' => $ranges
//        ]);
//
//        $result = $service->spreadsheets_values->batchClear($spreadsheetId, $requestBody);
//        return $this->hasError($result) ? false : true;
//    }

    // batchUpdateRequest - еще не реализовано
//    public function batchUpdateRequest($table, $range)
//    {
//        $service = $this->service;
//        $requestBody = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest('{"requests": [
//                {
//                  "addConditionalFormatRule": {
//                    "rule": {
//                      "ranges": [
//                        {
//                          "sheetId": '.$table.',
//                          "startColumnIndex": 0,
//                          "endColumnIndex": 1,
//                        }
//                      ],
//                      "booleanRule": {
//                        "format": {
//                          "backgroundColor": {
//                            "green": 0.2,
//                            "red": 0.8,
//                          }
//                        }
//                      }
//                    },
//                    "index": 0
//                  }
//                }
//              ]
//        ]');
//
//        $spreadsheetId = $this->getSreadSheetsId($table);
//        $result = $service->spreadsheets->batchUpdate($spreadsheetId, $range, $requestBody);
//        return $this->hasError($result) ? false : true;
//    }
}