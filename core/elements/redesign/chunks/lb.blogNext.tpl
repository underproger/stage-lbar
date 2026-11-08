{* Соседняя статья — следующая (tplPext pdoNeighbors), как старый tpl.next: ссылка, название, превью (pthumb 300×180). *}
<a class="lb-nb lb-nb--next" href="/{$uri}">
    <span class="lb-nb__img"><img src="[[pthumb? &input=`[[+tv.img-blog-prew:empty=`[[++img-blog-prew-default]]`]]` &options=`w=300&h=180&zc=1`]]" alt="" width="300" height="180" loading="lazy" decoding="async"></span>
    <span class="lb-nb__body">
        <span class="lb-nb__dir" aria-hidden="true"><svg viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></span>
        <span class="lb-nb__title">{$pagetitle}</span>
    </span>
</a>
