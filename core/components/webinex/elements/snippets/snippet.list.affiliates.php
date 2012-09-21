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
 * List Affiliates snippet
 * @package webinex
 * @subpackage snippets
 */
$webinex = $modx->getService('webinex','Webinex',$modx->getOption('webinex.core_path',null,$modx->getOption('core_path').'components/webinex/').'model/webinex/',$scriptProperties);
if (!($webinex instanceof Webinex)) return 'could not instantiate Webinex';

/* setup default properties */
$tpl = $modx->getOption('tpl',$scriptProperties,'wx-affiliates.tpl');
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'DESC');
$where = $modx->getOption('where',$scriptProperties,'{}');
$limit = $modx->getOption('limit',$scriptProperties,0);
$offset = $modx->getOption('offset',$scriptProperties,0);

/* build query */
$c = $modx->newQuery('wxAffiliate');
$c->sortby($sort,$dir);

$output = '';

$whereArray = $modx->fromJSON($where);
$c->where($whereArray);

if($limit || $offset) $c->limit($limit, $offset);

$affiliates = $modx->getCollection('wxAffiliate',$c);

foreach ($affiliates as $affiliate) {
    $affiliateArray = $affiliate->toArray();
    $output .= $modx->getChunk($tpl, $affiliateArray);
}

return $output;