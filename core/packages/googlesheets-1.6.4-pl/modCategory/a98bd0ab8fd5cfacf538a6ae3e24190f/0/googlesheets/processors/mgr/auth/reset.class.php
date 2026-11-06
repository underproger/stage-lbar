<?php

class GoogleSheetsResetTokenProcessor extends modObjectProcessor
{
    public $languageTopics = ['googlesheets'];
    
    
    public function process() {
        $GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/');
        
        if($GoogleSheets->resetToken()) {
            return $this->success($this->modx->lexicon('googlesheets_auth_reset'));
        } else {
            return $this->failure($this->modx->lexicon('googlesheets_title_error'));
        }
        
        return parent::process();
    }

}

return 'GoogleSheetsResetTokenProcessor';