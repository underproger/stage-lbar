<?php


class msFavoritesOnUserRemove extends msFavoritesPlugin
{
    public function run()
    {
        $user = $this->modx->getOption('user', $this->scriptProperties);
        if (!$user) {
            return;
        }
        $uid = $user->get('id');
        $this->modx->removeCollection('msFavorite', array('uid' => $uid));
    }

}