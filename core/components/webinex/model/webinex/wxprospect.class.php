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
		    $profile = $this->xpdo->newObject('modUserProfile');
		    $profile->set('email',$email);
		    $this->addOne($profile);
		    $this->xpdo->user = $this;
		    $this->addSessionContext($this->xpdo->context->key);
		    $group = $this->xpdo->getOption('webinex.default_prospect_group',null,0);
		    $this->save();
		    if($group) {
		    	$this->joinGroup($group);
		    }
	    }
    }
}