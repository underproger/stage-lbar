<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class GoogleSheetsMigxImportProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsMigx';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'save';
    
    public $message = array(
        'count' => 0,
        'create' => 0,
        'update' => 0,
        'error' => 0,
    );
    
    public $table;
    public $range;
    public $importFields;
    public $unigue;
    public $imethod;
    public $importType;
    public $typeResource;

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
            return $this->failure($this->modx->lexicon('googlesheets_import_err_ns'));
        }
        
        // Проверяем авторизацию
        if (!$this->GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/')) {
            return $this->failure($this->modx->lexicon('Could not load GoogleSheets class!'));
        }
        
        if(!$this->GoogleSheets->getStatus()) {
            return $this->failure($this->GoogleSheets->getResponce('msg'));
        }
        
        foreach ($ids as $id) {
            
            /** @var GoogleSheetsExport $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_import_err_nf'));
            }
            
            // Таблица для импорта
            $this->table = $object->get('name');
            // Лист для импорта
            $this->range = $object->get('range');
            
            // Ресурс
            $resourceID = $object->get('resource');
            // MIGX поле
            $migxName = $object->get('migx');
            
            // Получаем данные из таблицы
            if(!$values = $this->GoogleSheets->getValues($this->table, $this->range)) {
                return $this->failure($this->modx->lexicon('googlesheets_err_get_value'));
            } else {
                
                // Удаляем первую строчку
                array_shift($values);
                
                // Event: gsOnBeforeImportValues
                $this->modx->invokeEvent('gsOnBeforeImportValues', array(
                    'values' => &$values,
                    'range' => $this->range,
                ));

                // Форматирование данных
                $values = $this->prepare($values, $migxName);
                
                // Event: gsOnImportValues
                $this->modx->invokeEvent('gsOnImportValues', array(
                    'values' => &$values,
                    'range' => $this->range,
                ));
                
                $values = $this->afterPrepare($values);
                
                if($tv = $this->modx->getObject('modTemplateVar', array('name' => $migxName))) {
                    $tvID = $tv->get('id');
                    if($this->GoogleSheets->resource->importTV($resourceID, $tvID, $values)) {
                        return $this->success($this->modx->lexicon('googlesheets_import_success'));
                    }
                }
                
                return $this->failure($this->modx->lexicon('googlesheets_import_error'));

            }
        }
        
        return $this->success();
    }
    
    public function prepare($values, $migxName)
    {
        $headers = $this->getHeaders($values, $migxName);
        
        $values = array_map(function($value) use ($headers){
            
            if(count($headers) > count($value)) {
                $value = array_pad($value, count($headers), '');
            }
            if(count($headers) < count($value)) {
                $value = array_slice($value, 0, count($headers));   
            }
            $value = array_combine(array_keys($headers), $value);
            
            return $value;
        },$values);
        
        return $values;
    }
    
    public function afterPrepare($values)
    {
        $values = json_encode($values, JSON_UNESCAPED_SLASHES);
        return $values;
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

return 'GoogleSheetsMigxImportProcessor';