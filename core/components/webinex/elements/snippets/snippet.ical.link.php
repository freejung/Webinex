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
 * iCalLink snippet
 * @package webinex
 * @subpackage snippets
 */

$useSession = $modx->getOption('useSession',$scriptProperties,1); 
$instance = $modx->getOption('instance',$scriptProperties,1);
$props = array();
$props['tpl'] = $modx->getOption('tpl',$scriptProperties,'wx-ical.tpl');
$props['dtstart'] = $modx->getOption('dtstart',$scriptProperties,'');
$props['dtend'] = $modx->getOption('dtend',$scriptProperties,'');
$props['duration'] = $modx->getOption('duration',$scriptProperties,'');
$props['location'] = $modx->getOption('location',$scriptProperties,'');
$props['description'] = $modx->getOption('description',$scriptProperties,'');
$props['summary'] = $modx->getOption('summary',$scriptProperties,'');
$props['reminder'] = $modx->getOption('reminder',$scriptProperties,'');
$props['filename'] = $modx->getOption('filename',$scriptProperties,'event.ics');

if($useSession) {
    $_SESSION['ical'.$instance] = $props;
    return $modx->makeUrl($modx->resource->id, '', array('cal' => $instance));
}else{
    return $modx->makeUrl($modx->resource->id, '', array(
        'cal' => $instance,
        'cf' => urlencode($modx->toJSON($props))
    ));
}