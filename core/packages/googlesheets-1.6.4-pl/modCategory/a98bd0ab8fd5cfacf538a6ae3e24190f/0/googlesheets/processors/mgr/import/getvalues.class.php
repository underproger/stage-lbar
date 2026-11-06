<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class GoogleSheetsImportGetValuesProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsImport';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'save';

    public $object = array();

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

            $this->object = $object->toArray();

            // Таблица для импорта
            $this->object['table'] = $object->get('name');

            // Получаем поля импорта
            $this->setImportFields($this->object['import_fields']);

            $this->object['unique'] = explode(',',$this->object['unique']);

            // Получаем данные из таблицы
            if(!$values = $this->GoogleSheets->getValues($this->object['table'], $this->object['range'])) {
                return $this->failure($this->modx->lexicon('googlesheets_err_get_value'));
            } else {

                if(!$values = $this->beforePrepare($values)) {
                    return $this->failure($this->modx->lexicon('googlesheets_import_err_not_unique'));
                }

                // Event: gsOnBeforeImportValues
                $this->modx->invokeEvent('gsOnBeforeImportValues', array(
                    'values' => &$values,
                    'range' => $this->object['range'],
                    'fields' => $this->object['import_fields'],
                ));

                // Тип ресурса
                $this->object['class_key'] = $this->object['type'];
                $this->object['classKey'] = $this->object['type'];
                switch($this->object['type']) {
                    case 'modResource' :
                        $this->object['class_key'] = 'modDocument';
                        break;
                    case 'msOptionsPrice2' :
                        $this->object['classKey'] = 'msopModification';
                        break;
                    case 'msProductRemains' :
                        $this->object['classKey'] = 'msprRemains';
                        break;
                }

                // Форматирование данных
                $values = $this->prepare($values);

                // Event: gsOnImportValues
                $this->modx->invokeEvent('gsOnImportValues', array(
                    'values' => &$values,
                    'range' => $this->object['range'],
                ));

            }
        }

        return $this->success($this->modx->lexicon('googlesheets_title_success'),  array_merge($this->object, array(
                'values' => $values,
                'total' => count($values)
            )
        ));
    }

    public function setImportFields($fields)
    {
        if(!$fields) {
            return $this->failure($this->modx->lexicon('googlesheets_import_err_empty_fields'));
        }
        $fields = array_map('trim', explode(',', $fields));

        $this->object['import_fields'] = $fields;
    }

    public function beforePrepare($values)
    {
        // Удаляем первую строчку
        if($this->object['skip_first']) {
            array_shift($values);
        }

        // Проверяем существует ли уникальное поле в списке полей для импорта
        foreach($this->object['unique'] as $unique) {
            if(!in_array($unique, $this->object['import_fields'])) {
                return false;
            }
        }

        return $values;
    }

    public function prepare($values)
    {

        $values = array_map(function($value){

            // Удаляем поля ignore в массиве значений
            $value = array_filter($value, function($v, $k){
                $f = $this->object['import_fields'];
                return !empty($f[$k]) && $f[$k] !== 'ignore';
            }, ARRAY_FILTER_USE_BOTH);

            // Подставляем поля импорта в массив
            $importFields = array_filter($this->object['import_fields'], function($v){
                return !empty($v) && $v !== 'ignore';
            });

            // Подставляем нужные ключи
            if(count($importFields) > count($value)) {
                $value = array_pad($value, count($importFields), '');
            }
            if(count($importFields) < count($value)) {
                $value = array_slice($value, 0, count($importFields));
            }
            $value = array_combine($importFields, $value);

            // Если уникальное поле не добавилось в массив(возможно оно пустое), то пропускаем строчку
            foreach($this->object['unique'] as $unique) {
                if(!isset($value[$unique])) {
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, $this->modx->lexicon('googlesheets_err_null_unique'));
                    return false;
                }
            }

            // Преобразуем данные
            array_walk($value, function(&$val, $field){
                switch($field){
                    case 'parent':
                    case 'parent_name':
                        if(!empty($val) && !is_numeric($val)) {
                            $val = $this->getID(array('pagetitle' => $val)) ?: $val;
                        }
                        break;
                    case 'template':
                    case 'template_name':
                        if(!empty($val) && !is_numeric($val)) {
                            $val = $this->getID(array('templatename' => $val), 'modTemplate') ?: 0;
                        }
                        break;
                    case 'color':
                    case 'tags':
                    case 'size':
                    case 'images':
                        $val = explode(',', $val);
                        break;
                    case 'categories':
//                        $categories = explode(',', $val);
//                        $categories = array_map(function($category) {
//                            if(!empty($category) && !is_numeric($category)) {
//                                return $this->getID(array('pagetitle' => $category)) ?: $category;
//                            }
//                        },$categories);
//                        $val = implode(',', $categories);
                        break;
                }
            });

            // Преобразуем опции в массив
            foreach($value as $key => $val) {
                if(preg_match('/^option.(\w+)/i', $key)) {
                    $value[$key] = explode(',', $val);
                }
            }

            // msProductRemains
            if($this->object['type'] == 'msProductRemains') {
                if(isset($value['options'])) {
                    $options = explode(',', $value['options']);
                } else {
                    $options = array();

                    foreach($value as $field => $v) {
                        if(preg_match('/^options.(\w+)/i', $field)) {
                            $k = str_replace('options.','',$field);
                            $options[$k] = $v;
                        }
                    }

                }

                $output = array();
                foreach($options as $option) {
                    $option = explode(':', $option);
                    $output[$option[0]] = $option[1] ?: $option[0];
                }
                $options = json_encode($output);
                $value['options'] = $options;

            }

            return $value;
        }, $values);

        return $values;
    }

    public function getID($where = [], $classKey = 'modResource')
    {
        if($res = $this->modx->getObject($classKey, $where)) {
            return $res->get('id');
        }
        return false;
    }

}

return 'GoogleSheetsImportGetValuesProcessor';