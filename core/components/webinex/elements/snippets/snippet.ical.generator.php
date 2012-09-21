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
 * iCalGenerator snippet
 * @package webinex
 * @subpackage snippets
 */

$useSession = $modx->getOption('useSession',$scriptProperties,1);

if(!filter_has_var(INPUT_GET, 'cal')){
  return '';
}else{
  if (!filter_input(INPUT_GET, "cal", FILTER_VALIDATE_INT)){
     return '';
  }else{
    $cal = $_GET['cal'];
    if($useSession) {
        if (!$props = $_SESSION['ical'.$cal]) return '';
    }else {
        if(!filter_has_var(INPUT_GET, 'cf')){
            return '';
        }else{
            $props = $modx->fromJSON(urldecode(filter_var($_GET['cf'], FILTER_SANITIZE_URL)));
        }
   }
    $now = time();
    $start = is_numeric($props['dtstart']) ? $props['dtstart'] : strtotime($props['dtstart']);
    $end = is_numeric($props['dtend'])||empty($props['dtend']) ? $props['dtend'] : strtotime($props['dtend']);
    $props['dtstart'] = gmstrftime('%Y%m%d',$start).'T'.gmstrftime('%H%M%S',$start).'Z';
    $props['dtend'] = gmstrftime('%Y%m%d',$end).'T'.gmstrftime('%H%M%S',$end).'Z';
    $props['dtstamp'] = gmstrftime('%Y%m%d',$now).'T'.gmstrftime('%H%M%S',$now).'Z';
    header('Content-Disposition: attachment; filename=' . $props['filename']);
    header('Content-Type: application/x-download');
    echo $modx->getChunk($props['tpl'], $props);
    die();
  }
}