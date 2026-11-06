<?php

class GoogleSheetsImportCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsImport';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        // $name = trim($this->getProperty('name'));
        // if (empty($name)) {
        //     $this->modx->error->addField('name', $this->modx->lexicon('googlesheets_import_err_name'));
        // } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
        //     $this->modx->error->addField('name', $this->modx->lexicon('googlesheets_import_err_ae'));
        // }

        return parent::beforeSet();
    }

}

return 'GoogleSheetsImportCreateProcessor';