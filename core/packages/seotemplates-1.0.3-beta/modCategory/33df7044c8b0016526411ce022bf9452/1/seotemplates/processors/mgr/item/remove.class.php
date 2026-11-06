<?php

class seoTemplatesItemRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'seoTemplatesItem';
    public $classKey = 'seoTemplatesItem';
    public $languageTopics = array('seotemplates');
    //public $permission = 'remove';


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
            return $this->failure($this->modx->lexicon('seotemplates_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var seoTemplatesItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('seotemplates_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'seoTemplatesItemRemoveProcessor';