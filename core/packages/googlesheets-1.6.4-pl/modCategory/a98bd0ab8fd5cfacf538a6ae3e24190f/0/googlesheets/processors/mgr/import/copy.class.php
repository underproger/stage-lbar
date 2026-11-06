<?php

class GoogleSheetsImportCopyProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsImport';
    public $languageTopics = ['googlesheets'];


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
            return $this->failure($this->modx->lexicon('googlesheets_copy_empty'));
        }
        foreach ($ids as $id) {
            if (!$target = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_err_copy'));
            }
            $source = $this->modx->newObject($this->classKey, $target->toArray());
            if(!$source->save()) {
                return $this->failure($this->modx->lexicon('googlesheets_err_copy'));
            }
        }

        return $this->success();
    }

}

return 'GoogleSheetsImportCopyProcessor';