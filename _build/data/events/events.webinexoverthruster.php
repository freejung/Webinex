<?php
/**
 * Adds events to webinexOverThruster plugin
 * 
 * @package webinex
 * @subpackage build
 */
$events = array();

$events['OnChunkFormSave']= $modx->newObject('modPluginEvent');
$events['OnChunkFormSave']->fromArray(array(
    'event' => 'OnChunkFormSave',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

$events['OnDocFormSave']= $modx->newObject('modPluginEvent');
$events['OnDocFormSave']->fromArray(array(
    'event' => 'OnDocFormSave',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);

return $events;