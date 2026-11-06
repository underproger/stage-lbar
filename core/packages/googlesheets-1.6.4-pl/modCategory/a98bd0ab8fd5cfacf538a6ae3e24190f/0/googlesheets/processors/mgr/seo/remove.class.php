<?php

class GoogleSheetsSeoRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsSeo';
    public $languageTopics = ['googlesheets'];
    //public $permission = 'remove';


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
            return $this->failure($this->modx->lexicon('googlesheets_seo_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var GoogleSheetsItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_seo_err_nf'));
            }
            $object->remove();
        }

        return $this->success();
    }

}

return 'GoogleSheetsSeoRemoveProcessor';