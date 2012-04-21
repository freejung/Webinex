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
    
	 public function afterSave() {
        if($webinar = $this->modx->getObject('wxWebinar', $this->object->get('webinar'))) {
        	   $presenter = $this->object;
            $presentation = $webinar->primaryPresentation();
            $presentedBy = $this->modx->newObject('wxPresentedBy');
            $presentedBy->addOne($presenter);
            $presentedBy->addOne($presentation);
            $presentedByArray = array();
            $presentedByArray[0] = $presentedBy;
            $presentation->addMany($presentedByArray);
            $webinar->save();
        }
        return parent::afterSave();
    }
}
return 'PresenterCreateProcessor';