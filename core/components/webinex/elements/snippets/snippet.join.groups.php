<?php
/*
 * Snippet joinGroups - adds user to a group specified by the GET parameter "group"
 * Optionally limit this to groups in "groups" parameter
*/
if(!filter_has_var(INPUT_GET, 'group')){
  return '';
}else{
  if (!filter_input(INPUT_GET, "group", FILTER_VALIDATE_INT)){
     return '';
  }else{
    $groupId = $_GET['group'];
  }
}

$groupIds = $modx->getOption('groupIds',$scriptProperties,0);

if($modx->user->isAuthenticated($modx->context->key)) {
	if($group = $modx->getObject('modUserGroup',$groupId)) {
		$groupName = $group->get('name');
		if($groupIds) {
			$allowedGroups = explode(',',$groupIds);
			if (!in_array($groupId, $allowedGroups)) return '';
		}
		$joined = $modx->user->joinGroup($groupName);
	}
}
return '';