<?php

class seoTemplatesFieldDisableProcessor extends modObjectProcessor
{
    public $objectType = 'seoTemplatesField';
    public $classKey = 'seoTemplatesField';
    public $languageTopics = array('seotemplates');
    //public $permission = 'save';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('seotemplates_field_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var seoTemplatesField $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('seotemplates_field_err_nf'));
            }

            $object->set('active', false);
            $object->save();
        }

        return $this->success();
    }

}

return 'seoTemplatesFieldDisableProcessor';
