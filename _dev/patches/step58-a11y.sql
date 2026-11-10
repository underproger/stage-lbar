-- step58: доступность для PageSpeed (axe / Lighthouse) — старые чанки, которые ещё выводятся (по просьбе пользователя «исправить все
-- подобные моменты»): тексты на странице не меняются.
-- 1) Галереи в статьях блога (tpl.ms2GalleryBlog) и на странице курса (tpl.ms2GalleryStudy): у ссылок на фото не было имени (alt пустой —
--    описания фото в ms2Gallery не заполнены) → alt = описание фото, если оно есть, иначе «заголовок страницы — номер фото» (порядок фото в галерее ресурса, rank + 1: в статье несколько вызовов галереи по тегам).
-- 2) Блок контактов курса (bl-contact): у ссылки на почту aria-label="email" не совпадал с видимым адресом — убран (именем ссылки
--    остаётся сам адрес); у карты Google (iframe из настройки google-map) не было title — добавлен, как в lb-contact.
-- Откат: обратные REPLACE.
SET NAMES utf8mb4;
UPDATE Impulse_Digital_X_site_htmlsnippets
   SET snippet = REPLACE(snippet,
       'alt="{$file[\'description\']}"', 'alt="{($file[\'description\'] ?: ($_modx->resource.pagetitle ~ \' — \' ~ ($file[\'rank\'] + 1))) | escape}"')
 WHERE name IN ('tpl.ms2GalleryBlog', 'tpl.ms2GalleryStudy');
UPDATE Impulse_Digital_X_site_htmlsnippets
   SET snippet = REPLACE(REPLACE(snippet,
       '<a class="email" aria-label="email" href=', '<a class="email" href='),
       '<div class="google-container">[[++google-map]]</div>', '<div class="google-container">[[++google-map:replace=`<iframe ==<iframe title="Google Maps" `]]</div>')
 WHERE name = 'bl-contact';
