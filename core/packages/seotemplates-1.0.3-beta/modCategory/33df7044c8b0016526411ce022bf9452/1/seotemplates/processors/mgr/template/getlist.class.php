<?php

class seoTemplatesTemplateGetListProcessor extends modObjectGetListProcessor
{

    public $classKey = 'modTemplate';

    public function process()
    {
        $data = array();
        $query = trim($this->getProperty('query'));
        //$limit = trim($this->getProperty('limit', 10));
        //$start = intval($this->getProperty('start', 0));
        $mode = $this->getProperty('mode');

        $c = $this->modx->newQuery($this->classKey);

        $c->sortby('id', 'ASC');
        $c->select(array(
            'id','templatename','description'
        ));

        if ($limit > 0) {
            $c->limit($limit, $start);
        }

        if (!empty($query)) {
            $c->where(array('templatename:LIKE' => "%{$query}%"));
        }

        if ($c->prepare() && $c->stmt->execute()) {
            $data = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $this->outputArray($data);

    }

}

return 'seoTemplatesTemplateGetListProcessor';
