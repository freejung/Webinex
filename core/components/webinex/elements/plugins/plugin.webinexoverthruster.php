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
 * Webinex overThruster
 * Plugin to update default webinar templates
 * @package webinex
 * @subpackage plugins
 */
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