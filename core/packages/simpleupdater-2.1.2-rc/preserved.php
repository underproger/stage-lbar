<?php return array (
  'a2f22efa2876a1136f4889c704a19354' => 
  array (
    'criteria' => 
    array (
      'name' => 'simpleupdater',
    ),
    'object' => 
    array (
      'name' => 'simpleupdater',
      'path' => '{core_path}components/simpleupdater/',
      'assets_path' => '',
    ),
  ),
  'e237724da50187e80e398ef5a7cfb830' => 
  array (
    'criteria' => 
    array (
      'namespace' => 'simpleupdater',
      'controller' => 'index',
    ),
    'object' => 
    array (
      'id' => 13,
      'namespace' => 'simpleupdater',
      'controller' => 'index',
      'haslayout' => 1,
      'lang_topics' => 'simpleupdater:default',
      'assets' => '',
      'help_url' => '',
    ),
  ),
  'b53f553ff6d56e292e07aeda3040caf7' => 
  array (
    'criteria' => 
    array (
      'text' => 'simpleupdater',
    ),
    'object' => 
    array (
      'text' => 'simpleupdater',
      'parent' => 'components',
      'action' => '13',
      'description' => 'simpleupdater_menu_desc',
      'icon' => 'images/icons/plugin.gif',
      'menuindex' => 0,
      'params' => '',
      'handler' => '',
      'permissions' => '',
      'namespace' => 'core',
    ),
  ),
  '549ee891916fbcd523ed524138bd6540' => 
  array (
    'criteria' => 
    array (
      'category' => 'simpleUpdater',
    ),
    'object' => 
    array (
      'id' => 39,
      'parent' => 0,
      'category' => 'simpleUpdater',
      'rank' => 0,
    ),
  ),
  '4e225878a76ff57d3e999dda1aae1884' => 
  array (
    'criteria' => 
    array (
      'name' => 'simpleUpdater',
    ),
    'object' => 
    array (
      'id' => 25,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'simpleUpdater',
      'description' => '',
      'editor_type' => 0,
      'category' => 39,
      'cache_type' => 0,
      'plugincode' => 'switch ($modx->event->name) {
    case \'OnManagerPageBeforeRender\':
        $modx->controller->addLexiconTopic(\'simpleupdater:default\');
        $modx->controller->addCss($modx->getOption(\'assets_url\').\'components/simpleupdater/css/mgr/main.css\');
        $modx->controller->addJavascript($modx->getOption(\'assets_url\').\'components/simpleupdater/js/mgr/widgets/update.button.js\');
        $response = $modx->runProcessor(\'mgr/version/check\', array(), array(\'processors_path\' => $modx->getOption(\'core_path\') . \'components/simpleupdater/processors/\'));
        $resObj = $response->getObject();
        $_html = "<script>	var simpleUpdateConfig = " . $modx->toJSON($resObj) . ";</script>";
        $modx->controller->addHtml($_html);
        break;
}',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => 'core/components/simpleupdater/elements/plugins/plugin.simpleupdater.php',
      'content' => 'switch ($modx->event->name) {
    case \'OnManagerPageBeforeRender\':
        $modx->controller->addLexiconTopic(\'simpleupdater:default\');
        $modx->controller->addCss($modx->getOption(\'assets_url\').\'components/simpleupdater/css/mgr/main.css\');
        $modx->controller->addJavascript($modx->getOption(\'assets_url\').\'components/simpleupdater/js/mgr/widgets/update.button.js\');
        $response = $modx->runProcessor(\'mgr/version/check\', array(), array(\'processors_path\' => $modx->getOption(\'core_path\') . \'components/simpleupdater/processors/\'));
        $resObj = $response->getObject();
        $_html = "<script>	var simpleUpdateConfig = " . $modx->toJSON($resObj) . ";</script>";
        $modx->controller->addHtml($_html);
        break;
}',
    ),
  ),
  'ab43901a0ab6d0d1cab1664284c1cf00' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 25,
      'event' => 'OnManagerPageBeforeRender',
    ),
    'object' => 
    array (
      'pluginid' => 25,
      'event' => 'OnManagerPageBeforeRender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
);