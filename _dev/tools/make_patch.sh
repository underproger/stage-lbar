#!/bin/bash
# make_patch.sh OUT.sql "Описание" — дамп всех чанков редизайна (категория Redesign) + шаблон «Главная»
OUT=$1; DESC=$2; P=Impulse_Digital_X_
OPTS="--no-create-info --skip-triggers --replace --skip-extended-insert --compact --default-character-set=utf8mb4"
CAT=$(mysql -N lbar -e "SELECT id FROM ${P}categories WHERE category='Redesign'")
{
echo "-- stage-lbar: $DESC"
echo "-- Накатывать на базу стейджа поверх предыдущих патчей. Затем очистить core/cache/."
echo "SET NAMES utf8mb4;"
echo "-- все статичные чанки редизайна (содержимое — файлы core/elements/redesign/chunks/*.tpl из git)"
mysqldump $OPTS lbar ${P}site_htmlsnippets --where="category=$CAT"
echo "-- шаблон «Главная»"
mysqldump $OPTS lbar ${P}site_templates --where="id=1"
} | sed '/enable the sandbox mode/d' > "$OUT"
grep -c "^REPLACE" "$OUT"
