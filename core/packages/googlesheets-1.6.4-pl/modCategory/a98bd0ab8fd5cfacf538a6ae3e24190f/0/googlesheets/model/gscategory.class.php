<?php

class gsCategory
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
    
    // Получаем кол-во категорий
    public function getTotal($range)
    {
        $query = $this->modx->newQuery('modResource');
        $query->where(array(
            'published' => 1,
            'deleted' => 0,
            'class_key' => 'msCategory'
        ));
        
        // Event: gsOnBeforeGetCategories
        $this->modx->invokeEvent('gsOnBeforeGetCategories', array(
            'query' => $query,
            'range' => $range,
        ));
        
        return $this->modx->getCount('modResource', $query);
    }
    
    // Получаем список категорий
    public function getCategory($range, $limit = 5000, $offset = 0)
    {
        $query = $this->modx->newQuery('modResource');
        $query->where(array(
            'published' => 1,
            'deleted' => 0,
            'class_key' => 'msCategory'
        ));
        $query->limit($limit, $offset);
        
        $query->select($this->modx->getSelectColumns('modResource', 'modResource','','', false));
        
        // Event: gsOnBeforeGetCategories
        $this->modx->invokeEvent('gsOnBeforeGetCategories', array(
            'query' => $query,
            'range' => $range,
        ));
        
        $query->prepare();
        $query->stmt->execute();
        $categories = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Event: gsOnGetCategories
        $this->modx->invokeEvent('gsOnGetCategories', array(
            'categories' => &$categories,
            'range' => $range,
        ));
        
        return $categories;
    }
    
    // Получаем список категорий товара
    public function getCategories($product_id, $field = 'id')
    {
        if(empty($product_id)) {
            return false; 
        }
        $categories_id = [];
        $where = array('product_id' => $product_id);
        if($categories = $this->modx->getCollection('msCategoryMember', $where)) {
            foreach($categories as $category) {
                $categories_id[] = $category->get('category_id');
            }
        }
        // Добавляем родителя
        // $categories_id[] = $this->getField($product_id, 'parent');
        return $categories_id;
    }
    
}    