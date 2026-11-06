<?php

class gsResource
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;
        $this->modx->lexicon->load('googlesheets:default');
           
    }
    
    // Получаем кол-во ресурсов
    public function getTotal($range)
    {
        $query = $this->modx->newQuery('modResource');
        $query->where(array(
            'content_type' => 1,
            'published' => 1,
            'deleted' => 0,
            'class_key' => 'modDocument'
        ));
        
        // Event: gsOnBeforeGetResource
        $this->modx->invokeEvent('gsOnBeforeGetResource', array(
            'query' => $query,
            'range' => $range,
        ));
        
        return $this->modx->getCount('modResource', $query);
    }
    
    // Получаем ресурсы
    public function getResources($range, $limit = 5000, $offset = 0)
    {
        $query = $this->modx->newQuery('modResource');
        $where = array(
            'content_type' => 1,
            'published' => 1,
            'deleted' => 0,
            'class_key' => 'modDocument'
        );
        $query->where($where);
        $query->limit($limit, $offset);
        
        // Event: gsOnBeforeGetResource
        $this->modx->invokeEvent('gsOnBeforeGetResource', array(
            'query' => $query,
            'range' => $range,
        ));
        
        $query->select($this->modx->getSelectColumns('modResource', 'modResource','','', false));
        $query->prepare();
        $query->stmt->execute();
        $resources = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Event: gsOnGetResource
        $this->modx->invokeEvent('gsOnGetResource', array(
            'resources' => &$resources,
            'range' => $range,
        ));
        
        return $resources;
    }
    
    // Добавляем tv к ресурсу
    public function joinTemplateVar($range, $resources, $fields)
    {
        $tvs = array_filter($fields, function($v){
            if(preg_match('/^tv(\d+)/i', $v)) {
                return $v;
            }
        });
        
        foreach($tvs as $tv) {
            foreach($resources as $idx => $res) {
                $resources[$idx][$tv] = $this->getTVValue($res['id'], str_replace('tv', '', $tv));
            }
        }
        
        return $resources;
    }
    
    
    // Получаем значение TV
    public function getTVValue($resourceID, $tvID)
    {
        if(!is_int($tvID)) {
            if($tv = $this->modx->getObject('modTemplateVar', array('name' => $tvID))) {
                $tvID = $tv->get('id');
            }
        }

        $where = array('tmplvarid' => $tvID, 'contentid' => $resourceID);
        $query = $this->modx->newQuery('modTemplateVarResource');
        $query->where($where);
        $query->select($this->modx->getSelectColumns('modTemplateVarResource', 'modTemplateVarResource', '', array('value'), false));
        $query->prepare();
        $query->stmt->execute();
        if($value = $query->stmt->fetchAll(PDO::FETCH_ASSOC)) {
            return $value[0]['value'];
        }
        return '';
    }
    
    
    // Импорт TV
    public function importTV($id, $tvID, $value)
    {
        if($tvID < 1) return false;
        $where = array(
            'tmplvarid' => $tvID,
            'contentid' => $id,
        );
        if(!$tv = $this->modx->getObject('modTemplateVarResource', $where)) {
            $tv = $this->modx->newObject('modTemplateVarResource', $where);
        }
        $tv->set('value', $value);
        if($tv->save()) {
            return true;
        }
        return false;
    }
    
    // Добавляем изображения к ресурсу ms2Gallery
    public function joinImages($range, $resources)
    {
        
        $corePath = $this->modx->getOption('ms2gallery.core_path', null, $this->modx->getOption('core_path') . 'components/ms2gallery/');
        $this->modx->addPackage('ms2gallery', $corePath . 'model/');

        foreach($resources as $idx => $res) {
            $query = $this->modx->newQuery('msResourceFile');
            $query->where(array('parent' => 0, 'resource_id' => $res['id']));
            $query->select($this->modx->getSelectColumns('msResourceFile', 'msResourceFile', '', array('url'), false));
            $query->prepare();
            $query->stmt->execute();
            $results = $query->stmt->fetchAll(PDO::FETCH_ASSOC);
            $images = array();
            foreach($results as $result) {
                $images[] = $result['url'];
            }
            $resources[$idx]['images'] = implode(',', $images);
        }
        
        return $resources;
    }
    
    // Загружаем изображения ms2Gallery
    public function ms2GalleryUpload($id, $files)
    {
        // Проверяем источник файлов у ресурса
        if($resource = $this->modx->getObject('modResource', $id)) {
            $properties = $resource->getProperties('ms2gallery');
            $properties['media_source'] = $this->modx->getOption('ms2gallery_source_default');
            $resource->setProperties($properties, 'ms2gallery');
            // $resource->set('source', $properties['media_source']);
            $resource->save();
            
            // Загружаем файлы
            foreach ($files as $file) {
                // Вызов процессора загрузки изображений
                $response = $this->modx->runProcessor('gallery/upload', array(
                        'file' => MODX_BASE_PATH . $file,
                        'id' => $id,
                    ),
                    array('processors_path' => MODX_CORE_PATH . 'components/ms2gallery/processors/mgr/')
                );
        
                // Вывод результата работы процессора
                if ($response->isError()) {
                    $this->modx->log(xPDO::LOG_LEVEL_ERROR, $file . ' - ' . $response->getMessage());
                }
            }
        }
    }
    
}    