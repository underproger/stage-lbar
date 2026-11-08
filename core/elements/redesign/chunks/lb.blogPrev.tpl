{* Соседняя статья — предыдущая (tplPrev pdoNeighbors), как старый tpl.prev: ссылка, название, превью (pthumb 300×180). *}
<a class="lb-nb lb-nb--prev" href="/{$uri}">
    <span class="lb-nb__img"><img src="[[pthumb? &input=`[[+tv.img-blog-prew:empty=`[[++img-blog-prew-default]]`]]` &options=`w=300&h=180&zc=1`]]" alt="" width="300" height="180" loading="lazy" decoding="async"></span>
    <span class="lb-nb__body">
        <span class="lb-nb__dir" aria-hidden="true"><svg viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M26 7H1.5M7.5 1.2 1.5 7l6 5.8"/></svg></span>
        <span class="lb-nb__title">{$pagetitle}</span>
    </span>
</a>
