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
$xpdo_meta_map['wxReferral']= array (
  'package' => 'webinex',
  'version' => '1.1',
  'table' => 'wx_referrals',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'prospect' => NULL,
    'entry' => 0,
    'affiliate' => 0,
    'createdon' => NULL,
  ),
  'fieldMeta' => 
  array (
    'prospect' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
    ),
    'entry' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'affiliate' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'createdon' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => true,
    ),
  ),
  'indexes' => 
  array (
    'affiliate' => 
    array (
      'alias' => 'affiliate',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'affiliate' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'entry' => 
    array (
      'alias' => 'entry',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'entry' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'prospect' => 
    array (
      'alias' => 'prospect',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'prospect' => 
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
    'Affiliate' => 
    array (
      'class' => 'wxAffiliate',
      'local' => 'affiliate',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Entry' => 
    array (
      'class' => 'modResource',
      'local' => 'entry',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Prospect' => 
    array (
      'class' => 'wxProspect',
      'local' => 'prospect',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Registration' => 
    array (
      'class' => 'wxRegistration',
      'local' => 'id',
      'foreign' => 'referral',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
