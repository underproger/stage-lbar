-- Шаг 51: микроразметка WebSite — лишний «]]» после JSON (из-за него JSON-LD невалиден) в старом чанке script (id 10: все страницы
-- на шаблонах с [[$script]]) и в шаблоне «Обучение» (15, свой блок). На страницах услуг (lb-script) убран в шаге 50.
-- Откат не нужен (строка «]]» выводилась как текст).
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(snippet, CONCAT('"url": "[[!++site_url]]"', CHAR(10), '      }', CHAR(10), CHAR(9), ']]', CHAR(10), '</script>'), CONCAT('"url": "[[!++site_url]]"', CHAR(10), '      }', CHAR(10), '</script>')) WHERE name = 'script';
UPDATE Impulse_Digital_X_site_templates SET content = REPLACE(content, CONCAT('"url": "[[!++site_url]]"', CHAR(10), '      }', CHAR(10), CHAR(9), ']]', CHAR(10), '</script>'), CONCAT('"url": "[[!++site_url]]"', CHAR(10), '      }', CHAR(10), '</script>')) WHERE id = 15;
