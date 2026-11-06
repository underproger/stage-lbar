<?php

class msFavoritesOnEmptyTrash extends msFavoritesPlugin
{
    public function run()
    {
        $ids = (array)$this->modx->getOption('ids', $this->scriptProperties, array(), true);
        $this->modx->removeCollection('msFavorite', array('rid:IN' => $ids));
    }
}
