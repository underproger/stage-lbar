{* Вкладка раздела портфолио (tpl pdoResources в lb-pgallery): текущая страница отмечена is-current / aria-current. *}
<a class="lb-pgallery__tab{$id == $_modx->resource.id ? ' is-current' : ''}" href="{$uri}"{if $id == $_modx->resource.id} aria-current="page"{/if}>{$menutitle ?: $pagetitle}</a>
