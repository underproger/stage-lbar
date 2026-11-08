#!/bin/bash
# make_patch.sh OUT.sql "Описание" — дамп всех чанков редизайна (категория Redesign) + шаблоны «Главная» (1) и «Категория» (8)
OUT=$1; DESC=$2; P=Impulse_Digital_X_
OPTS="--no-create-info --skip-triggers --replace --skip-extended-insert --compact --default-character-set=utf8mb4"
CAT=$(mysql -N lbar -e "SELECT id FROM ${P}categories WHERE category='Redesign'")
{
echo "-- stage-lbar: $DESC"
echo "-- Накатывать на базу стейджа поверх предыдущих патчей. Затем очистить core/cache/."
echo "SET NAMES utf8mb4;"
echo "-- все статичные чанки редизайна (содержимое — файлы core/elements/redesign/chunks/*.tpl из git)"
mysqldump $OPTS lbar ${P}site_htmlsnippets --where="category=$CAT"
echo "-- шаблоны «Главная» (1) и «Категория» (8, страницы услуг)"
mysqldump $OPTS lbar ${P}site_templates --where="id IN (1,8)"
} | sed '/enable the sandbox mode/d' > "$OUT"
grep -c "^REPLACE" "$OUT"
