<?php
class VideoCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'vxVideo';  
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.video';
 
    public function beforeSave() {
        $title = $this->getProperty('title');
 
        if (empty($title)) {
            $this->addFieldError('title',$this->modx->lexicon('webinex.video_err_ns_title'));
        }     
        
        return parent::beforeSave();
    }
    
    public function afterSave() {
        if($webinar = $this->modx->getObject('wxWebinar', $this->object->get('webinar'))) {
            $presentation = $webinar->primaryPresentation();
            $presentation->addOne($this->object,$this->object->get('targetfield'));
            $webinar->save();
        }
        return parent::afterSave();
    }
}
return 'VideoCreateProcessor';