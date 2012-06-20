<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 */
/**
 * @package webinex
 * @subpackage model
 */
$xpdo_meta_map['wxWebinar']= array (
  'package' => 'webinex',
  'version' => '1.1',
  'extends' => 'modResource',
  'fields' => 
  array (
  ),
  'fieldMeta' => 
  array (
  ),
  'composites' => 
  array (
    'Presentation' => 
    array (
      'class' => 'wxPresentation',
      'local' => 'id',
      'foreign' => 'webinar',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
