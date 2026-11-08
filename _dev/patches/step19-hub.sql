-- общая страница «Услуги» (RO 80, RU 302): шаблон «Услуги - общая» с доступом к тем же TV, что у «Внутренней» (3)
SET @tid := (SELECT id FROM Impulse_Digital_X_site_templates WHERE templatename='Услуги - общая');
INSERT IGNORE INTO Impulse_Digital_X_site_tmplvar_templates (tmplvarid, templateid, `rank`) SELECT tmplvarid, @tid, `rank` FROM Impulse_Digital_X_site_tmplvar_templates WHERE templateid=3;
UPDATE Impulse_Digital_X_site_content SET template=@tid WHERE id IN (80,302);
