-- step40: меню шапки.
-- «Instruire» (RO 60, /obuchenie) → веб-ссылка на курс 182: MODX отдаёт 301 на /curs-complet-micropigmentare; скрыта из меню,
--   исключена из sitemap (TV 7 «exclude»). Содержимое ресурса было пустым (страница собиралась из дочерних), TV не трогаются.
--   В RU и EN обучения нет (RU-курсы удалены, EN не переводились) — там редиректа и пункта нет.
-- «Curs complet micropigmentare» (182) → в корень на место «Instruire», подпись в меню (menutitle) — «Curs». Адрес не меняется (без alias path).
-- «Recenzii / Отзывы / Reviews» (171 / 300 / 1171) → в корень, сразу после «Despre noi / О нас / About us» (крошки: Главная → Отзывы).
--   В RO «Blog» и «Contact» сдвинуты на одну позицию (порядок меню прежний).
-- «Главная» и «Вакансии» убраны из шапки в чанке lb-header (pdoMenu &resources), в базе не меняются (в подвале и sitemap остаются).
SET NAMES utf8mb4;
UPDATE Impulse_Digital_X_site_content SET class_key = 'modWebLink', content = '182', hidemenu = 1 WHERE id = 60 AND context_key = 'web';
DELETE FROM Impulse_Digital_X_site_tmplvar_contentvalues WHERE tmplvarid = 7 AND contentid = 60;
INSERT INTO Impulse_Digital_X_site_tmplvar_contentvalues (tmplvarid, contentid, value) VALUES (7, 60, '1');
UPDATE Impulse_Digital_X_site_content SET parent = 0, menuindex = 3, menutitle = 'Curs' WHERE id = 182 AND context_key = 'web';
UPDATE Impulse_Digital_X_site_content SET parent = 0, menuindex = 8 WHERE id IN (171, 300, 1171);
UPDATE Impulse_Digital_X_site_content SET menuindex = 9 WHERE id = 31 AND context_key = 'web';
UPDATE Impulse_Digital_X_site_content SET menuindex = 10 WHERE id = 3 AND context_key = 'web';
