<?php

class GoogleSheetsExportRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsExport';
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
            return $this->failure($this->modx->lexicon('googlesheets_export_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var GoogleSheetsExport $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_export_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'GoogleSheetsExportRemoveProcessor';