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
 * List Presentations snippet
 * @package webinex
 * @subpackage snippets
 */
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

/* setup default properties */
$tpl = $modx->getOption('tpl',$scriptProperties,'wx-presentations.tpl');
$sort = $modx->getOption('sort',$scriptProperties,'eventdate');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
$dateFormat = $modx->getOption('dateFormat',$scriptProperties,'l F j, Y');
$timeFormat = $modx->getOption('timeFormat',$scriptProperties,'g:ia');
$parents = $modx->getOption('parents',$scriptProperties,'');
$grandparents = $modx->getOption('grandparents',$scriptProperties,'');
$where = $modx->getOption('where',$scriptProperties,'{}');
$presentationId = $modx->getOption('presentationId',$scriptProperties,0);

$parentsArray = explode(',', $parents);
$whereArray = $modx->fromJSON($where);   

/* build query */
$c = $modx->newQuery('wxPresentation');
$c->sortby($sort,$dir);
if($parents != '') {
    $parentsArray = explode(',',$parents);
    $whereArray['parent:IN'] = $parentsArray;
}

if($grandparents != '') {
    $grandparentsArray = explode(',',$grandparents);
    $whereArray['grandparent:IN'] = $grandparentsArray;
}
$c->where($whereArray);

if($presentationId) {
	$presentations = array($modx->getObject('wxPresentation',$presentationId));
}else {
	$presentations = $modx->getCollection('wxPresentation',$c);
}

/* iterate */
$output = '';

foreach ($presentations as $presentation) {
    $webinar = $presentation->getOne('Webinar');
    $thisWebinarId = $webinar->get('id');
    /*return the soonest presentation, and only published webinars*/
    if($webinar->get('published')){
        $presentationArray = $presentation->toFullArray();
        $eventdate = $presentationArray['eventdate'];
        $presentationArray['eventdate'] = date($dateFormat, strtotime($eventdate));
        $presentationArray['starttime'] = date($timeFormat, strtotime($eventdate));
        $presentationArray['start-date-time'] = $eventdate;
        $output .= $modx->getChunk($tpl,$presentationArray);
    }
}
 
return $output;