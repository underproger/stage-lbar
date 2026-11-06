<?php
$seoTemplates = $modx->getService('seotemplates','seoTemplates',$modx->getOption('seotemplates_core_path',null,$modx->getOption('core_path').'components/seotemplates/').'model/seotemplates/', array());
if (!($seoTemplates instanceof seoTemplates)) return '';

//$pdotools = $modx->getService('pdoTools');

if ($modx->event->name == 'OnLoadWebDocument') {

  if (!$template = $modx->getObject('modTemplate', $modx->resource->template)) {return '';};
  $template = $template->get('templatename');
  $templates = array();

  $c = $modx->newQuery('seoTemplatesItem');
  $c->sortby('id', 'ASC');
  $c->select(array('id', 'template', 'field', 'value', 'active'));
  $c->where(array('active:=' => 1));

  if ($c->prepare() && $c->stmt->execute()) {
    $items = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  if (empty($items)) return '';

  foreach($items as $item) {
    $tpls = json_decode($item['template'], true);

    if (in_array($template, $tpls)) {
        $templates[] = $item;
    }
  }

  if (empty($templates)) return '';

  $placeholders = array();
  $fields = array();

  $tmp = $modx->getCollection('seoTemplatesField');

  if ($tmp) {

      foreach ($tmp as $field) {
        $fields[$field->get('id')] = $field->get('name');
      }

      foreach($templates as $item) {
        $field = $item['field'];

        if (isset($fields[$field])) {
          $placeholders[$fields[$field]] = $item['value'];
        }
      }

      foreach ($placeholders as $k => $v) {
        $chunk = $modx->newObject('modChunk', array('name' => 'seoTemplatesTmp_'.$k));
        $chunk->setCacheable(false);
        $placeholders[$k] = $chunk->process(array($k => $v), $v);
        //$placeholders[$k] = $pdotools->getChunk('@INLINE '.$v, array($k => $v));
      }

      $prefix = $modx->getOption('seotemplates_placeholder_prefix', null, 'st_');

      $modx->setPlaceholders($placeholders, $prefix);

  }

}