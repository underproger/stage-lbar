{* Список статей блога (шаблон «Блог - список статей», id 4) — вместо статей в content-blog-list (H1 и крошки — в баннере lb-shero).
   Список — как было: pdoPage (parents = текущий, limit 60, hideContainers, setMeta, сортировка по просмотрам HitsPage), карточка lb.blogCard;
   постраничная навигация — [[!+page.nav]]; текст раздела (content) — только на первой странице, как было. *}
{set $list = $_modx->runSnippet('!pdoPage', [
    'parents' => $_modx->resource.id,
    'limit' => 60,
    'hideContainers' => 1,
    'setMeta' => 1,
    'tpl' => 'lb.blogCard',
    'includeTVs' => 'img-blog-prew,HitsPage,video-icon,gallery-icon',
    'sortby' => 'HitsPage',
    'sortdir' => 'DESC',
    'tplPageWrapper' => '@INLINE <nav class="lb-pager" aria-label="Pagination"><ul class="lb-pager__list">[[+first]][[+prev]][[+pages]][[+next]][[+last]]</ul></nav>',
    'tplPage' => '@INLINE <li class="lb-pager__item"><a class="lb-pager__link" href="[[+href]]">[[+pageNo]]</a></li>',
    'tplPageActive' => '@INLINE <li class="lb-pager__item is-active"><span class="lb-pager__link">[[+pageNo]]</span></li>',
    'tplPagePrev' => '@INLINE <li class="lb-pager__item lb-pager__item--prev"><a class="lb-pager__link" href="[[+href]]" aria-label="&larr;">&larr;</a></li>',
    'tplPageNext' => '@INLINE <li class="lb-pager__item lb-pager__item--next"><a class="lb-pager__link" href="[[+href]]" aria-label="&rarr;">&rarr;</a></li>',
    'tplPageFirst' => '',
    'tplPageLast' => '',
    'tplPagePrevEmpty' => '',
    'tplPageNextEmpty' => '',
    'tplPageSkip' => '@INLINE <li class="lb-pager__item lb-pager__item--skip"><span>…</span></li>'
])}
<section class="lb-bloglist" id="lb-bloglist">
    <div class="lb-bloglist__bg" aria-hidden="true"></div>
    <div class="lb-bloglist__inner">
        <div class="lb-bloglist__grid">
            {$list}
        </div>
        [[!+page.nav]]
        {if !$.get['page'] && ($_modx->resource.content | trim)}
        <div class="lb-bloglist__text">{$_modx->resource.content}</div>
        {/if}
    </div>
</section>
