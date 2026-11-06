# stage-lbar — handoff (редизайн lbar.ro на MODX)

Состояние на 06.11.2026 (вечер), сделаны блоки 1–5 главной, последний коммит — см. `git log`. Папка `_dev/` — служебная (закрыта `.htaccess`),
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
  **Решение пользователя:** надзаголовок «LBAR STUDIO» — только в блоке 4 (`lbar.rd.implica.eyebrow`), в остальных блоках его не делать
  (в блоке 5 — «Programare online / Онлайн-запись»). Логотип «LBar | Studio de micropigmentare» с фото блока 4 убран.
- **Фон блоков — без фото, только графика** (решение пользователя с блока 5): вазы, камни, цветы, тени листьев и т.п. из макетов не переносить,
  фон рисовать SVG/CSS (диски, тонкие медные дуги, градиенты, свет).
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
**Версия кэша CSS/JS:** `?v=` в `lb-head.tpl` и `lb-scripts.tpl` (сейчас **1.4.0**) — поднимать при изменениях.
**Новые/изменённые чанки в БД:** `sudo -u www-data php _dev/tools/modx_apply3.php` (пересохраняет все `*.tpl` из папки как статичные чанки и меняет
вызов в шаблоне «Главная») — для нового блока сделать по аналогии `modx_apply5.php` (последний — `modx_apply5.php`, замена `[[$старый-чанк]]` → `[[$lb-новый]]`).
**После правки `.tpl` чистить `core/cache/resource/`** (главная кэшируется — без этого на скриншоте старая разметка; CSS/JS это не касается).

Шаблон **«Главная» (id 1)** сейчас: `[[$head]] [[$lb-head]]` … `[[$lb-header]] [[$lb-banner-main]] [[$lb-about]] [[$lb-services]] [[*title-main-bl3:notempty=`[[$lb-implica]]`]] [[$lb-consult]] [[$bl2-study-trener]] …` `[[$script]] [[$lb-scripts]]`.
Старые чанки используются ещё на других шаблонах (напр. `bl1-about-us`, `bl3-text` — в шаблоне «Категория», 27 страниц) — **их не правим**, делаем новые `lb-*` и подключаем только в «Главную».

Шрифты: `LB Serif` = Noto Serif Display (var wdth/wght, +italic), `LB Sans` = DM Sans (+Onest для кириллицы), `LB Display` = Playfair Display (+italic),
`LB Text` = Montserrat (+italic), `LB Classic` = Crimson Pro (wght 300–500 / italic 400–500, урезан) + Spectral для кириллицы (300 / italic 400) — заголовок блока 5. Подключены в `scss/_fonts.scss` с unicode-range (latin / румынские ș ț ă / кириллица). Новые шрифты брать из npm `@fontsource-variable/*`.

### Подводные камни (уже решены — не наступать снова)
- Старый CSS (`.wrapper.main-ro h1/h2`, `span{font-weight:400}`) перебивает новые стили → для h1/h2 поднимать специфичность
  (`.lb-x .lb-x__wrap h2.lb-x__title`), веса задавать прямо на span. Проверка утечек — JS в `probe.py` (сравнить computed styles со старым CSS и без).
- Ресеты в блоках — только через `:where()`, иначе перебивают свои же классы.
- `transform` зарезервирован под GSAP; hover-сдвиги — через CSS-свойства `translate` / `scale`.
- В RU-контексте `$_modx->config['phone-1']` (ClientConfig) в Fenom пустой → телефон выводить MODX-тегом `[[++phone-1]]`.
- В tpl для pdoResources лексикон не подхвачен → в начале tpl `{$_modx->lexicon->load('babel:translate')}`.
- `lazy`-плагин добавляет `loading="lazy"` всем img без атрибута → у первого экрана ставить `loading="eager"`.
- webp-плагин подменяет jpg/png на `/webp/...` если файл есть — наши картинки сразу `.webp`.
- `span{font-weight:400}` из старого CSS бьёт и по служебным span внутри заголовков (строки H2 блока 4) — вес ставить на сами span.
- `.lb-x :where(a){color:inherit}` имеет специфичность (0,1,0) и перебивает `.lb-btn--solid` (цвет текста кнопки) — в новых блоках `color` в ресете ссылок не задавать.
- H2 с курсивом (`<em>București</em>, …`): `get_text(' ')` в bs4 даёт «București , …» — `seo_compare.py` нормализует пробел перед пунктуацией (так видит текст браузер).

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
6. **Перетекающий фон** на всех стыках (пользователь просит делать так между всеми блоками): баннер → 2 (`img/seam-hero.svg`), 2 → 3 (`img/seam.svg`), 3 → 4 (`img/seam-implica.svg`).
   Плюс 4 → 5 (`img/seam-consult.svg`). Всё в `scss/_seam.scss` (подключается последним): фоны блоков уходят в общий цвет стыка (маски фото + градиенты), шёлковая лента
   рисуется половинками в обоих блоках (`::before`/`::after`), контент — над ней (`z-index: 1`). Ленту под новый стык генерить
   `_dev/tools/make_seam.py OUT.svg "x:dy …"` — точки обходят фото и тексты соседних блоков.
7. **Блок «Micropigmentarea … implică» `lb-implica`** (`scss/_implica.scss`) — вместо `bl3-text` (условие `[[*title-main-bl3:notempty=…]]` сохранено).
   H2 — TV `title-main-bl3` (текст не менялся), разбивка на строки и курсив — лексикон `lbar.rd.implica.title`
   (`|` — перенос, `*…*` — курсив; если TV изменят и он перестанет совпадать — H2 выводится как есть). Карточки — TV `title/text-1..3-bl3`,
   иконки SVG, кнопки `.lb-btn--solid` («Programează-te» → `#bl8-form`) и ссылка с кругом-play на портфолио (100/198).
   Дуга — SVG-окружность (586, 603, r 435 @1920), точки на ней ставит JS по фактической высоте карточек; в RU блок выше 1080 —
   JS ставит `.is-tall`, низ фото растворяется. Анимация: прорисовка дуги, «выезд» строк H2, карточки справа, иконки, точки.
   Фон `img/implica-bg*.webp` (без текста/кнопок/карточек/дуги/логотипа), мобильный `implica-mobile.webp`. Сверка с макетом на 1920 — ±1–5px.
8. **Блок «Консультация» (форма) `lb-consult` + tpl формы `lb.formConsult`** (`scss/_consult.scss`) — вместо `bl4-form`. Заголовок — TV `main-title-bl4`
   (div, не H2 — как было), разбивка/курсив — лексикон `lbar.rd.consult.title`; подзаголовок — TV `sub-title-bl4`; кнопка — TV `link-form-bl4`.
   Форма — тот же вызов `[[!AjaxForm]]` (FormIt, хуки `spam,email,FormItSaveForm,GoogleSheetsSaveForm`, валидация), `id="form-bl4"` сохранён
   (на него завязаны якоря `#form-bl4` и редирект на «спасибо» в чанке `script`), поля/скрытые поля — как в `tpl.Form.Bl4`.
   Телефон — intlTelInput из чанка `inttelinput` (флаг, код, разделитель стилизованы; padding-left считает библиотека, при resize пересчёт в JS).
   Фон — `img/consult-bg.svg` (только графика). Старые `bl4-form`/`tpl.Form.Bl4` используются в шаблонах 8 и 19 — не трогаем.
   Локально отправка падает на PHP 8 (PHPMailer `__autoload`) — это окружение; валидация/AJAX проверены, на хостинге PHP 7 — работает как раньше.
   Для скриншотов с телефонным полем — `_dev/tools/shot5.py` (подставляет intl-tel-input из npm `/home/claude/iti`, внешние запросы в песочнице закрыты).

SQL-патчи, отданные пользователю: `lbar-full-stage-2026-11-06.sql.gz` (исходный дамп + адреса стейджа + шапка/баннер), `stage-lbar-02-about.sql`,
`stage-lbar-03-services.sql`, `stage-lbar-04-implica.sql` (новый чанк `lb-implica` id 274 + шаблон «Главная»),
`stage-lbar-05-consult.sql` (чанки `lb-consult` id 275, `lb.formConsult` id 276 + все чанки Redesign + шаблон «Главная»). Патчи проверены импортом.
После 05 БД **не менялась**.

## 5. Следующий шаг — блок 6 (по порядку шаблона: `[[$bl2-study-trener]]`, «Faceți cunoștință! Masterul dvs. – Ksenia Kobilianskaia»)

Макета пока нет — ждём от пользователя. Дальше по шаблону: `bl6-portfolio-front-page`, `bl7-price`, `bl8-form`, `bl9-reviews`,
`bl-faq`, `bl-seo`, `bl-blog`, `bl-contact`, `footer`. В `bl2-study-trener` есть кнопка-попап «Obțineți o consultație personală» (H2 попапа в SEO-эталоне) — не терять.
Формы — осторожно: id (`form-bl8`, `form-study-*`) и обработчики (AjaxForm, редирект в чанке `script`) не ломать. Стык 5 → 6 сделать по `_seam.scss`.

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

Блок 4 делался вариантом с координатами в системе 1920 (удобнее мерить по `ref1920.png`):
`grid.py IN OUT x1 y1 x2 y2 scale step` — кроп с сеткой координат; `clean4.py up2.png clean.png _dev/rects/block4-implica.json` — очистка
(прямоугольники в px 1920, маска дуги `arcmask.py`, логотип на фото — inpaint по маске букв); `cmp.py REF SHOT out [x1 y1 x2 y2]` — наложение/разница;
`tmeas.py` / `cardmeas.py` — замер строк заголовка и карточек; `shotcss.py` — скрин с подмешанным CSS (подбор шрифтов/размеров без пересборки);
`fontcmp.py` — сравнение шрифтов-кандидатов с макетом; `probe4.py` — позиции/стили элементов после анимации.
Скрипты в `_dev/tools` писались под конкретные блоки — пути (`/home/claude/sr`, `/home/claude/b4`, `/home/claude/tools`, …) поправить под себя.

## 7. Локальное окружение (новая сессия)

1. Подключить репо (`add_repo underproger/stage-lbar`, push), клонировать в `/home/claude/stage-lbar`.
2. Пользователь прикладывает дамп и патчи. В этот раз пришёл дамп хостинга `mysql_impua_testlbar_….tar.gz` (исходная база, без патчей) +
   `stage-lbar-urls.sql`, `-01-header-banner.sql`, `-02-about.sql`, `-03-services.sql`; плюс теперь `-04-implica.sql`.
3. `cd /home/claude/stage-lbar && bash _dev/setup_local.sh <дамп> <urls> <01> <02> <03> <04>` (файлы — по порядку; .tar.gz/.gz/.sql) — поднимет MariaDB, Apache+SSL, PHP-полифилл,
   конфиги из `_dev/local-config`, hosts (`stage-lbar.touchit.vinnica.ua` → 127.0.0.1), симлинк `/home/impua/lbar.ro/www` → репо.
4. После рестарта контейнера: `bash _dev/tools/up.sh`. Chrome для скриншотов запускать с `--no-proxy-server`, внешние запросы блокировать (так в `shot*.py`).
5. Хостинг, скорее всего, на PHP 7.x — **PHP 8 на сервере не включать** (MODX 2.8.1 падает).
