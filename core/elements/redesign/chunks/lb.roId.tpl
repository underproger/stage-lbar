{* id ресурса, чьи отзывы (ветка EasyComm) и фото (ms2Gallery) выводятся на странице: у EN-страницы — RO-двойник по связям Babel
   (сниппет BabelTranslation; переводы EN — без своих галерей и веток, общие с RO), у RO и RU — сам ресурс.
   Вызов: {$_modx->getChunk('lb.roId') | trim}. *}
{set $id = $_modx->resource.id}
{if $_modx->config.cultureKey == 'en'}
{set $ro = $_modx->runSnippet('BabelTranslation', ['resourceId' => $id, 'contextKey' => 'web']) | trim}
{if $ro}{set $id = $ro}{/if}
{/if}
{$id}
