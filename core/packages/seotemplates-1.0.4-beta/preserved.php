<?php return array (
  '7bbf518ad88ab5aa774df9c72bdf304a' => 
  array (
    'criteria' => 
    array (
      'name' => 'seotemplates',
    ),
    'object' => 
    array (
      'name' => 'seotemplates',
      'path' => '{core_path}components/seotemplates/',
      'assets_path' => '',
    ),
  ),
  '3404c93934ed4a51ad91cff2b54fd787' => 
  array (
    'criteria' => 
    array (
      'key' => 'seotemplates_placeholder_prefix',
    ),
    'object' => 
    array (
      'key' => 'seotemplates_placeholder_prefix',
      'value' => 'st_',
      'xtype' => 'textfield',
      'namespace' => 'seotemplates',
      'area' => 'seotemplates_main',
      'editedon' => NULL,
    ),
  ),
  '02bce32f1f7f92977ac2519e1ac46010' => 
  array (
    'criteria' => 
    array (
      'text' => 'seotemplates',
    ),
    'object' => 
    array (
      'text' => 'seotemplates',
      'parent' => 'components',
      'action' => 'home',
      'description' => 'seotemplates_menu_desc',
      'icon' => '',
      'menuindex' => 0,
      'params' => '',
      'handler' => '',
      'permissions' => '',
      'namespace' => 'seotemplates',
    ),
  ),
  'b31120872777769169d7b31174bc73fe' => 
  array (
    'criteria' => 
    array (
      'category' => 'seoTemplates',
    ),
    'object' => 
    array (
      'id' => 52,
      'parent' => 0,
      'category' => 'seoTemplates',
      'rank' => 0,
    ),
  ),
  '2c1800651549dccf668f3f9416a88308' => 
  array (
    'criteria' => 
    array (
      'name' => 'seoTemplates',
    ),
    'object' => 
    array (
      'id' => 30,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'seoTemplates',
      'description' => '',
      'editor_type' => 0,
      'category' => 52,
      'cache_type' => 0,
      'plugincode' => '$seoTemplates = $modx->getService(\'seotemplates\',\'seoTemplates\',$modx->getOption(\'seotemplates_core_path\',null,$modx->getOption(\'core_path\').\'components/seotemplates/\').\'model/seotemplates/\', array());
if (!($seoTemplates instanceof seoTemplates)) return \'\';

//$pdotools = $modx->getService(\'pdoTools\');

if ($modx->event->name == \'OnLoadWebDocument\') {

  if (!$template = $modx->getObject(\'modTemplate\', $modx->resource->template)) {return \'\';};
  $template = $template->get(\'templatename\');
  $templates = array();

  $c = $modx->newQuery(\'seoTemplatesItem\');
  $c->sortby(\'id\', \'ASC\');
  $c->select(array(\'id\', \'template\', \'field\', \'value\', \'active\'));
  $c->where(array(\'active:=\' => 1));

  if ($c->prepare() && $c->stmt->execute()) {
    $items = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  if (empty($items)) return \'\';

  foreach($items as $item) {
    $tpls = json_decode($item[\'template\'], true);

    if (in_array($template, $tpls)) {
        $templates[] = $item;
    }
  }

  if (empty($templates)) return \'\';

  $placeholders = array();
  $fields = array();

  $tmp = $modx->getCollection(\'seoTemplatesField\');

  if ($tmp) {

      foreach ($tmp as $field) {
        $fields[$field->get(\'id\')] = $field->get(\'name\');
      }

      foreach($templates as $item) {
        $field = $item[\'field\'];

        if (isset($fields[$field])) {
          $placeholders[$fields[$field]] = $item[\'value\'];
        }
      }

      foreach ($placeholders as $k => $v) {
        $chunk = $modx->newObject(\'modChunk\', array(\'name\' => \'seoTemplatesTmp_\'.$k));
        $chunk->setCacheable(false);
        $placeholders[$k] = $chunk->process(array($k => $v), $v);
        //$placeholders[$k] = $pdotools->getChunk(\'@INLINE \'.$v, array($k => $v));
      }

      $prefix = $modx->getOption(\'seotemplates_placeholder_prefix\', null, \'st_\');

      $modx->setPlaceholders($placeholders, $prefix);

  }

}',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => 'core/components/seotemplates/elements/plugins/plugin.seotemplates.php',
      'content' => '$seoTemplates = $modx->getService(\'seotemplates\',\'seoTemplates\',$modx->getOption(\'seotemplates_core_path\',null,$modx->getOption(\'core_path\').\'components/seotemplates/\').\'model/seotemplates/\', array());
if (!($seoTemplates instanceof seoTemplates)) return \'\';

//$pdotools = $modx->getService(\'pdoTools\');

if ($modx->event->name == \'OnLoadWebDocument\') {

  if (!$template = $modx->getObject(\'modTemplate\', $modx->resource->template)) {return \'\';};
  $template = $template->get(\'templatename\');
  $templates = array();

  $c = $modx->newQuery(\'seoTemplatesItem\');
  $c->sortby(\'id\', \'ASC\');
  $c->select(array(\'id\', \'template\', \'field\', \'value\', \'active\'));
  $c->where(array(\'active:=\' => 1));

  if ($c->prepare() && $c->stmt->execute()) {
    $items = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  if (empty($items)) return \'\';

  foreach($items as $item) {
    $tpls = json_decode($item[\'template\'], true);

    if (in_array($template, $tpls)) {
        $templates[] = $item;
    }
  }

  if (empty($templates)) return \'\';

  $placeholders = array();
  $fields = array();

  $tmp = $modx->getCollection(\'seoTemplatesField\');

  if ($tmp) {

      foreach ($tmp as $field) {
        $fields[$field->get(\'id\')] = $field->get(\'name\');
      }

      foreach($templates as $item) {
        $field = $item[\'field\'];

        if (isset($fields[$field])) {
          $placeholders[$fields[$field]] = $item[\'value\'];
        }
      }

      foreach ($placeholders as $k => $v) {
        $chunk = $modx->newObject(\'modChunk\', array(\'name\' => \'seoTemplatesTmp_\'.$k));
        $chunk->setCacheable(false);
        $placeholders[$k] = $chunk->process(array($k => $v), $v);
        //$placeholders[$k] = $pdotools->getChunk(\'@INLINE \'.$v, array($k => $v));
      }

      $prefix = $modx->getOption(\'seotemplates_placeholder_prefix\', null, \'st_\');

      $modx->setPlaceholders($placeholders, $prefix);

  }

}',
    ),
  ),
  'ecf093a33e3719f4bc0f1f0f7a6256f0' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 30,
      'event' => 'OnLoadWebDocument',
    ),
    'object' => 
    array (
      'pluginid' => 30,
      'event' => 'OnLoadWebDocument',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
);