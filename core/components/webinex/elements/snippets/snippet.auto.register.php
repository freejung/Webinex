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
 * autoRegister snippet - automatically register logged in member for a webinar
 * @package webinex
 * @subpackage snippets
 */
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

$memberGroup = $modx->getOption('memberGroup',$scriptProperties,'Members');
$resubmitUrl = $modx->getOption('resubmitUrl',$scriptProperties,FALSE);
$fieldValues = $modx->getOption('fieldValues',$scriptProperties,'');
$thanksPage = $modx->getOption('thanksPage',$scriptProperties,1);
$debug = $modx->getOption('debug',$scriptProperties,0);

$modx->setLogLevel(modX::LOG_LEVEL_INFO);
if ($debug) $modx->setLogLevel(modX::LOG_LEVEL_DEBUG);

$fieldValueArray = $modx->fromJSON($fieldValues);

if($modx->user->isAuthenticated($modx->context->key)) {
	if ($modx->user->get('class_key') == 'wxProspect' && $modx->user->isMember($memberGroup)) {
	    if($modx->resource->class_key == 'wxWebinar') {
			$webinar = $modx->getObject('wxWebinar',$modx->resource->id);
		    $presentation = $webinar->primaryPresentation();
		    $modx->user->registerFor(array($presentation));
		    $modx->log(modX::LOG_LEVEL_DEBUG, 'user '.$modx->user->username.' registered for presentation'.$presentation->id);
			if ($resubmitUrl) {
				$modx->log(modX::LOG_LEVEL_DEBUG, 'resubmit URL:'.$resubmitUrl);
		    	$profile=$modx->user->getOne('Profile');
			    $email = $profile->email;
			    $modx->log(modX::LOG_LEVEL_DEBUG, 'email: '.$email);
			    $fieldValueArray['emailAddress'] = $email;
		    	$modx->runSnippet('resubmitHook', array('url' => $resubmitUrl, 'fieldValues' => $modx->toJSON($fieldValueArray)));
		    	$modx->log(modX::LOG_LEVEL_DEBUG, 'field values: '.print_r($fieldValueArray,true));
		    }
		    $thanksUrl = $modx->makeUrl($thanksPage, $modx->context->key, array('ps' => $modx->resource->id), 'http');
		    $modx->sendRedirect($thanksUrl);
		}
	}
}

return '';
