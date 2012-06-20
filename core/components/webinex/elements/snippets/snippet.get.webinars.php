<?php

$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

$output = '';

$tpl = $modx->getOption('tpl',$scriptProperties,'firsttpl');
$sort = $modx->getOption('sort',$scriptProperties,'eventdate');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$parents = $modx->getOption('parents',$scriptProperties,'');
$grandparents = $modx->getOption('grandparents',$scriptProperties,'');
$limit = $modx->getOption('limit',$scriptProperties,0);
$offset = $modx->getOption('offset',$scriptProperties,0);
$timeshift = $modx->getOption('timeshift',$scriptProperties,1800);
$recorded = $modx->getOption('recorded',$scriptProperties,0);
$upcoming = $modx->getOption('upcoming',$scriptProperties,1);

$c = $modx->newQuery('wxPresentation');
$c->sortby($sort,$dir);
$whereArray = array('primary' => 1);

if(!$upcoming) {
    $whereArray['recording:!='] = '';
}
if(!$recorded) {
    $whereArray['eventdate:>='] = date('Y-m-d H:i:s',(time()-$timeshift));
}

if($parents != '') {
    $parentsArray = explode(',',$parents);
    $whereArray['parent:IN'] = $parentsArray;
}

if($grandparents != '') {
    $grandparentsArray = explode(',',$grandparents);
    $whereArray['grandparent:IN'] = $grandparentsArray;
}

$c->where($whereArray);

if($limit || $offset) $c->limit($limit, $offset);

$presentations = $modx->getCollection('wxPresentation',$c);

foreach ($presentations as $presentation) {
    if($tpl == 'firsttpl' || $tpl == 'secondtpl' || $tpl == 'thirdtpl') {
        $output .= $presentation->get($tpl);
    }else{
        $presentationArray = $presentation->toFullArray();
        $output .= $modx->getChunk($tpl, $presentationArray);
    }
}

return $output;