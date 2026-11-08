# Полная SEO-сверка «исходный сайт ↔ стейдж» (шаг 38)

1. Исходная база: `mysql lbar_orig < дамп_хостинга.sql` (строку sandbox вырезать), `GRANT ALL ON lbar_orig.* TO 'lbar'@'localhost'`.
2. Текущий сайт: `python3 crawl.py /home/claude/b31/new stage-lbar.touchit.vinnica.ua` (все 106 адресов из `_dev/seo-baseline/seo.json`).
3. Исходный сайт: в `core/config/config.inc.php` временно `lbar` → `lbar_orig` (dbase и dsn), очистить `core/cache/`,
   `python3 crawl.py /home/claude/b31/orig lbar.ro`, вернуть конфиг, **подождать 3 с (opcache)** и снова очистить кэш.
4. `python3 -I audit.py` → `report.json`: статусы/редиректы, title, description, keywords, robots, viewport, og, canonical,
   hreflang, lang, base, H1–H6 (все, по порядку), JSON-LD, микроразметка (itemprop/itemtype, FAQ, крошки), ссылки (пропали/новые),
   слова текста (пропали), картинки (пропали / alt изменился), число H1.
5. `python3 missing.py` → `missing.json`: картинки, которые на страницах отдают 404 (img, srcset, фоны CSS; 1920 и 390).
6. `python3 perf.py 1920 "" contact …` — вес страницы, CLS, LCP, картинки без width/height, lazy выше сгиба.
