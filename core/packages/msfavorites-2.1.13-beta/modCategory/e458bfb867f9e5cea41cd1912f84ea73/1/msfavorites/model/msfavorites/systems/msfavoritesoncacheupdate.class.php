<?php

class msFavoritesOnCacheUpdate extends msFavoritesPlugin
{
    public function run()
    {
        if ($this->msFavorites->getOption('clear_temporary', null)) {
            $limit = $this->msFavorites->getOption('msfavorites_time_limit', null, 30, true);

            $time = new DateTime();
            $time = $time->modify('-' . (int)($limit) . 'day');
            $time = $time->format('Y-m-d H:i:s');

            $this->modx->removeCollection('msFavorite', array(
                'temporary'    => true,
                'timestamp:<=' => $time,
            ));
        }
    }
}
