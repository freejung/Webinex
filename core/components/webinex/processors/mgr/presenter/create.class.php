<?php
class PresenterCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'wxPresenter';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.presenter';
 
    public function beforeSave() {
        $firstname = $this->getProperty('firstname');
 
        if (empty($firstname)) {
            $this->addFieldError('firstname',$this->modx->lexicon('webinex.presenter_err_ns_firstname'));
        } 
        $lastname = $this->getProperty('lastname');
 
        if (empty($lastname)) {
            $this->addFieldError('lastname',$this->modx->lexicon('webinex.presenter_err_ns_lastname'));
        }         
        
        return parent::beforeSave();
    }
}
return 'PresenterCreateProcessor';