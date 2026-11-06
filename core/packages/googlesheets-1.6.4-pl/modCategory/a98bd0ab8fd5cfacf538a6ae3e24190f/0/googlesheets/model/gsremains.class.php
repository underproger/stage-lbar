<?php

class gsRemains
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
    
    // Получаем остатки товара
    public function getProductRemains($range)
    {
        
        $corePath = $this->modx->getOption('msproductremains.core_path', null, $this->modx->getOption('core_path') . 'components/msproductremains/');
        $this->modx->addPackage('msproductremains', $corePath . 'model/');
        
        $classKey = 'msprRemains';
        $query = $this->modx->newQuery($classKey);
        $query->select($this->modx->getSelectColumns($classKey, $classKey, '', '', false));
        
        // Event: gsOnBeforeGetRemains
        $this->modx->invokeEvent('gsOnBeforeGetRemains', array(
            'query' => $query,
            'range' => $range,
        ));

        $query->prepare();
        $query->stmt->execute();
        $remains = $query->stmt->fetchAll(PDO::FETCH_ASSOC);

        // Event: gsOnGetRemains
        $this->modx->invokeEvent('gsOnGetRemains', array(
            'remains' => &$remains,
            'range' => $range,
        ));
        
        return $remains;
    }
    
}    