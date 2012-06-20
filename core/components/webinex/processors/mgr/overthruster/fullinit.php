<?php
$modx->log(modX::LOG_LEVEL_INFO, 'Initializing Webinex Overthruster... ');
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/');
if (!($webinex instanceof Webinex)){
    $modx->log(modX::LOG_LEVEL_ERROR, 'could not instantiate webinex');
    $modx->log(modX::LOG_LEVEL_INFO, 'COMPLETED');
    return NULL;
}
$success = 1;
set_time_limit(5000);
$i=1;
$allPresentations = $modx->getCollection('wxPresentation',array('primary' => 1));
$allPresentations = array_reverse($allPresentations);
$nps = count($allPresentations);
foreach($allPresentations as $presentation) {
	$modx->log(modX::LOG_LEVEL_INFO, 'Initializing templates for presentation '.$i.' of '.$nps.', id= '.$presentation->id);
    if(!$presentation->setTemplates()) $success = 0;
    $i ++;
}
if ($success){
    $modx->log(modX::LOG_LEVEL_INFO, 'Success!');
}else{
    $modx->log(modX::LOG_LEVEL_ERROR, 'Webinex Overthruster initialization failed, some templates may not have been updated.');
}
$modx->log(modX::LOG_LEVEL_INFO, 'COMPLETED');
return NULL;