<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

class GoogleSheetsExportEnableProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsExport';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'save';
    
    public $GoogleSheets = '';
    public $object = array();
    
    public $message = array(
        'total' => 0,
        'export' => 0,
        'error' => 0,
    );
    
    public $exportFields = [];
    public $exportFieldsExtra = [];
    

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        $this->object['offset'] = $offset = (int)$this->getProperty('offset');
        $this->object['limit'] = $limit = (int)$this->getProperty('limit');
        
        if($this->getProperty('message')) {
            $this->message = $this->modx->fromJSON($this->getProperty('message'));
        }
        
        if($this->getProperty('total')) {
            $this->object['total'] = (int)$this->getProperty('total');
        }
        
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
        
        foreach ($ids as $id) {
            /** @var GoogleSheetsExport $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_export_err_nf'));
            }
            
            $this->object['ids'] = array($id);
            
            // Таблица для экспорта
            $this->object['table'] = $table = $object->get('name');
            // Лист для экспорта
            $this->object['range'] = $range = $object->get('range');
    
            // Тип экспорта
            $this->object['exportType'] = $exportType = $object->get('type') ?: 'modResource';

            // Настройка экспорта
            $this->object['imethod'] = $imethod = $object->get('imethod') ?: 'Update';
            
            // Заголовки
            $this->object['header_table'] = $header_table = $object->get('header_table');
            
            // Получаем поля для экспорта
            if(!$exportFieldsPrepare = $this->getExportFields($object->get('export_fields'))) {
                return $this->failure($this->modx->lexicon('googlesheets_export_err_fields'));   
            }
            
            // Получаем данные для экспорта
            switch($exportType) {
                
                // Ресурсы
                case 'modResource':
                    
                    if(!$offset) {
                        $this->object['total'] = (int)$this->GoogleSheets->resource->getTotal($range);
                    }
                    
                    $row = $this->GoogleSheets->resource->getResources($range, $limit, $offset);
                    
                    // Добавляем дополнительные поля (TV)
                    $row = $this->GoogleSheets->resource->joinTemplateVar($range, $row, $exportFieldsPrepare);
                    
                    // Добавялем изображения
                    if(in_array('images', $exportFieldsPrepare)) {
                        $row = $this->GoogleSheets->resource->joinImages($range, $row, 'msResourceFile');
                    }
                    
                    break;
                
                // Категории
                case 'msCategory': 
                    
                    if(!$offset) {
                        $this->object['total'] = (int)$this->GoogleSheets->category->getTotal($range);
                    }
                    
                    $row = $this->GoogleSheets->category->getCategory($range, $limit, $offset);

                    // Добавляем дополнительные поля (TV)
                    $row = $this->GoogleSheets->resource->joinTemplateVar($range, $row, $exportFieldsPrepare);
                    
                    // Добавялем изображения
                    if(in_array('images', $exportFieldsPrepare)) {
                        $row = $this->GoogleSheets->resource->joinImages($range, $row, 'msResourceFile');
                    }
                    break;     
                
                // Товары
                case 'msProduct': 
                    
                    if(!$offset) {
                        $this->object['total'] = (int)$this->GoogleSheets->product->getTotal($range);
                    }
                    
                    $row = $this->GoogleSheets->product->getProducts($range, $limit, $offset);
                    
                    // Добавляем дополнительные поля (TV)
                    $row = $this->GoogleSheets->resource->joinTemplateVar($range, $row, $exportFieldsPrepare);
                    
                    // Добавляем опции товара
                    $row = $this->GoogleSheets->product->joinProductOptions($range, $row, $exportFieldsPrepare);
                    
                    // Добавялем изображения
                    if(in_array('images', $exportFieldsPrepare)) {
                        
                        $source = $this->modx->getOption('ms2gallery_source_default');
                        $tab = $this->modx->getOption('ms2gallery_disable_for_ms2');
                        if($source && !$tab) {
                            // ms2Gallery
                            $row = $this->GoogleSheets->resource->joinImages($range, $row);
                        } else {
                            if($this->modx->getoption('ms2_product_tab_gallery')) {
                                $row = $this->GoogleSheets->product->joinImages($range, $row);
                            }
                        }
                    }
    
                    break;
                    
                // Заказы
                case 'msOrder': 
                    
                    if(!$offset) {
                        $this->object['total'] = (int)$this->GoogleSheets->order->getTotal($range);
                    }
                    
                    $row = $this->GoogleSheets->order->getOrders($range, $this->exportFields, $limit, $offset);
                    // Добавляем дополнительные свойства к массиву
                    if(in_array('address_properties', $exportFieldsPrepare)) {
                        $row = $this->propertiesToString($row);
                    }

                    break;
                    
                // Производители
                case 'msVendor': 
                    $row = $this->GoogleSheets->vendor->getVendors($range); 
                    break;    
                    
                // Пользователи
                case 'modUser': 
                    $row = $this->GoogleSheets->user->getUsers($range); 
                    break;
                
                // Покупатели
                case 'msClient': 
                    $row = $this->GoogleSheets->order->getClients($range); 
                    break; 
                    
                // Дополнительные опции товара
                case 'msOptionsPrice2': 
                    $row = $this->GoogleSheets->optionsprice2->getOptionsPrice2($range, $exportFieldsPrepare); 
                    break;
                    
                // Остатки товара
                case 'msProductRemains': 
                    $row = $this->GoogleSheets->remains->getProductRemains($range); 
                    break;    
            }

            if(count($row) < 5000) {
                $this->object['total'] = count($row);
            }
            
            // Фильтруем результат (получаем только нужные поля)
            $values = $this->beforePrepare($row, $exportFieldsPrepare);

            $this->modx->invokeEvent('gsOnBeforeExportValues', array(
                'values' => &$values,
                'range' => $range,
            ));

            // Форматируем поля
            $values = $this->prepare($values);
            
            $this->modx->invokeEvent('gsOnExportValues', array(
                'values' => &$values,
                'range' => $range,
            ));

            if($offset == 0) {
                $values = $this->afterPrepare($values, $header_table);
            } else {
                $values = $this->afterPrepare($values);
            }

            $this->modx->invokeEvent('gsOnAfterExportValues', array(
                'values' => &$values,
                'range' => $range,
            ));
            
            // Экспортируем данные в таблицу
            if($imethod == 'Update') {
                // Очищаем всю таблицу
                if($offset == 0) {
                    if(!$result = $this->GoogleSheets->clearValues($table, $range)) {
                        $msgError = $this->GoogleSheets->getResponce('msg');
                        $this->modx->log(1, print_r($result, 1));
                        return $this->failure($msgError);
                    }
                    // Добавляем новые значения
                    $result = $this->GoogleSheets->updateValues($table, $range, 'RAW', $values);
                } else {
                    $result = $this->GoogleSheets->appendValues($table, $range, 'RAW', $values);
                }

            } else {
                // Добавляем после последней записи в таблицу
                $result = $this->GoogleSheets->appendValues($table, $range, 'RAW', $values);
            }
            
            if(!$result) {
                $msgError = $this->GoogleSheets->getResponce('msg') ?: $this->modx->lexicon('googlesheets_export_error');
                $this->modx->log(1, print_r($result, 1));
                // Записываем кол-во ошибок
                $this->message['error'] += count($values);
                return $this->failure($msgError);
            } else {
                // Записываем кол-во экспортированных данных
                $this->message['export'] += count($values);
                if($offset == 0 && $header_table) {
                   --$this->message['export']; 
                }
            }
            
            // Event: gsOnAfterExportValues
            $this->modx->invokeEvent('gsOnAfterExportValues', array_merge($this->message, array(
                'range' => $range,
            )));
            
            return $this->success($this->modx->lexicon('googlesheets_content_success'), array_merge($this->object, array(
                'message' => $this->message
            )));
            
        }
        
        return $this->success();
        
    }

    
    public function getExportFields($fields)
    {
        if(!$fields) {
            return false;
        }
        $fields = array_map('trim', explode(',', $fields));
        $this->exportFields = $fields;
        
        // Форматируем поля
        $fields = array_map(function($v) {
            return str_replace('_name', '', $v);
        }, $fields);
        
        
        return $fields;   
    }
    
    public function propertiesToString($orders)
    {
        return array_map(function($order){
            if(isset($order['address_properties']) && !empty($order['address_properties'])) {
                $properties = json_decode($order['address_properties'],1);
                $fields = [];
                foreach($properties as $name => $value) {
                    $name = 'properties_' . str_replace('extfld_', '', $name);
                    $order[$name] = $value;
                    if(!in_array($name, $this->exportFields)) {
                        $fields[] = $name;
                    }
                }

                unset($order['address_properties']);
                $key = array_search('address_properties',$this->exportFields);
                if($key > -1) {
                    unset($this->exportFields[$key]);
                    $this->exportFields = array_merge($this->exportFields, $fields);
                }
            }
            return $order;
        },$orders);
    }
    
    // Фильтруем полученные данные
    public function beforePrepare($values, $exportFieldsPrepare)
    {
        
        $values = array_map(function($value) use($exportFieldsPrepare){

            // msProductRemains
            if(isset($value['options']) && !empty($value['options'])) {
                $options = json_decode($value['options'],1);
                foreach($exportFieldsPrepare as $field) {
                    if(preg_match('/^options.(\w+)/i', $field)) {
                        $key = str_replace('options.','',$field);
                        $value[$field] = $options[$key];
                    }
                }
            }
            
            $value = $this->addModificationField($value);
            
            // SEO TAB
            if(isset($value['properties']) && !empty($value['properties'])) {
                $properties = json_decode($value['properties'],1);
                $stercseo = isset($properties['stercseo']) ? $properties['stercseo'] : [];
                foreach($stercseo as $key => $seo) {
                    $value["seo.{$key}"] = $seo;
                } 
            }

            // Фильтруем
            $value = array_filter($value,function($name) {
                return in_array($name, $this->exportFields);
            },ARRAY_FILTER_USE_KEY);

            // Сортировка
            $fields = array_flip($this->exportFields);
            $fields = array_map(function($v){
                return '';
            },$fields);

            $value = array_merge($fields,$value);

            return $value;
        },$values);
        
        return $values;
    }
    
    public function prepare($values)
    {
        return array_map(function($value) {
            return $this->dataFormatting($value);
        },$values);
    }
    
    public function afterPrepare($values, $header_table = null)
    {
        $values = array_map(function($value){
            return array_values($value);
        },$values);
        
        // Записываем кол-во найденных позиций
        $this->message['total'] += count($values);
        
        // Добавляем заголовки
        if($header_table) {
            $values = array_merge(array($this->exportFields), $values);
        }
        
        return $values;
    }
    
    public function addModificationField($value) {
        
        foreach($this->exportFields as $field) {
            $key = str_replace('_name', '', $field);
            switch($field) {
                case 'categories':
                    if(!empty($value['id'])) {    
                        $value[$field] = $this->getCategories($value['id']) ?: ''; 
                    }   
                    break;
                case 'categories_name':
                    if(!empty($value['id'])) {
                        $value[$field] = $this->getCategories($value['id'], 'name') ?: ''; 
                    }    
                    break;
                case 'parent_name':
                    if(!empty($value[$key])) {
                        $value[$field] = $this->getField($value[$key]);
                    }
                    break;
                case 'template_name':
                    if(!empty($value[$key])) {
                        $value[$field] = $this->getField($value[$key], 'templatename', 'modTemplate');
                    }    
                    break;
                case 'keywords':
                case 'seo.keywords':
                    if(!empty($value['id'])) {
                        $value[$field] = $this->getField(array('resource' => $value['id']), 'keywords', 'seoKeywords'); 
                    }
                    break;
                case 'seo.redirect':
                    if(!empty($value['id'])) {
                        $value[$field] = $this->getFields(array('resource' => $value['id']), 'url', 'seoUrl'); 
                    }
                    break;
            }
        }
        
        return $value;
    }
    
    public function dataFormatting($value)
    {
        foreach($this->exportFields as $field) {
            $key = str_replace('_name', '', $field);
            switch($field) {
                case 'size':
                case 'color':
                case 'tags':
                    if(!empty($value[$key])) {
                        $value[$field] = implode(',', json_decode($value[$key],1)); 
                    }
                    break;
                case 'options':
                    if(!empty($value[$key])) {
                        $options = json_decode($value[$key],1);
                        $output = array();
                        foreach($options as $k => $option) {
                            $output[] = "{$k}:{$option}";
                        }
                        $value[$field] = implode(',',$output);
                    }
                    break;
            }
        }


        
        // Невозможно записать в таблицу пустые неопределенные значения
        // Поэтому заменяем их на пустую строку.
        $value = array_map(function($v,$k){
            if($v == '0') return $v;
            return empty($v) ? ' ' : $v;
        },$value,array_keys($value));
        
        return $value;
    }
    
    public function getCategories($product_id, $field = 'id')
    {
        $categories = $this->GoogleSheets->category->getCategories($product_id);
        if($field == 'name') {
            $categories = array_map(function($id){
                return $this->getField($id, 'pagetitle');
            },$categories);
        }
        
        return implode(',', $categories);
    }
    
    public function getField($where, $field = 'pagetitle', $classKey = 'modResource')
    {
        if($res = $this->modx->getObject($classKey, $where)) {
            return $res->get($field);
        }
        return is_array($where) ? '' : $where;
    }
    
    public function getFields($where, $field = 'pagetitle', $classKey = 'modResource')
    {
        if($classKey == 'seoUrl') {
            $corePath = $this->modx->getOption('stercseo.core_path', null, $this->modx->getOption('core_path').'components/stercseo/');
            $this->modx->addPackage('stercseo', $corePath.'model/'); 
        }
        
        if($objects = $this->modx->getCollection($classKey, $where)) {
            $output = array_map(function($object) use($field) {
                $f = $object->get($field);
                $f = str_replace('%3A', ':', $f);
                $f = str_replace('%2F', '/', $f);
                return $f;
            }, $objects);
            
            return implode(', ', $output);
        }
    
        return is_array($where) ? '' : $where;
    }

}

return 'GoogleSheetsExportEnableProcessor';