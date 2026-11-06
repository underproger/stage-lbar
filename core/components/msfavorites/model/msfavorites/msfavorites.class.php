<?php

/**
 * The base class for msFavorites.
 */
class msFavorites
{

    /* @var modX $modx */
    public $modx;
    public $namespace;
    public $config = array();
    public $placeholders = array();
    public $initialized = array();

    public $version = '2.1.13-beta';

    /**
     * @param       $n
     * @param array $p
     */
    public function __call($n, array $p)
    {
        echo __METHOD__ . ' says: ' . $n;
    }

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;

        $corePath = $this->getOption('core_path', $config,
            $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/msfavorites/');
        $assetsPath = $this->getOption('assets_path', $config,
            $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/msfavorites/');
        $assetsUrl = $this->getOption('assets_url', $config,
            $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/msfavorites/');
        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge(array(
            'connectorUrl'   => $connectorUrl,
            'assetsBasePath' => MODX_ASSETS_PATH,
            'assetsBaseUrl'  => MODX_ASSETS_URL,
            'assetsPath'     => $assetsPath,
            'assetsUrl'      => $assetsUrl,
            'cssUrl'         => $assetsUrl . 'css/',
            'jsUrl'          => $assetsUrl . 'js/',
            'corePath'       => $corePath,
            'modelPath'      => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',
        ), $config);


        $this->modx->addPackage('msfavorites', $this->config['modelPath']);
        $this->modx->lexicon->load('msfavorites:default');
        $this->namespace = $this->getOption('namespace', $config, 'msfavorites');

        $this->checkStat();
    }

    /**
     * @param       $key
     * @param array $config
     * @param null $default
     *
     * @return mixed|null
     */
    public function getOption($key, $config = array(), $default = null, $skipEmpty = false)
    {
        $option = $default;
        if (!empty($key) AND is_string($key)) {
            if ($config != null AND array_key_exists($key, $config)) {
                $option = $config[$key];
            } else if (array_key_exists($key, $this->config)) {
                $option = $this->config[$key];
            } else if (array_key_exists("{$this->namespace}_{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}_{$key}");
            }
        }
        if ($skipEmpty AND empty($option)) {
            $option = $default;
        }

        return $option;
    }

    public function initialize($ctx = 'web', array $scriptProperties = array())
    {
        if (isset($this->initialized[$ctx])) {
            return $this->initialized[$ctx];
        }

        $this->config = array_merge($this->config, $scriptProperties, array('ctx' => $ctx));

        if (!defined('MODX_API_MODE') OR !MODX_API_MODE) {

            $pls = $this->placeholders = $this->makePlaceholders($this->config);

            $css = $this->getOption('frontCss', $scriptProperties,
                $this->modx->getOption('msfavorites_front_css', null), true);
            $this->regClientCSS($css, $this->version);

            $js = $this->getOption('frontJs', $scriptProperties, $this->modx->getOption('msfavorites_front_js', null),
                true);
            $this->regClientScript($js, $this->version);

            $action = trim($this->getOption('actionUrl', null, '[[+assetsUrl]]action.php'));
            $options = isset($this->config['options']) ? $this->config['options'] : '';
            if (!is_array($options)) {
                $options = json_decode($options, true);
            }
            foreach (array('list') as $k) {
                if (isset($this->config[$k])) {
                    $options[$k] = $this->config[$k];
                }
            }

            $config = json_encode(array(
                'actionUrl' => str_replace($pls['pl'], $pls['vl'], $action),
                'ctx'       => $this->modx->context->get('key'),
                'version'   => $this->version,
                'options'   => $options,
            ), true);

            $this->regClientStartupScript("<script type=\"text/javascript\">msFavoritesConfig={$config};</script>",
                true);
        }

        $initialize = true;
        $this->initialized[$ctx] = $initialize;

        return $initialize;
    }

    public function regClientStartupScript($src, $plaintext)
    {
        $src = trim($src);
        if (!empty($src)) {
            $this->modx->regClientStartupScript($src, $plaintext);
        }
    }

    public function regClientScript($src, $version = '')
    {
        $src = trim($src);
        if (!empty($src)) {
            if (!empty($version)) {
                $version = '?v=' . dechex(crc32($version));
            } else {
                $version = '';
            }

            // check is load
            if (empty($version)) {
                $tmp = preg_replace('/\[\[.*?\]\]/', '', $src);
                foreach ($this->modx->loadedjscripts as $script => $v) {
                    if (strpos($script, $tmp) != false) {
                        return;
                    }
                }
            }

            $pls = $this->placeholders;
            if (empty($pls)) {
                $pls = $this->placeholders = $this->makePlaceholders($this->config);
            }

            $src = str_replace($pls['pl'], $pls['vl'], $src);
            $this->modx->regClientScript($src . $version, false);
        }
    }

    public function regClientCSS($src, $version = '')
    {
        $src = trim($src);
        if (!empty($src)) {
            if (!empty($version)) {
                $version = '?v=' . dechex(crc32($version));
            } else {
                $version = '';
            }

            // check is load
            if (empty($version)) {
                $tmp = preg_replace('/\[\[.*?\]\]/', '', $src);
                foreach ($this->modx->loadedjscripts as $script => $v) {
                    if (strpos($script, $tmp) != false) {
                        return;
                    }
                }
            }

            $pls = $this->placeholders;
            if (empty($pls)) {
                $pls = $this->placeholders = $this->makePlaceholders($this->config);
            }

            $src = str_replace($pls['pl'], $pls['vl'], $src);
            $this->modx->regClientCSS($src . $version, null);
        }
    }

    /**
     * return lexicon message if possibly
     *
     * @param string $message
     *
     * @return string $message
     */
    public function lexicon($message, $placeholders = array())
    {
        $key = '';
        if ($this->modx->lexicon->exists($message)) {
            $key = $message;
        } else if ($this->modx->lexicon->exists($this->namespace . '_' . $message)) {
            $key = $this->namespace . '_' . $message;
        }
        if ($key !== '') {
            $message = $this->modx->lexicon->process($key, $placeholders);
        }

        return $message;
    }

    /**
     * @param        $array
     * @param string $delimiter
     *
     * @return array
     */
    public function explodeAndClean($array, $delimiter = ',')
    {
        $array = explode($delimiter, $array);     // Explode fields to array
        $array = array_map('trim', $array);       // Trim array's values
        $array = array_keys(array_flip($array));  // Remove duplicate fields
        $array = array_filter($array);            // Remove empty values from array

        return $array;
    }

    /**
     * @param        $array
     * @param string $delimiter
     *
     * @return array|string
     */
    public function cleanAndImplode($array, $delimiter = ',')
    {
        $array = array_map('trim', $array);       // Trim array's values
        $array = array_keys(array_flip($array));  // Remove duplicate fields
        $array = array_filter($array);            // Remove empty values from array
        $array = implode($delimiter, $array);

        return $array;
    }

    /**
     * Transform array to placeholders
     *
     * @param array $array
     * @param string $plPrefix
     * @param string $prefix
     * @param string $suffix
     * @param bool $uncacheable
     *
     * @return array
     */
    public function makePlaceholders(
        array $array = array(),
        $plPrefix = '',
        $prefix = '[[+',
        $suffix = ']]',
        $uncacheable = true
    )
    {
        $result = array('pl' => array(), 'vl' => array());

        $uncached_prefix = str_replace('[[', '[[!', $prefix);
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $result = array_merge_recursive($result,
                    $this->makePlaceholders($v, $plPrefix . $k . '.', $prefix, $suffix, $uncacheable));
            } else {
                $pl = $plPrefix . $k;
                $result['pl'][$pl] = $prefix . $pl . $suffix;
                $result['vl'][$pl] = $v;
                if ($uncacheable) {
                    $result['pl']['!' . $pl] = $uncached_prefix . $pl . $suffix;
                    $result['vl']['!' . $pl] = $v;
                }
            }
        }

        return $result;
    }

    public function runProcessor($action = '', $data = array())
    {
        if (empty($action)) {
            return false;
        }
        if ($this->modx->context->get('key') !== 'mgr') {
            $action = 'web/' . $action;
        }

        if ($error = $this->modx->getService('error', 'error.modError')) {
            $error->reset();
        }

        $processorsPath = !empty($this->config['processorsPath']) ? $this->config['processorsPath'] : MODX_CORE_PATH;
        /* @var modProcessorResponse $response */
        $response = $this->modx->runProcessor($action, $data, array('processors_path' => $processorsPath));

        return $this->prepareResponse($response);
    }

    public function prepareResponse($response)
    {
        if ($response instanceof modProcessorResponse) {
            $output = $response->getResponse();
            if ($response->isError()) {
                header('HTTP/1.1 400 Bad Request');
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            $output = $this->failure($response);
        }

        return $output;
    }

    /**
     * @param string $message
     * @param array $data
     * @param array $placeholders
     *
     * @return array|string
     */
    public function failure($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => false,
            'message' => $this->lexicon($message, $placeholders),
            'data'    => $data,
        );

        return $response;
    }

    /**
     * @param string $message
     * @param array $data
     * @param array $placeholders
     *
     * @return array|string
     */
    public function success($message = '', $data = array(), $placeholders = array())
    {
        $response = array(
            'success' => true,
            'message' => $this->lexicon($message, $placeholders),
            'data'    => $data,
        );

        return $response;
    }

    public function processContext($ctx = 'web')
    {
        if ($this->modx->context->key != $ctx AND $this->modx->getCount('modContext', array('key' => $ctx))) {
            $this->modx->switchContext($ctx);
            $this->modx->user = null;
            $this->modx->getUser($ctx);
        }
    }

    public function processResource($rid = 0)
    {
        if ($this->modx->getRequest()) {
            $this->modx->invokeEvent("OnWebPageInit");

            if ($this->modx->resource = $this->modx->request->getResource('id', $rid)) {
                $this->modx->beforeProcessing();

                $this->modx->invokeEvent("OnLoadWebDocument");
                if (!$this->modx->getResponse()) {
                    $this->modx->log(modX::LOG_LEVEL_FATAL, 'Could not load response class.');
                }

                $this->modx->resource->_output = $this->modx->resource->process();

                $this->modx->beforeRender();
            }
        }
    }

    public function processLexicon($topics = array())
    {
        $lang = $this->modx->context->getOption('cultureKey');
        foreach ($topics as $topic) {
            $this->modx->lexicon->load($lang . ':' . $topic);
        }
    }

    public function processFavorites($params = array())
    {
        $response = $this->invokeEvent('msFavoritesOnBeforeProcessFavorites', array(
            'params' => $params,
        ));
        if (!$response['success']) {
            return $response['message'];
        }
        $params = $response['data']['params'];


        $uid = $this->modx->user->id;
        if (empty($uid)) {
            $uid = session_id();
        }

        $rid = $this->modx->resource->id;
        if (empty($rid)) {
            $rid = 0;
        }

        $list = trim($this->modx->getOption('list', $params, 'default', true));
        $method = trim($this->modx->getOption('method', $params, '', true));
        $properties = $this->modx->getOption('properties', $params, array(), true);
        $options = $this->modx->getOption('options', $params, array(), true);

        $query = array(
            'uid'  => $uid,
            'rid'  => $rid,
            'list' => $list,
        );

        /** @var msFavorite $instance */
        switch ($method) {
            case 'add':
                if ($instance = $this->modx->getObject('msFavorite', $query)) {
                    $instance->set('properties', $properties);
                    $instance->save();
                }
                break;
            case 'remove':
                if ($instance = $this->modx->getObject('msFavorite', $query)) {
                    $instance->remove();
                }
                break;
            case 'clear':
                if ($instance = $this->modx->newObject('msFavorite')) {
                    $instance->clear($query);
                }
                break;
        }

        //$output = $this->getFavorites(array('uid' => $uid));
        $output = $this->getFavoritesOutput(array('uid' => $uid), false, null, $query, $options);

        $response = $this->invokeEvent('msFavoritesOnProcessFavorites', array(
            'params' => $params,
            'output' => $output,
        ));
        if (!$response['success']) {
            return $response['message'];
        }
        $output = $response['data']['output'];

        return $output;
    }


    /*public function transferFavorites($query = array())
    {
        $uid = $this->modx->getOption('uid', $query, $this->modx->user->id, true);
        $suid = $this->modx->getOption('session', $query, session_id(), true);
        $temporary = (int)$this->modx->getOption('temporary', $query, true);

        $this->modx->log(1, 'transfer_temporary');
        $this->modx->log(1, print_r($uid, 1));
        $this->modx->log(1, print_r($suid, 1));

        // transfer
        $table = $this->modx->getTableName('msFavorite');
        $sql = "UPDATE IGNORE {$table} SET `uid` = '$uid', `temporary` = '0' ";
        $sql .= " WHERE (`temporary` = '$temporary' AND `uid` = '$suid') ";
        $this->modx->exec($sql);
        // remove dublicate
        $sql = "DELETE FROM {$table} ";
        $sql .= " WHERE (`temporary` = '$temporary' AND `uid` = '$suid') ";
        $this->modx->exec($sql);
    }*/

    public function getFavoritesOutput($query = array(), $implode = false, $sort = null, $params = array(), $options = array())
    {
        $list = $user = $total = array();
        $optionsList = isset($options['list']) ? $options['list'] : array();
        $optionsUser = isset($options['user']) ? $options['user'] : array();

        // list
        foreach (array('uid', 'rid', 'list') as $k) {
            $tmp = isset($query[$k]) ? trim($query[$k]) : '';
            if (empty($tmp)) {
                unset($query[$k]);
            }
            if (empty($query[$k]) AND !empty($optionsList[$k])) {
                $query[$k] = $optionsList[$k];
            }
        }

        // add
        foreach (array('uid', 'rid', 'list') as $k) {
            if (empty($query[$k]) AND !empty($optionsList[$k])) {
                $query[$k] = $optionsList[$k];
            }
        }

        $q = $this->modx->newQuery('msFavorite');
        $q->where($query);

        $limit = !empty($optionsList['limit']) ? (int)$optionsList['limit'] : 0;
        $q->limit($limit);

        if (!is_array($sort)) {
            $sort = json_decode($sort, true);
        }
        if (is_array($sort)) {
            foreach ($sort as $column => $direction) {
                $q->query['sortby'][] = array(
                    'column'    => $column,
                    'direction' => $direction,
                );
            }
        }

        $q->select('list, rid');

        $rows = array();
        if ($q->prepare() AND $q->stmt->execute()) {
            if (!$rows = $q->stmt->fetchAll(PDO::FETCH_COLUMN | PDO::FETCH_GROUP)) {
                $rows = array();
            }
        }
        foreach ($rows as $k => $v) {
            if (empty($v[0])) {
                continue;
            }

            $list[$k] = array();
            foreach ($v as $idx => $id) {
                $list[$k][] = (int)$id;
            }
            $total[$k] = count($v);

            if ($implode) {
                $list[$k] = implode($list[$k], ',');
            }
        }


        // user
        unset($query['uid']);
        unset($query['list']);
        foreach (array('rid') as $k) {
            $tmp = trim($params[$k]);
            if (!empty($tmp)) {
                $query[$k] = $tmp;
            }
        }

        // add
        foreach (array('uid', 'rid', 'list') as $k) {
            if (empty($query[$k]) AND !empty($optionsUser[$k])) {
                $query[$k] = $optionsList[$k];
            }
        }

        $q = $this->modx->newQuery('msFavorite');
        $q->where($query);
        $limit = !empty($optionsUser['limit']) ? (int)$optionsUser['limit'] : 0;
        $q->limit($limit);

        $q->query['sortby'][] = array(
            'column'    => 'rid',
            'direction' => 'ASC',
        );

        $q->select('list, rid');
        $rows = array();
        if ($q->prepare() AND $q->stmt->execute()) {
            if (!$rows = $q->stmt->fetchAll(PDO::FETCH_COLUMN | PDO::FETCH_GROUP)) {
                $rows = array();
            }
        }

        foreach ($rows as $k => $v) {
            if (empty($v[0])) {
                continue;
            }

            $user[$k] = array();
            foreach ($v as $idx => $id) {
                if (!isset($user[$k][$id])) {
                    $user[$k][$id] = 0;
                }
                $user[$k][$id]++;
            }

            if ($implode) {
                $user[$k] = implode($user[$k], ',');
            }
        }

        return array('list' => $list, 'user' => $user, 'total' => $total);
    }

    /*
     * TODO deprecated
     */
    public function getFavorites($query = array(), $implode = false, $sort = null)
    {
        $list = $total = array();

        foreach (array('uid', 'rid', 'list') as $k) {
            $tmp = trim($query[$k]);
            if (empty($tmp)) {
                unset($query[$k]);
            }
        }

        $q = $this->modx->newQuery('msFavorite');
        $q->where($query);
        $q->limit(0);

        if (!is_array($sort)) {
            $sort = json_decode($sort, true);
        }
        if (is_array($sort)) {
            foreach ($sort as $column => $direction) {
                $q->query['sortby'][] = array(
                    'column'    => $column,
                    'direction' => $direction,
                );
            }
        }

        $q->select('list, rid');

        $rows = array();
        if ($q->prepare() AND $q->stmt->execute()) {
            if (!$rows = $q->stmt->fetchAll(PDO::FETCH_COLUMN | PDO::FETCH_GROUP)) {
                $rows = array();
            }
        }
        foreach ($rows as $k => $v) {
            if (empty($v[0])) {
                continue;
            }

            $list[$k] = array();
            foreach ($v as $idx => $id) {
                $list[$k][] = (int)$id;
            }
            $total[$k] = count($v);

            if ($implode) {
                $list[$k] = implode($list[$k], ',');
            }
        }

        return array('list' => $list, 'total' => $total);
    }


    public function setPlaceholders($subject, $prefix = 'msfavorite', $separator = '.', $restore = false)
    {
        $keys = array();
        $restored = array();
        if (is_array($subject)) {
            foreach ($subject as $key => $value) {
                $rv = $this->modx->toPlaceholder($key, $value, $prefix, $separator, $restore);
                if (isset($rv['keys'])) {
                    foreach ($rv['keys'] as $rvKey) {
                        $keys[] = $rvKey;
                    }
                }
                if ($restore === true AND isset($rv['restore'])) {
                    $restored = array_merge($restored, $rv['restore']);
                }
            }
        }
        $return = array('keys' => $keys);
        if ($restore === true) {
            $return['restore'] = $restored;
        }

        return $return;
    }

    public function invokeEvent($eventName, array $params = array(), $glue = '<br/>')
    {
        if (isset($this->modx->event->returnedValues)) {
            $this->modx->event->returnedValues = null;
        }

        $response = $this->modx->invokeEvent($eventName, $params);
        if (is_array($response) AND count($response) > 1) {
            foreach ($response as $k => $v) {
                if (empty($v)) {
                    unset($response[$k]);
                }
            }
        }

        $message = is_array($response) ? implode($glue, $response) : trim((string)$response);
        if (isset($this->modx->event->returnedValues) AND is_array($this->modx->event->returnedValues)) {
            $params = array_merge($params, $this->modx->event->returnedValues);
        }

        return array(
            'success' => empty($message),
            'message' => $message,
            'data'    => $params,
        );
    }

    protected function checkStat()
    {
        $key = strtolower(__CLASS__);
        /** @var modDbRegister $registry */
        $registry = $this->modx->getService('registry', 'registry.modRegistry')->getRegister('user', 'registry.modDbRegister');
        $registry->connect();
        $registry->subscribe('/modstore/' . md5($key));
        if ($res = $registry->read(array('poll_limit' => 1, 'remove_read' => false))) {
            return;
        }
        $c = $this->modx->newQuery('transport.modTransportProvider', array('service_url:LIKE' => '%modstore%'));
        $c->select('username,api_key');
        /** @var modRest $rest */
        $rest = $this->modx->getService('modRest', 'rest.modRest', '', array(
            'baseUrl'        => 'https://modstore.pro/extras',
            'suppressSuffix' => true,
            'timeout'        => 1,
            'connectTimeout' => 1,
        ));

        if ($rest) {
            $level = $this->modx->getLogLevel();
            $this->modx->setLogLevel(modX::LOG_LEVEL_FATAL);
            $rest->post('stat', array(
                'package'            => $key,
                'version'            => $this->version,
                'keys'               => ($c->prepare() AND $c->stmt->execute()) ? $c->stmt->fetchAll(PDO::FETCH_ASSOC) : array(),
                'uuid'               => $this->modx->uuid,
                'database'           => $this->modx->config['dbtype'],
                'revolution_version' => $this->modx->version['code_name'] . '-' . $this->modx->version['full_version'],
                'supports'           => $this->modx->version['code_name'] . '-' . $this->modx->version['full_version'],
                'http_host'          => $this->modx->getOption('http_host'),
                'php_version'        => XPDO_PHP_VERSION,
                'language'           => $this->modx->getOption('manager_language'),
            ));
            $this->modx->setLogLevel($level);
        }
        $registry->subscribe('/modstore/');
        $registry->send('/modstore/', array(md5($key) => true), array('ttl' => 3600 * 24));
    }

}