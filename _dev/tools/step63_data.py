#!/usr/bin/env python3
# step63_data.py — шаг 63: удаление тату (RO 625 / RU 321 / EN 1625), блок «Специалисты» (MIGX bl7_service_specialists-list):
#   без Игоря (по просьбе пользователя), новые фото Алёны и Ксении — /images/inner/spec-aliona.webp, spec-ksenia.webp
#   (файлы пользователя, 800×1000; папка images — на хостинге, в git её нет).
# Запуск: python3 _dev/tools/step63_data.py [out.sql] → по умолчанию _dev/patches/step63-data.sql (и применяет к локальной базе с --apply)
import json, sys, os, pymysql

P = 'Impulse_Digital_X_'
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
args = [a for a in sys.argv[1:] if not a.startswith('--')]
OUT = args[0] if args else os.path.join(ROOT, '_dev/patches/step63-data.sql')
IDS = (625, 321, 1625)
PHOTO = {'/images/inner/s2.png': '/images/inner/spec-aliona.webp', '/images/inner/s1.png': '/images/inner/spec-ksenia.webp'}
DROP = '/images/inner/s3.png'  # Игорь

db = pymysql.connect(unix_socket='/run/mysqld/mysqld.sock', user='root', database='lbar', charset='utf8mb4', autocommit=True)
c = db.cursor(pymysql.cursors.DictCursor)
q = lambda v: db.escape(str(v))


def php_json(items):
    return json.dumps(items, ensure_ascii=True, separators=(',', ':')).replace('/', '\\/')


sql = ['-- step63: удаление тату (625 / 321 / 1625) — «Специалисты» без Игоря, новые фото Алёны и Ксении',
       '-- (файлы images/inner/spec-aliona.webp, spec-ksenia.webp). Сгенерировано _dev/tools/step63_data.py. Повторный запуск безопасен.',
       'SET NAMES utf8mb4;', '']
for rid in IDS:
    c.execute(f"SELECT v.value FROM {P}site_tmplvar_contentvalues v JOIN {P}site_tmplvars t ON t.id = v.tmplvarid "
              f"WHERE t.name = 'bl7_service_specialists-list' AND v.contentid = {rid}")
    items = json.loads(c.fetchone()['value'])
    items = [it for it in items if it.get('image') != DROP]
    for it in items:
        it['image'] = PHOTO.get(it.get('image'), it.get('image'))
    assert len(items) == 2 and all(it['image'] in PHOTO.values() for it in items), (rid, items)
    sql.append(f"UPDATE {P}site_tmplvar_contentvalues SET value = {q(php_json(items))} WHERE contentid = {rid} "
               f"AND tmplvarid = (SELECT id FROM {P}site_tmplvars WHERE name = 'bl7_service_specialists-list');")
open(OUT, 'w').write('\n'.join(sql) + '\n')
print('written', OUT)
if '--apply' in sys.argv:
    for line in sql:
        if line.startswith('UPDATE'):
            c.execute(line)
    print('applied')
