<?php

class seoTemplatesFieldCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'seoTemplatesField';
    public $classKey = 'seoTemplatesField';
    public $languageTopics = array('seotemplates');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('seotemplates_field_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('seotemplates_field_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'seoTemplatesFieldCreateProcessor';