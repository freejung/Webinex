<?php
class PresentationRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'wxPresentation';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.Presentation';
}
return 'PresentationRemoveProcessor';