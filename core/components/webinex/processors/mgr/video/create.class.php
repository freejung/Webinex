<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 */
/**
 * @package webinex
 * @subpackage processors
 */
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
}
return 'VideoCreateProcessor';