-- step64: «Портфолио» (RO 100 / RU 198 / EN 1100) — новые фото мастеров в карточках (TV img-master-1 — Ксения, img-master-2 — Алёна;
-- источник файлов TV — папка images/design/): файлы images/design/master-ksenia.webp, master-aliona.webp (фото пользователя, 780×780).
-- Прежние значения: master-kseniya-min.jpg / master-alena-min.jpg. Повторный запуск безопасен.
SET NAMES utf8mb4;
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = 'master-ksenia.webp'
 WHERE contentid IN (100, 198, 1100) AND tmplvarid = (SELECT id FROM Impulse_Digital_X_site_tmplvars WHERE name = 'img-master-1');
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = 'master-aliona.webp'
 WHERE contentid IN (100, 198, 1100) AND tmplvarid = (SELECT id FROM Impulse_Digital_X_site_tmplvars WHERE name = 'img-master-2');
