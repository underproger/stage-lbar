-- step54: страница «Удаление тату лазером» в новом дизайне.
-- Шаблон «Удаление тату» (категория Redesign) приходит выше в патче (по имени); здесь — доступ к TV (объединение шаблонов
--   «Категория NEW» (19) — тексты старых блоков страницы — и «Категория» (8) — блоки услуг: галерея, отзывы, FAQ, микроразметка)
--   и назначение ресурсам RO 625 /indepartare-tatuaj-cu-laser, RU 321 /ru/lazernoye-udaleniye-tatuazha-i-tatu.
-- Значения TV не меняются. Шаблон 19 не меняется (на нём остаются другие страницы).
-- Откат: UPDATE ... SET template = 19 WHERE id IN (625, 321).
SET NAMES utf8mb4;
SET @tid := (SELECT id FROM Impulse_Digital_X_site_templates WHERE templatename = 'Удаление тату');
INSERT IGNORE INTO Impulse_Digital_X_site_tmplvar_templates (tmplvarid, templateid, `rank`) SELECT tmplvarid, @tid, `rank` FROM Impulse_Digital_X_site_tmplvar_templates WHERE templateid = 19;
INSERT IGNORE INTO Impulse_Digital_X_site_tmplvar_templates (tmplvarid, templateid, `rank`) SELECT tmplvarid, @tid, `rank` FROM Impulse_Digital_X_site_tmplvar_templates WHERE templateid = 8;
UPDATE Impulse_Digital_X_site_content SET template = @tid WHERE id IN (625, 321);
