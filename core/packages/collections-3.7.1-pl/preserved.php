<?php return array (
  'aa11b24fa02fb68bbbda3982247f357d' => 
  array (
    'criteria' => 
    array (
      'name' => 'collections',
    ),
    'object' => 
    array (
      'name' => 'collections',
      'path' => '{core_path}components/collections/',
      'assets_path' => '{assets_path}components/collections/',
    ),
  ),
  '13a1454bc8f6c6c11d131266d5aca930' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.mgr_date_format',
    ),
    'object' => 
    array (
      'key' => 'collections.mgr_date_format',
      'value' => 'M d',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  '89c872518338deedb5f6777a73048348' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.mgr_time_format',
    ),
    'object' => 
    array (
      'key' => 'collections.mgr_time_format',
      'value' => 'g:i a',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  '32836cca7c429094733d011b71feadfa' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.mgr_datetime_format',
    ),
    'object' => 
    array (
      'key' => 'collections.mgr_datetime_format',
      'value' => 'M d, g:i a',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  '4fb275b4a0f1fee180bc0e3689ad01a5' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.user_js',
    ),
    'object' => 
    array (
      'key' => 'collections.user_js',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  'd2b5d80f1d21c08f4b1dbca6beb7ee79' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.user_css',
    ),
    'object' => 
    array (
      'key' => 'collections.user_css',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  'b7548b1a2f97b54dc4836d5fefb925db' => 
  array (
    'criteria' => 
    array (
      'key' => 'mgr_tree_icon_collectioncontainer',
    ),
    'object' => 
    array (
      'key' => 'mgr_tree_icon_collectioncontainer',
      'value' => 'collectioncontainer',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  '7734bc64acfb1ad3794163ae8bef98be' => 
  array (
    'criteria' => 
    array (
      'key' => 'mgr_tree_icon_selectioncontainer',
    ),
    'object' => 
    array (
      'key' => 'mgr_tree_icon_selectioncontainer',
      'value' => 'selectioncontainer',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  '061238bbaeb7da9bb12b77a00b13f262' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.renderer_image_path',
    ),
    'object' => 
    array (
      'key' => 'collections.renderer_image_path',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  'c0b5a00e0142dc1381ae3011762453d3' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.tree_tbar_collection',
    ),
    'object' => 
    array (
      'key' => 'collections.tree_tbar_collection',
      'value' => '0',
      'xtype' => 'combo-boolean',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  '2a2a590f3767892d79dec8ed951f5578' => 
  array (
    'criteria' => 
    array (
      'key' => 'collections.tree_tbar_selection',
    ),
    'object' => 
    array (
      'key' => 'collections.tree_tbar_selection',
      'value' => '0',
      'xtype' => 'combo-boolean',
      'namespace' => 'collections',
      'area' => 'manager',
      'editedon' => NULL,
    ),
  ),
  'ff4d59772d55b0ac4ceb81aff19faf8a' => 
  array (
    'criteria' => 
    array (
      'category' => 'Collections',
    ),
    'object' => 
    array (
      'id' => 7,
      'parent' => 0,
      'category' => 'Collections',
      'rank' => 0,
    ),
  ),
  'b3e0070e097f055fc1a5708334295f84' => 
  array (
    'criteria' => 
    array (
      'name' => 'getSelections',
    ),
    'object' => 
    array (
      'id' => 15,
      'source' => 0,
      'property_preprocess' => 0,
      'name' => 'getSelections',
      'description' => '',
      'editor_type' => 0,
      'category' => 7,
      'cache_type' => 0,
      'snippet' => '/**
 * getSelections
 *
 * DESCRIPTION
 *
 * This snippet is a helper for getResources call.
 * It will allows you to select all linked resources under specific Selection with a usage of getResources snippet.
 * Returns distinct list of linked Resources for given Selections
 *
 * getResources are required
 *
 * PROPERTIES:
 *
 * &sortdir                 string  optional    Direction of sorting by linked resource\'s menuindex. Default: ASC
 * &selections              string  optional    Comma separated list of Selection IDs for which should be retrieved linked resources. Default: empty string
 * &getResourcesSnippet     string  optional    Name of getResources snippet. Default: getResources
 *
 * USAGE:
 *
 * [[getSelections? &selections=`1` &tpl=`rowTpl`]]
 * [[getSelections? &selections=`1` &tpl=`rowTpl` &sortby=`RAND()`]]
 *
 */

$collections = $modx->getService(\'collections\',\'Collections\',$modx->getOption(\'collections.core_path\',null,$modx->getOption(\'core_path\').\'components/collections/\').\'model/collections/\',$scriptProperties);
if (!($collections instanceof Collections)) return \'\';

$getResourcesSnippet = $modx->getOption(\'getResourcesSnippet\', $scriptProperties, \'getResources\');

$getResourcesExists = $modx->getCount(\'modSnippet\', array(\'name\' => $getResourcesSnippet));
if ($getResourcesExists == 0) return \'getResources not found\';

$sortDir = strtolower($modx->getOption(\'sortdir\', $scriptProperties, \'asc\'));
$selections = $modx->getOption(\'selections\', $scriptProperties, \'\');
$sortBy = $modx->getOption(\'sortby\', $scriptProperties, \'\');
$excludeToPlaceholder = $modx->getOption(\'excludeToPlaceholder\', $scriptProperties, \'\');

$selections = $modx->collections->explodeAndClean($selections);

if ($sortDir != \'asc\') {
    $sortDir = \'desc\';
}

$linkedResourcesQuery = $modx->newQuery(\'CollectionSelection\');

if (!empty($selections)) {
    $linkedResourcesQuery->where(array(
        \'collection:IN\' => $selections
    ));
}

if ($sortBy == \'\') {
    $linkedResourcesQuery->sortby(\'menuindex\', $sortDir);
}

$linkedResourcesQuery->select(array(
    \'resource\' => \'DISTINCT(resource)\',
    \'menuindex\' => \'menuindex\'
));

$linkedResourcesQuery->prepare();

$linkedResourcesQuery->stmt->execute();

$linkedResources = $linkedResourcesQuery->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

if (!empty($excludeToPlaceholder)) {
    $excludeResources = array();
    foreach($linkedResources as $res) {
        $excludeResources[] = \'-\' . $res;
    }
    $excludeResources = implode(\',\', $excludeResources);
    $modx->setPlaceholder($excludeToPlaceholder, $excludeResources);
}

$linkedResources = implode(\',\', $linkedResources);

$properties = $scriptProperties;
unset($properties[\'selections\']);

$properties[\'resources\'] = $linkedResources;
$properties[\'parents\'] = ($properties[\'getResourcesSnippet\'] == \'pdoResources\') ? 0 : -1;

if ($sortBy == \'\') {
    $properties[\'sortby\'] = \'FIELD(modResource.id, \' . $linkedResources . \' )\';
    $properties[\'sortdir\'] = \'asc\';
}

return $modx->runSnippet($getResourcesSnippet, $properties);',
      'locked' => 0,
      'properties' => 'a:0:{}',
      'moduleguid' => '',
      'static' => 0,
      'static_file' => '',
      'content' => '/**
 * getSelections
 *
 * DESCRIPTION
 *
 * This snippet is a helper for getResources call.
 * It will allows you to select all linked resources under specific Selection with a usage of getResources snippet.
 * Returns distinct list of linked Resources for given Selections
 *
 * getResources are required
 *
 * PROPERTIES:
 *
 * &sortdir                 string  optional    Direction of sorting by linked resource\'s menuindex. Default: ASC
 * &selections              string  optional    Comma separated list of Selection IDs for which should be retrieved linked resources. Default: empty string
 * &getResourcesSnippet     string  optional    Name of getResources snippet. Default: getResources
 *
 * USAGE:
 *
 * [[getSelections? &selections=`1` &tpl=`rowTpl`]]
 * [[getSelections? &selections=`1` &tpl=`rowTpl` &sortby=`RAND()`]]
 *
 */

$collections = $modx->getService(\'collections\',\'Collections\',$modx->getOption(\'collections.core_path\',null,$modx->getOption(\'core_path\').\'components/collections/\').\'model/collections/\',$scriptProperties);
if (!($collections instanceof Collections)) return \'\';

$getResourcesSnippet = $modx->getOption(\'getResourcesSnippet\', $scriptProperties, \'getResources\');

$getResourcesExists = $modx->getCount(\'modSnippet\', array(\'name\' => $getResourcesSnippet));
if ($getResourcesExists == 0) return \'getResources not found\';

$sortDir = strtolower($modx->getOption(\'sortdir\', $scriptProperties, \'asc\'));
$selections = $modx->getOption(\'selections\', $scriptProperties, \'\');
$sortBy = $modx->getOption(\'sortby\', $scriptProperties, \'\');
$excludeToPlaceholder = $modx->getOption(\'excludeToPlaceholder\', $scriptProperties, \'\');

$selections = $modx->collections->explodeAndClean($selections);

if ($sortDir != \'asc\') {
    $sortDir = \'desc\';
}

$linkedResourcesQuery = $modx->newQuery(\'CollectionSelection\');

if (!empty($selections)) {
    $linkedResourcesQuery->where(array(
        \'collection:IN\' => $selections
    ));
}

if ($sortBy == \'\') {
    $linkedResourcesQuery->sortby(\'menuindex\', $sortDir);
}

$linkedResourcesQuery->select(array(
    \'resource\' => \'DISTINCT(resource)\',
    \'menuindex\' => \'menuindex\'
));

$linkedResourcesQuery->prepare();

$linkedResourcesQuery->stmt->execute();

$linkedResources = $linkedResourcesQuery->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

if (!empty($excludeToPlaceholder)) {
    $excludeResources = array();
    foreach($linkedResources as $res) {
        $excludeResources[] = \'-\' . $res;
    }
    $excludeResources = implode(\',\', $excludeResources);
    $modx->setPlaceholder($excludeToPlaceholder, $excludeResources);
}

$linkedResources = implode(\',\', $linkedResources);

$properties = $scriptProperties;
unset($properties[\'selections\']);

$properties[\'resources\'] = $linkedResources;
$properties[\'parents\'] = ($properties[\'getResourcesSnippet\'] == \'pdoResources\') ? 0 : -1;

if ($sortBy == \'\') {
    $properties[\'sortby\'] = \'FIELD(modResource.id, \' . $linkedResources . \' )\';
    $properties[\'sortdir\'] = \'asc\';
}

return $modx->runSnippet($getResourcesSnippet, $properties);',
    ),
  ),
  'ccff462c18b5f45ebab463b95b25a999' => 
  array (
    'criteria' => 
    array (
      'name' => 'Collections',
    ),
    'object' => 
    array (
      'id' => 7,
      'source' => 0,
      'property_preprocess' => 0,
      'name' => 'Collections',
      'description' => '',
      'editor_type' => 0,
      'category' => 7,
      'cache_type' => 0,
      'plugincode' => '/**
 * Collections
 *
 * DESCRIPTION
 *
 * This plugin inject JS to handle proper working of close buttons in Resource\'s panel (OnDocFormPrerender)
 * This plugin handles setting proper show_in_tree parameter (OnBeforeDocFormSave, OnResourceSort)
 *
 * @var modX $modx
 * @var array $scriptProperties
 */
$corePath = $modx->getOption(\'collections.core_path\', null, $modx->getOption(\'core_path\', null, MODX_CORE_PATH) . \'components/collections/\');
/** @var Collections $collections */
$collections = $modx->getService(
    \'collections\',
    \'Collections\',
    $corePath . \'model/collections/\',
    array(
        \'core_path\' => $corePath
    )
);

if (!($collections instanceof Collections)) return \'\';

$className = "\\\\Collections\\\\Events\\\\{$modx->event->name}";
if (class_exists($className)) {
    /** @var \\Collections\\Events\\Event $handler */
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}

return;',
      'locked' => 0,
      'properties' => 'a:0:{}',
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => '',
      'content' => '/**
 * Collections
 *
 * DESCRIPTION
 *
 * This plugin inject JS to handle proper working of close buttons in Resource\'s panel (OnDocFormPrerender)
 * This plugin handles setting proper show_in_tree parameter (OnBeforeDocFormSave, OnResourceSort)
 *
 * @var modX $modx
 * @var array $scriptProperties
 */
$corePath = $modx->getOption(\'collections.core_path\', null, $modx->getOption(\'core_path\', null, MODX_CORE_PATH) . \'components/collections/\');
/** @var Collections $collections */
$collections = $modx->getService(
    \'collections\',
    \'Collections\',
    $corePath . \'model/collections/\',
    array(
        \'core_path\' => $corePath
    )
);

if (!($collections instanceof Collections)) return \'\';

$className = "\\\\Collections\\\\Events\\\\{$modx->event->name}";
if (class_exists($className)) {
    /** @var \\Collections\\Events\\Event $handler */
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}

return;',
    ),
  ),
  '55e95853c81f2ac7cd1ba50bc8a7661b' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnManagerPageInit',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnManagerPageInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '54cf5fed1c34df9919da65db413e07af' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnBeforeDocFormSave',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnBeforeDocFormSave',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '0ff741145b3d2eb79035852fc1006d09' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnResourceBeforeSort',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnResourceBeforeSort',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '976270e0b176b5cb737a59b26b3eef11' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnDocFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnDocFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '2ba7b5a306475dfae0003a16a18d734e' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnBeforeEmptyTrash',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnBeforeEmptyTrash',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '603a88f3ad4d811a48fbdf8225efc6b0' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnDocFormRender',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnDocFormRender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '352b406b421fe58f46e3909da82b0c91' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnManagerPageBeforeRender',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnManagerPageBeforeRender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'aa5b0de9093bcf0cc9094509556ddfa7' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'FredOnBeforeGetResourceTree',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'FredOnBeforeGetResourceTree',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '9cf5292ca79214e26a7a50dc29f8f757' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'FredBeforeRender',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'FredBeforeRender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '04e220064ddad620ba726453ce10f1bc' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 7,
      'event' => 'OnResourceDuplicate',
    ),
    'object' => 
    array (
      'pluginid' => 7,
      'event' => 'OnResourceDuplicate',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'b0ac5aa5ffddcf2197e0c38783a2e066' => 
  array (
    'criteria' => 
    array (
      'text' => 'collections.menu.collection_templates',
    ),
    'object' => 
    array (
      'text' => 'collections.menu.collection_templates',
      'parent' => 'components',
      'action' => 'home',
      'description' => 'collections.menu.collection_templates_desc',
      'icon' => '',
      'menuindex' => 0,
      'params' => '',
      'handler' => '',
      'permissions' => '',
      'namespace' => 'collections',
    ),
  ),
);