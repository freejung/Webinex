<?php
$format = $modx->getOption('format',$scriptProperties,0);
$local = $modx->getOption('timezone',$scriptProperties,0);

$now = time();

if($format) {
  if($local) {
    return strftime($format,$now);
  }else{
    return gmstrftime($format,$now);
  }
}else{
  return $now;
}