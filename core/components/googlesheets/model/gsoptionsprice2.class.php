<?php

class gsOptionsPrice2
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

    // Получаем модификации товара
    public function getOptionsPrice2($range, $fields)
    {
        $classKey = 'msopModification';
        $query = $this->modx->newQuery($classKey);
        $query->select($this->modx->getSelectColumns($classKey, $classKey, '', '', false));

        // Event: gsOnBeforeGetOptionsPrice2
        $this->modx->invokeEvent('gsOnBeforeGetOptionsPrice2', array(
            'query' => $query,
            'range' => $range,
        ));

        $query->prepare();
        $query->stmt->execute();
        $options = $query->stmt->fetchAll(PDO::FETCH_ASSOC);

        // Добавляем опции
        if(in_array('modification',$fields)) {
            $options = $this->getModification($options);
        }

        // Event: gsOnGetOptionsPrice2
        $this->modx->invokeEvent('gsOnGetOptionsPrice2', array(
            'options' => &$options,
            'range' => $range,
        ));

        return $options;
    }

    // Получаем все опции модификации товара
    public function getModification($options)
    {

        return array_map(function($option){

            $classKey = 'msopModificationOption';
            $query = $this->modx->newQuery($classKey);
            $query->where(array('mid' => $option['id']));
            $query->select($this->modx->getSelectColumns($classKey, $classKey, '', array('key','value'), false));
            $query->prepare();
            $query->stmt->execute();
            if($results = $query->stmt->fetchAll(PDO::FETCH_ASSOC)) {
                $tmp = array();
                foreach($results as $result) {
                    $tmp[] = "{$result['key']}:{$result['value']}";
                }
                $option['modification'] = implode(',', $tmp);
            }

            return $option;
        },$options);
    }


    // Сохраняем опции модификации msOptionsPrice2
    public function setModification($modification,$unique)
    {
        if(empty($unique)) return false;

        // Получаем id модификации
        $where = array($unique => $modification[$unique]);
        if(!$mod = $this->modx->getObject('msopModification', $where)) {
            $mod = $this->modx->newObject('msopModification');
            foreach($modification as $key => $val) {
                $mod->set($key,$val);
            }
            $mod->save();
        }
        $mid = $mod->get('id');

        $values = array_map(function($value){
            $value = explode(':',$value);
            $value = array($value[0] => $value[1]);
            return $value;
        },explode(',',$modification['modification']));

        foreach($values as $value) {
            foreach($value as $key => $v) {
                $where = array('mid' => $mid, 'rid' => $modification['rid'], 'key' => $key);
                if(!$opt = $this->modx->getObject('msopModificationOption',$where)) {
                    $opt = $this->modx->newObject('msopModificationOption');
                    foreach($where as $k => $w) {
                        $opt->set($k,$w);
                    }
                }
                $opt->set('value', $v);
                $opt->save();
            }
        }

    }

}