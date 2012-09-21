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
 * iCal snippet
 * @package webinex
 * @subpackage snippets
 */
 
$instance = $modx->getOption('instance',$scriptProperties,1);
 
if(!filter_has_var(INPUT_GET, 'cal')){
  return $modx->makeUrl($modx->resource->id, '', array_merge($_GET, array('cal' => $instance)));
}else{
  if (!filter_input(INPUT_GET, "cal", FILTER_VALIDATE_INT)){
     return $modx->makeUrl($modx->resource->id, '', array_merge($_GET, array('cal' => $instance)));
  }else{
    $cal = $_GET['cal'];
  }
}

if($cal == $instance) {

$tpl = $modx->getOption('tpl',$scriptProperties,'wx-ical.tpl');
$start = $modx->getOption('start',$scriptProperties,'');
$end = $modx->getOption('end',$scriptProperties,'');
$duration = $modx->getOption('duration',$scriptProperties,'');
$description = $modx->getOption('description',$scriptProperties,'');
$summary = $modx->getOption('summary',$scriptProperties,'');
$reminder = $modx->getOption('reminder',$scriptProperties,'');

$props = array();
$props['dtstart'] = gmstrftime('%Y%m%d',$start).'T'.gmstrftime('%H%M%S',$start).'Z';
$props['dtend'] = gmstrftime('%Y%m%d',$end).'T'.gmstrftime('%H%M%S',$end).'Z';
$props['duration'] = $duration;
$props['description']=$description;
$props['summary']=$summary;
$props['reminder']=$reminder;

$iCalFile = $modx->getChunk($tpl, $props);

}

return $modx->makeUrl($modx->resource->id, '', array_merge($_GET, array('cal' => $instance)));


