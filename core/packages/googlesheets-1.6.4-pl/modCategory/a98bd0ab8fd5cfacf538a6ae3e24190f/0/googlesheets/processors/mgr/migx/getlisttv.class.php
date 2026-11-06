<?php

class GoogleSheetsMigxGetListTVProcessor extends modObjectGetListProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'modTemplateVar';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $query)
    {
        
        $query->select('id,name');
        $query->where(array('type' => 'migx'));
        return $query;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $data = array(
            'id' => $object->get('id'),
            'name' => $object->get('name'),
        );

        return $data;
    }

}

return 'GoogleSheetsMigxGetListTVProcessor';