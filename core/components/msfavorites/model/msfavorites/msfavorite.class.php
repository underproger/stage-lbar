<?php

class msFavorite extends xPDOObject
{

    public static function load(xPDO & $xpdo, $className, $criteria, $cacheFlag = true)
    {
        /** @var $instance msFavorite */
        $instance = parent::load($xpdo, 'msFavorite', $criteria, $cacheFlag);
        if (!is_object($instance) OR !($instance instanceof $className)) {
            if (is_array($criteria) AND !empty($criteria['uid']) AND !empty($criteria['rid']) AND !empty($criteria['list'])) {
                $query = array(
                    'uid'  => $criteria['uid'],
                    'rid'  => $criteria['rid'],
                    'list' => $criteria['list'],
                );

                $q = $xpdo->newQuery('msFavorite');
                $q->where($query);
                if (!$instance = $xpdo->getObject('msFavorite', $q)) {
                    $limit = $xpdo->getOption('msfavorites_list_limit', null, 500, true);

                    if ($limit > $xpdo->getCount('msFavorite', array(
                            'uid'  => $criteria['uid'],
                            'list' => $criteria['list'],
                        ))
                    ) {
                        $instance = $xpdo->newObject('msFavorite');
                        $instance->fromArray($query, '', true);
                        if (!is_numeric($query['uid'])) {
                            $instance->set('temporary', 1);
                        }
                        if ($instance->save()) {
                            //$instance->_new = true;
                        }
                    }
                }
            }
        }

        return $instance;
    }

    /**
     * @param null $cacheFlag
     *
     * @return bool
     */
    public function save($cacheFlag = null)
    {
        $isNew = $this->isNew();

        if ($this->xpdo instanceof modX) {
            $this->xpdo->invokeEvent('msFavoriteBeforeSave', array(
                'mode'      => $isNew ? modSystemEvent::MODE_NEW : modSystemEvent::MODE_UPD,
                'favorite'  => &$this,
                'cacheFlag' => $cacheFlag,
            ));
        }

        $saved = parent:: save($cacheFlag);

        if ($saved && $this->xpdo instanceof modX) {
            $this->xpdo->invokeEvent('msFavoriteSave', array(
                'mode'      => $isNew ? modSystemEvent::MODE_NEW : modSystemEvent::MODE_UPD,
                'favorite'  => &$this,
                'cacheFlag' => $cacheFlag,
            ));
        }

        return $saved;
    }

    public function remove(array $ancestors = array())
    {
        if ($this->xpdo instanceof modX) {
            $this->xpdo->invokeEvent('msFavoriteBeforeRemove', array(
                'favorite'  => &$this,
                'ancestors' => $ancestors,
            ));
        }

        $remove = parent::remove($ancestors);

        if ($this->xpdo instanceof modX) {
            $this->xpdo->invokeEvent('msFavoriteRemove', array(
                'favorite'  => &$this,
                'ancestors' => $ancestors,
            ));
        }

        return $remove;
    }

    public function clear($query = array())
    {
        $uid = isset($query['uid']) ? $query['uid'] : session_id();
        $list = isset($query['list']) ? $query['list'] : '';

        $lists = explode(',', $list);     // Explode fields to array
        $lists = array_map('trim', $lists);       // Trim array's values
        $lists = array_keys(array_flip($lists));  // Remove duplicate fields
        $lists = array_filter($lists);            // Remove empty values from array

        if (empty($lists)) {
            return false;
        }

        foreach ($lists as $list) {
            $c = $this->xpdo->newQuery('msFavorite');
            $c->where(array(
                'uid'  => $uid,
                'list' => $list,
            ));
            $c->limit(0);

            $instances = $this->xpdo->getIterator('msFavorite', $c);
            /** @var msFavorite[] $instances */
            foreach ($instances as $instance) {
                $instance->remove();
            }
        }

        return true;
    }
}