<?php
class CompanyCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'wxCompany';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.company';
 
    public function beforeSave() {
        $name = $this->getProperty('name');
 
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('webinex.company_err_ns_name'));
        }       
        
        return parent::beforeSave();
    }
}
return 'CompanyCreateProcessor';