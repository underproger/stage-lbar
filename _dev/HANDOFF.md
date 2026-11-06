# stage-lbar — handoff (редизайн lbar.ro на MODX)

Состояние на 06.11.2026, последний коммит — см. `git log`. Папка `_dev/` — служебная (закрыта `.htaccess`),
**в конце проекта удалить** вместе с остальным мусором.

## 1. Проект

- Сайт **lbar.ro** — студия перманентного макияжа (Бухарест). MODX Revolution **2.8.1**, Babel: контекст `web` = RO (корень), `ru` = RU (`/ru/`).
  Менеджер: `/impulsemanager/`. Префикс таблиц `Impulse_Digital_X_`. pdoTools + Fenom включены, ClientConfig (телефон, соцсети и т.п.).
- **Стейдж:** https://stage-lbar.touchit.vinnica.ua/ — закрыт от индексации правилами в `.htaccess` (любой домен ≠ `lbar.ro` получает
  `X-Robots-Tag: noindex, nofollow` и `robots-stage.txt` с `Disallow: /`). На проде правила не срабатывают — откатывать не нужно.
- **Репо:** `underproger/stage-lbar` (GitHub), ветка `main`, сайт лежит в корне репо. Пользователь сам забирает из git и деплоит на хостинг.
- **Задача:** редизайн главной (потом остальные страницы) по скринам-макетам пользователя **1 в 1**, анимированно («wow»), **не сломав SEO**.

## 2. Правила пользователя (важно)

- Общение — по-русски, коротко и по делу.
- Конфиги и кэш — **в `.gitignore`** (`config.core.php` ×3, `core/config/config.inc.php`, `core/cache/`, `assets/image-cache/`, `webp/`). Конфиги на хостинг кладёт сам.
- **БД:** полную базу больше не присылать. Присылать **только SQL-патч, когда БД реально изменилась**; если не менялась — так и сказать («импорт не нужен»).
  Патч генерить `_dev/tools/make_patch.sh` (все чанки категории *Redesign* + шаблон «Главная») и **проверять импортом** на копии.
  Из дампов MariaDB **удалять строку** `/*M!999999\- enable the sandbox mode */` (ломает импорт консольным клиентом MySQL) — `make_patch.sh` это делает.
- **SEO:** тексты/заголовки из БД не менять без согласования (новые можно добавлять). После каждого блока — сверка `_dev/tools/seo_compare.py`
  (title, description, canonical, hreflang, robots, H1/H2, JSON-LD, ссылки меню) с эталоном `_dev/seo-baseline/seo.json` (снят до редизайна).
  Единственное согласованное изменение — H1 главной (см. блок 1). Пробел в конце alias у страницы `3d-i-6d-tatuaj-sprancene ` — **не трогать** (решение пользователя).
- **Мусор удаляем в конце:** старые чанки (`header`, `banner-main`, `bl1-about-us`, `bl2-category`, …), таблицы статистики
  `stat_online_users` / `stat_page_statistics` (~670 МБ из 700), `_dev/`, `.DS_Store` и т.п.
- **Без инлайн-стилей** в HTML, стили — в SCSS (BEM, vw-система), скрипты — отдельным файлом.
- Нумерация (01/02/03) — автоматически из индекса цикла, без ручных полей.
- **Кнопки по всему сайту** — как на `mockups/block3-services-v2-buttons-style.png`: коричневая пилюля с градиентом (`.lb-btn--solid`)
  и контурная пилюля (`.lb-btn--ghost`), стрелка `→` (`svg.lb-btn__arr`).
- **Не писать «Lbar Studio» в каждом блоке** (макеты-ИИ любят надзаголовки «LBAR STUDIO», подписи «LBar studio», логотип поверх фото) —
  такие элементы не переносить. Уже убрано: подпись «LBar studio» в фоне блока «Услуги», RU-надзаголовок «Студия LBar» → «Наши процедуры».
  Открытый вопрос: круглая печать «Studio LBar · Micropigmentare» и водяные знаки «Lbar» в фонах блоков 2–3 — уточнить, убирать ли.
- Папки картинок `images/` и `assets/images/` в архивах **не пришли** (локально 404) — пользователь ещё не прислал. На проде они есть.

## 3. Архитектура редизайна

| Что | Где |
|---|---|
| Чанки (статичные, источник — файлы) | `core/elements/redesign/chunks/*.tpl` → в MODX категория **Redesign**, `static=1`, `source=1`, `static_file=core/elements/redesign/chunks/<name>.tpl` |
| SCSS (BEM, vw от 1920) | `assets/templates/redesign/scss/` → сборка в `css/redesign.css` |
| JS | `assets/templates/redesign/js/redesign.js` + `js/vendor/gsap.min.js`, `ScrollTrigger.min.js` |
| Шрифты (локально, woff2 subset) | `assets/templates/redesign/fonts/` |
| Картинки редизайна | `assets/templates/redesign/img/` |
| Тексты интерфейса RO/RU | лексикон `core/components/babel/lexicon/{ro,ru}/translate.inc.php`, ключи `lbar.rd.*` (так уже было на сайте: `lbar.*`) |

**Сборка CSS:** `cd assets/templates/redesign && /home/claude/build/node_modules/.bin/sass scss/redesign.scss css/redesign.css --style=compressed --no-source-map --silence-deprecation=import`
**Версия кэша CSS/JS:** `?v=` в `lb-head.tpl` и `lb-scripts.tpl` (сейчас **1.2.0**) — поднимать при изменениях.
**Новые/изменённые чанки в БД:** `sudo -u www-data php _dev/tools/modx_apply3.php` (пересохраняет все `*.tpl` из папки как статичные чанки и меняет
вызов в шаблоне «Главная») — для нового блока сделать по аналогии `modx_apply4.php` (замена `[[$старый-чанк]]` → `[[$lb-новый]]`).

Шаблон **«Главная» (id 1)** сейчас: `[[$head]] [[$lb-head]]` … `[[$lb-header]] [[$lb-banner-main]] [[$lb-about]] [[$lb-services]] [[*title-main-bl3:notempty=`[[$bl3-text]]`]] …` `[[$script]] [[$lb-scripts]]`.
Старые чанки используются ещё на других шаблонах (напр. `bl1-about-us`, `bl3-text` — в шаблоне «Категория», 27 страниц) — **их не правим**, делаем новые `lb-*` и подключаем только в «Главную».

Шрифты: `LB Serif` = Noto Serif Display (var wdth/wght, +italic), `LB Sans` = DM Sans (+Onest для кириллицы), `LB Display` = Playfair Display (+italic),
`LB Text` = Montserrat (+italic). Подключены в `scss/_fonts.scss` с unicode-range (latin / румынские ș ț ă / кириллица). Новые шрифты брать из npm `@fontsource-variable/*`.

### Подводные камни (уже решены — не наступать снова)
- Старый CSS (`.wrapper.main-ro h1/h2`, `span{font-weight:400}`) перебивает новые стили → для h1/h2 поднимать специфичность
  (`.lb-x .lb-x__wrap h2.lb-x__title`), веса задавать прямо на span. Проверка утечек — JS в `probe.py` (сравнить computed styles со старым CSS и без).
- Ресеты в блоках — только через `:where()`, иначе перебивают свои же классы.
- `transform` зарезервирован под GSAP; hover-сдвиги — через CSS-свойства `translate` / `scale`.
- В RU-контексте `$_modx->config['phone-1']` (ClientConfig) в Fenom пустой → телефон выводить MODX-тегом `[[++phone-1]]`.
- В tpl для pdoResources лексикон не подхвачен → в начале tpl `{$_modx->lexicon->load('babel:translate')}`.
- `lazy`-плагин добавляет `loading="lazy"` всем img без атрибута → у первого экрана ставить `loading="eager"`.
- webp-плагин подменяет jpg/png на `/webp/...` если файл есть — наши картинки сразу `.webp`.

## 4. Сделано

1. **Шапка `lb-header`** — меню из дерева ресурсов (`pdoMenu`, те же 27/23 ссылки, 3 уровня, выпадашки), RO/RU (`lb.babelLink`), телефон, CTA «Fă o programare»
   (на главной скролл к `#bl8-form`, на других страницах — открывает попап из футера), мобильное меню-шторка. Fixed, при скролле — полупрозрачная.
2. **Баннер `lb-banner-main`** — 1:1 с макетом на 1920 (±1–3px). H1 из TV `title-banner` со строками через `|`
   (RO `Micropigmentare|premium|în București`, RU `Перманентный макияж|premium|в Бухаресте` — **согласованное изменение H1**), подзаголовок — TV `suptitle-banner`.
   Карточки 4000+/… — лексикон. Фон = апскейл скрина без текста (`img/hero-bg.webp`), мобильный кроп `hero-mobile.webp`.
3. **Блок «О микропигментации» `lb-about`** — заголовок/текст из TV `title_bl1_about` / `text_bl1_about` (без изменений; часть после тире — курсивом),
   текст свёрнут до 3 строк + «Citește mai mult / Ascunde» (полный текст в HTML). Преимущества, цитата, кнопка — лексикон `lbar.rd.about.*`.
4. **Блок «Услуги» `lb-services` + tpl `lb.serviceCard`** — TV `main-title-bl2`, `sub-title-bl2`, `id-bl2`; фото из макета для 3 услуг главной
   (карта id → картинка в tpl), для остальных — TV `im-category`. Слайдер-свайп на мобильном.
5. **Единый стиль кнопок** (шапка, баннер, блоки 2–3).
6. **Перетекающий фон** между блоками 2 и 3 (`scss/_seam.scss`, `img/seam.svg`) — декор рисуется половинками в обоих блоках.

SQL-патчи, отданные пользователю: `lbar-full-stage-2026-11-06.sql.gz` (исходный дамп + адреса стейджа + шапка/баннер), `stage-lbar-02-about.sql`,
`stage-lbar-03-services.sql`. После 03 БД **не менялась** (последние правки — только файлы).

## 5. Следующий шаг — блок 4 «Micropigmentarea … implică:»

Макет: `_dev/mockups/block4-implica-NEXT.png`. Старый чанк **`bl3-text`** (вызов в шаблоне: `[[*title-main-bl3:notempty=`[[$bl3-text]]`]]` — сохранить условие).
Данные (TV ресурсов 1 / 193): `title-main-bl3` (H2: RO «Micropigmentarea în salonul nostru din București, implică:», RU «Перманентный татуаж в Бухаресте от LBar — это:»),
`title-1..3-bl3`, `text-1..3-bl3` (RO Calitate/Siguranță/Frumusețe, RU Красиво/Безопасно/Современно), `im-1-bl3`, `alt-im-1-bl3`.
- Тексты — из TV (как в макете для RO совпадают). В заголовке выделить курсивом (Playfair italic, медный) слово/фразу как в макете («București») — для RU решить аналогично.
- **Не переносить** надзаголовок «LBAR STUDIO» и логотип «LBar | Studio de micropigmentare» на фото.
- Кнопки: «Programează-te →» (solid) и «Vezi portfolio» (ссылка с кругом-play) — тексты в лексикон; ссылки: форма записи `#bl8-form` / портфолио (id 100 RO, 198 RU).
- Иконки (бриллиант, щит, лотос) в медных плашках — SVG. Дуга с точками — SVG/CSS.

## 6. Конвейер «1 в 1» (как делались блоки)

1. Скрин макета → вырезать область блока (без белых полей) → `src.png` (~1083×609, это 1920×1080 в масштабе ×1.7729).
2. Апскейл ×2 EDSR: `python3 _dev/tools/upscale.py src.png up2.png` (~5 мин, модель `/home/claude/sr/EDSR_x2.pb`).
3. Убрать с фона всё, что будет кодом (текст, кнопки, карточки): прямоугольники в координатах скрина → `rects.json`
   (`[x1,y1,x2,y2,(радиус)]`), затем `OX=<смещение x> OY=<смещение y> python3 _dev/tools/clean_bg.py rects.json clean.png up2.png` (push-pull заливка + зерно).
   Примеры: `_dev/rects/*.json`.
4. Фон → `img/<блок>-bg.webp` (2166×1218, q≈86) + `-1440.webp`; мобильный кроп отдельно.
5. Размеры шрифтов — из ширины текста: `_dev/tools/fontmetrics.py` (функция `ink`), координаты — сетка поверх `ref1920.png` или diff `up2` vs `clean`.
6. Рендер и сверка: `shot2.py` (страница), `shot_el.py URL out.png 1920 1080 '#lb-xxx'` (блок, с прокруткой и скрытой шапкой), наложение/сравнение с `ref1920.png`.
7. SEO-сверка `python3 -I _dev/tools/seo_compare.py`, проверка утечек старого CSS (`probe.py`), мобильный 390×844.
8. Коммит + пуш, SQL-патч (если менялась БД) → файлы пользователю + сравнение «макет / сайт».

Скрипты в `_dev/tools` писались под конкретные блоки — пути (`/home/claude/sr`, `/home/claude/b2`, …) поправить под себя.

## 7. Локальное окружение (новая сессия)

1. Подключить репо (`add_repo underproger/stage-lbar`, push), клонировать в `/home/claude/stage-lbar`.
2. Пользователь прикладывает `lbar-full-stage-2026-11-06.sql.gz`, `stage-lbar-02-about.sql`, `stage-lbar-03-services.sql`.
3. `cd /home/claude/stage-lbar && bash _dev/setup_local.sh <full.sql.gz> <02.sql> <03.sql>` — поднимет MariaDB, Apache+SSL, PHP-полифилл,
   конфиги из `_dev/local-config`, hosts (`stage-lbar.touchit.vinnica.ua` → 127.0.0.1), симлинк `/home/impua/lbar.ro/www` → репо.
4. После рестарта контейнера: `bash _dev/tools/up.sh`. Chrome для скриншотов запускать с `--no-proxy-server`, внешние запросы блокировать (так в `shot*.py`).
5. Хостинг, скорее всего, на PHP 7.x — **PHP 8 на сервере не включать** (MODX 2.8.1 падает).
