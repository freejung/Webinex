<?php
class VideoRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'vxVideo';  
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.video';
}
return 'VideoRemoveProcessor';