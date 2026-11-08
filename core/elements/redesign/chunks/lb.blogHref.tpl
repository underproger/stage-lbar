{* Ссылка карточки статьи (lb-blog): значение TV link-st-N → URL опубликованной статьи текущего контекста или пусто.
   В TV можно указать id ресурса или путь (/alias, /ru/alias, полный URL). Удалённые и снятые с публикации — без ссылки. *}
{set $v = $v | trim}
{set $id = 0}
{if $v | ematch : '/^\d+$/'}
{set $id = $v}
{elseif $v}
{set $uri = $v | ereplace : '~^(https?://[^/]+)?/+~' : '' | ereplace : '~[?#].*$~' : '' | ereplace : '~^ru/~' : ''}
{set $id = $_modx->findResource($uri)}
{/if}
{if $id && $_modx->getResource($id, ['select' => 'id'])}{$_modx->makeUrl($id)}{/if}
