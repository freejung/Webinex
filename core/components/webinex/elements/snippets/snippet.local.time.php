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
 * Local Time Snippet
 * @package webinex
 * @subpackage snippets
 */


$timezone = $modx->getOption('timezone',$scriptProperties,'');
$presentationId = $modx->getOption('presentationId',$scriptProperties,0);
$format = $modx->getOption('format',$scriptProperties,'%a, %b %e, %Y, %l:%M%P');

$zones = array(
    '-5' => array('code' => 'America/New_York', name => 'Eastern Time'),
    '-6' => array('code' => 'America/Chicago', name => 'Central Time'),
    '-7' => array('code' => 'America/Denver', name => 'Mountain Time'),
    '-8' => array('code' => 'America/Los_Angeles', name => 'Pacific Time'),
    '-9' => array('code' => 'America/Anchorage', name => 'Alaska Time'),
    '-10' => array('code' => 'America/Adak', name => 'Hawaii-Aleutian Time'),
);
     
if(empty($zones[$timezone]['code']) || !$presentationId) return '';

if(!$presentation = $modx->getObject('wxPresentation', $presentationId)) return '';

$time = strtotime($presentation->get('eventdate'));

$systemTimezone = date_default_timezone_get();

date_default_timezone_set($zones[$timezone]['code']);

$localtime = strftime($format, $time).' '.$zones[$timezone]['name'];

date_default_timezone_set($systemTimezone);

return $localtime;