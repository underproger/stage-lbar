<?php

abstract class msFavoritesPlugin
{
    /** @var modX $modx */
    protected $modx;
    /** @var msFavorites $msFavorites */
    protected $msFavorites;
    /** @var array $scriptProperties */
    protected $scriptProperties;

    public function __construct(modX $modx, &$scriptProperties)
    {
        $this->modx = &$modx;
        $this->scriptProperties =& $scriptProperties;

        $corePath = $modx->getOption('msfavorites_core_path', null,
            $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/msfavorites/');
        /** @var msFavorites $msFavorites */
        $this->msFavorites = $modx->getService('msfavorites', 'msFavorites', $corePath . 'model/msfavorites/',
            array('core_path' => $corePath));
        if (!$this->msFavorites OR !($this->msFavorites instanceof msFavorites)) {
            return false;
        }
        
        $this->msFavorites->initialize($this->modx->context->key);
    }

    abstract public function run();
}