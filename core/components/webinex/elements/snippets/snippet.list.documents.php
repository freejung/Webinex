<?php
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

/* setup default properties */
$tpl = $modx->getOption('tpl',$scriptProperties,'wx-documents.tpl');
$sort = $modx->getOption('sort',$scriptProperties,'title');
$dir = $modx->getOption('dir',$scriptProperties,'DESC');
$presentation = $modx->getOption('presentation',$scriptProperties,0);
$where = $modx->getOption('where',$scriptProperties,'{}');
$limit = $modx->getOption('limit',$scriptProperties,0);
$offset = $modx->getOption('offset',$scriptProperties,0);

/* build query */
$c = $modx->newQuery('wxDocument');
$c->sortby($sort,$dir);

$output = '';

$whereArray = $modx->fromJSON($where);
$cArray = array();

if($presentation) {
    $pidArray = array();
    if($presentationObj = $modx->getObject('wxPresentation', $presentation)) {
        $attachmentArray = $presentationObj->getMany('Attachment');   
        foreach ($attachmentArray as $attachment) {
            $document = $attachment->getOne('Document');
            $docArray[] = $document->get('id');
        }
        $whereArray['id:IN'] = $docArray;
    }
}

$qArray = array_merge($whereArray, $cArray);

if(array_filter($qArray)) $c->where(array_merge($whereArray, $cArray));

if($limit || $offset) $c->limit($limit, $offset);

$documents = $modx->getCollection('wxDocument',$c);

foreach ($documents as $document) {
    $output .= $modx->getChunk($tpl, $document->toArray());
}


return $output;