<?php
class AffiliateCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'wxAffiliate';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.affiliate';
 
    public function beforeSave() {
        $name = $this->getProperty('name');
 
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('webinex.affiliate_err_ns_name'));
        }       
        
        return parent::beforeSave();
    }
}
return 'AffiliateCreateProcessor';