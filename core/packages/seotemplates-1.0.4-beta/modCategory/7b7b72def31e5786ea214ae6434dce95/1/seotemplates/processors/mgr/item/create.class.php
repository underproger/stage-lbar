<?php

class seoTemplatesItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'seoTemplatesItem';
    public $classKey = 'seoTemplatesItem';
    public $languageTopics = array('seotemplates');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {

        $template = $this->getProperty('template');
        $field = trim($this->getProperty('field'));

        $match = false;

        if (!empty($template) && !empty($field)) {
            if ($collection = $this->modx->getCollection($this->classKey, array('field' => $field))) {
                foreach($collection as $item) {

                    //$this->modx->log(1, print_r($item->get('template') ,true));

                    if (count(array_intersect($item->get('template'), $template)) > 0) {
                        $match = true;
                    }
                }
            }
        }

        if (empty($template)) {
            $this->modx->error->addField('template[]', $this->modx->lexicon('seotemplates_item_err_template'));
        } else if (empty($field)) {
            $this->modx->error->addField('field', $this->modx->lexicon('seotemplates_item_err_field'));
        } else if (
            $match
        ) {
            $this->modx->error->addField('template[]', $this->modx->lexicon('seotemplates_item_err_ae'));
            $this->modx->error->addField('field', $this->modx->lexicon('seotemplates_field_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'seoTemplatesItemCreateProcessor';