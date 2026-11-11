-- lbar.ro — чистка локальной базы (без смены адресов) (шаг 65).
-- 
-- Сгенерировано _dev/tools/prod_sql.py. Повторный запуск безопасен. Всё — по именам (id на стейдже и проде не важны).
SET NAMES utf8mb4;

-- 2. Тестовая страница «Тест» (/test, не опубликована, шаблон «Тестовый шаблон») — удалить
CREATE TEMPORARY TABLE IF NOT EXISTS lb_purge (id INT UNSIGNED PRIMARY KEY);
DELETE FROM lb_purge;
INSERT IGNORE INTO lb_purge (id)
  SELECT c.id FROM Impulse_Digital_X_site_content c JOIN Impulse_Digital_X_site_templates t ON t.id = c.template
  WHERE t.templatename = 'Тестовый шаблон' AND c.published = 0 AND c.alias = 'test';

-- 3. Корзина: ресурсы, удалённые в менеджере (deleted = 1), — насовсем. Кроме тех, на которые ссылаются связи языков (Babel)
--    живых страниц (RU-курс «Курсы перманентного макияжа в Бухаресте» — у RO-курса в связях ru:…; его можно восстановить из корзины).
INSERT IGNORE INTO lb_purge (id)
  SELECT c.id FROM Impulse_Digital_X_site_content c
  WHERE c.deleted = 1 AND NOT EXISTS (
    SELECT 1 FROM Impulse_Digital_X_site_tmplvar_contentvalues v
      JOIN Impulse_Digital_X_site_tmplvars tv ON tv.id = v.tmplvarid AND tv.name = 'babelLanguageLinks'
      JOIN Impulse_Digital_X_site_content l ON l.id = v.contentid AND l.deleted = 0
    WHERE CONCAT(v.value, ';') LIKE CONCAT('%:', c.id, ';%'));

DELETE v FROM Impulse_Digital_X_site_tmplvar_contentvalues v JOIN lb_purge p ON p.id = v.contentid;
DELETE g FROM Impulse_Digital_X_document_groups g JOIN lb_purge p ON p.id = g.document;
DELETE f FROM Impulse_Digital_X_ms2_resource_files f JOIN lb_purge p ON p.id = f.resource_id;
DELETE w FROM Impulse_Digital_X_mse2_words w JOIN lb_purge p ON p.id = w.resource;
DELETE i FROM Impulse_Digital_X_mse2_intro i JOIN lb_purge p ON p.id = i.resource;
DELETE k FROM Impulse_Digital_X_seopro_keywords k JOIN lb_purge p ON p.id = k.resource;
DELETE s FROM Impulse_Digital_X_collection_selections s JOIN lb_purge p ON p.id = s.resource;
DELETE r FROM Impulse_Digital_X_context_resource r JOIN lb_purge p ON p.id = r.resource;
DELETE c FROM Impulse_Digital_X_site_content c JOIN lb_purge p ON p.id = c.id;
DROP TEMPORARY TABLE lb_purge;

-- 4. Шаблоны без страниц: «Блог - Результаты поиска» (старый поиск по блогу), «Тестовый шаблон», «Удаление тату»
--    (новый дизайн удаления тату, шаги 54–59; страница возвращена на «Категория NEW» в шаге 60). Удаляются, только если страниц на них нет.
CREATE TEMPORARY TABLE IF NOT EXISTS lb_tpl (id INT UNSIGNED PRIMARY KEY);
DELETE FROM lb_tpl;
INSERT IGNORE INTO lb_tpl (id)
  SELECT t.id FROM Impulse_Digital_X_site_templates t
  WHERE t.templatename IN ('Блог - Результаты поиска', 'Удаление тату', 'Тестовый шаблон') AND NOT EXISTS (SELECT 1 FROM Impulse_Digital_X_site_content c WHERE c.template = t.id);
DELETE x FROM Impulse_Digital_X_site_tmplvar_templates x JOIN lb_tpl d ON d.id = x.templateid;
DELETE x FROM Impulse_Digital_X_media_sources_elements x JOIN lb_tpl d ON d.id = x.object WHERE x.object_class = 'modTemplate';
DELETE x FROM Impulse_Digital_X_element_property_sets x JOIN lb_tpl d ON d.id = x.element WHERE x.element_class = 'modTemplate';
DELETE t FROM Impulse_Digital_X_site_templates t JOIN lb_tpl d ON d.id = t.id;
DROP TEMPORARY TABLE lb_tpl;

-- 5. Чанки, которые сайт не выводит (91 шт.): старые блоки до редизайна (шапка, подвал, баннеры, блоки услуг / блога /
--    обучения), формы без вызова, примеры пакетов (Example-*), поиск по блогу, чанки нового дизайна удаления тату (lb-tz*, кроме lb-tzexamples).
--    Чанки пакетов (AjaxForm, FormIt, easyComm, ms2Gallery, mSearch2, miniShop2 …) не трогаются.
CREATE TEMPORARY TABLE IF NOT EXISTS lb_chunk (id INT UNSIGNED PRIMARY KEY);
DELETE FROM lb_chunk;
INSERT IGNORE INTO lb_chunk (id) SELECT id FROM Impulse_Digital_X_site_htmlsnippets WHERE BINARY name IN (
  'Example-Migx',
  'Example-Tabs',
  'Example-modal-form',
  'Example-pdoResources',
  'Example-simple-form',
  'album',
  'banner-interial',
  'banner-interial-category',
  'banner-interial-category-with-img',
  'banner-interial-contact',
  'banner-interial-portfolio',
  'banner-interial-price',
  'banner-interial-service',
  'banner-main',
  'banner-main-copy',
  'bl-blog',
  'bl-contact-new',
  'bl-contact-page',
  'bl-program',
  'bl-seo',
  'bl1-about-us',
  'bl1-subcat',
  'bl14-study-form',
  'bl2-category',
  'bl2-category-inerial',
  'bl2-category-inerial-2',
  'bl2-category-study',
  'bl3-text',
  'bl4-form',
  'bl5 - copy seo star',
  'bl6-portfolio',
  'bl6-portfolio-front-page',
  'bl6-portfolio-interial',
  'bl6-study-free-master-class',
  'bl7-price',
  'blog-nav',
  'blog-nav-sidebar',
  'blog-new-page',
  'blog-popular-page',
  'content',
  'content-blog',
  'content-blog-list',
  'content-gallery',
  'content-search-result',
  'footer',
  'footer-blog',
  'footer-study',
  'header',
  'header-old',
  'lb-tzequip',
  'lb-tzprice',
  'lb-tzteam',
  'migx_program_tpl',
  'schemaProduct',
  'seo-text',
  'soc-share',
  'table-res-bl7_2_tpl',
  'table-res-bl7_3_tpl',
  'text-style-1',
  'text-style-2',
  'tpl.Example.Form',
  'tpl.Example.Form.Label.Checkbox',
  'tpl.Filter2.checkbox',
  'tpl.Filter2.filter.Outer',
  'tpl.Form.Banner',
  'tpl.Form.Bl4',
  'tpl.Form.Main',
  'tpl.Form.Study.BL14',
  'tpl.Form.Study.Modal.BL6',
  'tpl.Search.Result',
  'tpl.Search.Result.Filter',
  'tpl.Search.auto',
  'tpl.SearchForm.Custom',
  'tpl.blog.new.page',
  'tpl.blog.poular.page',
  'tpl.category.main',
  'tpl.category.study',
  'tpl.ecForm.Blog',
  'tpl.ecMessages.Row.Micro',
  'tpl.ecThreadRating.Footer',
  'tpl.email.example',
  'tpl.moreWrap-category.main',
  'tpl.moreWrap-category.study',
  'tpl.moreWrap-new',
  'tpl.moreWrap-poular',
  'tpl.ms2Gallery.Blog',
  'tpl.next ',
  'tpl.prev',
  'tpl.subcat.blog',
  'tpl.top.category',
  'Разное');
DELETE x FROM Impulse_Digital_X_media_sources_elements x JOIN lb_chunk d ON d.id = x.object WHERE x.object_class = 'modChunk';
DELETE x FROM Impulse_Digital_X_element_property_sets x JOIN lb_chunk d ON d.id = x.element WHERE x.element_class = 'modChunk';
DELETE h FROM Impulse_Digital_X_site_htmlsnippets h JOIN lb_chunk d ON d.id = h.id;
DROP TEMPORARY TABLE lb_chunk;

-- 6. Блок «Преимущества» удаления тату (TV bl2_service_advantages-title / -list) — к шаблону «Категория NEW», чтобы править в менеджере
--    (выводился и раньше, но в админке полей не было: TV ни к одному шаблону не привязаны — так было и в исходной базе)
INSERT IGNORE INTO Impulse_Digital_X_site_tmplvar_templates (tmplvarid, templateid, rank)
  SELECT tv.id, t.id, 0 FROM Impulse_Digital_X_site_tmplvars tv JOIN Impulse_Digital_X_site_templates t ON t.templatename = 'Категория NEW'
  WHERE tv.name IN ('bl2_service_advantages-title', 'bl2_service_advantages-list');

-- 7. Служебные таблицы: статистика посещений siteStatistics (~670 МБ, плагин продолжит писать заново), сессии (все выйдут из менеджера),
--    журнал действий менеджера
TRUNCATE TABLE Impulse_Digital_X_stat_online_users;
TRUNCATE TABLE Impulse_Digital_X_stat_page_statistics;
TRUNCATE TABLE Impulse_Digital_X_session;
TRUNCATE TABLE Impulse_Digital_X_manager_log;
