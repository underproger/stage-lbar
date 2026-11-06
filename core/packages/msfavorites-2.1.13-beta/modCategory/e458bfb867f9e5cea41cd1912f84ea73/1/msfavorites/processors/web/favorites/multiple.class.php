<?php

require_once dirname(__FILE__) . '/response.class.php';

class msFavoritesMultipleProcessor extends msFavoritesResponseProcessor
{
    /** {@inheritDoc} */
    public function process()
    {
        $this->modx->event->_output = '';
        $data = $this->msFavorites->processFavorites($this->getProperties());
        if (!empty($this->modx->event->_output)) {
            return $this->msFavorites->failure($data);
        }

        return $this->msFavorites->success('', $data);
    }
}

return 'msFavoritesMultipleProcessor';