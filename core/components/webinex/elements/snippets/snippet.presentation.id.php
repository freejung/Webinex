<?php
if(!filter_has_var(INPUT_GET, 'ps')){
  return '';
}else{
  if (!filter_input(INPUT_GET, "ps", FILTER_VALIDATE_INT)){
     return '';
  }else{
    $presentationId = $_GET['ps'];
  }
}

$modx->setPlaceholder('wx-presentation-id', $presentationId); 

return'';
