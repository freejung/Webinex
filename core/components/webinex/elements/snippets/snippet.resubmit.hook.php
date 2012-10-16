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
 * Resubmit hook snippet - post form data to external URL
 * @package webinex
 * @subpackage snippets
 */
$url = $modx->getOption('url',$scriptProperties,0);
$fieldValues = $modx->getOption('fieldValues',$scriptProperties,'');
if(!$url) {
    return FALSE;
}
$fieldValueArray = $modx->fromJSON($fieldValues);
$allFormFields = array();
if($hook) {
	$allFormFields = $hook->getValues();
}
$allFormFields = array_merge($allFormFields, $fieldValues);
$postItems = array();
foreach ($allFormFields as $key => $value) {
    $postItems[] = $key . '=' . $value;
}
$postString = implode ('&', $postItems);
$curlConnection = curl_init($url);
curl_setopt($curlConnection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curlConnection, CURLOPT_USERAGENT,
  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $postString);
$result = curl_exec($curlConnection);
curl_close($curlConnection);
return TRUE;