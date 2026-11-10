#!/usr/bin/env python3
# en_build.py — английская версия сайта (контекст en, /en/): SQL-патч из RO-страниц базы и переводов _dev/en/tr/<RO_ID>.json.
#   EN id = RO id + 1000; слаги — SLUG ниже; поля и текстовые TV — из перевода; картинки / опции / прочие TV — копия RO;
#   ссылки в текстах: на переведённые страницы — /en/<слаг>, на остальные RO-страницы — /<uri>; относительные src картинок — от корня
#   (у EN base href = .../en/). Ветки отзывов и галереи ms2Gallery у EN — RO-двойника (чанк lb.roId), строки не копируются.
#   Связи Babel (TV babelLanguageLinks): RO и RU-двойнику дописывается ;en:<id>, EN — копия значения RO.
# Запуск: python3 _dev/tools/en_build.py [out.sql]   (база — lbar, локально)
import json, re, sys, os, pymysql

P = 'Impulse_Digital_X_'
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
TR = os.path.join(ROOT, '_dev/en/tr')
OUT = sys.argv[1] if len(sys.argv) > 1 else os.path.join(ROOT, '_dev/patches/step39-en.sql')
OFF = 1000
BABEL_TV = 304
SLUG = {1: 'permanent-makeup-bucharest', 80: 'services', 2: 'eyebrow-micropigmentation', 51: 'powder-brows', 53: 'hair-stroke-brows',
        52: 'microblading', 54: '3d-6d-eyebrow-tattoo', 162: 'eyeliner-micropigmentation', 163: 'lash-line-enhancement',
        167: 'lip-micropigmentation', 119: 'micropigmentation-touch-up', 168: 'beauty-mark-tattoo', 626: 'classic-eyelash-extensions',
        627: 'laser-hair-removal', 629: 'manicure', 631: 'pedicure', 177: 'gift-voucher', 100: 'portfolio',
        120: 'ksenia-kobilianskaia', 121: 'aliona-subcinskaia', 123: 'eyebrow-portfolio-before-after',
        124: 'eye-portfolio-before-after', 125: 'lip-portfolio-before-after', 126: 'training-moments', 44: 'prices',
        102: 'about-us', 171: 'reviews', 105: 'careers', 3: 'contact', 40: 'thank-you', 20: 'page-not-found', 23: 'sitemap'}
IDS = sorted(SLUG)
CYR = re.compile(r'[Ѐ-ӿ]')
# TV главной про блог (в EN блога нет) — не создаются
BLOG_TV = re.compile(r'^(title-blog-bl12|title-st-\d|text-st-\d|link-st-\d|img-st-\d|alt-st-\d)$')
FIELDS = ('pagetitle', 'longtitle', 'menutitle', 'description', 'introtext', 'content')
EN_FOOT_L = ('<p><a href="/en/">Home</a></p>\r\n<p><a href="/en/eyebrow-micropigmentation">Eyebrow micropigmentation</a></p>\r\n'
             '<p><a href="/en/lip-micropigmentation">Lip micropigmentation</a></p>\r\n'
             '<p><a href="/en/eyeliner-micropigmentation">Eyeliner micropigmentation</a></p>\r\n'
             '<p><a href="/en/laser-hair-removal">Laser hair removal</a></p>')
EN_FOOT_R = ('<p><a href="/en/reviews">Reviews</a></p>\r\n<p><a href="/en/prices">Prices</a></p>\r\n'
             '<p><a href="/en/portfolio">Portfolio</a></p>\r\n<p><a href="/en/about-us">About us</a></p>\r\n'
             '<p><a href="/en/contact">Contact</a></p>\r\n<p><a href="/en/gift-voucher">Gift Voucher</a></p>\n<p><a href="/en/careers">Careers</a></p>')

db = pymysql.connect(unix_socket='/run/mysqld/mysqld.sock', user='root', database='lbar', charset='utf8mb4')
c = db.cursor(pymysql.cursors.DictCursor)
q = lambda v: 'NULL' if v is None else (str(v) if isinstance(v, int) else db.escape(str(v)))

c.execute(f"SELECT * FROM {P}site_content WHERE id IN ({','.join(map(str, IDS))})")
res = {r['id']: r for r in c.fetchall()}
assert set(res) == set(IDS), set(IDS) - set(res)
c.execute(f"SELECT id, uri FROM {P}site_content WHERE context_key='web'")
uri2id = {}
for r in c.fetchall():
    uri2id[r['uri'].strip()] = r['id']
    uri2id[r['uri'].strip().rstrip('/')] = r['id']
c.execute(f"SELECT v.contentid, v.tmplvarid, t.name, t.type, v.value FROM {P}site_tmplvar_contentvalues v "
          f"JOIN {P}site_tmplvars t ON t.id = v.tmplvarid WHERE v.contentid IN ({','.join(map(str, IDS))}) ORDER BY v.contentid, v.tmplvarid")
tvs = {}
for r in c.fetchall():
    tvs.setdefault(r['contentid'], []).append(r)
c.execute(f"SELECT id FROM {P}site_content WHERE id BETWEEN {OFF + 1} AND {OFF + 999}")
clash = [r['id'] for r in c.fetchall() if res.get(r['id'] - OFF) is None]
assert not clash, f'ids busy: {clash}'


def en_href(h):
    """ссылка из RO-текста → для EN-страницы"""
    if not h or h.startswith(('#', 'mailto:', 'tel:', 'javascript:')) or '[[' in h:
        return h
    m = re.match(r'^https?://(?:www\.)?(?:lbar\.ro|stage-lbar\.touchit\.vinnica\.ua)(/.*)?$', h)
    if m:
        h = m.group(1) or '/'
    elif re.match(r'^[a-z]+:', h):
        return h
    frag = ''
    if '#' in h:
        h, frag = h.split('#', 1)
        frag = '#' + frag
    path = h[1:] if h.startswith('/') else h
    if path.startswith(('ru/', 'en/')):
        return '/' + path + frag
    rid = 1 if path in ('', '/') else uri2id.get(path.rstrip('/'))
    if rid in SLUG:
        return ('/en/' if rid == 1 else '/en/' + SLUG[rid]) + frag
    return '/' + path + frag


def en_html(s):
    s = re.sub(r'(href=")([^"]*)(")', lambda m: m.group(1) + en_href(m.group(2)) + m.group(3), s)
    s = re.sub(r'(src=")(?!/|https?:|data:|\[\[)([^"]+)(")', lambda m: m.group(1) + '/' + m.group(2) + m.group(3), s)
    return s


def php_json(items):
    return json.dumps(items, ensure_ascii=True, separators=(',', ':')).replace('/', '\\/')


now = 'UNIX_TIMESTAMP()'
sql = ['-- step39: английская версия (контекст en, /en/): контекст, настройки, Babel, 32 страницы (id = RO id + 1000), TV, связи Babel.',
       '-- Сгенерировано _dev/tools/en_build.py из RO-страниц и переводов _dev/en/tr. Повторный запуск безопасен (EN-строки пересоздаются).',
       'SET NAMES utf8mb4;', '']
# контекст и его настройки (site_url — от web, чтобы подошло и для stage, и для прода)
sql += [f"INSERT INTO {P}context (`key`, name, description, `rank`) VALUES ('en', 'English', 'English front-end context (/en/)', 0) "
        f"ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description);",
        f"DELETE FROM {P}context_setting WHERE context_key = 'en';",
        f"INSERT INTO {P}context_setting (context_key, `key`, value, xtype, namespace, area, editedon) VALUES "
        f"('en', 'base_url', '/en/', 'textfield', 'core', 'language', NULL), "
        f"('en', 'cultureKey', 'en', 'textfield', 'core', 'language', NULL), "
        f"('en', 'site_start', '{1 + OFF}', 'textfield', 'core', 'language', NULL), "
        f"('en', 'error_page', '{20 + OFF}', 'textfield', 'core', 'language', NULL);",
        f"INSERT INTO {P}context_setting (context_key, `key`, value, xtype, namespace, area, editedon) "
        f"SELECT 'en', 'site_url', CONCAT(TRIM(TRAILING '/' FROM value), '/en/'), 'textfield', 'core', 'language', NULL "
        f"FROM {P}context_setting WHERE context_key = 'web' AND `key` = 'site_url';",
        f"DELETE FROM {P}access_context WHERE target = 'en';",
        f"INSERT INTO {P}access_context (target, principal_class, principal, authority, policy) "
        f"SELECT 'en', principal_class, principal, authority, policy FROM {P}access_context WHERE target = 'ru';",
        f"UPDATE {P}system_settings SET value = 'web,ru,en' WHERE `key` = 'babel.contextKeys';",
        # источники файлов TV (картинки) — как у web: иначе пути картинок TV в контексте en строятся от корня
        f"DELETE FROM {P}media_sources_elements WHERE context_key = 'en';",
        f"INSERT INTO {P}media_sources_elements (source, object_class, object, context_key) "
        f"SELECT source, object_class, object, 'en' FROM {P}media_sources_elements WHERE context_key = 'web';", '']

en_ids = ','.join(str(i + OFF) for i in IDS)
sql += [f"DELETE FROM {P}site_tmplvar_contentvalues WHERE contentid IN ({en_ids});",
        f"DELETE FROM {P}site_content WHERE id IN ({en_ids}) AND context_key = 'en';", '']

cols = list(res[1].keys())
report = []
for rid in IDS:
    r = dict(res[rid])
    tr = json.load(open(os.path.join(TR, f'{rid}.json'))) if rid != 23 else {'fields': {}, 'tvs': {}, 'migx': {}}
    eid = rid + OFF
    r['id'] = eid
    r['context_key'] = 'en'
    r['parent'] = r['parent'] + OFF if r['parent'] in SLUG else 0
    r['alias'] = SLUG[rid]
    r['uri'] = 'sitemap.xml' if rid == 23 else SLUG[rid]
    r['uri_override'] = 0
    for f in FIELDS:
        if f in tr['fields']:
            r[f] = en_html(tr['fields'][f])
        elif (r[f] or '').strip() and rid != 23:
            raise SystemExit(f'{rid}: нет перевода поля {f}')
    if rid == 23:
        r['content'] = r['content'].replace('&context=`web`', '&context=`en`')
        assert '&context=`en`' in r['content']
    for k in ('createdon', 'editedon', 'publishedon'):
        r[k] = None
    r['pub_date'] = r['unpub_date'] = 0
    vals = [now if (k in ('createdon', 'editedon', 'publishedon')) else q(r[k]) for k in cols]
    sql.append(f"INSERT INTO {P}site_content ({', '.join('`' + k + '`' for k in cols)}) VALUES ({', '.join(vals)});")
    # TV
    rows = []
    for t in tvs.get(rid, []):
        n, typ, v = t['name'], t['type'], t['value'] or ''
        if t['tmplvarid'] == BABEL_TV:
            continue
        if rid == 1 and BLOG_TV.match(n):
            continue
        if n == 'foot-link-l':
            v = EN_FOOT_L
        elif n == 'foot-link-r':
            v = EN_FOOT_R
        elif n == 'id-bl2':
            v = ','.join(str(int(x) + OFF) for x in re.findall(r'\d+', v) if int(x) in SLUG)
        elif n.startswith('link') and n not in ('link-form-bl4', 'link-form-bl8') and typ in ('text', 'textarea'):
            v = en_href(v.strip()) if v.strip() else v
        elif typ == 'migx':
            items = json.loads(v) if v.strip() else []
            if n in tr['migx']:
                ti = tr['migx'][n]
                assert len(ti) == len(items), (rid, n)
                for it, tt in zip(items, ti):
                    for kk, vv in tt.items():
                        assert kk in it, (rid, n, kk)
                        it[kk] = en_html(vv)
                v = php_json(items)
            elif any(isinstance(x, str) and re.search(r'[A-Za-zăâîșț]{3}', x) for it in items for k2, x in it.items() if k2 not in ('MIGX_id', 'image')):
                raise SystemExit(f'{rid}: нет перевода MIGX {n}')
        elif typ in ('text', 'textarea', 'richtext'):
            if n in tr['tvs']:
                v = en_html(tr['tvs'][n])
            elif CYR.search(v):
                report.append(f'{rid} skip cyrillic TV {n}')
                continue
            elif v.strip() and n not in ('seo-price-range', 'localbusiness-best_rating', 'localbusiness-worst_rating', 'master-1', 'master-2', 'line-4'):
                raise SystemExit(f'{rid}: нет перевода TV {n}')
        rows.append(f"({t['tmplvarid']}, {eid}, {q(v)})")
    if rows:
        sql.append(f"INSERT INTO {P}site_tmplvar_contentvalues (tmplvarid, contentid, value) VALUES\n  " + ',\n  '.join(rows) + ';')
    sql.append('')

# Babel: RO и RU-двойнику — ;en:<id> (идемпотентно), EN — значение RO
c.execute(f"SELECT contentid, value FROM {P}site_tmplvar_contentvalues WHERE tmplvarid = {BABEL_TV} AND contentid IN ({','.join(map(str, IDS))})")
babel = {r['contentid']: r['value'] for r in c.fetchall()}
for rid in IDS:
    eid = rid + OFF
    links = dict(x.split(':') for x in babel[rid].split(';') if ':' in x)
    assert links.get('web') == str(rid), (rid, babel[rid])
    twins = [rid] + ([int(links['ru'])] if 'ru' in links else [])
    sql.append(f"UPDATE {P}site_tmplvar_contentvalues SET value = CONCAT(REPLACE(value, ';en:{eid}', ''), ';en:{eid}') "
               f"WHERE tmplvarid = {BABEL_TV} AND contentid IN ({','.join(map(str, twins))});")
    sql.append(f"INSERT INTO {P}site_tmplvar_contentvalues (tmplvarid, contentid, value) "
               f"SELECT {BABEL_TV}, {eid}, value FROM {P}site_tmplvar_contentvalues WHERE tmplvarid = {BABEL_TV} AND contentid = {rid};")
sql.append('')
open(OUT, 'w').write('\n'.join(sql) + '\n')
print('written', OUT, len(sql), 'lines')
for x in report:
    print(x)
