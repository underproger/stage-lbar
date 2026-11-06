<?php

class gsUser
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;
        $this->modx->lexicon->load('googlesheets:default');
           
    }

    // Получаем пользователей
    public function getUsers($range)
    {
        $query = $this->modx->newQuery('modUser');
        $query->leftJoin('modUserProfile', 'Profile', 'modUser.id = Profile.id');

        $query->select($this->modx->getSelectColumns('modUser', 'modUser', '', '', false));
        $query->select($this->modx->getSelectColumns('modUserProfile', 'Profile', '', '', false));
        
        // Event: gsOnBeforeGetUsers
        $this->modx->invokeEvent('gsOnBeforeGetUsers', array(
            'query' => $query,
            'range' => $range,
        ));
        
        $query->prepare();
        $query->stmt->execute();
        $users = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Event: gsOnGetUsers
        $this->modx->invokeEvent('gsOnGetUsers', array(
            'users' => &$users,
            'range' => $range,
        ));
        
        return $users;
    }
}    