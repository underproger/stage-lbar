<?php


abstract class msFavoritesResponseProcessor extends modProcessor
{
    /** @var  msFavorites $msFavorites */
    public $msFavorites;
    public $languageTopics = array('msfavorites');
    public $permission = '';

    function __construct(modX &$modx, array $properties = array())
    {
        parent::__construct($modx, $properties);

        if (!$namespace = $modx->getObject('modNamespace', 'msfavorites')) {
            $error = "[msFavorites] Not found modNamespace: msfavorites ";
            $this->modx->log(modX::LOG_LEVEL_ERROR, $error);

            return $this->failure($error);
        }
    }

    public function initialize()
    {
        $corePath = $this->modx->getOption('msfavorites_core_path', null,
            $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/msfavorites/');
        /** @var msFavorites $msFavorites */
        $this->msFavorites = $this->modx->getService('msfavorites', 'msFavorites', $corePath . 'model/msfavorites/',
            array('core_path' => $corePath));
        
        $ctx = (string)$this->getProperty('ctx', $this->modx->context->key);
        $this->msFavorites->initialize($ctx);

        /* process resource */
        $rid = (int)$this->getProperty('id');
        if (!empty($rid) AND $resource = $this->modx->getObject('modResource', $rid)) {
            $this->msFavorites->processContext($resource->get('context_key'));
            $this->msFavorites->processResource($resource->get('id'));
        }

        /* process ctx */
        $this->msFavorites->processContext($ctx);

        return true;
    }

}

return 'msFavoritesResponseProcessor';