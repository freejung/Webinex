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
 * List Documents snippet
 * @package webinex
 * @subpackage snippets
 */
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
    $docArray = array();
    if($presentationObj = $modx->getObject('wxPresentation', $presentation)) {
        if(!$attachmentArray = $presentationObj->getMany('Attachment')) return '';   
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