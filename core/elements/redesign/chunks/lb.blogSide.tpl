{* Статья в боковой колонке (популярные / новые) — данные как в старых tpl.blog.poular.page / tpl.blog.new.page:
   превью TV img-blog-prew (нет — настройка img-blog-prew-default, pthumb 200×160), название — pagetitle. *}
<a class="lb-side__item" href="{$uri}">
    <span class="lb-side__img"><img src="[[pthumb? &input=`[[+tv.img-blog-prew:empty=`[[++img-blog-prew-default]]`]]` &options=`w=200&h=160&zc=1`]]" alt="" width="100" height="80" loading="lazy" decoding="async"></span>
    <span class="lb-side__name">{$pagetitle}</span>
</a>
