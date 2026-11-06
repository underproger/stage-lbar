<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class GoogleSheetsImportProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsImport';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'save';

    public $object;
    public $GoogleSheets;

    /**
     * @return array|string
     */
    public function process()
    {
        $value = $this->modx->fromJSON($this->getProperty('value'));
        $this->object = $this->modx->fromJSON($this->getProperty('object'));

        // Проверяем авторизацию
        if (!$this->GoogleSheets = $this->modx->getService($this->objectType, $this->objectType, MODX_CORE_PATH . 'components/googlesheets/model/')) {
            return $this->failure($this->modx->lexicon('Could not load GoogleSheets class!'));
        }

        // msProductRemains
        if($this->object['type'] == 'msProductRemains'){
            $corePath = $this->modx->getOption('msproductremains.core_path', null, $this->modx->getOption('core_path') . 'components/msproductremains/');
            $this->modx->addPackage('msproductremains', $corePath . 'model/');
        }

        // Запускаем импорт
        $result = $this->import($value);

        // Event: gsOnAfterImportValues
        $this->modx->invokeEvent('gsOnAfterImportValues', $result);

        return $this->success($result);
    }


    public function import($value)
    {
        $mode = 'error';
        $value = $this->beforePrepare($value);

        // Получаем условие для получения ресурса
        $objectID = null;
        $unique = $this->object['unique'];

        $where = array();
        foreach($unique as $u) {
            $where[$u] = $value[$u];
        }

        $classKey = $this->object['classKey'];

        // ARTICLE
        if($this->object['type'] == 'msProduct' && in_array('article', $unique)) {
            if($product = $this->modx->getObject('msProductData', array('article' => $value['article']))) {
                $where['id'] = $product->get('id');
                unset($where['article']);
            } else {
                $classKey = 'msProductData';
            }
        }



        // Получаем объект
        if($object = $this->modx->getObject($classKey, $where)) {
            if($this->object['imethod'] != 'Create') {

                if($classKey == 'msProductData') {
                    $object = $this->modx->getObject($this->object['classKey'], $object->get('id'));
                }

                if($this->updateObject($object, $value)) {
                    $objectID = $object->get('id');
                    $mode = 'update';
                }
            }
        } else {
            $mode = 'empty';
            if($this->object['imethod'] != 'Update') {

                if($this->object['type'] == 'msOptionsPrice2') {
                    $objectID = $value['rid'];
                    $mode = 'create';
                } else {
                    if($objectID = $this->createObject($value)) {
                        $mode = 'create';
                    }
                }
            }
        }

        if($objectID) {
            $this->afterPrepare($objectID, $value, $unique);
        }

        return array(
            'mode' => $mode,
            'id' => $objectID,
            'value' => $value
        );
    }

    public function beforePrepare($value)
    {
        switch($this->object['type']) {
            case 'msProductRemains':
                if(isset($value['options'])) {
                    $value['options'] = json_encode($value['options']);
                }
                break;
            case 'msProduct':
                // Создаем категорию
                if(isset($value['categories']) || !empty($value['categories'])) {
                    $value['categories'] = $this->createCategories($value);
                }
            case 'modResource':
            case 'msCategory':
                // Создаем родителя
                if(isset($value['parent']) || !empty($value['parent'])) {
                    if($parent_id = $this->createParent($value['parent'])) {
                        $value['parent'] = $parent_id;
                    }
                }

                // SEO TAB
                $seoFields = array_filter($value, function($name){
                    if(preg_match('/^seo.(\w+)/i', $name)) {
                        return true;
                    }
                    return false;
                },ARRAY_FILTER_USE_KEY);

                if(count($seoFields)) {
                    if(!isset($value['properties'])) {
                        $value['properties'] = [];
                    }
                    $value['properties']['stercseo'] = [];
                    foreach($seoFields as $field => $v) {
                        $field = str_replace('seo.','',$field);
                        if($field != 'redirect') {
                            $value['properties']['stercseo'][$field] = $v;
                        }
                    }
                }
                break;
        }

        return $value;
    }

    public function prepare($value)
    {
        return $value;
    }

    public function createParent($parent)
    {
        $lexicon = 'parent';
        if($this->object['type'] != 'modResource') {
            $lexicon = 'category';
        }

        // Проверяем есть ли родитель
        if(is_numeric((int)$parent)) {
            if(!$this->modx->getCount('modResource', $parent)) {
                $this->modx->log(1, str_replace('[[+id]]', $parent, $this->modx->lexicon('googlesheets_err_' . $lexicon)));
            } else {
                return $parent;
            }
        } else {
            // Создаем ресурс
            if(!$this->modx->getCount('modResource', array('pagetitle' => $parent))) {
                if($id = $this->createObject(array('pagetitle' => $parent))) {
                    return $id;
                } else {
                    $this->modx->log(1, str_replace('[[+parent]]', $parent, $this->modx->lexicon('googlesheets_err_create_' . $lexicon)));
                }
            }
        }
        return false;
    }

    public function createCategories($value)
    {
        $categories = array_map(function($category){
            return $this->createParent(trim($category));
        },explode(',', $value['categories']));

        $categories = implode(',', $categories);
        return $categories;
    }

    public function createObject($value = [], $classKey = false)
    {
        $value = $this->prepareValues($value, $classKey);

        if(!isset($value['pagetitle'])) {
            $this->modx->log(1, $this->modx->lexicon('googlesheets_import_err_pagetitle'));
            return false;
        }
        if(empty($value['pagetitle'])) {
            $this->modx->log(1, $this->modx->lexicon('googlesheets_import_err_empty_pagetitle'));
            return false;
        }

        if($newObject = $this->modx->newObject($classKey ?: $this->object['classKey'])) {
            $newObject->fromArray($value);
            $newObject->save();
            return $newObject->get('id');
        }
        return false;
    }

    public function defaultsProperties($value, $classKey = false)
    {
        // Поля ресурса
        $defaults = array();

        $classKey = $classKey ?: $this->object['type'];
        switch($classKey) {
            case 'msProduct':
                // Товар в дереве ресурсов
                if(empty($value['show_in_tree'])){
                    $defaults['show_in_tree'] = $this->modx->getOption('ms2_product_show_in_tree_default', null, 0, true);
                }
                // Устанавливаем источник файлов
                if(empty($value['source'])) {
                    $defaults['source'] = $this->modx->getOption('ms2_product_source_default', null, 1, true);
                }
                // Устанавливаем шаблон по умолчанию
                if(empty($value['template'])) {
                    $defaults['template'] = $value['template'] = $this->modx->getOption('ms2_template_product_default', null, 1, true);
                }
            case 'modResource':
            case 'msCategory':
                $defaults = array_merge(array(
                    'context_key' => !empty($value['context_key']) ? $value['context_key'] : 'web',
                    'published' => !empty($value['published']) ? $value['published'] : 1,
                    'class_key' => !empty($value['class_key']) ? $value['class_key'] : $this->object['class_key'],
                    'template' => !empty($value['template']) ? $value['template'] : $this->modx->getOption('default_template'),
                    'alias' => !empty($value['alias']) ? $value['alias'] : !empty($value['pagetitle']) ? $this->modx->filterPathSegment($value['pagetitle']) : '',
                ),$defaults);
        }

        return $defaults;
    }




    public function prepareValues($value, $classKey = false)
    {

        $defaultValues = $this->defaultsProperties($value, $classKey);
        $value = array_merge($defaultValues, $value);

        $classKey = $classKey ?: $this->object['type'];
        if($classKey == 'msProduct') {
            // Удаляем не нужные значения
            $productData = array('article','price','old_price','weight','image','thumb','vendor','made_in','new','popular','favorite','tags','color','size');
            $value = array_filter($value, function($key) use($productData){
                return !in_array($key,$productData);
            }, ARRAY_FILTER_USE_KEY);
        }

        return $value;

    }

    public function updateObject($object, $value)
    {
        if(empty($value) || !$object) return false;
        $object->fromArray($value);
        if($object->save()) {
            return true;
        }
        return false;
    }


    public function afterPrepare($id, $value, $unique)
    {

        switch($this->object['type']){
            case 'msOptionsPrice2':
                // Добавляем опции модификации
                if(!empty($value['modification'])) {
                    $this->GoogleSheets->optionsprice2->setModification($value,$unique[0]);
                }
                break;
            case 'msProductRemains':
                break;
            case 'msProduct':
                // Обновляем поля товара (msProductData - ms2_products)
                $this->GoogleSheets->product->importProductData($id, $value);

                // Добавляем мультикатегории
                if(!empty($value['categories'])) {
                    $this->GoogleSheets->product->setCategories($id, $value['categories']);
                }

                // Добавляем стандартные опции
                $this->importProductOptions($id, $value);

            default:
                // Обновляем TV
                $this->importTV($id, $value);

                // Загружаем изображения msGallery
                if(!empty($value['images'])) {

                    $source = $this->modx->getOption('ms2gallery_source_default');
                    $tab = $this->modx->getOption('ms2gallery_disable_for_ms2');

                    if(($source && !$tab) || $this->object['type'] == 'modResource') {
                        $this->GoogleSheets->resource->ms2GalleryUpload($id, $value['images']);
                    } elseif($this->object['type'] == 'msProduct') {
                        $this->GoogleSheets->product->uploadGallery($id, $value['images']);
                    }

//                    if($source && !$tab) {
//                        $this->GoogleSheets->resource->ms2GalleryUpload($id, $value['images']);
//                    } else {
//                        if($this->object['type'] == 'msProduct') {
//                            $this->GoogleSheets->product->uploadGallery($id, $value['images']);
//                        }
//                    }
                }

                // SEO Pro
                if(!empty($value['keywords']) || !empty($value['seo.keywords'])) {
                    if($keywords = $this->modx->getObject('seoKeywords', array('resource' => $id))) {
                        $this->updateObject($keywords, array('keywords' => $value['keywords']));
                    } else {
                        $this->createObject(array(
                            'resource' => $id,
                            'keywords' => $value['keywords']
                        ), 'seoKeywords');
                    }
                }

                // SEO TAB
                if(isset($value['seo.redirect'])) {
                    $corePath = $this->modx->getOption('stercseo.core_path', null, $this->modx->getOption('core_path').'components/stercseo/');
                    $this->modx->addPackage('stercseo', $corePath.'model/');

                    if($stercseo = $this->modx->getCollection('seoUrl', array('resource' => $id))) {
                        foreach($stercseo as $s) {
                            $s->remove();
                        }
                    }
                    $urls = explode(',', trim($value['seo.redirect']));
                    foreach($urls as $url) {
                        $this->createObject(array(
                            'resource' => $id,
                            'context_key' => $value['context_key'],
                            'url' => $url
                        ), 'seoUrl');
                    }
                }
        }
    }

    public function importTV($id, $value = [])
    {
        foreach($value as $name => $val) {
            if(preg_match('/^tv(\w+)/i', $name)) {
                $this->GoogleSheets->resource->importTV($id, str_replace('tv', '', $name), $val);
            }
        }
    }

    public function importProductOptions($id, $values = [])
    {
        foreach($values as $name => $value) {
            if(preg_match('/^option.(\w+)/i', $name)) {
                $name = str_replace('option.', '', $name);
                $this->GoogleSheets->product->importProductOptions($id, $name, $value);
            }
        }
    }

}

return 'GoogleSheetsImportProcessor';