{* Баннер страниц услуг (шаблон «Категория», id 8) — вместо banner-interial-category(-with-img) и breadcrumb-wrap. По макету.
   Тексты — прежние TV ресурса, без правок:
   - надзаголовок — suptitle-banner главной (как в старом баннере);
   - H1 — title-banner: первое слово прямо, остальное курсивом (только разметка, текст H1 тот же);
   - подзаголовок — sub-title-banner;
   - description-banner: 2–3 строки (по <br> / <p>) до 40 символов — колонки с иконками (как в макете), до 80 — список с отметками,
     иначе (длинный текст, 4+ строк) — выводится как было, HTML из TV.
   Фото — TV img_banner_main. Если его нет — фото родителя (подразделы бровей), а на фото — две плашки
   title/description-banner-categoty-1/2 (в старом баннере без фото выводились они); если фото нет и у родителя — графическая подложка.
   Кнопки — прежние: запись (#bl8-form), консультация (#conract). Хлебные крошки — pdoCrumbs с прежними параметрами и микроразметкой.
   Общие страницы «Услуги» / «Обучение» (шаблоны «Услуги — общая» и «Внутренняя - Обучение», вместо banner-interial; режим hub):
   H1 — pagetitle (как в banner-interial), под ним — TV description-banner-inerial (до 300 знаков; длиннее — в lb-pgallery),
   фото — только своё (нет — графика),
   хлебные крошки — без exclude (как в banner-interial).
   Блог (шаблоны «Блог - список статей» 4 и «Блог - статья» 5) — тоже hub, без кнопки консультации (на этих страницах нет блока
   «Контакты»; запись — окно «Заказать звонок»). Статья: H1 с itemprop="headline" (страница обёрнута в itemscope Article в шаблоне),
   фото нет (превью статей маленькие — 360–760 px; графика, как у остальных общих страниц), под H1 — рубрика плашкой (itemprop="genre", как было),
   под ней карточка: дата, время чтения (слова content / 200), просмотры (HitsPage, как было), комментарии (ссылка на #review). Кнопки в баннере статьи нет
   (по макету пользователя; автор — в блоке под статьёй).
   Внимание: в выражениях Fenom не писать «*» + «/» подряд (закрывает служебный комментарий в скомпилированном шаблоне). *}
{set $r = $_modx->resource}
{set $isRo = $_modx->config.cultureKey == 'ro'}
{set $hub = $r.template != 8}
{set $blog = $r.template == 4 || $r.template == 5}
{set $art = $r.template == 5}
{set $t = ($hub ? $r.pagetitle : $r['title-banner']) | trim}
{set $first = $t | ereplace : '~\s.*$~s' : ''}
{set $rest = $t | ereplace : '~^\S+\s*~' : ''}
{set $eyebrow = $_modx->runSnippet('pdoField', ['id' => $_modx->config.site_start, 'field' => 'suptitle-banner']) | trim}

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
{set $n = $items | length}
{set $mode = ($n >= 2 && $n <= 3) ? ($max <= 40 ? 'cols' : ($max <= 80 ? 'list' : 'html')) : ($desc ? 'html' : '')}

{* фото: своё → родителя → нет *}
{set $own = $_modx->getResource($r.id, ['includeTVs' => 'img_banner_main', 'processTVs' => 1, 'tvPrefix' => '', 'select' => 'id,parent'])}
{set $photo = $own.img_banner_main | trim}
{set $badges = !$photo}
{if $blog}{set $badges = false}{/if}
{if !$photo && $r.parent && !$hub}
{set $par = $_modx->getResource($r.parent, ['includeTVs' => 'img_banner_main', 'processTVs' => 1, 'tvPrefix' => '', 'select' => 'id'])}
{set $photo = $par.img_banner_main | trim}
{/if}
{set $alt = $t | striptags}

{set $ico = [
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 32c2-11 9-19 24-24-1 15-9 22-20 24-1.3.2-2.7.2-4 0z"/><path d="M8 32 22 18"/><path d="M15 25h7M19 21v-5"/></svg>',
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 4 33 9v9c0 9-5.6 15.4-13 18-7.4-2.6-13-9-13-18V9z"/><path d="m14 20 4.5 4.5L27 16"/></svg>',
    '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="6" y="9" width="28" height="25" rx="3"/><path d="M6 16h28M13 5v7M27 5v7"/><path d="M13 22h.01M20 22h.01M27 22h.01M13 28h.01M20 28h.01M27 28h.01" stroke-width="2.6"/></svg>'
]}
{set $arr = '<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-shero{if !$photo} lb-shero--art{/if}{if $hub} lb-shero--hub{/if}{if $art} lb-shero--article{/if}" id="lb-shero">
    <div class="lb-shero__bg" aria-hidden="true"></div>

    <div class="lb-shero__media">
        <div class="lb-shero__frame" aria-hidden="true"></div>
        <div class="lb-shero__photo">
            {if $photo}
            <img src="/{$photo}" alt="{$alt}" loading="eager" fetchpriority="high" decoding="async">
            {/if}
        </div>
        {if $badges && ($r['title-banner-categoty-1'] | trim)}
        <ul class="lb-shero__badges">
            <li class="lb-shero__badge">
                <span class="lb-shero__badge-t">{$r['title-banner-categoty-1']}</span>
                {if $r['description-banner-categoty-1'] | trim}<span class="lb-shero__badge-d">{$r['description-banner-categoty-1'] | striptags}</span>{/if}
            </li>
            {if $r['title-banner-categoty-2'] | trim}
            <li class="lb-shero__badge">
                <span class="lb-shero__badge-t">{$r['title-banner-categoty-2']}</span>
                {if $r['description-banner-categoty-2'] | trim}<span class="lb-shero__badge-d">{$r['description-banner-categoty-2'] | striptags}</span>{/if}
            </li>
            {/if}
        </ul>
        {/if}
    </div>

    <div class="lb-shero__inner">
        <div class="lb-shero__content">
            {if $eyebrow}<p class="lb-shero__eyebrow">{$eyebrow}</p>{/if}
            <h1 class="lb-shero__title"{if $art} itemprop="headline"{/if}><span class="lb-shero__t1">{$first}</span>{if $rest} <span class="lb-shero__t2">{$rest}</span>{/if}</h1>
            {if $hub}
            {* длинный текст (у мастеров — биография, 1–2 тыс. знаков) в баннер не помещается — его выводит блок под баннером (lb-pgallery) *}
            {set $hdesc = $r['description-banner-inerial'] | trim}
            {if $hdesc && ($hdesc | striptags | trim | length) <= 300}<div class="lb-shero__desc">{$hdesc}</div>{/if}
            {elseif $r['sub-title-banner'] | trim}<p class="lb-shero__sub">{$r['sub-title-banner']}</p>{/if}

            {if $mode == 'cols'}
            <ul class="lb-shero__feats">
                {foreach $items as $i => $it}
                <li class="lb-shero__feat"><span class="lb-shero__ico">{$ico[$i % 3]}</span><span class="lb-shero__feat-t">{$it}</span></li>
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

            {if $art}
            {* время чтения: слова текста статьи / 200 в минуту, с округлением вверх (целочисленно: в Fenom нет ceil) *}
            {set $wc = $r.content | striptags | trim | esplit : '~\s+~u' | length}
            {set $min = ($wc + 199 - ($wc + 199) % 200) / 200}
            {set $si = ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"'}
            <a class="lb-shero__cat" href="{$r.parent | url}" itemprop="genre"><svg{$si}><path d="M3 12.2V4.5A1.5 1.5 0 0 1 4.5 3h7.7l8.8 8.8a1.5 1.5 0 0 1 0 2.1l-7.1 7.1a1.5 1.5 0 0 1-2.1 0z"/><circle cx="8" cy="8" r="1.6"/></svg>{$_modx->runSnippet('pdoField', ['id' => $r.parent, 'field' => 'pagetitle'])}</a>
            <ul class="lb-shero__stats">
                <li class="lb-shero__stat"><span class="lb-shero__sic"><svg{$si}><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4M7.5 13.5h.01M12 13.5h.01M16.5 13.5h.01M7.5 17h.01M12 17h.01"/></svg></span><span class="lb-shero__sv">{$r.publishedon | date : 'd.m.Y'}</span></li>
                <li class="lb-shero__stat"><span class="lb-shero__sic"><svg{$si}><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg></span><span class="lb-shero__sv">~ {$min} {'lbar.rd.blog.min' | lexicon}</span></li>
                <li class="lb-shero__stat"><span class="lb-shero__sic"><svg{$si}><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg></span><span class="lb-shero__st"><span class="lb-shero__sv lb-shero__sv--num">[[!HitsPage? &saveTv=`true`]]</span><span class="lb-shero__sl">{'lbar.rd.blog.views' | lexicon}</span></span></li>
                <li class="lb-shero__stat"><a href="#review"><span class="lb-shero__sic"><svg{$si}><path d="M20.5 14.5a2 2 0 0 1-2 2H8l-4.5 4V5.5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z"/></svg></span><span class="lb-shero__st"><span class="lb-shero__sv">[[!ecMessagesCount]]</span><span class="lb-shero__sl">{'lbar.rd.blog.ncomments' | lexicon}</span></span></a></li>
            </ul>
            {else}
            <div class="lb-shero__btns">
                <a class="lb-btn lb-btn--solid js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}{$arr}</a>
                {if !$blog}<a class="lb-btn lb-btn--ghost" href="#conract">{'lbar.buttons.banner.consultation' | lexicon}{$arr}</a>{/if}
            </div>
            {/if}
        </div>

        <nav class="lb-crumbs" aria-label="{$isRo ? 'Navigare' : 'Навигация'}">
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
