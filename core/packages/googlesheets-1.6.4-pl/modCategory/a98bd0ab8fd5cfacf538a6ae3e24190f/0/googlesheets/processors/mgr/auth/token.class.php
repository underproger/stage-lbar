<?php

class GoogleSheetsAuthTokenProcessor extends modObjectProcessor
{
    
    public $objectType = 'GoogleSheetsAuth';
    public $classKey = 'GoogleSheetsAuth';
    public $languageTopics = ['googlesheets:auth'];
    
    
    public function process() {
        $GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/');
        
        if(!$GoogleSheets->getStatus()) {
            if(!$GoogleSheets->getClient()) {
                $responce = $GoogleSheets->getResponce();
                return $this->failure($responce['msg'] . '<br><a href="https://console.developers.google.com/" target="blank">'.$this->modx->lexicon('googlesheets_auth').'</a>');
            }
        }
        
        $responce = $GoogleSheets->getResponce();
        return $this->success($responce['msg'], ['type' => $responce['type'], 'status' => $responce['status']]);
        return parent::process();
    }
}

return 'GoogleSheetsAuthTokenProcessor';