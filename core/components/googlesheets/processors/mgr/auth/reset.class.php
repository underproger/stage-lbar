<?php

class GoogleSheetsResetTokenProcessor extends modObjectProcessor
{
    public $languageTopics = ['googlesheets'];

    public function process() {
        $sheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/');
        $sheets->logout();

        return $this->success($this->modx->lexicon('googlesheets_auth_reset'));
    }

}

return 'GoogleSheetsResetTokenProcessor';