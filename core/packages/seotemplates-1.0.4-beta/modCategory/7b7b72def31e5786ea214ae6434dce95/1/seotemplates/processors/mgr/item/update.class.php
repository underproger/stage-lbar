<?php

class seoTemplatesItemUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'seoTemplatesItem';
    public $classKey = 'seoTemplatesItem';
    public $languageTopics = array('seotemplates');
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {

        $id = (int)$this->getProperty('id');
        $template = $this->getProperty('template');
        $field = trim($this->getProperty('field'));

        $match = false;

        if (!empty($template) && !empty($field)) {
            if ($collection = $this->modx->getCollection($this->classKey, array('field' => $field, 'id:!=' => $id))) {
                foreach($collection as $item) {
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

return 'seoTemplatesItemUpdateProcessor';
