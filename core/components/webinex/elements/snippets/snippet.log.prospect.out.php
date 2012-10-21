<?php
/*
 * Snippet logoutProspect- logs user out if user is a non-member prospect
*/

$memberGroup = $modx->getOption('memberGroup',$scriptProperties,'Members');

if($modx->user->isAuthenticated($modx->context->key)) {
	if($modx->user->get('class_key') == 'wxProspect' && !$modx->user->isMember($memberGroup)) {
		$modx->user->removeSessionContext($modx->context->key);
	}
}
return '';