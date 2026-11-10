{* Блок «О микропигментации» (редизайн, 2-й экран главной; на страницах услуг — вместо bl1-about-us).
   Заголовок и текст — прежние TV: title_bl1_about, text_bl1_about.
   Часть заголовка после тире выводится курсивом. Текст свёрнут до 3 строк (на услугах — до 7).
   Надзаголовков (eyebrow) нет — убраны по просьбе пользователя, как во всех блоках.
   Страницы услуг (модификатор --svc): без преимуществ и цитаты главной; фото — TV img_bl1_about
   (если задано — поверх фото фона в той же рамке; если нет — фото фона). Фон с фото в рамке — кадр пользователя (about-bg-v2 / about-mobile-v2,
   _dev/hero2/make_about.py), печати «Studio LBar» нет. «Citește mai mult» — под текстом.
   Удаление тату (шаблон «Удаление тату», шаг 54, вызов с &tz=`1`): TV старого блока bl1-about-service — заголовок
   bl1_about_service-title (был H2 — остаётся H2; span.gold-word — только оформление, текст тот же), текст text_1, подзаголовок title_2
   (H3, если заполнен) + text_2, примечание text_3; фото — bl1_about_service-img. *}
{* параметр &tz из вызова чанка в шаблоне: MODX-плейсхолдер подставляется до Fenom (без параметра остаётся «[[+tz]]» → не 1) *}
{set $tz = ('[[+tz]]' == '1')}
{set $r = $_modx->resource}
{set $title = ($tz ? ($r['bl1_about_service-title'] | striptags) : $r['title_bl1_about']) | trim}
{set $dash = ''}
{if ' — ' in $title}{set $dash = '—'}{elseif ' – ' in $title}{set $dash = '–'}{/if}
{set $tp = ($dash ? ($title | split : (' ' ~ $dash ~ ' ')) : [$title])}
{if $tz}
{set $t2 = $r['bl1_about_service-title_2'] | striptags | trim}
{set $text = ($r['bl1_about_service-text_1'] | trim) ~ ($t2 ? ('<h3>' ~ $t2 ~ '</h3>') : '') ~ ($r['bl1_about_service-text_2'] | trim) ~ ($r['bl1_about_service-text_3'] | trim)}
{else}
{set $text = $r['text_bl1_about']}
{/if}
{set $img = '/assets/templates/redesign/img/'}
{set $svc = $_modx->resource.id != $_modx->config.site_start}
{set $photo = $tz ? ($r['bl1_about_service-img'] | trim | ereplace : '~^/+~' : '') : ($svc ? ('[[*img_bl1_about]]' | trim) : '')}
<div id="bl1"></div>
<section class="lb-about{$svc ? ' lb-about--svc' : ''}" id="lb-about">
    <div class="lb-about__bg">
        <picture>
            <source media="(max-width: 1024px)" srcset="{$img}about-mobile-v2.webp" width="840" height="1090">
            <img src="{$img}about-bg-v2.webp" srcset="{$img}about-bg-v2-1440.webp 1440w, {$img}about-bg-v2.webp 2166w" sizes="100vw" width="2166" height="1218" alt="{$photo ? '' : ('lbar.rd.about.alt' | lexicon)}" loading="lazy" decoding="async">
        </picture>
        {if $photo}
        <img class="lb-about__photo" src="/{$photo | replace : ' ' : '%20'}" alt="{$title | escape}" width="540" height="850" loading="lazy" decoding="async">
        {/if}
    </div>

    <div class="lb-about__col">
        {if $title}
        <{$tz ? 'h2' : 'div'} class="lb-about__title{($svc && ($title | length) > 40) ? ' lb-about__title--long' : ''}">
            {if $tp | length > 1}
            <span class="lb-about__t1">{$tp[0]}&nbsp;{$dash}</span>
            <span class="lb-about__t2">{$tp[1]}</span>
            {else}
            <span class="lb-about__t1">{$title}</span>
            {/if}
        </{$tz ? 'h2' : 'div'}>
        {/if}

        {if $text}
        <div class="lb-about__textwrap">
            <div class="lb-about__text" id="lb-about-text">{$text}</div>
            <button class="lb-about__more" type="button" aria-controls="lb-about-text" aria-expanded="false">
                <span class="lb-about__moretxt">{'lbar.rd.about.more' | lexicon}</span><span class="lb-about__less">{'lbar.rd.about.less' | lexicon}</span>
                <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 4.5 6 8l3.5-3.5"/></svg>
            </button>
        </div>
        {/if}

        {if !$svc}
        <ul class="lb-about__list">
            <li class="lb-about__item">
                <span class="lb-about__ic" aria-hidden="true"><svg viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"><path d="M7 29 27 9"/><path d="M27.5 8.5c-5.5-1.8-13.4.8-16.6 7.8-1.6 3.4-1.7 7-1.3 9.9 3 .5 6.6.2 10-1.4 7-3.3 9.6-11 7.9-16.3z"/><path d="M12.5 21h6.5M15.5 17.5h6M19 14h4.5"/></svg></span>
                <span class="lb-about__label">{'lbar.rd.about.f1' | lexicon}</span>
            </li>
            <li class="lb-about__item">
                <span class="lb-about__ic" aria-hidden="true"><svg viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="18" r="12.5"/><path d="M18 10.5V18l5 4"/></svg></span>
                <span class="lb-about__label">{'lbar.rd.about.f2' | lexicon}</span>
            </li>
            <li class="lb-about__item">
                <span class="lb-about__ic" aria-hidden="true"><svg viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="1.35" stroke-linejoin="round"><path d="M13 13c.5 4.6 2.9 7 7.5 7.5-4.6.5-7 2.9-7.5 7.5-.5-4.6-2.9-7-7.5-7.5 4.6-.5 7-2.9 7.5-7.5z"/><path d="M24.5 6c.3 2.9 1.8 4.4 4.7 4.7-2.9.3-4.4 1.8-4.7 4.7-.3-2.9-1.8-4.4-4.7-4.7 2.9-.3 4.4-1.8 4.7-4.7z"/></svg></span>
                <span class="lb-about__label">{'lbar.rd.about.f3' | lexicon}</span>
            </li>
        </ul>

        <div class="lb-about__quote">
            <svg class="lb-about__qmark" viewBox="0 0 55 44" aria-hidden="true"><path fill="currentColor" d="M12.6 44C5.3 44 0 38.6 0 31.4 0 19.6 9.6 6.4 22.3 0l2.2 3.3C16.8 8.2 12 14.6 11.3 20.4c.7-.2 1.5-.3 2.3-.3 6.4 0 11.3 5 11.3 11.7S19.8 44 12.6 44zm30.1 0c-7.3 0-12.6-5.4-12.6-12.6C30.1 19.6 39.7 6.4 52.4 0l2.2 3.3C46.9 8.2 42.1 14.6 41.4 20.4c.7-.2 1.5-.3 2.3-.3 6.4 0 11.3 5 11.3 11.7S49.9 44 42.7 44z"/></svg>
            <p class="lb-about__qtext">{'lbar.rd.about.quote' | lexicon}</p>
        </div>
        {/if}

        <a class="lb-btn lb-btn--solid lb-about__cta" href="#form-bl4">{'lbar.rd.about.cta' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
    </div>
</section>
