<?php

class GoogleSheetsMigxCopyProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsMigx';
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
            if (!$migx = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('googlesheets_err_copy'));
            }
            $newMigx = $this->modx->newObject($this->classKey, $migx->toArray());
            if(!$newMigx->save()) {
                return $this->failure($this->modx->lexicon('googlesheets_err_copy'));
            }
        }

        return $this->success();
    }

}

return 'GoogleSheetsMigxCopyProcessor';