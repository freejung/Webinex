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
}
return 'DocumentCreateProcessor';