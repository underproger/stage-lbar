-- Шаг 76: фото тренера в баннере курса (banner-study, kseniya.png 598×844) — width / height: место под фото занято сразу. На десктопе
-- фото задаёт высоту баннера; без размеров (loading="lazy" от плагина) оно догружалось и сдвигало всё ниже баннера (CLS 0,174 на десктопе).
-- Повторный запуск ничего не меняет.
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(snippet, '<img src=\"/images/design/kseniya.png\" alt=\"', '<img src=\"/images/design/kseniya.png\" width=\"598\" height=\"844\" alt=\"') WHERE name = 'banner-study' AND snippet NOT LIKE '%kseniya.png" width%';
