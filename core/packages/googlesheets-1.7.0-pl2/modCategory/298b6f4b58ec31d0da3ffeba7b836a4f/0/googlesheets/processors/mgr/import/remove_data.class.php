<?php

class GoogleSheetsImportRemoveDataProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsImport';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'save';

    public $message = array(
        'count' => 0,
        'remove' => 0,
        'error' => 0,
        'empty' => 0,
    );
    
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
        
        $startTime = microtime(true);
        
        foreach ($ids as $id) {
            /** @var GoogleSheetsItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_import_err_nf'));
            }
            
            // Таблица
            $table = $object->get('name');
            
            // Лист
            $range = $object->get('range');
            
            // Уникальное поле
            $unigue = $object->get('unique');
            if(empty($unigue)) {
                return $this->failure($this->modx->lexicon('googlesheets_err_empty_unigue'));
            }
            
            // Проверяем указаны ли поля импорта
            $importFields = explode(',', $object->get('import_fields'));
            if(empty($importFields)) {
                return $this->failure($this->modx->lexicon('googlesheets_import_err_fields'));
            }
            
            // Проверяем есть ли уникальное поле в массиве полей
            if(!in_array($unigue, $importFields)) {
                return $this->failure($this->modx->lexicon('googlesheets_err_null_unigue'));
            }
            
            if(!$values = $this->GoogleSheets->getValues($table, $range)) {
                $responce = $this->GoogleSheets->getResponce();
                return $this->failure($responce['msg']);
            } else {

                // Всего результатов
                $this->message['count'] = count($values);
                if($object->get('skip_first')) {
                    --$this->message['count'];
                }
                
                // Обрабатываем данные                
                foreach($values as $idx => $value) {
                    // Первая строчка нас не интересует, это название полей
                    if($idx == 0 && $object->get('skip_first')) {
                        continue;
                    }
                    
                    // Длинна полученного массива и длина массива полей для импорта должны быть одинаковы
                    if(count($importFields) > count($value)) {
                        $value = array_pad($value,count($importFields),'');
                    } else {
                        $value = array_slice($value, 0, count($importFields));
                    }
                    
                    $value = array_combine($importFields,$value);

                    if($resource = $this->modx->getObject('modResource', array($unigue => $value[$unigue]))) {
                        if($resource->remove()) {
                            $this->setMessage('remove');
                        } else {
                            $this->setMessage('error');
                        }
                    } else {
                        $this->setMessage('empty');
                    }
                }

                $message = $this->message;
                $endTime = round(microtime(true) - $startTime, 3);
                return $this->success(
                    //$this->modx->lexicon('googlesheets_import_success') . '<br>' . 
                    $this->modx->lexicon('googlesheets_msg_total') . ' : ' . $message['count']  . '.<br>' . 
                    $this->modx->lexicon('googlesheets_msg_empty') . ' : ' . $message['empty']  . '.<br>' . 
                    $this->modx->lexicon('googlesheets_msg_error') . ' : ' . $message['error']  . '.<br>' . 
                    $this->modx->lexicon('googlesheets_msg_remove') . ' ' . $typeResourceLexicon . ' : ' . $message['remove']  . '.<br>' . 
                    $this->modx->lexicon('googlesheets_msg_time') . ' : ' .  $endTime . 's' 
                );
            }
        }

        return $this->success();
    }
    
    public function setMessage($type = '')
    {
        if(!empty($type)) {
            $this->message[$type] = $this->message[$type] + 1;
        }
    }

}

return 'GoogleSheetsImportRemoveDataProcessor';