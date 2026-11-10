{* Баннер страниц услуг (шаблон «Категория», id 8) — вместо banner-interial-category(-with-img) и breadcrumb-wrap. По макету.
   Тексты — прежние TV ресурса, без правок:
   - надзаголовка нет (был suptitle-banner главной — убран вместе со всеми eyebrow);
   - H1 — title-banner: первое слово прямо, остальное курсивом (только разметка, текст H1 тот же);
   - подзаголовок — sub-title-banner;
   - description-banner: 2–3 строки (по <br> / <p>) до 80 символов — список с отметками (шаг 57: и короткие строки — тоже списком,
     как у остальных услуг; колонки с иконками lb-shero__feats — только у удаления тату), иначе (длинный текст, 4+ строк) — выводится
     как было, HTML из TV.
   Фото — TV img_banner_main. Если его нет — фото родителя (подразделы бровей); если фото нет и у родителя — графическая подложка.
   Плашки title/description-banner-categoty-1/2 на фото (были у страниц без своего фото) — убраны по просьбе пользователя (шаг 57).
   Кнопки — прежние: запись (#bl8-form), консультация (#conract). Хлебные крошки — pdoCrumbs с прежними параметрами и микроразметкой.
   Общие страницы (режим hub): «Услуги» / «Обучение» (шаблоны «Услуги — общая» и «Внутренняя - Обучение»), «Внутренняя» (3),
   портфолио (10, 13), «Цены» (14), «Отзывы» (16), список статей блога (4) — вместо banner-interial:
   H1 — pagetitle (как в banner-interial), под ним — TV description-banner-inerial (до 300 знаков; длиннее — в lb-pgallery),
   хлебные крошки — без exclude (как в banner-interial). Кнопок нет (в banner-interial их не было, шаг 45);
   фото — только своё, без фото — простой баннер: фон, H1, текст, крошки, без графики справа (lb-shero--simple, шаг 45).
   Статья блога (5) баннера не имеет — H1, крошки и сведения выводит lb-article (шаг 45).
   Удаление тату (шаблон «Удаление тату», шаг 54, вызов с &tz=`1`): как у услуги, но TV старого баннера banner-interial-category-new —
   H1 title-banner-study, подзаголовок sub-title-2-banner-study, 4 преимущества text-1…4-banner-study (колонки с иконками, 2 × 2);
   надзаголовок sub-title-1-banner-study не выводится (без eyebrow, как везде).
   Внимание: в выражениях Fenom не писать «*» + «/» подряд (закрывает служебный комментарий в скомпилированном шаблоне). *}
{set $r = $_modx->resource}
{* параметр &tz из вызова чанка в шаблоне: MODX-плейсхолдер подставляется до Fenom (без параметра остаётся «[[+tz]]» → не 1) *}
{set $tz = ('[[+tz]]' == '1')}
{set $hub = $r.template != 8 && !$tz}
{set $t = ($hub ? $r.pagetitle : ($tz ? $r['title-banner-study'] : $r['title-banner'])) | trim}
{set $first = $t | ereplace : '~\s.*$~s' : ''}
{set $rest = $t | ereplace : '~^\S+\s*~' : ''}

{* преимущества *}
{set $desc = $hub ? '' : ($r['description-banner'] | trim)}
{set $items = []}
{set $max = 0}
{if $desc}
{foreach ($desc | ereplace : '~<br[^>]*>|</p>|</li>|</div>~i' : '|' | striptags | ereplace : '~\s+~u' : ' ' | split : '|') as $it}
{set $it = $it | trim}
{if $it}{set $items[] = $it}{if ($it | length) > $max}{set $max = $it | length}{/if}{/if}
{/foreach}
{/if}
{if $tz}
{set $items = []}
{foreach [1, 2, 3, 4] as $k}{set $it = $r['text-' ~ $k ~ '-banner-study'] | striptags | trim}{if $it}{set $items[] = $it}{/if}{/foreach}
{/if}
{set $n = $items | length}
{set $mode = $tz ? ($n ? 'cols' : '') : (($n >= 2 && $n <= 3) ? ($max <= 80 ? 'list' : 'html') : ($desc ? 'html' : ''))}

{* фото: своё → родителя → нет *}
{set $own = $_modx->getResource($r.id, ['includeTVs' => 'img_banner_main', 'processTVs' => 1, 'tvPrefix' => '', 'select' => 'id,parent'])}
{set $photo = $own.img_banner_main | trim}
{if !$photo && $r.parent && !$hub}
{set $par = $_modx->getResource($r.parent, ['includeTVs' => 'img_banner_main', 'processTVs' => 1, 'tvPrefix' => '', 'select' => 'id'])}
{set $photo = $par.img_banner_main | trim}
{/if}
{set $alt = $t | striptags}
{set $simple = $hub && !$photo}

{set $ico = [
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 32c2-11 9-19 24-24-1 15-9 22-20 24-1.3.2-2.7.2-4 0z"/><path d="M8 32 22 18"/><path d="M15 25h7M19 21v-5"/></svg>',
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 4 33 9v9c0 9-5.6 15.4-13 18-7.4-2.6-13-9-13-18V9z"/><path d="m14 20 4.5 4.5L27 16"/></svg>',
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="9" width="28" height="25" rx="3"/><path d="M6 16h28M13 5v7M27 5v7"/><path d="M13 22h.01M20 22h.01M27 22h.01M13 28h.01M20 28h.01M27 28h.01" stroke-width="2.6"/></svg>'
]}
{* удаление тату: безопасность, время сеанса, кожа без следов, любой тип тату *}
{if $tz}
{set $ico = [
    $ico[1],
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="20" cy="21" r="14"/><path d="M20 12v9l6 4"/><path d="M16 4h8"/></svg>',
    $ico[0],
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 4v8M20 28v8M4 20h8M28 20h8M8.7 8.7l5.6 5.6M25.7 25.7l5.6 5.6M31.3 8.7l-5.6 5.6M14.3 25.7l-5.6 5.6"/><circle cx="20" cy="20" r="3"/></svg>'
]}
{/if}
{set $arr = '<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-shero{if !$photo} lb-shero--art{/if}{if $hub} lb-shero--hub{/if}{if $simple} lb-shero--simple{/if}" id="lb-shero">
    <div class="lb-shero__bg" aria-hidden="true"></div>

    {if !$simple}
    <div class="lb-shero__media">
        <div class="lb-shero__frame" aria-hidden="true"></div>
        <div class="lb-shero__photo">
            {if $photo}
            <img src="/{$photo}" alt="{$alt}" loading="eager" fetchpriority="high" decoding="async">
            {/if}
        </div>
    </div>
    {/if}

    <div class="lb-shero__inner">
        <div class="lb-shero__content">
            <h1 class="lb-shero__title"><span class="lb-shero__t1">{$first}</span>{if $rest} <span class="lb-shero__t2">{$rest}</span>{/if}</h1>
            {if $hub}
            {* длинный текст (у мастеров — биография, 1–2 тыс. знаков) в баннер не помещается — его выводит блок под баннером (lb-pgallery) *}
            {set $hdesc = $r['description-banner-inerial'] | trim}
            {if $hdesc && ($hdesc | striptags | trim | length) <= 300}<div class="lb-shero__desc">{$hdesc}</div>{/if}
            {elseif $tz}{if $r['sub-title-2-banner-study'] | trim}<p class="lb-shero__sub">{$r['sub-title-2-banner-study']}</p>{/if}
            {elseif $r['sub-title-banner'] | trim}<p class="lb-shero__sub">{$r['sub-title-banner']}</p>{/if}

            {if $mode == 'cols'}
            {set $nic = $ico | length}
            <ul class="lb-shero__feats{($n > 3) ? ' lb-shero__feats--4' : ''}">
                {foreach $items as $i => $it}
                <li class="lb-shero__feat"><span class="lb-shero__ico">{$ico[$i % $nic]}</span><span class="lb-shero__feat-t">{$it}</span></li>
                {/foreach}
            </ul>
            {elseif $mode == 'list'}
            <ul class="lb-shero__list">
                {foreach $items as $it}
                <li class="lb-shero__li">{$it}</li>
                {/foreach}
            </ul>
            {elseif $mode == 'html'}
            <div class="lb-shero__desc">{$desc}</div>
            {/if}

            {if !$hub}
            <div class="lb-shero__btns">
                <a class="lb-btn lb-btn--solid js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}{$arr}</a>
                <a class="lb-btn lb-btn--ghost" href="#conract">{'lbar.buttons.banner.consultation' | lexicon}{$arr}</a>
            </div>
            {/if}
        </div>

        <nav class="lb-crumbs" aria-label="{'lbar.rd.aria.crumbs' | lexicon}">
            {$_modx->runSnippet('!pdoCrumbs', [
                'showHome' => 1,
                'showAtHome' => 0,
                'exclude' => $hub ? '' : '80,60',
                'tplWrapper' => '@INLINE <ol class="lb-crumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">[[+output]]</ol>',
                'tplHome' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link lb-crumbs__link--home" href="[[+link]]" itemprop="item"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.2 10 3l7 6.2"/><path d="M5 8v9h4v-5h2v5h4V8"/></svg><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                'tpl' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link" href="[[+link]]" itemprop="item"><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                'tplCurrent' => '@INLINE <li class="lb-crumbs__item lb-crumbs__item--current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">[[+menutitle]]</span><div itemprop="item" content="[[++site_url]][[+link]]"></div><meta itemprop="position" content="[[+idx]]" /></li>',
            ])}
        </nav>
    </div>
</section>
