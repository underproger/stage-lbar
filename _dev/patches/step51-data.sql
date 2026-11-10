-- Шаг 51: данные со страницы «О нас» (макет пользователя: с 2016 года, 10+ лет, 6 000+ процедур, 400+ учеников, ежедневно 9:00–20:00)
-- в остальных текстах сайта. Замены — по фрагментам (REPLACE), остальной текст не меняется.
-- Не менялось (не противоречит «О нас» или про другое): 2 категории мастеров (TOP-Master 5+ / TOP-Trainer 8+ — так и в FAQ «О нас»), опыт
-- Алёны / Игоря (5+), лазерная эпиляция (7 лет, 5 000+ сеансов — отдельная специализация), «Школа Lbar существует более 5 лет» (год
-- основания школы неизвестен), сроки держания пигмента, требования вакансий, статьи блога.
-- «О нас» RO (102): текст «О студии» (TV description-banner-inerial) — 10+ лет, 6 000+ процедур
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'Pe parcursul a peste 5 ani de activitate continuă', 'Pe parcursul a peste 10 ani de activitate continuă') WHERE tmplvarid = 93 AND contentid = 102;
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'au realizat peste 10 000+ proceduri de micropigmentare', 'au realizat peste 6 000 de proceduri de micropigmentare') WHERE tmplvarid = 93 AND contentid = 102;
-- «О нас» EN (1102): то же
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'Over more than 5 years of continuous work', 'Over more than 10 years of continuous work') WHERE tmplvarid = 93 AND contentid = 1102;
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'our artists have performed 10,000+ micropigmentation procedures', 'our artists have performed 6,000+ micropigmentation procedures') WHERE tmplvarid = 93 AND contentid = 1102;
-- Курс (182), баннер: опыт и число процедур тренера (TV text-1-banner-study)
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'Master Trainer cu experiență de peste 8 ani și peste 4000 de proceduri', 'Master Trainer cu experiență de peste 10 ani și peste 6 000 de proceduri') WHERE tmplvarid = 163 AND contentid = 182;
-- Курс (182), баннер: выпускники — 400+ (TV text-2-banner-study)
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'Peste 500 de masteri de succes', 'Peste 400 de masteri de succes') WHERE tmplvarid = 164 AND contentid = 182;
-- Курс (182), блок тренера (TV text-1-bl2-study)
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'Experiență de peste 4000+ proceduri', 'Experiență de peste 6 000 de proceduri') WHERE tmplvarid = 177 AND contentid = 182;
-- Удаление тату RO (625), специалисты: Ксения — 10+ лет (TV bl7_service_specialists-list)
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'dermopigmentist de top. Experien\\u021b\\u0103 de peste 5 ani.', 'dermopigmentist de top. Experien\\u021b\\u0103 de peste 10 ani.') WHERE tmplvarid = 289 AND contentid = 625;
-- Удаление тату RU (321): то же
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, '\\u043f\\u0435\\u0440\\u043c\\u0430\\u043d\\u0435\\u043d\\u0442\\u043d\\u043e\\u0433\\u043e \\u043c\\u0430\\u043a\\u0438\\u044f\\u0436\\u0430. \\u041e\\u043f\\u044b\\u0442 5+ \\u043b\\u0435\\u0442.', '\\u043f\\u0435\\u0440\\u043c\\u0430\\u043d\\u0435\\u043d\\u0442\\u043d\\u043e\\u0433\\u043e \\u043c\\u0430\\u043a\\u0438\\u044f\\u0436\\u0430. \\u041e\\u043f\\u044b\\u0442 10+ \\u043b\\u0435\\u0442.') WHERE tmplvarid = 289 AND contentid = 321;
-- Микроразметка: часы работы — ежедневно 9:00–20:00, как на сайте и в «О нас» (было пн–пт 9–20, сб 9–18, вс нет) — чанк script
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(snippet, '"dayOfWeek": [
				"Monday",
				"Tuesday",
				"Wednesday",
				"Thursday",
				"Friday"
				],
				"opens": "09:00",
				"closes": "20:00"
			},
			{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": [
				"Saturday"
				],
				"opens": "09:00",
				"closes": "18:00"
			}', '"dayOfWeek": [
				"Monday",
				"Tuesday",
				"Wednesday",
				"Thursday",
				"Friday",
				"Saturday",
				"Sunday"
				],
				"opens": "09:00",
				"closes": "20:00"
			}') WHERE name = 'script';
-- Курс (шаблон «Обучение», 15): своя микроразметка ProfessionalService была с киевским адресом, координатами и часами 10–21 —
-- адрес, координаты и описание — как в чанке script (Бухарест), часы — ежедневно 9:00–20:00
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"description": "Студия перманентного макияжа Lbar"', '"description": "Micropigmentare Bucuresti, tatuaj în salonul Lbar"') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"streetAddress": "Киев, ул. Григория Андрющенко 6Г"', '"streetAddress": "București, Sector 1, Strada Polonă 92"') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"addressLocality": "Киев"', '"addressLocality": "București"') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"addressRegion": "Киевская обл."', '"addressRegion": "Bucuresti"') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"postalCode": "01135"', '"postalCode": "010496"') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"addressCountry": "UA"', '"addressCountry": "RO"') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"latitude": 50.4535811', '"latitude": 44.4523683') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"longitude": 30.4797992', '"longitude": 26.1017169') WHERE id = 15;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"opens": "10:00",
				"closes": "21:00"', '"opens": "09:00",
				"closes": "20:00"') WHERE id = 15;
