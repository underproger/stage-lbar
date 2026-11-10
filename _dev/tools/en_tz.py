#!/usr/bin/env python3
# en_tz.py — шаг 61: удаление тату лазером (RO 625 / RU 321, старый дизайн — шаблон 19) — английская версия 1625 /en/laser-tattoo-removal
# + блок «Преимущества» (bl2) и третье оборудование у RO / RU, + правки старых чанков под EN (как в en_build.py для шага 39).
#   Перевод — _dev/en/tr/625.json (поля, текстовые TV, MIGX); прочие TV — копия RO; TV с кириллицей, которые шаблон 19 не выводит,
#   у EN не создаются. Галерея ms2Gallery и ветка отзывов EasyComm у EN — RO-двойника (чанк lb.roId).
# Запуск (локально, база lbar): python3 _dev/tools/en_tz.py [out.sql]  → по умолчанию _dev/patches/step61-en-tz.sql
import json, re, sys, os, pymysql

P = 'Impulse_Digital_X_'
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(ROOT, '_dev/patches/step61-en-tz.sql')
RO, RU, EN, EN_PARENT, SLUG = 625, 321, 1625, 1080, 'laser-tattoo-removal'
BABEL_TV = 304
CYR = re.compile(r'[Ѐ-ӿ]')
FIELDS = ('pagetitle', 'longtitle', 'menutitle', 'description')
tr = json.load(open(os.path.join(ROOT, '_dev/en/tr/625.json')))

db = pymysql.connect(unix_socket='/run/mysqld/mysqld.sock', user='root', database='lbar', charset='utf8mb4')
c = db.cursor(pymysql.cursors.DictCursor)
q = lambda v: 'NULL' if v is None else (str(v) if isinstance(v, int) else db.escape(str(v)))


def php_json(items):
    return json.dumps(items, ensure_ascii=True, separators=(',', ':')).replace('/', '\\/')


c.execute(f"SELECT * FROM {P}site_content WHERE id = {RO}")
r = dict(c.fetchone())
assert r['template'] == 19 and r['parent'] == 80, (r['template'], r['parent'])
c.execute(f"SELECT id FROM {P}site_content WHERE id = {EN_PARENT} AND context_key = 'en'")
assert c.fetchone(), 'нет EN-хаба 1080'
c.execute(f"SELECT v.tmplvarid, t.name, t.type, v.value FROM {P}site_tmplvar_contentvalues v JOIN {P}site_tmplvars t ON t.id = v.tmplvarid "
          f"WHERE v.contentid = {RO} ORDER BY v.tmplvarid")
tvs = c.fetchall()

sql = ['-- step61: удаление тату лазером — английская версия 1625 (/en/laser-tattoo-removal, шаблон 19 «Категория NEW», старый дизайн с новыми',
       '-- шапкой и подвалом, как RO 625 / RU 321); блок «Преимущества» (с lbar.com.ua) и третье оборудование (Face Lift 3 in 1) у RO / RU / EN;',
       '-- старые чанки — под EN: окно консультации (текст по-английски), галерея и отзывы EN — RO-двойника (lb.roId).',
       '-- Сгенерировано _dev/tools/en_tz.py (перевод — _dev/en/tr/625.json). Повторный запуск безопасен (EN-строки и TV пересоздаются).',
       '-- Картинка третьего аппарата — файл /images/inner/eq-face-lift.webp (положить на хостинг).',
       'SET NAMES utf8mb4;', '']

# ---------- RO / RU: «Преимущества» (bl2) и оборудование (bl3) — текущие значения базы ----------
c.execute(f"SELECT v.tmplvarid, v.contentid, v.value FROM {P}site_tmplvar_contentvalues v JOIN {P}site_tmplvars t ON t.id = v.tmplvarid "
          f"WHERE v.contentid IN ({RO}, {RU}) AND t.name IN ('bl2_service_advantages-title', 'bl2_service_advantages-list', 'bl3_service_equipment-list') "
          f"ORDER BY v.contentid, v.tmplvarid")
rows = c.fetchall()
assert len(rows) == 6, len(rows)
sql.append('-- RO / RU: блок «Преимущества» и список оборудования (третий аппарат)')
for x in rows:
    sql.append(f"DELETE FROM {P}site_tmplvar_contentvalues WHERE tmplvarid = {x['tmplvarid']} AND contentid = {x['contentid']};")
    sql.append(f"INSERT INTO {P}site_tmplvar_contentvalues (tmplvarid, contentid, value) VALUES ({x['tmplvarid']}, {x['contentid']}, {q(x['value'])});")
sql.append('')

# ---------- EN-ресурс ----------
e = dict(r)
e.update(id=EN, context_key='en', parent=EN_PARENT, alias=SLUG, uri=SLUG, uri_override=0, pub_date=0, unpub_date=0)
for f in FIELDS:
    e[f] = tr['fields'][f]
for f in ('introtext', 'content'):
    assert not (r[f] or '').strip(), f'{f} не пуст — нужен перевод'
cols = list(r.keys())
vals = ['UNIX_TIMESTAMP()' if k in ('createdon', 'editedon', 'publishedon') else q(e[k]) for k in cols]
sql += [f"DELETE FROM {P}site_tmplvar_contentvalues WHERE contentid = {EN};",
        f"DELETE FROM {P}site_content WHERE id = {EN} AND context_key = 'en';",
        f"INSERT INTO {P}site_content ({', '.join('`' + k + '`' for k in cols)}) VALUES ({', '.join(vals)});"]

rows, skipped = [], []
for t in tvs:
    n, typ, v = t['name'], t['type'], t['value'] or ''
    if t['tmplvarid'] == BABEL_TV:
        continue
    if typ == 'migx':
        items = json.loads(v) if v.strip() else []
        if n in tr['migx']:
            ti = tr['migx'][n]
            assert len(ti) == len(items), n
            for it, tt in zip(items, ti):
                for kk, vv in tt.items():
                    assert kk in it, (n, kk)
                    it[kk] = vv
            v = php_json(items)
        elif CYR.search(json.dumps(items, ensure_ascii=False)) or any(re.search(r'[A-Za-zăâîșț]{3}', str(x)) for it in items for k2, x in it.items() if k2 not in ('MIGX_id', 'image')):
            skipped.append(n)
            continue
    elif typ in ('text', 'textarea', 'richtext'):
        if n in tr['tvs']:
            v = tr['tvs'][n]
        elif CYR.search(v):
            skipped.append(n)
            continue
        elif v.strip() and n not in ('seo-price-range',) and not re.fullmatch(r'(<p>)?(<span>)?[\s\xa0]*(</span>)?(</p>)?', v):
            raise SystemExit(f'нет перевода TV {n}: {v[:60]!r}')
    rows.append(f"({t['tmplvarid']}, {EN}, {q(v)})")
sql.append(f"INSERT INTO {P}site_tmplvar_contentvalues (tmplvarid, contentid, value) VALUES\n  " + ',\n  '.join(rows) + ';')
sql.append('')

# ---------- Babel: RO и RU — ;en:1625, EN — значение RO ----------
sql += [f"UPDATE {P}site_tmplvar_contentvalues SET value = CONCAT(REPLACE(value, ';en:{EN}', ''), ';en:{EN}') "
        f"WHERE tmplvarid = {BABEL_TV} AND contentid IN ({RO}, {RU});",
        f"INSERT INTO {P}site_tmplvar_contentvalues (tmplvarid, contentid, value) "
        f"SELECT {BABEL_TV}, {EN}, value FROM {P}site_tmplvar_contentvalues WHERE tmplvarid = {BABEL_TV} AND contentid = {RO};", '']

# ---------- подвал EN-главной: пункт «Laser tattoo removal» (после «Laser hair removal»; у RO в этом месте ссылка «Îndepărtare tatuaje remover») ----------
sql += ['-- подвал EN-главной (TV foot-link-l у 1001): + Laser tattoo removal',
        f"UPDATE {P}site_tmplvar_contentvalues SET value = REPLACE(value, '<p><a href=\"/en/laser-hair-removal\">Laser hair removal</a></p>', "
        f"'<p><a href=\"/en/laser-hair-removal\">Laser hair removal</a></p>\\n\\n<p><a href=\"/en/{SLUG}\">Laser tattoo removal</a></p>') "
        f"WHERE tmplvarid = (SELECT id FROM {P}site_tmplvars WHERE name = 'foot-link-l') AND contentid = 1001 AND value NOT LIKE '%/en/{SLUG}%';", '']

# ---------- старые чанки шаблона 19 — под EN ----------
POP_T = "[[++cultureKey:is=`ro`:then=`Ia o consultație de la un specialist`:else=`Получить консультацию мастера`]]"
POP_S = ("[[++cultureKey:is=`ro`:then=`Aflați toate detaliile îndepărtării cu laser și obțineți răspunsuri la întrebările rămase de la specialistul "
         "dumneavoastră`:else=`Узнайте все детали лазерного удаления и получите ответы на оставшиеся вопросы от вашего мастера`]]")
c.execute(f"SELECT snippet FROM {P}site_htmlsnippets WHERE name = 'banner-interial-category-new'")
s = c.fetchone()['snippet']
assert (POP_T in s and POP_S in s) or "{elseif $_modx->config.cultureKey == 'en'}Get a consultation" in s, 'banner: тексты окна не найдены'  # или уже применено локально
sql += ['-- banner-interial-category-new: окно «Консультация» — третий язык (было: ro → RO, иначе RU)',
        f"UPDATE {P}site_htmlsnippets SET snippet = REPLACE(REPLACE(snippet, {q(POP_T)}, "
        + q("{if $_modx->config.cultureKey == 'ro'}Ia o consultație de la un specialist{elseif $_modx->config.cultureKey == 'en'}Get a consultation "
            "with a specialist{else}Получить консультацию мастера{/if}") + f"), {q(POP_S)}, "
        + q("{if $_modx->config.cultureKey == 'ro'}Aflați toate detaliile îndepărtării cu laser și obțineți răspunsuri la întrebările rămase de la "
            "specialistul dumneavoastră{elseif $_modx->config.cultureKey == 'en'}Find out all the details of laser removal and get answers to any "
            "remaining questions from your specialist{else}Узнайте все детали лазерного удаления и получите ответы на оставшиеся вопросы от вашего "
            "мастера{/if}") + ") WHERE name = 'banner-interial-category-new';", '']

GAL = "{set $portfolio = $_modx->runSnippet('!ms2Gallery', [\n"
c.execute(f"SELECT snippet FROM {P}site_htmlsnippets WHERE name = 'bl6-portfolio-new'")
s = c.fetchone()['snippet']
assert s.count(GAL) == 1, 'bl6: вызов ms2Gallery не найден'
sql += ['-- bl6-portfolio-new: фото — ресурса lb.roId (у EN — RO-двойник; у RO / RU — сам ресурс, как было)',
        f"UPDATE {P}site_htmlsnippets SET snippet = REPLACE(snippet, {q(GAL)}, "
        + q("{set $portfolio = $_modx->runSnippet('!ms2Gallery', [\n'resources' => ($_modx->getChunk('lb.roId') | trim),\n") + ") "
        f"WHERE name = 'bl6-portfolio-new' AND snippet NOT LIKE '%lb.roId%';", '']

c.execute(f"SELECT snippet FROM {P}site_htmlsnippets WHERE name = 'bl9-reviews-new'")
s = c.fetchone()['snippet']
pairs = [("{var $rateCount = '!ecMessagesCount' | snippet}",
          "{var $tid = $_modx->getChunk('lb.roId') | trim}{var $rateCount = $_modx->runSnippet('!ecMessagesCount', ['thread' => 'resource-' ~ $tid])}"),
         ('[[!ecMessagesCount]]', '[[!ecMessagesCount? &thread=`resource-{$tid}`]]'),
         ('[[!ecThreadRating]]', '[[!ecThreadRating? &thread=`resource-{$tid}`]]'),
         ('[[!ecMessages? &tpl=`tpl.ecMessages.Row`]]', '[[!ecMessages? &thread=`resource-{$tid}` &tpl=`tpl.ecMessages.Row`]]'),
         ('[[!ecForm?\n', '[[!ecForm?\n                            &thread=`resource-{$tid}`\n')]
for a, b in pairs:
    assert a in s or b in s, ('bl9', a)  # b — уже применено локально
expr = 'snippet'
for a, b in pairs:
    expr = f"REPLACE({expr}, {q(a)}, {q(b)})"
sql += ['-- bl9-reviews-new: ветка отзывов — resource-<lb.roId> (у EN — RO-двойника; у RO / RU — своя, как было)',
        f"UPDATE {P}site_htmlsnippets SET snippet = {expr} WHERE name = 'bl9-reviews-new' AND snippet NOT LIKE '%lb.roId%';", '']

c.execute(f"SELECT snippet FROM {P}site_htmlsnippets WHERE name = 'bl-contact'")
s = c.fetchone()['snippet']
cp = [('București, Sector 1', 'Bucharest, Sector 1'),
      ('Stația de tramvai Ștefan cel Mare', 'Ștefan cel Mare tram stop'),
      ('Programa: <br/>Luni-Duminica 9:00 - 20:00', 'Opening hours: <br/>Monday – Sunday 9:00 - 20:00')]
for a, b in cp:
    assert s.count(a) == 1 or b in s, ('bl-contact', a)  # b — уже применено локально
expr = 'snippet'
for a, b in cp:
    expr = f"REPLACE({expr}, {q(a)}, {q('{if $_modx->config.cultureKey == ' + chr(39) + 'en' + chr(39) + '}' + b + '{else}' + a + '{/if}')})"
sql += ['-- bl-contact (контакты старых страниц): на EN — адрес, трамвай и график по-английски (RO / RU — без изменений, как было)',
        f"UPDATE {P}site_htmlsnippets SET snippet = {expr} WHERE name = 'bl-contact' AND snippet NOT LIKE '%Bucharest, Sector 1%';", '']

open(OUT, 'w').write('\n'.join(sql) + '\n')
print('written', OUT, len(sql), 'lines; skipped TV (кириллица, шаблон 19 их не выводит):', skipped)
