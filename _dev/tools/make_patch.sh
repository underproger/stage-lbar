#!/bin/bash
# make_patch.sh OUT.sql "Описание" [доп.sql ...] — дамп всех чанков редизайна (категория Redesign) + шаблоны «Главная» (1),
# «Категория» (8), «Портфолио» (10), «Внутренняя - Галерея» (13), «Внутренняя - Обучение» (21) + шаблоны категории Redesign (по имени, без id: на другой базе id может быть другим)
# + дополнительные SQL-файлы шага (назначение шаблонов ресурсам и т. п.) — дописываются в конец как есть.
OUT=$1; DESC=$2; shift 2; P=Impulse_Digital_X_
OPTS="--no-create-info --skip-triggers --replace --skip-extended-insert --compact --default-character-set=utf8mb4"
CAT=$(mysql -N lbar -e "SELECT id FROM ${P}categories WHERE category='Redesign'")
{
echo "-- stage-lbar: $DESC"
echo "-- Накатывать на базу стейджа поверх предыдущих патчей. Затем очистить core/cache/."
echo "SET NAMES utf8mb4;"
echo "-- все статичные чанки редизайна (содержимое — файлы core/elements/redesign/chunks/*.tpl из git)"
mysqldump $OPTS lbar ${P}site_htmlsnippets --where="category=$CAT"
echo "-- шаблоны «Главная» (1), «Категория» (8), «Портфолио» (10), «Внутренняя - Галерея» (13), «Внутренняя - Обучение» (21)"
mysqldump $OPTS lbar ${P}site_templates --where="id IN (1,8,10,13,21)"
echo "-- шаблоны категории Redesign — по имени (создаются или обновляются)"
mysql -N --raw --default-character-set=utf8mb4 lbar -e "SELECT CONCAT('INSERT INTO ${P}site_templates (templatename, description, category, content) VALUES (', QUOTE(templatename), ', ', QUOTE(description), ', (SELECT id FROM ${P}categories WHERE category=''Redesign''), ', QUOTE(content), ') ON DUPLICATE KEY UPDATE description=VALUES(description), category=VALUES(category), content=VALUES(content);') FROM ${P}site_templates WHERE category=$CAT ORDER BY id"
for f in "$@"; do echo "-- $(basename "$f")"; cat "$f"; echo; done
} | sed '/enable the sandbox mode/d' > "$OUT"
grep -c "^REPLACE\|^INSERT" "$OUT"
