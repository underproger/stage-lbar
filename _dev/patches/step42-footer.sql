-- step42: подвал — в меню (TV foot-link-r главной контекста) добавлены «Вакансии» (из шапки убраны в шаге 40). Повторный запуск ничего не меняет.
--   RO 1: «Posturi vacante» → posturi-vacante; RU 193: «Вакансии» → vakansii (остальные пункты RU-подвала по-прежнему без ссылок);
--   EN 1001: «Careers» → /en/careers.
SET NAMES utf8mb4;
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = CONCAT(value, '\n<p><a href="posturi-vacante">Posturi vacante</a></p>')
  WHERE contentid = 1 AND tmplvarid = (SELECT id FROM Impulse_Digital_X_site_tmplvars WHERE name = 'foot-link-r') AND value NOT LIKE '%posturi-vacante%';
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = CONCAT(value, '\n<p><a href="vakansii">Вакансии</a></p>')
  WHERE contentid = 193 AND tmplvarid = (SELECT id FROM Impulse_Digital_X_site_tmplvars WHERE name = 'foot-link-r') AND value NOT LIKE '%vakansii%';
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = CONCAT(value, '\n<p><a href="/en/careers">Careers</a></p>')
  WHERE contentid = 1001 AND tmplvarid = (SELECT id FROM Impulse_Digital_X_site_tmplvars WHERE name = 'foot-link-r') AND value NOT LIKE '%/en/careers%';
