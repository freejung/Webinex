<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 *
 * Webinex is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Webinex is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Webinex; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package webinex
 */
/**
 * Register hook snippet - register user for a webinar
 * @package webinex
 * @subpackage snippets
 */
if(!$hook) return FALSE;
$email = $hook->getValue('emailAddress');
if(empty($email)) return FALSE;
$existingUser = FALSE;

if($modx->user->isAuthenticated($modx->context->key) && $modx->user->get('class_key') == 'wxProspect') {
    $profile=$modx->user->getOne('Profile');
    $prospectEmail = $profile->email;
    if($prospectEmail == $email) {
        $existingUser = TRUE;
    }
}

if(!$existingUser) {
    if($prospect=$modx->getObject('wxProspect',array('username' => $email))) {
        $modx->user = $prospect;
        $modx->user->addSessionContext($modx->context->key);
        $existingUser = TRUE;
    }
}

if(!$existingUser) { 
    $newProspect = $modx->newObject('wxProspect');
    $newProspect->standardSetup($email);
}

$profile = $modx->user->getOne('Profile');
$profile->set('email',$email);
if($hook->getValue('firstName') || $hook->getValue('lastName')) $profile->set('fullname',$hook->getValue('firstName').' '.$hook->getValue('lastName'));
if($hook->getValue('stateOrProvince')) $profile->set('state',$hook->getValue('stateOrProvince'));
if($hook->getValue('businessPhone')) $profile->set('phone',$hook->getValue('businessPhone'));
$fields = $profile->get('extended');
if($hook->getValue('Company')) $fields['Company'] = $hook->getValue('Company');
if($hook->getValue('title')) $fields['Title'] = $hook->getValue('title');
$profile->set('extended',$fields);
$saved = $modx->user->save();

if($modx->resource->class_key == 'wxWebinar' && $saved) {
    $registration = $modx->newObject('wxRegistration');
    $webinar = $modx->getObject('wxWebinar',$modx->resource->id);
    $presentation = $webinar->primaryPresentation();
    $registration->addOne($presentation);
    $registration->addOne($modx->user);
    $registration->set('createdon',time());
    if($referralId = $hook->getValue('referralId')) {
        $referral = $modx->getObject('wxReferral',$referralId);
        $registration->addOne($referral);
    }
    $registration->save(); 
}
return TRUE;