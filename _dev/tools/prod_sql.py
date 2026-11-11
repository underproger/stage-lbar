#!/usr/bin/env python3
# prod_sql.py — шаг 65: SQL для переноса стейджа на прод (lbar.ro) и чистки базы.
#   python3 _dev/tools/prod_sql.py            → _dev/prod/lbar-prod.sql        (адреса lbar.ro + чистка) — на прод, после импорта базы стейджа
#   python3 _dev/tools/prod_sql.py --local    → _dev/prod/lbar-cleanup-local.sql (только чистка, адреса стейджа не трогает) — для локальной базы
# Списки неиспользуемых чанков / шаблонов — _dev/tools/unused_elements.py (проверено: обход всех страниц RO / RU / EN до и после чистки —
# HTML совпадает; локальная база почищена тем же файлом --local — повторная генерация даст пустые списки). Всё — по именам (id на стейдже / проде могут отличаться), повторный запуск безопасен.
import json, os, subprocess, sys

ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
LOCAL = '--local' in sys.argv
OUT = os.path.join(ROOT, '_dev/prod', 'lbar-cleanup-local.sql' if LOCAL else 'lbar-prod.sql')
P = 'Impulse_Digital_X_'
U = json.loads(subprocess.run([sys.executable, os.path.join(ROOT, '_dev/tools/unused_elements.py'), 'lbar'],
                              capture_output=True, text=True, check=True).stdout)
q = lambda s: "'" + s.replace('\\', '\\\\').replace("'", "\\'") + "'"
if not U['unused_chunks'] and '--force' not in sys.argv:
    # после чистки локальной базы (шаг 65) списки пусты — готовый файл в _dev/prod/ не затираем
    sys.exit('нечего удалять: база уже почищена — ' + OUT + ' не перезаписан (--force — перезаписать)')
chunks = ',\n  '.join(q(n) for n in U['unused_chunks'])
tpls = ', '.join(q(n) for n in U['unused_tpl'])

S = []
S.append(f"""-- lbar.ro — {'чистка локальной базы (без смены адресов)' if LOCAL else 'перенос стейджа на прод: адреса lbar.ro + чистка базы'} (шаг 65).
-- {'' if LOCAL else 'Порядок: 1) бэкап базы и файлов прода; 2) импорт дампа базы стейджа в базу прода; 3) этот файл; 4) очистить core/cache/.'}
-- Сгенерировано _dev/tools/prod_sql.py. Повторный запуск безопасен. Всё — по именам (id на стейдже и проде не важны).
SET NAMES utf8mb4;
""")
if not LOCAL:
    S.append(f"""-- 1. Адреса контекстов: стейдж → lbar.ro (RO — корень, RU — /ru/, EN — /en/)
UPDATE {P}context_setting SET value = 'https://lbar.ro/'    WHERE context_key = 'web' AND `key` = 'site_url';
UPDATE {P}context_setting SET value = 'https://lbar.ro/ru/' WHERE context_key = 'ru'  AND `key` = 'site_url';
UPDATE {P}context_setting SET value = 'https://lbar.ro/en/' WHERE context_key = 'en'  AND `key` = 'site_url';
-- если где-то задан http_host контекста — тоже на lbar.ro (в базе стейджа его нет)
UPDATE {P}context_setting SET value = 'lbar.ro' WHERE `key` = 'http_host' AND value <> 'lbar.ro';
-- phpThumb: картинки «выше корня сайта» — было разрешено только в локальной песочнице (на проде — как было, пусто)
UPDATE {P}system_settings SET value = '' WHERE `key` = 'phpthumb_allow_src_above_docroot';
""")

S.append(f"""-- 2. Тестовая страница «Тест» (/test, не опубликована, шаблон «Тестовый шаблон») — удалить
CREATE TEMPORARY TABLE IF NOT EXISTS lb_purge (id INT UNSIGNED PRIMARY KEY);
DELETE FROM lb_purge;
INSERT IGNORE INTO lb_purge (id)
  SELECT c.id FROM {P}site_content c JOIN {P}site_templates t ON t.id = c.template
  WHERE t.templatename = 'Тестовый шаблон' AND c.published = 0 AND c.alias = 'test';

-- 3. Корзина: ресурсы, удалённые в менеджере (deleted = 1), — насовсем. Кроме тех, на которые ссылаются связи языков (Babel)
--    живых страниц (RU-курс «Курсы перманентного макияжа в Бухаресте» — у RO-курса в связях ru:…; его можно восстановить из корзины).
INSERT IGNORE INTO lb_purge (id)
  SELECT c.id FROM {P}site_content c
  WHERE c.deleted = 1 AND NOT EXISTS (
    SELECT 1 FROM {P}site_tmplvar_contentvalues v
      JOIN {P}site_tmplvars tv ON tv.id = v.tmplvarid AND tv.name = 'babelLanguageLinks'
      JOIN {P}site_content l ON l.id = v.contentid AND l.deleted = 0
    WHERE CONCAT(v.value, ';') LIKE CONCAT('%:', c.id, ';%'));

DELETE v FROM {P}site_tmplvar_contentvalues v JOIN lb_purge p ON p.id = v.contentid;
DELETE g FROM {P}document_groups g JOIN lb_purge p ON p.id = g.document;
DELETE f FROM {P}ms2_resource_files f JOIN lb_purge p ON p.id = f.resource_id;
DELETE w FROM {P}mse2_words w JOIN lb_purge p ON p.id = w.resource;
DELETE i FROM {P}mse2_intro i JOIN lb_purge p ON p.id = i.resource;
DELETE k FROM {P}seopro_keywords k JOIN lb_purge p ON p.id = k.resource;
DELETE s FROM {P}collection_selections s JOIN lb_purge p ON p.id = s.resource;
DELETE r FROM {P}context_resource r JOIN lb_purge p ON p.id = r.resource;
DELETE c FROM {P}site_content c JOIN lb_purge p ON p.id = c.id;
DROP TEMPORARY TABLE lb_purge;

-- 4. Шаблоны без страниц: «Блог - Результаты поиска» (старый поиск по блогу), «Тестовый шаблон», «Удаление тату»
--    (новый дизайн удаления тату, шаги 54–59; страница возвращена на «Категория NEW» в шаге 60). Удаляются, только если страниц на них нет.
CREATE TEMPORARY TABLE IF NOT EXISTS lb_tpl (id INT UNSIGNED PRIMARY KEY);
DELETE FROM lb_tpl;
INSERT IGNORE INTO lb_tpl (id)
  SELECT t.id FROM {P}site_templates t
  WHERE t.templatename IN ({tpls}) AND NOT EXISTS (SELECT 1 FROM {P}site_content c WHERE c.template = t.id);
DELETE x FROM {P}site_tmplvar_templates x JOIN lb_tpl d ON d.id = x.templateid;
DELETE x FROM {P}media_sources_elements x JOIN lb_tpl d ON d.id = x.object WHERE x.object_class = 'modTemplate';
DELETE x FROM {P}element_property_sets x JOIN lb_tpl d ON d.id = x.element WHERE x.element_class = 'modTemplate';
DELETE t FROM {P}site_templates t JOIN lb_tpl d ON d.id = t.id;
DROP TEMPORARY TABLE lb_tpl;

-- 5. Чанки, которые сайт не выводит ({len(U['unused_chunks'])} шт.): старые блоки до редизайна (шапка, подвал, баннеры, блоки услуг / блога /
--    обучения), формы без вызова, примеры пакетов (Example-*), поиск по блогу, чанки нового дизайна удаления тату (lb-tz*, кроме lb-tzexamples).
--    Чанки пакетов (AjaxForm, FormIt, easyComm, ms2Gallery, mSearch2, miniShop2 …) не трогаются.
CREATE TEMPORARY TABLE IF NOT EXISTS lb_chunk (id INT UNSIGNED PRIMARY KEY);
DELETE FROM lb_chunk;
INSERT IGNORE INTO lb_chunk (id) SELECT id FROM {P}site_htmlsnippets WHERE BINARY name IN (
  {chunks});
DELETE x FROM {P}media_sources_elements x JOIN lb_chunk d ON d.id = x.object WHERE x.object_class = 'modChunk';
DELETE x FROM {P}element_property_sets x JOIN lb_chunk d ON d.id = x.element WHERE x.element_class = 'modChunk';
DELETE h FROM {P}site_htmlsnippets h JOIN lb_chunk d ON d.id = h.id;
DROP TEMPORARY TABLE lb_chunk;

-- 6. Блок «Преимущества» удаления тату (TV bl2_service_advantages-title / -list) — к шаблону «Категория NEW», чтобы править в менеджере
--    (выводился и раньше, но в админке полей не было: TV ни к одному шаблону не привязаны — так было и в исходной базе)
INSERT IGNORE INTO {P}site_tmplvar_templates (tmplvarid, templateid, rank)
  SELECT tv.id, t.id, 0 FROM {P}site_tmplvars tv JOIN {P}site_templates t ON t.templatename = 'Категория NEW'
  WHERE tv.name IN ('bl2_service_advantages-title', 'bl2_service_advantages-list');

-- 7. Служебные таблицы: статистика посещений siteStatistics (~670 МБ, плагин продолжит писать заново), сессии (все выйдут из менеджера),
--    журнал действий менеджера
TRUNCATE TABLE {P}stat_online_users;
TRUNCATE TABLE {P}stat_page_statistics;
TRUNCATE TABLE {P}session;
TRUNCATE TABLE {P}manager_log;
""")
if not LOCAL:
    S.append(f"""-- 8. Проверка: должно вернуть 0 строк (адресов стейджа в базе не осталось)
SELECT 'context_setting' t, context_key, `key`, value FROM {P}context_setting WHERE value LIKE '%touchit%'
UNION ALL SELECT 'system_settings', '', `key`, value FROM {P}system_settings WHERE value LIKE '%touchit%'
UNION ALL SELECT 'clientconfig', '', `key`, value FROM {P}clientconfig_setting WHERE value LIKE '%touchit%';
""")
os.makedirs(os.path.dirname(OUT), exist_ok=True)
open(OUT, 'w').write('\n'.join(S))
print('written', OUT, len(U['unused_chunks']), 'chunks', U['unused_tpl'])
