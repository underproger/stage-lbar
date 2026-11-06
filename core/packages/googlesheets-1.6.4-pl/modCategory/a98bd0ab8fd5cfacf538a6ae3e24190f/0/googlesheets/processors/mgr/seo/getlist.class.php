<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

class GoogleSheetsSeoGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsSeo';
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'asc';
    //public $permission = 'list';


    /**
     * We do a special check of permissions
     * because our objects is not an instances of modAccessibleObject
     *
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = trim($this->getProperty('query'));
        if ($query) {
            $c->where([
                'name:LIKE' => "%{$query}%",
                'OR:range:LIKE' => "%{$query}%",
            ]);
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('googlesheets_update'),
            //'multiple' => $this->modx->lexicon('googlesheets_items_update'),
            'action' => 'updateItem',
            'button' => true,
            'menu' => true,
        ];
        
        // Кнопка для импорта
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-download action-green',
            'title' => $this->modx->lexicon('googlesheets_importxml'),
            // 'multiple' => $this->modx->lexicon('googlesheets_imports_enable'),
            'action' => 'getValues',
            'button' => true,
            'menu' => true,
        ];

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('googlesheets_remove'),
            // 'multiple' => $this->modx->lexicon('googlesheets_imports_remove'),
            'action' => 'removeItem',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'GoogleSheetsSeoGetListProcessor';