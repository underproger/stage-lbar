<?php
$xpdo_meta_map['seoTemplatesItem']= array (
  'package' => 'seotemplates',
  'version' => '1.1',
  'table' => 'seotemplates_items',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'template' => '',
    'field' => '',
    'value' => '',
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'template' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'json',
      'null' => true,
      'default' => '',
    ),
    'field' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'value' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => true,
      'default' => '',
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'null' => true,
      'default' => 1,
    ),
  ),
  'indexes' => 
  array (
    'active' => 
    array (
      'alias' => 'active',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'active' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
