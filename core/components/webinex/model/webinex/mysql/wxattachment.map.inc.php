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
$xpdo_meta_map['wxAttachment']= array (
  'package' => 'webinex',
  'version' => '1.1',
  'table' => 'wx_attachments',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'presentation' => 0,
    'document' => 0,
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
    'document' => 
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
    'document' => 
    array (
      'alias' => 'document',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'document' => 
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
    'Document' => 
    array (
      'class' => 'wxDocument',
      'local' => 'document',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
