<?php
$url = $modx->getOption('url',$scriptProperties,0);
if(!$hook || !$url) {
    return FALSE;
}
$allFormFields = $hook->getValues();
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