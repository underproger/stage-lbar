-- step56: данные по ответам пользователя.
-- 1) Цена ретуши / коррекции — 400 RON (как в «Ценах» и таблицах бровей). Было 300 RON (col-4, выводится в таблице) у страниц
--    «Коррекция» RO 119 / RU 316 / EN 1119 (три строки ретуши) и «Pleoape» RO 163 / EN 1163 (строка «Retuș» / «Touch-up»;
--    у RU-двойника 318 уже 400). TV 64 table-res-bl7. Скрытая колонка col-3 (бывший TOP Master) не менялась.
-- 2) Школа существует с 2018 года: курс 182, TV 262 migx_advantages_study, пункт 3 — «există de peste 5 ani» → «există din 2018»
--    (без числа лет — не устаревает). Значение MIGX хранится с \u-экранированием («există»).
-- Откат: обратные REPLACE.
SET NAMES utf8mb4;
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, '"col-4":"300 RON"', '"col-4":"400 RON"')
 WHERE tmplvarid = 64 AND contentid IN (119, 316, 1119, 163, 1163);
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = REPLACE(value, 'exist\\u0103 de peste 5 ani.', 'exist\\u0103 din 2018.')
 WHERE tmplvarid = 262 AND contentid = 182;
