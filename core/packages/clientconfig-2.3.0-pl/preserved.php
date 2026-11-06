<?php return array (
  '11410a611eacd975a6a46ea7c36ac158' => 
  array (
    'criteria' => 
    array (
      'name' => 'clientconfig',
    ),
    'object' => 
    array (
      'name' => 'clientconfig',
      'path' => '{core_path}components/clientconfig/',
      'assets_path' => '{assets_path}components/clientconfig/',
    ),
  ),
  '5939e3954a36d831db61e4ea9c8ed35a' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.admin_groups',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.admin_groups',
      'value' => 'Administrator',
      'xtype' => 'textfield',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  'f65a7cf2b9020fca05a821628309e42b' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.clear_cache',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.clear_cache',
      'value' => '1',
      'xtype' => 'combo-boolean',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  '75008182dc75c6ccf39bfa08bf7b4171' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.vertical_tabs',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.vertical_tabs',
      'value' => '',
      'xtype' => 'combo-boolean',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  'df7aa21d4e751a658d7e5897a56c0f5e' => 
  array (
    'criteria' => 
    array (
      'key' => 'clientconfig.google_fonts_api_key',
    ),
    'object' => 
    array (
      'key' => 'clientconfig.google_fonts_api_key',
      'value' => '',
      'xtype' => 'textfield',
      'namespace' => 'clientconfig',
      'area' => 'Default',
      'editedon' => NULL,
    ),
  ),
  'd239843861e5b1328a33a045bec37074' => 
  array (
    'criteria' => 
    array (
      'name' => 'ClientConfig_ConfigChange',
    ),
    'object' => 
    array (
      'name' => 'ClientConfig_ConfigChange',
      'service' => 6,
      'groupname' => 'clientconfig',
    ),
  ),
  '75cbd312e585f1beff2fe1022794584f' => 
  array (
    'criteria' => 
    array (
      'name' => 'ClientConfig',
    ),
    'object' => 
    array (
      'id' => 16,
      'source' => 0,
      'property_preprocess' => 0,
      'name' => 'ClientConfig',
      'description' => 'Sets system settings from the Client Config CMP.',
      'editor_type' => 0,
      'category' => 0,
      'cache_type' => 0,
      'plugincode' => '/**
 * ClientConfig
 *
 * Copyright 2011-2014 by Mark Hamstra <hello@markhamstra.com>
 *
 * ClientConfig is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ClientConfig is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ClientConfig; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package clientconfig
 *
 * @var modX $modx
 * @var int $id
 * @var string $mode
 * @var modResource $resource
 * @var modTemplate $template
 * @var modTemplateVar $tv
 * @var modChunk $chunk
 * @var modSnippet $snippet
 * @var modPlugin $plugin
*/

$eventName = $modx->event->name;

switch($eventName) {
    case \'OnMODXInit\':
        /* Grab the class */
        $path = $modx->getOption(\'clientconfig.core_path\', null, $modx->getOption(\'core_path\') . \'components/clientconfig/\');
        $path .= \'model/clientconfig/\';
        $clientConfig = $modx->getService(\'clientconfig\',\'ClientConfig\', $path);

        /* If we got the class (gotta be careful of failed migrations), grab settings and go! */
        if ($clientConfig instanceof ClientConfig) {
            $settings = $clientConfig->getSettings();

            /* Make settings available as [[++tags]] */
            $modx->setPlaceholders($settings, \'+\');

            /* Make settings available for $modx->getOption() */
            foreach ($settings as $key => $value) {
                $modx->setOption($key, $value);
            }
        }
        break;
}

return;',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => '',
      'content' => '/**
 * ClientConfig
 *
 * Copyright 2011-2014 by Mark Hamstra <hello@markhamstra.com>
 *
 * ClientConfig is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ClientConfig is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ClientConfig; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package clientconfig
 *
 * @var modX $modx
 * @var int $id
 * @var string $mode
 * @var modResource $resource
 * @var modTemplate $template
 * @var modTemplateVar $tv
 * @var modChunk $chunk
 * @var modSnippet $snippet
 * @var modPlugin $plugin
*/

$eventName = $modx->event->name;

switch($eventName) {
    case \'OnMODXInit\':
        /* Grab the class */
        $path = $modx->getOption(\'clientconfig.core_path\', null, $modx->getOption(\'core_path\') . \'components/clientconfig/\');
        $path .= \'model/clientconfig/\';
        $clientConfig = $modx->getService(\'clientconfig\',\'ClientConfig\', $path);

        /* If we got the class (gotta be careful of failed migrations), grab settings and go! */
        if ($clientConfig instanceof ClientConfig) {
            $settings = $clientConfig->getSettings();

            /* Make settings available as [[++tags]] */
            $modx->setPlaceholders($settings, \'+\');

            /* Make settings available for $modx->getOption() */
            foreach ($settings as $key => $value) {
                $modx->setOption($key, $value);
            }
        }
        break;
}

return;',
    ),
  ),
  '57abad8bda1d78d9257fdc473cad4eaa' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 16,
      'event' => 'OnMODXInit',
    ),
    'object' => 
    array (
      'pluginid' => 16,
      'event' => 'OnMODXInit',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  'f712b10400831dcc16886536c2df174a' => 
  array (
    'criteria' => 
    array (
      'text' => 'clientconfig',
    ),
    'object' => 
    array (
      'text' => 'clientconfig',
      'parent' => 'components',
      'action' => '7',
      'description' => 'clientconfig.desc',
      'icon' => 'images/icons/plugin.gif',
      'menuindex' => 0,
      'params' => '',
      'handler' => '',
      'permissions' => '',
      'namespace' => 'core',
    ),
  ),
  'f2199321f6c4a51555fb447759fb8489' => 
  array (
    'criteria' => 
    array (
      'category' => 'ClientConfig',
    ),
    'object' => 
    array (
      'id' => 20,
      'parent' => 0,
      'category' => 'ClientConfig',
      'rank' => 0,
    ),
  ),
);