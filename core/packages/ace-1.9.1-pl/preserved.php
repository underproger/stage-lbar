<?php return array (
  '3b250c6ca9f9f32c401ef806b41936b1' => 
  array (
    'criteria' => 
    array (
      'name' => 'ace',
    ),
    'object' => 
    array (
      'name' => 'ace',
      'path' => '{core_path}components/ace/',
      'assets_path' => '',
    ),
  ),
  '9e1493f7594d19c999701fc293403659' => 
  array (
    'criteria' => 
    array (
      'name' => 'Ace',
    ),
    'object' => 
    array (
      'id' => 2,
      'source' => 0,
      'property_preprocess' => 0,
      'name' => 'Ace',
      'description' => 'Ace code editor plugin for MODx Revolution',
      'editor_type' => 0,
      'category' => 0,
      'cache_type' => 0,
      'plugincode' => '/**
 * Ace Source Editor Plugin
 *
 * Events: OnManagerPageBeforeRender, OnRichTextEditorRegister, OnSnipFormPrerender,
 * OnTempFormPrerender, OnChunkFormPrerender, OnPluginFormPrerender,
 * OnFileCreateFormPrerender, OnFileEditFormPrerender, OnDocFormPrerender
 *
 * @author Danil Kostin <danya.postfactum(at)gmail.com>
 *
 * @package ace
 *
 * @var array $scriptProperties
 * @var Ace $ace
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'Ace\');
    return;
}

if ($modx->getOption(\'which_element_editor\', null, \'Ace\') !== \'Ace\') {
    return;
}

$ace = $modx->getService(\'ace\', \'Ace\', $modx->getOption(\'ace.core_path\', null, $modx->getOption(\'core_path\').\'components/ace/\').\'model/ace/\');
$ace->initialize();

$extensionMap = array(
    \'tpl\'   => \'text/x-smarty\',
    \'htm\'   => \'text/html\',
    \'html\'  => \'text/html\',
    \'css\'   => \'text/css\',
    \'scss\'  => \'text/x-scss\',
    \'less\'  => \'text/x-less\',
    \'svg\'   => \'image/svg+xml\',
    \'xml\'   => \'application/xml\',
    \'xsl\'   => \'application/xml\',
    \'js\'    => \'application/javascript\',
    \'json\'  => \'application/json\',
    \'php\'   => \'application/x-php\',
    \'sql\'   => \'text/x-sql\',
    \'md\'    => \'text/x-markdown\',
    \'txt\'   => \'text/plain\',
    \'twig\'  => \'text/x-twig\'
);

// Defines wether we should highlight modx tags
$modxTags = false;
switch ($modx->event->name) {
    case \'OnSnipFormPrerender\':
        $field = \'modx-snippet-snippet\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnTempFormPrerender\':
        $field = \'modx-template-content\';
        $modxTags = true;

        switch (true) {
            case $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $modx->getOption(\'pdotools_fenom_parser\'):
                $mimeType = \'text/x-smarty\';
                break;
            default:
                $mimeType = \'text/html\';
                break;
        }

        break;
    case \'OnChunkFormPrerender\':
        $field = \'modx-chunk-snippet\';
        if ($modx->controller->chunk && $modx->controller->chunk->isStatic()) {
            $extension = pathinfo($modx->controller->chunk->getSourceFile(), PATHINFO_EXTENSION);
            $mimeType = isset($extensionMap[$extension]) ? $extensionMap[$extension] : \'text/plain\';
        } else {
            $mimeType = \'text/html\';
        }
        $modxTags = true;

        switch (true) {
            case $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $modx->getOption(\'pdotools_fenom_default\'):
                $mimeType = \'text/x-smarty\';
                break;
            default:
                $mimeType = \'text/html\';
                break;
        }

        break;
    case \'OnPluginFormPrerender\':
        $field = \'modx-plugin-plugincode\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnFileCreateFormPrerender\':
        $field = \'modx-file-content\';
        $mimeType = \'text/plain\';
        break;
    case \'OnFileEditFormPrerender\':
        $field = \'modx-file-content\';
        $extension = pathinfo($scriptProperties[\'file\'], PATHINFO_EXTENSION);
        $mimeType = isset($extensionMap[$extension])
            ? $extensionMap[$extension]
            : \'text/plain\';
        $modxTags = $extension == \'tpl\';
        break;
    case \'OnDocFormPrerender\':
        if (!$modx->controller->resourceArray) {
            return;
        }
        $field = \'ta\';
        $mimeType = $modx->getObject(\'modContentType\', $modx->controller->resourceArray[\'content_type\'])->get(\'mime_type\');

        switch (true) {
            case $mimeType == \'text/html\' && $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $mimeType == \'text/html\' && $modx->getOption(\'pdotools_fenom_parser\'):
                $mimeType = \'text/x-smarty\';
                break;
        }

        if ($modx->getOption(\'use_editor\')){
            $richText = $modx->controller->resourceArray[\'richtext\'];
            $classKey = $modx->controller->resourceArray[\'class_key\'];
            if ($richText || in_array($classKey, array(\'modStaticResource\',\'modSymLink\',\'modWebLink\',\'modXMLRPCResource\'))) {
                $field = false;
            }
        }
        $modxTags = true;
        break;
    default:
        return;
}

$modxTags = (int) $modxTags;
$script = \'\';
if ($field) {
    $script .= "MODx.ux.Ace.replaceComponent(\'$field\', \'$mimeType\', $modxTags);";
}

if ($modx->event->name == \'OnDocFormPrerender\' && !$modx->getOption(\'use_editor\')) {
    $script .= "MODx.ux.Ace.replaceTextAreas(Ext.query(\'.modx-richtext\'));";
}

if ($script) {
    $modx->controller->addHtml(\'<script>Ext.onReady(function() {\' . $script . \'});</script>\');
}',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => 'ace/elements/plugins/ace.plugin.php',
      'content' => '/**
 * Ace Source Editor Plugin
 *
 * Events: OnManagerPageBeforeRender, OnRichTextEditorRegister, OnSnipFormPrerender,
 * OnTempFormPrerender, OnChunkFormPrerender, OnPluginFormPrerender,
 * OnFileCreateFormPrerender, OnFileEditFormPrerender, OnDocFormPrerender
 *
 * @author Danil Kostin <danya.postfactum(at)gmail.com>
 *
 * @package ace
 *
 * @var array $scriptProperties
 * @var Ace $ace
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'Ace\');
    return;
}

if ($modx->getOption(\'which_element_editor\', null, \'Ace\') !== \'Ace\') {
    return;
}

$ace = $modx->getService(\'ace\', \'Ace\', $modx->getOption(\'ace.core_path\', null, $modx->getOption(\'core_path\').\'components/ace/\').\'model/ace/\');
$ace->initialize();

$extensionMap = array(
    \'tpl\'   => \'text/x-smarty\',
    \'htm\'   => \'text/html\',
    \'html\'  => \'text/html\',
    \'css\'   => \'text/css\',
    \'scss\'  => \'text/x-scss\',
    \'less\'  => \'text/x-less\',
    \'svg\'   => \'image/svg+xml\',
    \'xml\'   => \'application/xml\',
    \'xsl\'   => \'application/xml\',
    \'js\'    => \'application/javascript\',
    \'json\'  => \'application/json\',
    \'php\'   => \'application/x-php\',
    \'sql\'   => \'text/x-sql\',
    \'md\'    => \'text/x-markdown\',
    \'txt\'   => \'text/plain\',
    \'twig\'  => \'text/x-twig\'
);

// Defines wether we should highlight modx tags
$modxTags = false;
switch ($modx->event->name) {
    case \'OnSnipFormPrerender\':
        $field = \'modx-snippet-snippet\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnTempFormPrerender\':
        $field = \'modx-template-content\';
        $modxTags = true;

        switch (true) {
            case $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $modx->getOption(\'pdotools_fenom_parser\'):
                $mimeType = \'text/x-smarty\';
                break;
            default:
                $mimeType = \'text/html\';
                break;
        }

        break;
    case \'OnChunkFormPrerender\':
        $field = \'modx-chunk-snippet\';
        if ($modx->controller->chunk && $modx->controller->chunk->isStatic()) {
            $extension = pathinfo($modx->controller->chunk->getSourceFile(), PATHINFO_EXTENSION);
            $mimeType = isset($extensionMap[$extension]) ? $extensionMap[$extension] : \'text/plain\';
        } else {
            $mimeType = \'text/html\';
        }
        $modxTags = true;

        switch (true) {
            case $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $modx->getOption(\'pdotools_fenom_default\'):
                $mimeType = \'text/x-smarty\';
                break;
            default:
                $mimeType = \'text/html\';
                break;
        }

        break;
    case \'OnPluginFormPrerender\':
        $field = \'modx-plugin-plugincode\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnFileCreateFormPrerender\':
        $field = \'modx-file-content\';
        $mimeType = \'text/plain\';
        break;
    case \'OnFileEditFormPrerender\':
        $field = \'modx-file-content\';
        $extension = pathinfo($scriptProperties[\'file\'], PATHINFO_EXTENSION);
        $mimeType = isset($extensionMap[$extension])
            ? $extensionMap[$extension]
            : \'text/plain\';
        $modxTags = $extension == \'tpl\';
        break;
    case \'OnDocFormPrerender\':
        if (!$modx->controller->resourceArray) {
            return;
        }
        $field = \'ta\';
        $mimeType = $modx->getObject(\'modContentType\', $modx->controller->resourceArray[\'content_type\'])->get(\'mime_type\');

        switch (true) {
            case $mimeType == \'text/html\' && $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $mimeType == \'text/html\' && $modx->getOption(\'pdotools_fenom_parser\'):
                $mimeType = \'text/x-smarty\';
                break;
        }

        if ($modx->getOption(\'use_editor\')){
            $richText = $modx->controller->resourceArray[\'richtext\'];
            $classKey = $modx->controller->resourceArray[\'class_key\'];
            if ($richText || in_array($classKey, array(\'modStaticResource\',\'modSymLink\',\'modWebLink\',\'modXMLRPCResource\'))) {
                $field = false;
            }
        }
        $modxTags = true;
        break;
    default:
        return;
}

$modxTags = (int) $modxTags;
$script = \'\';
if ($field) {
    $script .= "MODx.ux.Ace.replaceComponent(\'$field\', \'$mimeType\', $modxTags);";
}

if ($modx->event->name == \'OnDocFormPrerender\' && !$modx->getOption(\'use_editor\')) {
    $script .= "MODx.ux.Ace.replaceTextAreas(Ext.query(\'.modx-richtext\'));";
}

if ($script) {
    $modx->controller->addHtml(\'<script>Ext.onReady(function() {\' . $script . \'});</script>\');
}',
    ),
  ),
  '666f606d2256e722ca529ffde3cb9b04' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnChunkFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnChunkFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '5c119b203d263b3074ddab5b700f4500' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnPluginFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnPluginFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'c7c6e36982c5bf75d12c7ee4b57cfa87' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnSnipFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnSnipFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'e0679493301bac2183f6956a9f16c49a' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnTempFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnTempFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '9e693e4b07ea23f500de3782307e2062' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnFileEditFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnFileEditFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '33114ca26942a27f22299c645754b56c' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnFileCreateFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnFileCreateFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'a92f15c9a8a54db4f55f6c856e42a766' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnDocFormPrerender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnDocFormPrerender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '6e35d397adfb373be96f5e2952d4ccdc' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnRichTextEditorRegister',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnRichTextEditorRegister',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'b2c8d7433413037aba8d6ae899934c3e' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 2,
      'event' => 'OnManagerPageBeforeRender',
    ),
    'object' => 
    array (
      'pluginid' => 2,
      'event' => 'OnManagerPageBeforeRender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'dd76a18ffe2c326bdf48a7a4dcf8aea8' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.theme',
    ),
    'object' => 
    array (
      'key' => 'ace.theme',
      'value' => 'monokai',
      'xtype' => 'textfield',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => '2017-03-13 09:47:34',
    ),
  ),
  'c8389ad03c1fd808de3041c81f3f2595' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.font_size',
    ),
    'object' => 
    array (
      'key' => 'ace.font_size',
      'value' => '17px',
      'xtype' => 'textfield',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => '2017-03-13 09:45:37',
    ),
  ),
  '73fae3182a89d5dd10097b0f55c28261' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.word_wrap',
    ),
    'object' => 
    array (
      'key' => 'ace.word_wrap',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '189c099c32ce09dd917e79ed993d8711' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.soft_tabs',
    ),
    'object' => 
    array (
      'key' => 'ace.soft_tabs',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '61f6db265a14eebe7d8bdfc1c658ced7' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.tab_size',
    ),
    'object' => 
    array (
      'key' => 'ace.tab_size',
      'value' => '4',
      'xtype' => 'textfield',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '34135d927185fdb11c69ba275c4944fe' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.fold_widgets',
    ),
    'object' => 
    array (
      'key' => 'ace.fold_widgets',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  'a5c3133a51120e96edc8601ff14b8fec' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.show_invisibles',
    ),
    'object' => 
    array (
      'key' => 'ace.show_invisibles',
      'value' => '0',
      'xtype' => 'combo-boolean',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '9f311900aabcd7ed02a45b7cb5a803dc' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.snippets',
    ),
    'object' => 
    array (
      'key' => 'ace.snippets',
      'value' => '',
      'xtype' => 'textarea',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
  '6f90a9e753657e4991b13997929705c0' => 
  array (
    'criteria' => 
    array (
      'key' => 'ace.height',
    ),
    'object' => 
    array (
      'key' => 'ace.height',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'ace',
      'area' => 'general',
      'editedon' => NULL,
    ),
  ),
);