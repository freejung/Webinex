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
class PresentationCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'wxPresentation';
    public $languageTopics = array('webinex:default');
    public $objectType = 'webinex.Presentation';
 
    public function beforeSave() {
        $date = $this->getProperty('eventdate');
 
        if (empty($date)) {
            $this->addFieldError('eventdate',$this->modx->lexicon('webinex.Presentation_err_ns_date'));
        }
        return parent::beforeSave();
    }
    public function afterSave() {
        if($webinar = $this->modx->getObject('wxWebinar', $this->object->get('webinar'))) {
            $webinar->setPrimaryPresentation($this->object->get('id'));
        }
        return parent::afterSave();
    }
}
return 'PresentationCreateProcessor';