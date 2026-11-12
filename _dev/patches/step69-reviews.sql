-- Шаг 69: число отзывов в микроразметке (aggregateRating). Старый чанк script заменён на lb-script во всех шаблонах (статьи блога —
-- с &reviews=`25`); курс (шаблон «Обучение» 15, свой JSON-LD) — 90 вместо 13. Повторный запуск ничего не меняет.
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '[[$script]]', '[[$lb-script? &reviews=`25`]]') WHERE id = 5;
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '[[$script]]', '[[$lb-script]]') WHERE templatename IN ('Главная', '404 eror page', 'Внутренняя', 'Блог - список статей', 'Success-Page-RU', 'Контакты', 'Портфолио', 'Внутренняя - Галерея', 'Цены', 'Отзывы', 'Внутренняя - Обучение', 'Услуги - общая', 'О нас');
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, '"reviewCount": 13', '"reviewCount": 90') WHERE id = 15;
