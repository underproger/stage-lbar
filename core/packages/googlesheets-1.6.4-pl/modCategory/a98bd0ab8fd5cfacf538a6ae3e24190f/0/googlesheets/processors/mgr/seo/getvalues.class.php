<?php

class GoogleSheetsSeoGetValuesProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsSeo';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'save';
    
    public $GoogleSheets = '';
    public $ABC = '';
    
    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }
        
        stream_context_set_default(
            array(
                'http' => array(
                    'method' => 'HEAD'
                )
            )
        );

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('googlesheets_seo_err_ns'));
        }
        
        // Проверяем авторизацию
        if (!$this->GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/')) {
            return $this->failure($this->modx->lexicon('Could not load GoogleSheets class!'));
        }
        
        if(!$this->GoogleSheets->getStatus()) {
            return $this->failure($this->GoogleSheets->getResponce('msg'));
        }
        
        $this->ABC = $this->GoogleSheets->getABC();
        
        foreach ($ids as $id) {
            /** @var GoogleSheetsSeo $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_seo_err_nf'));
            }
            
            // Таблица для экспорта
            $table = $this->GoogleSheets->getSreadSheetsId($object->get('name'));
            // Лист для экспорта
            $range = $object->get('range');
            // Класс ресурса
            $classResource = $object->get('class_key_resource') ?: 'modResource';
            // Настройка экспорта
            $imethod = $object->get('imethod') ?: 'Update';
            
            // Получаем поля для экспорта
            if(!$seoFields = $object->get('fields')) {
                return $this->failure($this->modx->lexicon('googlesheets_seo_err_fields'));
            }
            $seoFields = str_replace(' ', '', $seoFields);
            $seoFields = explode(',', $seoFields);
            
            // Проверяем существует ли поле id
            if(!in_array('id',$seoFields)) {
                return $this->failure($this->modx->lexicon('googlesheets_err_seo_empty_id'));
            }
            
            // Получаем данные для экспорта
            switch($classResource) {
                case 'modResource' :
                    $row = $this->GoogleSheets->getResources($range, $seoFields, false);
                    break;
                // Категории
                case 'msCategory': 
                    $row = $this->GoogleSheets->getCategory($range, $seoFields); 
                    break;    
                // Товары
                case 'msProduct': 
                    $row = $this->GoogleSheets->getProducts($range, $seoFields);
                    break;
            }
            
            // Добавляем seo поля
            $row = $this->addSeoFields($range, $row, $seoFields);
            
            // Получаем значения для экспорта
            $values = $this->getValues($row, $seoFields);
            
            // Event: gsOnExportValues
            $this->modx->invokeEvent('gsOnExportValues', array(
                'values' => &$values,
                'range' => $range,
            ));
            
        }
        
        return $this->success($this->modx->lexicon('googlesheets_title_success'), [
            'table'  => $table,
            'range'  => $range,
            'imethod'  => $imethod,
            'values' => $values,
            'total' => count($values),
        ]);
    }
    
    public function xpath($field, $seoFields, $url)
    {
        $seoField = '';
        if(preg_match('/^seo.(\w+)/i', $field)) {
            switch(str_replace('seo.', '', $field)) {
                case 'title': 
                    $seoField = '//title';
                    break;
                case 'description': 
                    $seoField = "//meta[@name='description']/@content";
                    break; 
                case 'keywords': 
                    $seoField = "//meta[@name='keywords']/@content";
                    break;
                case 'robots': 
                    $seoField = "//meta[@name='robots']/@content";
                    break;     
                case 'canonical': 
                    $seoField = "//link[@rel='canonical']/@href";
                    break; 
                case 'alternate': 
                    $seoField = "//link[@rel='alternate']/@href";
                    break; 
                default:
                    if(preg_match('/^seo.h(\d+)/i', $field)) {
                        $seoField = '//h' . str_replace('seo.h', '', $field);
                    }
            }
        }
        
        if(preg_match('/^count.(\w+)/i', $field)) {
            switch(str_replace('seo.', '', $field)) {
                case 'products': 
                    $seoField = "//div[contains(@class,'ms2_product')]"; 
                    break; 
            }    
        }
        
        
        if(preg_match('/^len.(\w+)/i', $field)) {
            $key = array_search('seo.' . str_replace('len.', '', $field), $seoFields);
            if($key > -1) {
                $seoField = "=LEN(" . $this->ABC[$key] . "{idx})"; 
            }
        }
        
        if(preg_match('/^http.(\w+)/i', $field)) {
            $http = get_headers($url, 1);
            switch(str_replace('http.', '', $field)) {
                case 'status': 
                    $seoField = $http[0];
                    break;
            }
        }
        
        return $seoField;
    }
    
    public function addSeoFields($range, $resources, $seoFields)
    {
        foreach($resources as $idx => $resource) {
            if(!isset($resource['id'])) continue;
            $url = $this->modx->makeUrl($resource['id'], '', '', 'full');
            foreach($seoFields as $seoField) {
                $seoFieldValue = $this->xpath($seoField, $seoFields, $url);
                
                // Event: gsOnBeforeGetSeoField
                $this->modx->invokeEvent('gsOnBeforeGetSeoField', array(
                    'seoField' => $seoField,
                    'seoFieldValue' => &$seoFieldValue,
                    'range' => $range,
                ));
                
                if(empty($resources[$idx][$seoField])) {
                    if(empty($seoFieldValue)) {
                        $resources[$idx][$seoField] = '';
                    } else {
                        if(preg_match('/^seo.(\w+)/i', $seoField)) {
                            $resources[$idx][$seoField] = '=IMPORTXML("'.$url.'";"'.$seoFieldValue.'")';
                        }
                        if(preg_match('/^count.(\w+)/i', $seoField)) {
                            $resources[$idx][$seoField] = '=COUNTA(IMPORTXML('."'.$url.'";"'.$seoFieldValue.'".'))';    
                        }
                        if(preg_match('/^len.(\w+)/i', $seoField)) {
                            $resources[$idx][$seoField] = str_replace('{idx}', $idx + 1, $seoFieldValue);
                        }
                        if(preg_match('/^http.(\w+)/i', $seoField)) {
                            $resources[$idx][$seoField] = $seoFieldValue;    
                        }
                    }
                }
            }
        }

        // Event: gsOnGetSeoFields
        $this->modx->invokeEvent('gsOnGetSeoFields', array(
            'resources' => &$resources,
            'range' => $range,
        ));
        
        return $resources;
    }
    

    public function getValues($row, $seoFields)
    {

        foreach($row as $idx => $value) {
            // Форматируем данные
            $value = $this->dataFormatting($value);
            
            // Формируем массив значений для передачи
            $row[$idx] = array_values($value);
        }
        return $row;
    }
    
    public function dataFormatting($value)
    {
        
        // Невозможно записать в таблицу пустые неопределенные значения
        // Поэтому заменяем их на пустую строку.
        $value = array_map(function($v){
            if($v == '0') return $v;
            
            $arr = json_decode($v);
            if(is_array($arr)) {
                $v = implode(',', $arr);
            }
    
            return empty($v) ? '' : $v;
        },$value);
        
        return $value;
    }

}

return 'GoogleSheetsSeoGetValuesProcessor';