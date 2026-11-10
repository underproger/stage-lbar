#!/usr/bin/env python3
# en_course.py — шаг 62: курс «Curs complet micropigmentare» (RO 182 / RU 295, шаблон 15 «Обучение», старый дизайн с новыми шапкой и подвалом)
# — английская версия 1182 /en/complete-micropigmentation-course + правки старых чанков шаблона 15 под EN (как en_tz.py в шаге 61).
#   Перевод — _dev/en/tr/182.json (поля, текстовые TV, MIGX: программа, вопросы, преимущества); прочие TV — копия RO
#   (фото migx_plan_study — пути как у RO: чанк migx_plan_study_tpl сам добавляет «/» для не-RO языков).
#   Фото ms2Gallery у EN — RO-двойника (чанк lb.roId).
# Запуск (локально, база lbar): python3 _dev/tools/en_course.py [out.sql]  → по умолчанию _dev/patches/step62-en-course.sql
import json, re, sys, os, pymysql

P = 'Impulse_Digital_X_'
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(ROOT, '_dev/patches/step62-en-course.sql')
RO, RU, EN, SLUG = 182, 295, 1182, 'complete-micropigmentation-course'
BABEL_TV = 304
FIELDS = ('pagetitle', 'longtitle', 'menutitle', 'description')
tr = json.load(open(os.path.join(ROOT, '_dev/en/tr/182.json')))

db = pymysql.connect(unix_socket='/run/mysqld/mysqld.sock', user='root', database='lbar', charset='utf8mb4')
c = db.cursor(pymysql.cursors.DictCursor)
q = lambda v: 'NULL' if v is None else (str(v) if isinstance(v, int) else db.escape(str(v)))
EN_IF = lambda en, other: "{if $_modx->config.cultureKey == 'en'}" + en + '{else}' + other + '{/if}'


def php_json(items):
    return json.dumps(items, ensure_ascii=True, separators=(',', ':')).replace('/', '\\/')


def chunk(name):
    c.execute(f"SELECT snippet FROM {P}site_htmlsnippets WHERE name = %s", (name,))
    return c.fetchone()['snippet']


c.execute(f"SELECT * FROM {P}site_content WHERE id = {RO}")
r = dict(c.fetchone())
assert r['template'] == 15 and r['parent'] == 0 and r['context_key'] == 'web', (r['template'], r['parent'])
c.execute(f"SELECT v.tmplvarid, t.name, t.type, v.value FROM {P}site_tmplvar_contentvalues v JOIN {P}site_tmplvars t ON t.id = v.tmplvarid "
          f"WHERE v.contentid = {RO} ORDER BY v.tmplvarid")
tvs = c.fetchall()

sql = ['-- step62: курс «Curs complet micropigmentare» — английская версия 1182 (/en/complete-micropigmentation-course, шаблон 15 «Обучение»,',
       '-- старый дизайн с новыми шапкой и подвалом, как RO 182); старые чанки шаблона 15 — под EN (alt, сообщения форм, галерея RO-двойника);',
       '-- окно цены курса: подзаголовок и кнопка выводили ключи словаря (опечатки в чанках) — исправлено для всех языков.',
       '-- Сгенерировано _dev/tools/en_course.py (перевод — _dev/en/tr/182.json). Повторный запуск безопасен (EN-строки и TV пересоздаются).',
       'SET NAMES utf8mb4;', '']

# ---------- EN-ресурс ----------
e = dict(r)
e.update(id=EN, context_key='en', parent=0, alias=SLUG, uri=SLUG, uri_override=0, pub_date=0, unpub_date=0)
for f in FIELDS:
    e[f] = tr['fields'][f]
for f in ('introtext', 'content'):
    assert not (r[f] or '').strip(), f'{f} не пуст — нужен перевод'
cols = list(r.keys())
vals = ['UNIX_TIMESTAMP()' if k in ('createdon', 'editedon', 'publishedon') else q(e[k]) for k in cols]
sql += [f"DELETE FROM {P}site_tmplvar_contentvalues WHERE contentid = {EN};",
        f"DELETE FROM {P}site_content WHERE id = {EN} AND context_key = 'en';",
        f"INSERT INTO {P}site_content ({', '.join('`' + k + '`' for k in cols)}) VALUES ({', '.join(vals)});"]

rows = []
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
        else:
            assert n == 'migx_plan_study' and all(set(it) <= {'MIGX_id', 'image'} for it in items), ('нет перевода MIGX', n)
    elif typ in ('text', 'textarea', 'richtext'):
        if n not in tr['tvs']:
            raise SystemExit(f'нет перевода TV {n}: {v[:60]!r}')
        v = tr['tvs'][n]
    rows.append(f"({t['tmplvarid']}, {EN}, {q(v)})")
sql.append(f"INSERT INTO {P}site_tmplvar_contentvalues (tmplvarid, contentid, value) VALUES\n  " + ',\n  '.join(rows) + ';')
sql.append('')

# ---------- Babel: RO и RU — ;en:1182, EN — значение RO ----------
sql += [f"UPDATE {P}site_tmplvar_contentvalues SET value = CONCAT(REPLACE(value, ';en:{EN}', ''), ';en:{EN}') "
        f"WHERE tmplvarid = {BABEL_TV} AND contentid IN ({RO}, {RU});",
        f"INSERT INTO {P}site_tmplvar_contentvalues (tmplvarid, contentid, value) "
        f"SELECT {BABEL_TV}, {EN}, value FROM {P}site_tmplvar_contentvalues WHERE tmplvarid = {BABEL_TV} AND contentid = {RO};", '']

# ---------- подвал EN-главной: пункт «Training» (последним, как у RO) ----------
sql += ['-- подвал EN-главной (TV foot-link-l у 1001): + Training (у RO — последний пункт «Training» → curs-complet-micropigmentare)',
        f"UPDATE {P}site_tmplvar_contentvalues SET value = CONCAT(value, '\\n<p><a href=\"/en/{SLUG}\">Training</a></p>') "
        f"WHERE tmplvarid = (SELECT id FROM {P}site_tmplvars WHERE name = 'foot-link-l') AND contentid = 1001 AND value NOT LIKE '%/en/{SLUG}%';", '']

# ---------- старые чанки шаблона 15 — под EN ----------
VAL_RU, SUC_RU = 'Пожалуйста, заполните обязательные поля*', 'Ваше сообщение было успешно отправлено!'
VAL = ('&validationErrorMessage=`' + VAL_RU + '`',
       '&validationErrorMessage=`[[++cultureKey:is=`en`:then=`Please fill in the required fields*`:else=`' + VAL_RU + '`]]`')
SUC = ('&successMessage=`' + SUC_RU + '`',
       '&successMessage=`[[++cultureKey:is=`en`:then=`Your message has been sent successfully!`:else=`' + SUC_RU + '`]]`')
KS = 'Ксения Кобылянская'
ALT_KS = ('alt="' + KS + '"', 'alt="' + EN_IF('Ksenia Kobilianskaia', KS) + '"')
ALT_10 = ('alt="Вам не нужно проходить обучение, если', 'alt="' + EN_IF('You should not take the course if', 'Вам не нужно проходить обучение, если'))
TYPO = ("{$_modx->lexicon('lbar-study-prices-form=subtitle')}", "{$_modx->lexicon('lbar-study-prices-form-subtitle')}")
GAL = ('[[!ms2Gallery?\n', "{set $roid = $_modx->getChunk('lb.roId') | trim}[[!ms2Gallery?\n                &resources=`{$roid}`\n")
BTN8 = ('{$_modx->lexicon("lbar.study.prices.btn")}', '{$_modx->lexicon("lbar-study-prices-btn")}')
plan = [  # чанк, [(было, стало, сколько раз)], признак «уже применено», комментарий
    ('banner-study', [ALT_KS + (1,), VAL + (1,), SUC + (1,)], 'Ksenia Kobilianskaia', 'фото тренера — alt по-английски; сообщения формы'),
    ('bl2-study-trener', [ALT_KS + (1,), VAL + (1,), SUC + (1,)], 'Ksenia Kobilianskaia', 'то же'),
    ('bl10-study-info', [ALT_10 + (1,)], 'You should not take', 'alt картинки'),
    ('bl11-study-calculator', [VAL + (1,), SUC + (1,)], 'Please fill in', 'сообщения формы'),
    ('bl12-study-form', [VAL + (1,), SUC + (1,)], 'Please fill in', 'сообщения формы'),
    ('bl18-study-succsess', [VAL + (1,), SUC + (1,)], 'Please fill in', 'сообщения формы'),
    ('bl8-study-price', [VAL + (3,), SUC + (3,), TYPO + (1,)], 'Please fill in',
     'сообщения форм; подзаголовок окна первого тарифа: опечатка в ключе словаря (выводился сам ключ) — для всех языков'),
    ('bl7-study-portfolio', [GAL + (1,)], 'lb.roId', 'фото — ресурса lb.roId (у EN — RO-двойник; у RO / RU — сам ресурс, как было)'),
    ('tpl.Form.Study.Modal.BL8', [BTN8 + (1,)], 'lbar-study-prices-btn',
     'кнопка окна цены курса: ключа lbar.study.prices.btn нет в словаре (выводился сам ключ) — общий ключ кнопки тарифов, для всех языков'),
]
for name, reps, done, note in plan:
    s = chunk(name)
    if done not in s:
        for a, b, n in reps:
            assert s.count(a) == n, (name, a[:40], s.count(a))
    expr = 'snippet'
    for a, b, n in reps:
        expr = f"REPLACE({expr}, {q(a)}, {q(b)})"
    sql += [f'-- {name}: {note}',
            f"UPDATE {P}site_htmlsnippets SET snippet = {expr} WHERE name = {q(name)} AND snippet NOT LIKE {q('%' + done + '%')};", '']

open(OUT, 'w').write('\n'.join(sql) + '\n')
print('written', OUT, len(sql), 'lines;', len(rows), 'TV')
