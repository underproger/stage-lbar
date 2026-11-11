-- lbar.ro — проверка ПЕРЕД переносом (шаг 65). Запускать на базе ПРОДА, только чтение — ничего не меняет.
-- Стейдж сделан из копии базы прода от 05.11.2026 11:27 (UTC). Всё, что появилось на проде позже, при замене базы пропадёт.
-- Если все числа — 0, переносить спокойно. Если нет — сначала перенести это отдельно (новые отзывы / заявки / правки страниц).
SELECT 'Новые отзывы (easyComm)' AS what, COUNT(*) AS cnt
  FROM Impulse_Digital_X_ec_messages WHERE createdon > '2026-11-05 11:27:23'
UNION ALL SELECT 'Новые заявки с форм (FormIt)', COUNT(*)
  FROM Impulse_Digital_X_formit_forms WHERE `date` > 1793878043
UNION ALL SELECT 'Новые или изменённые страницы', COUNT(*)
  FROM Impulse_Digital_X_site_content WHERE editedon > 1793878043 OR createdon > 1793878043
UNION ALL SELECT 'Новые фото в галереях', COUNT(*)
  FROM Impulse_Digital_X_ms2_resource_files WHERE createdon > '2026-11-05 11:27:23'
UNION ALL SELECT 'Действия в менеджере', COUNT(*)
  FROM Impulse_Digital_X_manager_log WHERE occurred > '2026-11-05 11:27:23';
