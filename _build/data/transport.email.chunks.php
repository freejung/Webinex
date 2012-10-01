<?php

$chunks = array();
 
$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'id' => 1,
    'name' => 'wx-email-invitation',
    'description' => 'Webinar Invitation Email',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-email-invitation.chunk'),
),'',true,true);

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'id' => 2,
    'name' => 'wx-email-response',
    'description' => 'Webinar Registration Response',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-email-response.chunk'),
),'',true,true);

$chunks[3]= $modx->newObject('modChunk');
$chunks[3]->fromArray(array(
    'id' => 3,
    'name' => 'wx-email-reminder',
    'description' => 'Webinar Reminder Email',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-email-reminder.chunk'),
),'',true,true);

$chunks[4]= $modx->newObject('modChunk');
$chunks[4]->fromArray(array(
    'id' => 4,
    'name' => 'wx-email-thanks',
    'description' => 'Webinar Attendance Thanks',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-email-thanks.chunk'),
),'',true,true);

$chunks[5]= $modx->newObject('modChunk');
$chunks[5]->fromArray(array(
    'id' => 5,
    'name' => 'wx-email-missed',
    'description' => 'Webinar Followup Missed',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-email-missed.chunk'),
),'',true,true);

unset($properties);
 
return $chunks;