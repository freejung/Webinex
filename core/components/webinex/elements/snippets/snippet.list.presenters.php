<?php
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

/* setup default properties */
$tpl = $modx->getOption('tpl',$scriptProperties,'wx-presenters.tpl');
$sort = $modx->getOption('sort',$scriptProperties,'lastname');
$dir = $modx->getOption('dir',$scriptProperties,'DESC');
$presentation = $modx->getOption('presentation',$scriptProperties,0);
$company = $modx->getOption('company',$scriptProperties,0);
$where = $modx->getOption('where',$scriptProperties,'{}');
$limit = $modx->getOption('limit',$scriptProperties,0);
$offset = $modx->getOption('offset',$scriptProperties,0);

/* build query */
$c = $modx->newQuery('wxPresenter');
$c->sortby($sort,$dir);

$output = '';

$whereArray = $modx->fromJSON($where);
$cArray = array();
if($company) $cArray = array('company:=' => $company);

if($presentation) {
    $pidArray = array();
    if($presentationObj = $modx->getObject('wxPresentation', $presentation)) {
        $presentedByArray = $presentationObj->getMany('PresentedBy');
        if(empty($presentedByArray)) return NULL;
        foreach ($presentedByArray as $presentedBy) {
            $presenter = $presentedBy->getOne('Presenter');
            $pidArray[] = $presenter->get('id');
        }
        $whereArray['id:IN'] = $pidArray;
    }
}

$qArray = array_merge($whereArray, $cArray);

if(array_filter($qArray)) $c->where(array_merge($whereArray, $cArray));

if($limit || $offset) $c->limit($limit, $offset);

$presenters = $modx->getCollection('wxPresenter',$c);

foreach ($presenters as $presenter) {
    $companyArray = array();
    if($thisCompany = $presenter->getOne('Company')) $companyArray = $thisCompany->toArray('company.');
    $presenterArray = $presenter->toArray();
    $output .= $modx->getChunk($tpl, array_merge($companyArray, $presenterArray));
}


return $output;