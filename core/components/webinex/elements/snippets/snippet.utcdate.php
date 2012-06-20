<?php
if (empty($options)) $options = '%A, %d %B %Y %H:%M:%S';
$value = 0 + $input;
if ($value != 0 && $value != -1) {
    $output= gmstrftime($options,$value);
} else {
    $output= '';
}
return $output;