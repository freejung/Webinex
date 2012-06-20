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
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) { 
	$modx->log(modX::LOG_LEVEL_ERROR,'ERROR: cannot initialize Webinex class, aborting.');
	$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
}else{
	if(array_key_exists('webinar', $this->properties)) {
		if($webinar = $modx->getObject('wxWebinar',$this->properties['webinar'])) {
			$presentation = $webinar->primaryPresentation();
			$presentationArray = $presentation->toFullArray();
			$affiliateArray = array();
			if(array_key_exists('affiliate', $this->properties)) {
				if($this->properties['affiliate'] && $affiliate = $modx->getObject('wxAffiliate',$this->properties['affiliate'])) {
				    $affiliateArray = $affiliate->toArray('aff.');
				}else{
                                    $affiliateArray = array('aff.code' => '');
                                }
			}
			if(array_key_exists('email', $this->properties)) {
				$modx2 = new modX();
			    $modx2->initialize($webinar->get('context_key'));
			    $modx2->getService('error','error.modError');
				if($output = $modx2->getChunk($this->properties['email'],array_merge($affiliateArray, $presentationArray))) {
					$modx->log(modX::LOG_LEVEL_INFO,'<textarea style="width:630px;height:250px;">'.$output.'</textarea>');
				}else {
					$modx->log(modX::LOG_LEVEL_ERROR,'Could not get email template '.$this->properties['email']);
				}
			}
		}
	}else {
		$modx->log(modX::LOG_LEVEL_ERROR,'No webinar specified');
	}
	$modx->log(modX::LOG_LEVEL_INFO,'COMPLETED');
}

