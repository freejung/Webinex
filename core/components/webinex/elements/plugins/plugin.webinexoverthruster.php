<?php
$modx->log(modX::LOG_LEVEL_INFO, 'Initializing Webinex Overthruster... ');
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/');
if (!($webinex instanceof Webinex)){
    $modx->log(modX::LOG_LEVEL_ERROR, 'could not instantiate webinex');
    return false;
}
$success = 1;
$eventName = $modx->event->name;
switch($eventName) {    
    case 'OnSiteRefresh':
        $allPresentations = $modx->getCollection('wxPresentation',array('primary' => 1));
        foreach($allPresentations as $presentation) {
            if(!$presentation->setTemplates()) $success = 0;
        }
        break;
    case 'OnDocFormSave':
        if($webinar = $modx->getObject('modResource',$id)) {
            if($webinar->get('class_key') == 'wxWebinar') {
                if($presentation = $webinar->primaryPresentation()) {
                    if(!$presentation->setTemplates()) $success = 0;
                }
            }
        }
        break;
        case 'OnChunkFormSave':
        if($modx->getObject('modCategory',$chunk->category)->get('category') == 'Webinex') {
            $allPresentations = $modx->getCollection('wxPresentation',array('primary' => 1));
            foreach($allPresentations as $presentation) {
                if(!$presentation->setTemplates()) $success = 0;
            }
        }
        break;
}
if ($success){
    $modx->log(modX::LOG_LEVEL_INFO, 'Success!');
}else{
    $modx->log(modX::LOG_LEVEL_ERROR, 'Webinex Overthruster initialization failed, some templates may not have been updated.');
}
return NULL;