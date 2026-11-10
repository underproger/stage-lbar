-- step60: удаление тату лазером (RO 625 / RU 321) — по просьбе пользователя обратно в старый дизайн: шаблон «Категория NEW» (19),
-- на нём с шага 50 новые шапка и подвал (lb-header / lb-footer, lb-oldpage). Значения TV не менялись (тексты страниц — прежние).
-- Шаблон «Удаление тату» и чанки lb-tzequip / lb-tzteam / lb-tzprice остаются в базе (без ресурсов) — на случай возврата к новому виду.
-- Откат (снова новый дизайн): UPDATE ... SET template = (SELECT id FROM ..._site_templates WHERE templatename = 'Удаление тату') WHERE id IN (625, 321).
SET NAMES utf8mb4;
UPDATE Impulse_Digital_X_site_content SET template = 19 WHERE id IN (625, 321);
-- Доступность (PageSpeed, как в шаге 58) — старые блоки этой страницы; тексты не меняются:
-- 1) bl1-about-service: пустой H3 (TV bl1_about_service-title_2 пуст) больше не выводится — только если TV заполнен.
UPDATE Impulse_Digital_X_site_htmlsnippets
   SET snippet = REPLACE(snippet,
       '<h3 class="inner-subtitle inner-work__subtitle">\n                    [[*bl1_about_service-title_2]]\n                </h3>',
       '[[*bl1_about_service-title_2:notempty=`<h3 class="inner-subtitle inner-work__subtitle">\n                    [[*bl1_about_service-title_2]]\n                </h3>`]]')
 WHERE name = 'bl1-about-service';
-- 2) getEquipmentList (оборудование): названия H4 → H3 — после H2 шёл H4 (пропуск уровня); вид прежний (_header.scss, .lb-oldpage).
UPDATE Impulse_Digital_X_site_snippets
   SET snippet = REPLACE(REPLACE(snippet, '<h4><?=$item[\'title\'];?></h4>', '<h3><?=$item[\'title\'];?></h3>'), '<h4><?= $item[\'title\']; ?></h4>', '<h3><?= $item[\'title\']; ?></h3>')
 WHERE name = 'getEquipmentList';
-- 3) tpl.ms2GalleryBlog.New (галерея «до / после»): у ссылок на фото не было имени — alt как в шаге 58 (описание или «pagetitle — номер»).
UPDATE Impulse_Digital_X_site_htmlsnippets
   SET snippet = REPLACE(snippet,
       'alt="{$file[\'description\']}"', 'alt="{($file[\'description\'] ?: ($_modx->resource.pagetitle ~ \' — \' ~ ($file[\'rank\'] + 1))) | escape}"')
 WHERE name = 'tpl.ms2GalleryBlog.New';
