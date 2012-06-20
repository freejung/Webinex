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
$xpdo_meta_map['wxPresentedBy']= array (
  'package' => 'webinex',
  'version' => '1.1',
  'table' => 'wx_presentedby',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'presentation' => 0,
    'presenter' => 0,
  ),
  'fieldMeta' => 
  array (
    'presentation' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'presenter' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'presentation' => 
    array (
      'alias' => 'presentation',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'presentation' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'presenter' => 
    array (
      'alias' => 'presenter',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'presenter' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Presentation' => 
    array (
      'class' => 'wxPresentation',
      'local' => 'presentation',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Presenter' => 
    array (
      'class' => 'wxPresenter',
      'local' => 'presenter',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
