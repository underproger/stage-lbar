#!/usr/bin/env python3
# step62_tz.py — шаг 62: удаление тату (RO 625 / RU 321 / EN 1625) — блок «Цена на примерах» под таблицей цен + фото третьего аппарата у EN.
#   TV tz_price_examples-title / tz_price_examples (создаёт _dev/tools/modx_apply62.php) — в патч по имени (id на хостинге другой),
#   категория — как у TV таблицы цен (bl5_services_prices-table), шаблоны «Категория NEW» и «Удаление тату» — по имени.
#   Значения TV — текущие значения локальной базы. Чанк lb-tzexamples (статичный, Redesign) — в дампе make_patch.sh.
# Запуск: python3 _dev/tools/step62_tz.py [out.sql]  → по умолчанию _dev/patches/step62-tz-examples.sql
import sys, os, pymysql

P = 'Impulse_Digital_X_'
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(ROOT, '_dev/patches/step62-tz-examples.sql')
IDS = (625, 321, 1625)
db = pymysql.connect(unix_socket='/run/mysqld/mysqld.sock', user='root', database='lbar', charset='utf8mb4')
c = db.cursor(pymysql.cursors.DictCursor)
q = lambda v: 'NULL' if v is None else (str(v) if isinstance(v, int) else db.escape(str(v)))
TV = f'{P}site_tmplvars'
TVV = f'{P}site_tmplvar_contentvalues'

sql = ['-- step62: удаление тату — блок «Цена на примерах» (фото — цена, 6 примеров) под таблицей цен у RO 625 / RU 321 / EN 1625;',
       '-- EN 1625: фото третьего аппарата в списке оборудования — путь от корня (относительный давал 404 при base /en/).',
       '-- Сгенерировано _dev/tools/step62_tz.py. Повторный запуск безопасен.', 'SET NAMES utf8mb4;', '']

sql.append(f"SET @cat := (SELECT category FROM {TV} WHERE name = 'bl5_services_prices-table');")
for name in ('tz_price_examples-title', 'tz_price_examples'):
    c.execute(f"SELECT * FROM {TV} WHERE name = %s", (name,))
    t = c.fetchone()
    assert t, name
    cols = [k for k in t if k not in ('id', 'category')]
    sql.append(f"INSERT INTO {TV} ({', '.join('`' + k + '`' for k in cols)}, `category`) SELECT {', '.join(q(t[k]) for k in cols)}, @cat "
               f"FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM {TV} WHERE name = {q(name)});")
    sql.append(f"UPDATE {TV} SET {', '.join('`' + k + '` = ' + q(t[k]) for k in cols if k != 'name')}, `category` = @cat WHERE name = {q(name)};")
    c.execute(f"SELECT tt.rank, st.templatename FROM {P}site_tmplvar_templates tt JOIN {P}site_templates st ON st.id = tt.templateid "
              f"WHERE tt.tmplvarid = {t['id']} ORDER BY st.templatename")
    tpl = c.fetchall()
    assert sorted(x['templatename'] for x in tpl) == ['Категория NEW', 'Удаление тату'], tpl
    sql.append(f"INSERT IGNORE INTO {P}site_tmplvar_templates (tmplvarid, templateid, rank) SELECT (SELECT id FROM {TV} WHERE name = {q(name)}), id, "
               f"{tpl[0]['rank']} FROM {P}site_templates WHERE templatename IN ('Категория NEW', 'Удаление тату');")
sql.append('')

sql.append('-- значения: заголовок и примеры у 625 / 321 / 1625; список оборудования у 625 / 1625 (путь картинки третьего аппарата — от корня)')
c.execute(f"SELECT t.name, v.contentid, v.value FROM {TVV} v JOIN {TV} t ON t.id = v.tmplvarid WHERE v.contentid IN {IDS} "
          f"AND (t.name IN ('tz_price_examples-title', 'tz_price_examples') OR (t.name = 'bl3_service_equipment-list' AND v.contentid IN (625, 1625))) "
          f"ORDER BY t.name, v.contentid")
rows = c.fetchall()
assert len(rows) == 8, len(rows)
for x in rows:
    if x['name'] == 'bl3_service_equipment-list':
        assert '"images\\/' not in x['value'] and '"images/' not in x['value'], x['contentid']
    tid = f"(SELECT id FROM {TV} WHERE name = {q(x['name'])})"
    sql.append(f"DELETE FROM {TVV} WHERE tmplvarid = {tid} AND contentid = {x['contentid']};")
    sql.append(f"INSERT INTO {TVV} (tmplvarid, contentid, value) SELECT id, {x['contentid']}, {q(x['value'])} FROM {TV} WHERE name = {q(x['name'])};")
sql.append('')

A = "[[*bl5_services_prices-table]]\n       </div> \n"
B = A + "       [[*tz_price_examples:notempty=`[[$lb-tzexamples]]`]]\n"
c.execute(f"SELECT snippet FROM {P}site_htmlsnippets WHERE name = 'bl5-service-prices'")
s = c.fetchone()['snippet']
assert B in s, 'bl5-service-prices: вставка не найдена'
sql += ['-- bl5-service-prices (старый чанк блока цен, шаблоны «Категория NEW» / «Удаление тату»): под таблицей — чанк lb-tzexamples, если TV заполнен',
        f"UPDATE {P}site_htmlsnippets SET snippet = REPLACE(snippet, {q(A)}, {q(B)}) WHERE name = 'bl5-service-prices' AND snippet NOT LIKE '%lb-tzexamples%';", '']
open(OUT, 'w').write('\n'.join(sql) + '\n')
print('written', OUT, len(sql), 'lines')
