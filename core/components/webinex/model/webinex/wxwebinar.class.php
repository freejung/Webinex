<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 */
/**
 * @package webinex
 * @subpackage model
 */

require_once MODX_CORE_PATH.'model/modx/modprocessor.class.php';
require_once MODX_CORE_PATH.'model/modx/processors/resource/create.class.php';
require_once MODX_CORE_PATH.'model/modx/processors/resource/update.class.php';

class wxWebinar extends modResource {
    public $showInContextMenu = true;
    function __construct(xPDO & $xpdo) {
        parent :: __construct($xpdo);
        $this->set('class_key','wxWebinar');
    }	
    public static function getControllerPath(xPDO &$modx) {
        return $modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'controllers/resource/';
    }
    public function getContextMenuText() {
      $this->xpdo->lexicon->load('webinex:default');
      return array(
        'text_create' => $this->xpdo->lexicon('webinar'),
        'text_create_here' => $this->xpdo->lexicon('webinar_create_here'),
      );
    }
    public function getResourceTypeName() {
      $this->xpdo->lexicon->load('webinex:default');
      return $this->xpdo->lexicon('webinar');
    }
    
    public function save($cacheFlag= null) {
        $rt= parent :: save($cacheFlag);
        if($parent = $this->getOne('Parent')){
            $allPresentations = $this->getMany('Presentation');
            foreach($allPresentations as $presentation) {
               $presentation->addOne($parent,'Parent');
               if($grandparent = $parent->getOne('Parent')){
                   $presentation->addOne($grandparent,'Grandparent');
               }
               $presentation->save();
            }
        }
        return $rt;
    }
    
    public function primaryPresentation() {
        $latestPresentation = NULL;
        if ($presentations = $this->getMany('Presentation')) {
            $i = 0;    
            foreach($presentations as $presentation) {
              if($presentation->get('primary') == 1) {
                  if ($i == 0) {
                      $latestPresentation = $presentation;
                  }else{
                      if($latestPresentation->get('eventdate') <= $presentation->get('eventdate')) {
                          $latestPresentation->set('primary',0);
                          $latestPresentation->save();
                          $latestPresentation = $presentation;
                      }else{
                          $presentation->set('primary',0);
                          $presentation->save();
                      }
                  }
                  $i++;
               }
            }
            if($i == 0) {
                foreach($presentations as $presentation) {
                    if ($i == 0) {
                          $latestPresentation = $presentation;
                      }else{
                          if($latestPresentation->get('eventdate') <= $presentation->get('eventdate')) {
                          	$latestPresentation->set('primary',0);
                          	$latestPresentation->save();
                          	$latestPresentation = $presentation;
                          }else{
                          	$presentation->set('primary',0);
                          	$presentation->save();
                          }
                      }
                      $i++;
                }
                $latestPresentation->set('primary',1);
                $latestPresentation->save();
            }
        }
        return $latestPresentation;
    }
    
    public function setPrimaryPresentation($newPrimaryId){
        if($presentations = $this->getMany('Presentation')) {
            $oldPrimaryId = 0;
            $isNewPrimary = 0;
            foreach($presentations as $presentation) {
                if($presentation->get('primary') == 1) {
                    $presentation->set('primary',0);
                    $presentation->save();
                    $oldPrimaryId = $presentation->get('id');
                }
                if($presentation->get('id') == $newPrimaryId) {
                    $presentation->set('primary',1);
                    $presentation->save();
                    $isNewPrimary = 1;
                }
            }
            if($isNewPrimary) {
                return 1;
            }else{
                $oldPrimary = getObject('wxPresentation', $oldPrimaryId);
                $oldPrimary->set('primary', 1);
                return NULL;
            }
        }
        return NULL;
    }
}

class wxWebinarCreateProcessor extends modResourceCreateProcessor {
	 public function beforeSet() {
        $beforeSet = parent::beforeSet();
        $presentation = $this->modx->newObject('wxPresentation');
        $presentation->set('primary',1);
        $presentations = array();
        $presentations[1] = $presentation;
        $this->object->addMany($presentations);
        return $beforeSet;
    }

	public function beforeSave() {
        $beforeSave = parent::beforeSave();
        $date = $this->getProperty('eventdate');
        if (empty($date)) {
            $this->addFieldError('eventdate',$this->modx->lexicon('presentation_err_ns_date'));
            return null;
        }
        if($primaryPresentation = $this->object->primaryPresentation()) { 
            $primaryPresentation->fromArray($this->properties);
        }
        return $beforeSave;
    }
    
    public function afterSave() {
        $afterSave = parent::afterSave();
        if($primaryPresentation = $this->object->primaryPresentation()) {
            $presenterIds = array_filter($this->object->get('presenter'));
            if(!empty($presenterIds)) {
            	  $this->modx->log(modX::LOG_LEVEL_DEBUG,'presenterIds exists');
            	  $presentedByArray = array();
            	  $i = 0;
            	  foreach ($presenterIds as $presenterId) {
                     $presentedByArray[$i] = $this->modx->newObject('wxPresentedBy');
                     $presenter = $this->modx->getObject('wxPresenter',$presenterId);
                     $presentedByArray[$i]->addOne($presenter);
                     $i++;
                 }
                 $primaryPresentation->addMany($presentedByArray);
                 $primaryPresentation->save();
            }
            $documentIds = array_filter($this->object->get('document'));
            if(!empty($documentIds)) {
            	  $attachmentArray = array();
            	  $i = 0;
            	  foreach ($documentIds as $documentId) {
                     $attachmentArray[$i] = $this->modx->newObject('wxAttachment');
                     $document = $this->modx->getObject('wxDocument',$documentId);
                     $attachmentArray[$i]->addOne($document);
                     $i++;
                 }
                 $primaryPresentation->addMany($attachmentArray);
                 $primaryPresentation->save();
            }
        }
        return $afterSave;
    }
}

class wxWebinarUpdateProcessor extends modResourceUpdateProcessor {

	public function beforeSave() {
        $beforeSave = parent::beforeSave();
        if($primaryPresentation = $this->object->primaryPresentation()) { 
            $primaryPresentation->fromArray($this->properties);
            $newPrimaryPresentationId = $this->object->get('presentation');
            if($primaryPresentation->get('id') != $newPrimaryPresentationId) { 
                $this->object->setPrimaryPresentation($newPrimaryPresentationId);
                $primaryPresentation = $this->object->primaryPresentation();
            }
            $presenterIds = array_filter($this->object->get('presenter'));
            if(!empty($presenterIds)) {
            	  $oldPresentedByArray = $primaryPresentation->getMany('PresentedBy');
            	  if(!empty($oldPresentedByArray)) {
            	  	   foreach ($oldPresentedByArray as $oldP) {
            	  	   	$oldP->remove();
            	  	   }
            	  }
            	  $presentedByArray = array();
            	  $i = 0;
            	  foreach ($presenterIds as $presenterId) {
                     $presentedByArray[$i] = $this->modx->newObject('wxPresentedBy');
                     $presenter = $this->modx->getObject('wxPresenter',$presenterId);
                     $presentedByArray[$i]->addOne($presenter);
                     $i++;
                 }
                 $primaryPresentation->addMany($presentedByArray);
            }
            $documentIds = array_filter($this->object->get('document'));
            if(!empty($documentIds)) {
            	  $oldAttachmentArray = $primaryPresentation->getMany('Attachment');
            	  if(!empty($oldAttachmentArray)) {
            	  	   foreach ($oldAttachmentArray as $oldA) {
            	  	   	$oldA->remove();
            	  	   }
            	  }
            	  $attachmentArray = array();
            	  $i = 0;
            	  foreach ($documentIds as $documentId) {
                     $attachmentArray[$i] = $this->modx->newObject('wxAttachment');
                     $document = $this->modx->getObject('wxDocument',$documentId);
                     $attachmentArray[$i]->addOne($document);
                     $i++;
                 }
                 $primaryPresentation->addMany($attachmentArray);
            }
        }
        return $beforeSave;
    }
}