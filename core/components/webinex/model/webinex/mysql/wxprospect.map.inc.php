<?php
$xpdo_meta_map['wxProspect']= array (
  'package' => 'webinex',
  'version' => '1.1',
  'table' => 'users',
  'extends' => 'modUser',
  'fields' => 
  array (
  ),
  'fieldMeta' => 
  array (
  ),
  'composites' => 
  array (
    'Referral' => 
    array (
      'class' => 'wxReferral',
      'local' => 'id',
      'foreign' => 'prospect',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Registration' => 
    array (
      'class' => 'wxRegistration',
      'local' => 'id',
      'foreign' => 'prospect',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
