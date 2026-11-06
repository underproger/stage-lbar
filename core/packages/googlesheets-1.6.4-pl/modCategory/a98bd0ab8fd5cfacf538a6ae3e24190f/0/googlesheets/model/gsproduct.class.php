<?php

class gsProduct
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;
        $this->modx->lexicon->load('googlesheets:default');

    }

    // Получаем кол-во товаров
    public function getTotal($range)
    {
        $query = $this->modx->newQuery('msProduct');
        $query->where(array(
            'published' => 1,
            'deleted' => 0,
            'class_key' => 'msProduct',
        ));

        // Event: gsOnBeforeGetProducts
        $this->modx->invokeEvent('gsOnBeforeGetProducts', array(
            'query' => $query,
            'range' => $range,
        ));

        return $this->modx->getCount('msProduct', $query);
    }

    // Получаем товары
    public function getProducts($range, $limit = 5000, $offset = 0)
    {

        $query = $this->modx->newQuery('msProduct');
        $query->where(array(
            'published' => 1,
            'deleted' => 0,
            'class_key' => 'msProduct',
        ));
        $query->limit($limit, $offset);

        $query->select($this->modx->getSelectColumns('msProduct', 'msProduct', '', '', false));

        // Добавляем свойства товара
        $query->leftJoin('msProductData', 'Data', 'msProduct.id = Data.id');
        $query->select($this->modx->getSelectColumns('msProductData', 'Data', '', '', false));

        // Добавляем производителей товара
        $query->leftJoin('msVendor', 'Vendor', 'Data.vendor = Vendor.id');
        $query->select($this->modx->getSelectColumns('msVendor', 'Vendor', 'vendor_', '', false));

        // Event: gsOnBeforeGetProducts
        $this->modx->invokeEvent('gsOnBeforeGetProducts', array(
            'query' => $query,
            'range' => $range,
        ));

        $query->groupby('msProduct.id');
        $query->prepare();
        $query->stmt->execute();
        $products = $query->stmt->fetchAll(PDO::FETCH_ASSOC);

        // Event: gsOnGetProducts
        $this->modx->invokeEvent('gsOnGetProducts', array(
            'products' => &$products,
            'range' => $range,
        ));

        return $products;
    }

    // Добавлем опции к товару
    public function joinProductOptions($range, $resources, $fields)
    {
        $options = array_filter($fields, function($v){
            if(preg_match('/^option.(\w+)/i', $v)) {
                return $v;
            }
        });

        foreach($options as $option) {
            foreach($resources as $idx => $res) {
                $query = $this->modx->newQuery('msProductOption');
                $query->where(array('key' => str_replace('option.', '', $option), 'product_id' => $res['id']));
                $query->select($this->modx->getSelectColumns('msProductOption', 'msProductOption', '', array('value'), false));
                $query->prepare();
                $query->stmt->execute();
                $results = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
                $tmp = [];
                foreach($results as $result) {
                    $tmp[] = $result['value'];
                }
                $resources[$idx][$option] = implode(',', $tmp);
            }
        }

        return $resources;
    }

    // Добавляем изображения к товару
    public function joinImages($range, $products)
    {
        foreach($products as $idx => $product) {
            $query = $this->modx->newQuery('msProductFile');
            $query->where(array('parent' => 0, 'product_id' => $product['id']));
            $query->select($this->modx->getSelectColumns('msProductFile', 'msProductFile', '', array('url'), false));
            $query->prepare();
            $query->stmt->execute();
            $results = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
            $images = array();
            foreach($results as $result) {
                $images[] = $result['url'];
            }
            $products[$idx]['images'] = implode(',', $images);
        }

        return $products;
    }


    // IMPORT

    // Обновляем свойства товара
    public function importProductData($id, $value)
    {
        if(!$product = $this->modx->getObject('msProductData', $id)) {
            $product = $this->modx->newObject('msProductData');
        }
        $product->fromArray($value);
        $product->save();
    }

    // Обновляем опции товара
    public function importProductOptions($id, $key, $values)
    {
        $where = array(
            'product_id' => $id,
            'key' => $key,
        );

        $q = $this->modx->newQuery('msProductOption');
        $q->select($this->modx->getSelectColumns('msProductOption', 'msProductOption', '', '', false));
        $q->command('DELETE');
        $q->where($where);
        $q->prepare();
        $q->stmt->execute();

        $table = $this->modx->getTableName('msProductOption');
        if(!is_array($values)) {
            $values = [$values];
        }

        foreach($values as $val) {
            $sql = "INSERT INTO {$table} (`product_id`,`key`,`value`) VALUES ({$where['product_id']}, \"{$where['key']}\", \"{$val}\");";
            $stmt = $this->modx->prepare($sql);
            $stmt->execute();
        }

        return true;
    }


    // Загружаем изображения msGallery
    public function uploadGallery($id, $files)
    {
        // Удаляем старые картинки
        if($this->removeGallery($id)) {
            foreach ($files as $file) {
                if(empty(trim($file))) continue;
                // Вызов процессора загрузки изображений
                $response = $this->modx->runProcessor('gallery/upload', array(
                    'file' => MODX_BASE_PATH . trim($file),
                    'id' => $id
                ),
                    array('processors_path' => MODX_CORE_PATH . 'components/minishop2/processors/mgr/')
                );

                // Вывод результата работы процессора
                if ($response->isError()) {
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, $file . ' - ' . $response->getMessage());
                }
            }
        }
    }

    // Удаляем все картинки из msGallery
    public function removeGallery($id)
    {
        $images = $this->modx->getCollection('msProductFile', array(
            'type' => 'image',
            'parent' => 0,
            'product_id' => $id,
        ));
        foreach($images as $image) {
            $response = $this->modx->runProcessor('gallery/remove', array(
                'id' => $image->get('id')
            ),
                array('processors_path' => MODX_CORE_PATH.'components/minishop2/processors/mgr/')
            );
            if ($response->isError()) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($response->getAllErrors(), 1));
                return false;
            }
        }

        return true;
    }



    // Устанавливаем мультикатегории
    public function setCategories($id, $categories)
    {
        // Удаляем все картегории товара
        $this->removeCategories($id);

        $categories = explode(',', $categories);
        foreach($categories as $category) {
            // Добавляем новую категорию
            if($res = $this->modx->newObject('msCategoryMember')) {
                $res->set('product_id', $id);
                $res->set('category_id', $category);
                $res->save();
            }
        }
    }

    // Удаляем все категории у товара
    public function removeCategories($id)
    {
        if($categories = $this->modx->getCollection('msCategoryMember', array('product_id' => $id))) {
            foreach($categories as $category) {
                $category->remove();
            }
        }
    }

} 