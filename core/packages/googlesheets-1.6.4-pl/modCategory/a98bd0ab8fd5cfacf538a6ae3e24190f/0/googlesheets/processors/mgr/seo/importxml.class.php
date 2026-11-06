<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class GoogleSheetsSeoImportXMLProcessor extends modObjectProcessor
{
    public $objectType = 'GoogleSheets';
    public $classKey = 'GoogleSheetsSeo';
    public $languageTopics = ['googlesheets'];
    
    public $GoogleSheets = '';

    /**
     * @return array|string
     */
    public function process()
    {
       
        $value = $this->modx->fromJSON($this->getProperty('value'));
        $table = $this->getProperty('table');
        $range = $this->getProperty('range');
        $imethod = $this->getProperty('imethod');
        $offset = $this->getProperty('offset');
        
        // Проверяем авторизацию
        if (!$this->GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/')) {
            return $this->failure($this->modx->lexicon('Could not load GoogleSheets class!'));
        }
        
        // Экспортируем данные в таблицу
        if($imethod == 'Update' && $offset == 0) {
            if($result = $this->GoogleSheets->clearValues($table, $range)) {
                // Добавляем новые значения
                $result = $this->GoogleSheets->updateValues($table, $range, 'USER_ENTERED', [$value]);      
            }
        } else {
            $result = $this->GoogleSheets->appendValues($table, $range, 'USER_ENTERED', [$value]);
        }
        
        if(!$result) {
            $msgError = $this->GoogleSheets->getResponce('msg') ?: $this->modx->lexicon('googlesheets_export_error');
            return $this->failure($msgError);
        } else {
            return $this->success('Success!');
        }
    }

}

return 'GoogleSheetsSeoImportXMLProcessor';