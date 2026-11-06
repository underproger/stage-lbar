<?php

/**
 * The home manager controller for seoTemplates.
 *
 */
class seoTemplatesHomeManagerController extends modExtraManagerController
{
    /** @var seoTemplates $seoTemplates */
    public $seoTemplates;


    /**
     *
     */
    public function initialize()
    {
        $path = $this->modx->getOption('seotemplates_core_path', null,
                $this->modx->getOption('core_path') . 'components/seotemplates/') . 'model/seotemplates/';
        $this->seoTemplates = $this->modx->getService('seotemplates', 'seoTemplates', $path);
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('seotemplates:default');
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
        return $this->modx->lexicon('seotemplates');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->seoTemplates->config['cssUrl'] . 'mgr/main.css');
        $this->addCss($this->seoTemplates->config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/seotemplates.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/misc/fields.combo.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/widgets/fields.grid.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/widgets/fields.windows.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->seoTemplates->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        seoTemplates.config = ' . json_encode($this->seoTemplates->config) . ';
        seoTemplates.config.connector_url = "' . $this->seoTemplates->config['connectorUrl'] . '";
        Ext.onReady(function() {
            MODx.load({ xtype: "seotemplates-page-home"});
        });
        </script>
        ');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        return $this->seoTemplates->config['templatesPath'] . 'home.tpl';
    }
}