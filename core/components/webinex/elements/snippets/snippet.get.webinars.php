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
 * Get Webinars snippet - list custom webinar resources
 * @package webinex
 * @subpackage snippets
 */

$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

$output = '';

$tpl = $modx->getOption('tpl',$scriptProperties,'firsttpl');
$sort = $modx->getOption('sort',$scriptProperties,'eventdate');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$parents = $modx->getOption('parents',$scriptProperties,'');
$grandparents = $modx->getOption('grandparents',$scriptProperties,'');
$include = $modx->getOption('include',$scriptProperties,'');
$limit = $modx->getOption('limit',$scriptProperties,0);
$offset = $modx->getOption('offset',$scriptProperties,0);
$timeshift = $modx->getOption('timeshift',$scriptProperties,1800);
$recorded = $modx->getOption('recorded',$scriptProperties,0);
$upcoming = $modx->getOption('upcoming',$scriptProperties,1);
$includeTVs = $modx->getOption('includeTVs',$scriptProperties,false);
$includeTVList = $modx->getOption('includeTVList',$scriptProperties,array());
$processTVs = $modx->getOption('processTVs',$scriptProperties,false);
$processTVList = $modx->getOption('processTVList',$scriptProperties,array());
$prepareTVs = $modx->getOption('prepareTVs',$scriptProperties,false);
$prepareTVList = $modx->getOption('prepareTVList',$scriptProperties,array());
$tvPrefix = $modx->getOption('tvPrefix',$scriptProperties,'tv.');

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

if($include != '') {
    $includeArray = explode(',',$include);
    $whereArray['webinar:IN'] = $includeArray;
}

$c->where($whereArray);

if($limit || $offset) $c->limit($limit, $offset);

$presentations = $modx->getCollection('wxPresentation',$c);

foreach ($presentations as $presentation) {
    if($tpl == 'firsttpl' || $tpl == 'secondtpl' || $tpl == 'thirdtpl') {
        $output .= $presentation->get($tpl);
    }else{
        $presentationArray = $presentation->toFullArray($includeTVs, $includeTVList, $processTVs, $processTVList, $prepareTVs, $prepareTVList, $tvPrefix);
        $output .= $modx->getChunk($tpl, $presentationArray);
    }
}

return $output;