<?php

$chunks = array();
 
$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'id' => 1,
    'name' => 'wx-first.tpl',
    'description' => 'First standard template for displaying webinars and recorded webinars.',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-first.tpl.chunk.tpl'),
),'',true,true);

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'id' => 2,
    'name' => 'wx-second.tpl',
    'description' => 'Second standard template for displaying webinars and recorded webinars.',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-second.tpl.chunk.tpl'),
),'',true,true);

$chunks[3]= $modx->newObject('modChunk');
$chunks[3]->fromArray(array(
    'id' => 3,
    'name' => 'wx-third.tpl',
    'description' => 'Third standard template for displaying webinars and recorded webinars.',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-third.tpl.chunk.tpl'),
),'',true,true);

$chunks[4]= $modx->newObject('modChunk');
$chunks[4]->fromArray(array(
    'id' => 4,
    'name' => 'wx-presenters.tpl',
    'description' => 'Third standard template for displaying webinars and recorded webinars.',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-presenters.tpl.chunk.tpl'),
),'',true,true);

$chunks[5]= $modx->newObject('modChunk');
$chunks[5]->fromArray(array(
    'id' => 5,
    'name' => 'wx-presenter-pic.tpl',
    'description' => 'Third standard template for displaying webinars and recorded webinars.',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-presenter-pic.tpl.chunk.tpl'),
),'',true,true);

$chunks[6]= $modx->newObject('modChunk');
$chunks[6]->fromArray(array(
    'id' => 6,
    'name' => 'wx-presentations.tpl',
    'description' => 'Third standard template for displaying webinars and recorded webinars.',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-presentations.tpl.chunk.tpl'),
),'',true,true);

$chunks[7]= $modx->newObject('modChunk');
$chunks[7]->fromArray(array(
    'id' => 7,
    'name' => 'wx-ical',
    'description' => 'Chunk for creating an iCalendar file. Place on a resource with an otherwise blank template, setting the suffix to "ics" and the content disposition to "attachment"',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-ical.chunk'),
),'',true,true);

$chunks[8]= $modx->newObject('modChunk');
$chunks[8]->fromArray(array(
    'id' => 8,
    'name' => 'wx-ical.tpl',
    'description' => 'Template for listPresentations for creating an iCalendar file',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-ical.tpl.chunk.tpl'),
),'',true,true);

$chunks[9]= $modx->newObject('modChunk');
$chunks[9]->fromArray(array(
    'id' => 9,
    'name' => 'wx-registration-page',
    'description' => 'Chunk containing the content of a sample webinar registration landing page',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-registration-page.chunk'),
),'',true,true);

$chunks[10]= $modx->newObject('modChunk');
$chunks[10]->fromArray(array(
    'id' => 10,
    'name' => 'wx-presentation-lp.tpl',
    'description' => 'Template for listPresentations for creating a sample registration landing page',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-presentation-lp.tpl'),
),'',true,true);

$chunks[11]= $modx->newObject('modChunk');
$chunks[11]->fromArray(array(
    'id' => 11,
    'name' => 'wx-documents.tpl',
    'description' => 'Template for listing webinar attachment documents',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-documents.tpl.chunk.tpl'),
),'',true,true);

$chunks[12]= $modx->newObject('modChunk');
$chunks[12]->fromArray(array(
    'id' => 12,
    'name' => 'wx-thanks.tpl',
    'description' => 'Template for listPresentations for creating a sample registration followup page',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-thanks.tpl.chunk.tpl'),
),'',true,true);

$chunks[13]= $modx->newObject('modChunk');
$chunks[13]->fromArray(array(
    'id' => 13,
    'name' => 'wx-thanks-page',
    'description' => 'Template for creating a sample registration followup page',
    'snippet' => getSnippetContent($sources['elements'].'chunks/wx-thanks-page.chunk'),
),'',true,true);

unset($properties);
 
return $chunks;