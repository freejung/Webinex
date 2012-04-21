<?php
class DocumentRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'wxDocument';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.document';
}
return 'DocumentRemoveProcessor';