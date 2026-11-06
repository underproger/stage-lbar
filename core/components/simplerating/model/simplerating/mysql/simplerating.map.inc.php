<?php
$xpdo_meta_map['SimpleRating']= array (
  'package' => 'simplerating',
  'version' => '1.1',
  'table' => 'simple_rating',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'resource' => NULL,
    'rating_value' => NULL,
    'rating_count' => 0,
    'rating_ips' => NULL,
  ),
  'fieldMeta' => 
  array (
    'resource' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'index' => 'unique',
    ),
    'rating_value' => 
    array (
      'dbtype' => 'decimal',
      'precision' => '2,1',
      'phptype' => 'float',
      'null' => false,
      'index' => 'index',
    ),
    'rating_count' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'rating_ips' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'array',
      'null' => false,
    ),
  ),
  'indexes' => 
  array (
    'resource' => 
    array (
      'alias' => 'resource',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'resource' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'id' => 
    array (
      'alias' => 'id',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'rating_value' => 
    array (
      'alias' => 'rating_value',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'rating_value' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
