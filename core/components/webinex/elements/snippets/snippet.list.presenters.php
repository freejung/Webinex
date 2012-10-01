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
 * List Presenters snippet
 * @package webinex
 * @subpackage snippets
 */
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

if($presenters = $modx->getCollection('wxPresenter',$c)){
    foreach ($presenters as $presenter) {
        $companyArray = array();
        if($thisCompany = $presenter->getOne('Company')) $companyArray = $thisCompany->toArray('company.');
        $presenterArray = $presenter->toArray();
        $output .= $modx->getChunk($tpl, array_merge($companyArray, $presenterArray));
    }
}
return $output;