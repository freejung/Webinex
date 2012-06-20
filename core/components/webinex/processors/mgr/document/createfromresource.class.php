<?php
class DocumentCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'wxDocument';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.document';
 
    public function beforeSave() {
        $title = $this->getProperty('title');
 
        if (empty($title)) {
            $this->addFieldError('title',$this->modx->lexicon('webinex.document_err_ns_title'));
        } 
        $url = $this->getProperty('url');
 
        if (empty($url)) {
            $this->addFieldError('url',$this->modx->lexicon('webinex.document_err_ns_url'));
        }         
        
        return parent::beforeSave();
    }
    
    public function afterSave() {
        if($webinar = $this->modx->getObject('wxWebinar', $this->object->get('webinar'))) {
        	$document = $this->object;
            $presentation = $webinar->primaryPresentation();
            $attachment = $this->modx->newObject('wxAttachment');
            $attachment->addOne($document);
            $attachment->addOne($presentation);
            $attachmentArray = array();
            $attachmentArray[0] = $attachment;
            $presentation->addMany($attachmentArray);
            $presentation->save();
        }
        return parent::afterSave();
    }
}
return 'DocumentCreateProcessor';