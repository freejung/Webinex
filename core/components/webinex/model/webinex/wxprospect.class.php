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
class wxProspect extends modUser {
    function __construct(xPDO & $xpdo) {
        parent :: __construct($xpdo);
        $this->set('class_key','wxProspect');
    }
    
    /* Set up this user with username=email, log in to current context, and save */
    public function standardSetup ($email) {
        if ($this->xpdo instanceof modX) {
            $this->set('username',$email);
            $this->set('password',$this->generatePassword());
            $group = $this->xpdo->getOption('webinex.default_prospect_group',null,0);
            $this->save();
            if($group) {
                $this->joinGroup($group);
            }
            $profile = $this->xpdo->newObject('modUserProfile');
            $profile->set('email',$email);
            $this->addOne($profile);
            $this->save();
        }
    }
    
    /* register this prospect for presentations */
    /*
    * @param array of wxPresentation $presentations
    * $param int $referralId
    */
    public function registerFor ($presentations = array(), $referralId = 0) {
    	$registrationArray = array();
    	$registrations = array();
    	foreach($presentations as $presentation) {
    		//check if already registered
    		if(!$registrations = $this->getMany('Registration', array('presentation' => $presentation->id))){
		    	$registration = $this->xpdo->newObject('wxRegistration');
		    	$registration->addOne($presentation);
			    $registration->set('createdon',time());
			    if($referralId) {
			        $referral = $this->xpdo->getObject('wxReferral',$referralId);
			        $registration->addOne($referral);
			    }
			    $registrationArray[] = $registration;
		    }else{
		    	$registrationArray = array_merge($registrationArray, $registrations);
		    }
	    }
    	$this->addMany($registrationArray);
    	$this->save();
    	return $registrationArray;
    }
}