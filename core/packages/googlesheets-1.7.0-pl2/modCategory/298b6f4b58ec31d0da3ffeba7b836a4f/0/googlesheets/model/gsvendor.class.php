<?php

class gsVendor
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

    // Получаем производителей
    public function getVendors($range)
    {
        $query = $this->modx->newQuery('msVendor');
        $query->select($this->modx->getSelectColumns('msVendor', 'msVendor','','', false));
        
        // Event: gsOnBeforeGetVendors
        $this->modx->invokeEvent('gsOnBeforeGetVendors', array(
            'query' => $query,
            'range' => $range,
        ));
        
        $query->prepare();
        $query->stmt->execute();
        $vendors = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Event: gsOnGetVendors
        $this->modx->invokeEvent('gsOnGetVendors', array(
            'vendors' => &$vendors,
            'range' => $range,
        ));
        
        return $vendors;
    }
}    