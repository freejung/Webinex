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
 * Join hook for register snippet - set registrants class key to wxProspect
 * @package webinex
 * @subpackage snippets
 */
if(!$hook) {
	$modx->log(modX::LOG_LEVEL_ERROR, 'Join Hook called with no hook');
	return FALSE;
}
$debug = $modx->getOption('debug',$scriptProperties,0);

$modx->setLogLevel(modX::LOG_LEVEL_INFO);
if ($debug) $modx->setLogLevel(modX::LOG_LEVEL_DEBUG);

$modx->log(modX::LOG_LEVEL_DEBUG, 'Join hook called');
if($user = $hook->getValue('register.user')){
	$modx->log(modX::LOG_LEVEL_DEBUG, 'getting user from hook');
	$profile = $hook->getValue('register.profile');
	$user->set('class_key', 'wxProspect');
	$fields = $profile->get('extended');
	$fullName = '';
	if($firstName = $hook->getValue('firstName')) {
		$fullName .= $firstName;
		$fields['firstname'] = $firstName;
	}
	if($lastName = $hook->getValue('lastName')) {
		$fullName .= ' '.$lastName;
		$fields['lastname'] = $lastName;
	}
	if ($firstName || $lastName) $profile->set('fullname',trim($fullName));
	$saved = $user->save();
	if(!$saved) $modx->log(modX::LOG_LEVEL_ERROR, 'Join Hook: user not saved');
}else{
	$modx->log(modX::LOG_LEVEL_ERROR, 'Join Hook: cannot get user');
}
return TRUE;