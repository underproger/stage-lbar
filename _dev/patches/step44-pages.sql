-- step44: страницы «Extensii de gene fir cu fir», «Manichiură», «Pedichiură» убраны — 301 на главную своего языка.
-- Как и с «Instruire» (шаг 40): ресурс → веб-ссылка на главную (MODX отдаёт 301), скрыт из меню, исключён из sitemap (TV 7 «exclude»).
--   RO 626 /extensii-de-gene-fir-cu-fir, 629 /manichiura, 631 /pedichiura → 1 (/)
--   RU 630 /ru/manichiura, 632 /ru/pedichiura → 193 (/ru/)            (RU-страницы наращивания ресниц не было)
--   EN 1626 /en/classic-eyelash-extensions, 1629 /en/manicure, 1631 /en/pedicure → 1001 (/en/)
-- Карточки услуг (чанк lb-subservices) веб-ссылки не выводят. Тексты и TV страниц в базе остаются.
-- Откат: class_key = 'modDocument', content = '', hidemenu = 0 для этих id; DELETE из tmplvar_contentvalues WHERE tmplvarid = 7 AND contentid IN (…)
--   (до шага content у всех восьми был пустым, TV 7 не заполнен).
SET NAMES utf8mb4;
UPDATE Impulse_Digital_X_site_content SET class_key = 'modWebLink', content = '1', hidemenu = 1 WHERE id IN (626, 629, 631) AND context_key = 'web';
UPDATE Impulse_Digital_X_site_content SET class_key = 'modWebLink', content = '193', hidemenu = 1 WHERE id IN (630, 632) AND context_key = 'ru';
UPDATE Impulse_Digital_X_site_content SET class_key = 'modWebLink', content = '1001', hidemenu = 1 WHERE id IN (1626, 1629, 1631) AND context_key = 'en';
DELETE FROM Impulse_Digital_X_site_tmplvar_contentvalues WHERE tmplvarid = 7 AND contentid IN (626, 629, 630, 631, 632, 1626, 1629, 1631);
INSERT INTO Impulse_Digital_X_site_tmplvar_contentvalues (tmplvarid, contentid, value) VALUES
  (7, 626, '1'), (7, 629, '1'), (7, 630, '1'), (7, 631, '1'), (7, 632, '1'), (7, 1626, '1'), (7, 1629, '1'), (7, 1631, '1');
