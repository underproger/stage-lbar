<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

class GoogleSheetsMigxExportProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsMigx';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'save';
    
    public $GoogleSheets;

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('googlesheets_export_err_ns'));
        }
        
        // Проверяем авторизацию
        if (!$this->GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/')) {
            return $this->failure($this->modx->lexicon('Could not load GoogleSheets class!'));
        }
        
        if(!$this->GoogleSheets->getStatus()) {
            return $this->failure($this->GoogleSheets->getResponce('msg'));
        }
        
        // Замеряем время
        $startTime = microtime(true);
        
        foreach ($ids as $id) {
            /** @var GoogleSheetsMigxExport $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_export_err_nf'));
            }
            
            // Таблица для экспорта
            $table = $object->get('name');
            // Лист для экспорта
            $range = $object->get('range');
    
            // Ресурс
            $resourceID = $object->get('resource');
            // MIGX поле
            $migxName = $object->get('migx');
            
            // Получаем данные для экспорта
            $values = $this->GoogleSheets->resource->getTVValue($resourceID, $migxName);
            
            // Форматируем поля
            $values = $this->beforePrepare($values);
            
            $this->modx->invokeEvent('gsOnBeforeExportValues', array(
                'values' => &$values,
                'range' => $range,
            ));            

            $values = $this->prepare($values);
            
            $this->modx->invokeEvent('gsOnExportValues', array(
                'values' => &$values,
                'range' => $range,
            ));
            
            $values = $this->afterPrepare($values, $migxName);
            
            // Очищаем всю таблицу
            if($result = $this->GoogleSheets->clearValues($table, $range)) {
                // Добавляем новые значения
                $result = $this->GoogleSheets->updateValues($table, $range, 'RAW', $values);      
            }
        
            if(!$result) {
                $msgError = $this->GoogleSheets->getResponce('msg') ?: $this->modx->lexicon('googlesheets_export_error');
                return $this->failure($msgError);
            } else {
                return $this->success($this->modx->lexicon('googlesheets_export_success'));
            }
            
        }
        return $this->success();
        
    }
    
    public function beforePrepare($values)
    {
        // Преобразуем в массив
        return json_decode($values,1);
    }
    
    public function prepare($values)
    {
        // Удаляем MIGX_id
        return array_map(function($value){
            $value = array_filter($value, function($v,$k){
                return $k != 'MIGX_id';
            }, ARRAY_FILTER_USE_BOTH);
            
            // Заменяем пустые значения
            $value = array_map(function($v){
                return empty($v) ? '' : $v;
            },$value);
            
            return $value;
        },$values);
    }
    
    public function afterPrepare($values, $migxName)
    {
        
        // Добавляем заголовок
        if($headers = $this->getHeaders($values, $migxName)) {
            $values = array_merge(array($headers), $values);
        }
        
        // Сортируем массив
        foreach($values as $idx => $value) {
            if($idx == 0) continue;
            $values[$idx] = array_merge($values[0], $value);
        }
        
        // Удаляем ключи
        $results = [];
        foreach($values as $idx => $value) {
            $results[$idx] = array();
            foreach($value as $v) {
                $results[$idx][] = $v;
            }
        }

        return $results;
    }
    
    public function getHeaders($values, $migxName)
    {
        
        $tv = $this->modx->getObject('modTemplateVar', array(
            'type' => 'migx',
            'name' => $migxName,
        ));
        if(!$tv) return $values;
        $input_properties = $tv->get('input_properties');
        $headers = array();
        
                
        $configs = $input_properties['configs'];
        if(!empty($configs)) {
            
            $packageName = 'migx';
            $packagepath = $this->modx->getOption('core_path') . 'components/' . $packageName . '/';
            $modelpath = $packagepath . 'model/';
            $prefix = null;
            $this->modx->addPackage($packageName, $modelpath, $prefix);
            
            if($migx = $this->modx->getObject('migxConfig', array('name' => $configs))) {
                $formtabs = json_decode($migx->get('formtabs'),1);
            }
        } else {
            $formtabs = json_decode($input_properties['formtabs'],1);
        }
        
        foreach($formtabs[0] as $idx => $formtab) {
            if(is_array($formtab)) {
                foreach($formtab as $item) {
                    $headers[$item['field']] = $item['caption'];
                } 
            }
        }

        return $headers;
    }
    
}

return 'GoogleSheetsMigxExportProcessor';