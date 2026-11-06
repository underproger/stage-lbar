<?php

/**
 * The home manager controller for GoogleSheets.
 *
 */
class GoogleSheetsHomeManagerController extends modExtraManagerController
{
    /** @var GoogleSheets $GoogleSheets */
    public $GoogleSheets;


    /**
     *
     */
    public function initialize()
    {
        $code = $this->modx->getObject('modSystemSetting','googlesheets_auth_code');
        if($_GET['code'] && $code) {
            $code->set('value', $_GET['code']);
            $code->save();
        }
        $this->GoogleSheets = $this->modx->getService('GoogleSheets', 'GoogleSheets', MODX_CORE_PATH . 'components/googlesheets/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['googlesheets:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('googlesheets');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->GoogleSheets->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/googlesheets.js');
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/misc/combo.js');
        
        // IMPORT
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/import/grid.js');
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/import/window.js');
        // EXPORT
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/export/grid.js');
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/export/window.js');
        // SEO
        // $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/seo/grid.js');
        // $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/seo/window.js');
        // MIGX
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/migx/grid.js');
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/migx/window.js');
        
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->GoogleSheets->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        GoogleSheets.config = ' . json_encode($this->GoogleSheets->config) . ';
        GoogleSheets.config.connector_url = "' . $this->GoogleSheets->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "googlesheets-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="googlesheets-panel-home-div"></div>';

        return '';
    }
}