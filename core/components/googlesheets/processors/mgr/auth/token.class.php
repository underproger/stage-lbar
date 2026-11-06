<?php

class GoogleSheetsAuthTokenProcessor extends modObjectProcessor
{
    
    public $objectType = 'GoogleSheetsAuth';
    public $classKey = 'GoogleSheetsAuth';
    public $languageTopics = ['googlesheets:auth'];

    public function process() {
        $GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/');
        $responce = $GoogleSheets->getResponce();

        if ($responce['status']) {
            return $this->success($responce['msg']);
        }

        if ($responce['type'] == 'text') {
            return $this->failure($responce['msg'] . '<br><a href="https://console.developers.google.com/" target="blank">'.$this->modx->lexicon('googlesheets_auth').'</a>');
        }

        if ($responce['type'] == 'uri') {
            return $this->failure('', ['uri' => $responce['uri']]);
        }

        return parent::process();
    }
}

return 'GoogleSheetsAuthTokenProcessor';