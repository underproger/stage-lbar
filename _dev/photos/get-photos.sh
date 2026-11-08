#!/usr/bin/env bash
# Архив фото, которые использует новый дизайн главной (в git их нет). Запускать НА ХОСТИНГЕ из корня сайта (папка с index.php):
#   bash /путь/к/get-photos.sh                 — список берётся из photos.txt рядом со скриптом
#   bash /путь/к/get-photos.sh /путь/photos.txt
# Результат — lbar-photos.tar.gz в текущей папке (пути внутри архива — от корня сайта). Отсутствующие файлы перечисляются и пропускаются.
set -u
LIST="${1:-$(dirname "$0")/photos.txt}"
OUT="lbar-photos.tar.gz"
[ -f "$LIST" ] || { echo "Нет списка: $LIST"; exit 1; }
[ -f index.php ] || echo "Внимание: в текущей папке нет index.php — запускайте из корня сайта."
TMP=$(mktemp)
total=0; miss=0
while IFS= read -r f || [ -n "$f" ]; do
    f="${f%$'\r'}"                       # если файл сохранили в Windows (CRLF)
    case "$f" in ''|'#'*) continue ;; esac
    total=$((total + 1))
    if [ -f "$f" ]; then printf '%s\n' "$f" >> "$TMP"; else echo "нет файла: $f"; miss=$((miss + 1)); fi
done < "$LIST"
found=$((total - miss))
if [ "$found" -eq 0 ]; then echo "Ни одного файла не найдено — проверьте, что запускаете из корня сайта."; rm -f "$TMP"; exit 1; fi
tar -czf "$OUT" -T "$TMP"
rm -f "$TMP"
echo "Готово: $OUT — $found из $total файлов, $(du -h "$OUT" | cut -f1)"
