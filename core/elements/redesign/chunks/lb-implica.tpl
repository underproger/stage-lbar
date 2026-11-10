{* Блок «Micropigmentarea … implică:» (редизайн, 4-й экран главной).
   Тексты — прежние TV: title-main-bl3 (H2), title-1..3-bl3, text-1..3-bl3.
   Разбивка H2 на строки и курсив — из лексикона lbar.rd.implica.title: «|» — перенос строки, *слово* — курсив.
   Если TV заголовка изменят и он перестанет совпадать с лексиконом, заголовок выводится как есть (без разбивки и курсива).
   Страницы услуг (вместо bl3-text, модификатор --svc): заголовок — курсив после тире / двоеточия (lb.accent), надзаголовков нет
   (на главной «LBAR STUDIO» тоже убран), вместо иконок — номера 01–03 (как в старом блоке); фото — TV im-1-bl3 (alt — alt-im-1-bl3)
   в круге на месте фото главной (--photo), фон — тон блока; нет фото — фон главной (implica-bg-v2 — кадр пользователя).
   Кнопка с «плеем» — видео студии на YouTube в окне fancybox (подключён в старом main.js), текст — lbar.rd.implica.video. *}
{set $title = $_modx->resource['title-main-bl3'] | trim}
{set $fmt = 'lbar.rd.implica.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
{set $video = 'https://www.youtube.com/watch?v=2xwQU_Vt1ys'}
{set $img = '/assets/templates/redesign/img/'}
{set $svc = $_modx->resource.id != $_modx->config.site_start}
{set $photo = $svc ? ('[[*im-1-bl3]]' | trim) : ''}
{set $icons = [
    1 => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.15" stroke-linejoin="round"><path d="M14.5 10h19l7.5 9.5L24 39 7 19.5 14.5 10z"/><path d="M7 19.5h34M14.5 10l5 9.5L24 10l4.5 9.5 5-9.5M19.5 19.5 24 39l4.5-19.5"/></svg>',
    2 => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.15" stroke-linecap="round" stroke-linejoin="round"><path d="M24 7.5 37.5 12v10.2c0 8.6-5.6 15.3-13.5 18.3-7.9-3-13.5-9.7-13.5-18.3V12L24 7.5z"/><path d="m17.6 24.1 4.6 4.5 8.4-8.8"/></svg>',
    3 => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" stroke-linejoin="round"><g transform="matrix(1.14 0 0 1.3 -3.4 -8)"><path d="M24 13c4 4 5.5 9 5.5 13 0 4.5-2.2 8-5.5 10.5-3.3-2.5-5.5-6-5.5-10.5 0-4 1.5-9 5.5-13z"/><path d="M24 36.5c-6-1-10-5.5-10.4-17 3.6 1 6 2.5 7.4 4.5M24 36.5c6-1 10-5.5 10.4-17-3.6 1-6 2.5-7.4 4.5"/><path d="M18.7 34.8c-6.7.7-11.2-2.3-13.7-7.3 3-.9 6-.9 9.2.1M29.3 34.8c6.7.7 11.2-2.3 13.7-7.3-3-.9-6-.9-9.2.1"/></g></svg>'
]}
<section class="lb-implica{$svc ? ' lb-implica--svc' : ''}{$photo ? ' lb-implica--photo' : ''}" id="lb-implica">
    <div class="lb-implica__bg">
        {if $photo}
        <img class="lb-implica__photo" src="/{$photo | replace : ' ' : '%20'}" alt="{('[[*alt-im-1-bl3]]' | trim) | escape}" width="850" height="850" loading="lazy" decoding="async">
        {else}
        <picture>
            <source media="(max-width: 1024px)" srcset="{$img}implica-mobile-v2.webp" width="840" height="861">
            <img src="{$img}implica-bg-v2.webp" srcset="{$img}implica-bg-v2-1440.webp 1440w, {$img}implica-bg-v2.webp 2166w" sizes="100vw" width="2166" height="1218" alt="{'lbar.rd.implica.alt' | lexicon}" loading="lazy" decoding="async">
        </picture>
        {/if}
    </div>

    <svg class="lb-implica__arc" viewBox="0 0 1920 1080" aria-hidden="true">
        <defs>
            <linearGradient id="lb-implica-arc" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#9f6e50" stop-opacity=".08"/>
                <stop offset=".14" stop-color="#9f6e50" stop-opacity=".55"/>
                <stop offset=".3" stop-color="#9f6e50" stop-opacity=".95"/>
                <stop offset=".8" stop-color="#9f6e50" stop-opacity=".9"/>
                <stop offset="1" stop-color="#9f6e50" stop-opacity="0"/>
            </linearGradient>
        </defs>
        <path class="lb-implica__arcline" d="M903.8 306A435 435 0 0 1 878.5 925" stroke="url(#lb-implica-arc)"/>
    </svg>

    <div class="lb-implica__col">

        {if $title}
        <h2 class="lb-implica__title">
            {if $plain == $title}
            {foreach ($fmt | split : '|') as $line}
            <span class="lb-implica__line"><span class="lb-implica__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
            {/foreach}
            {else}
            <span class="lb-implica__line"><span class="lb-implica__lin">{$_modx->getChunk('lb.accent', ['t' => $title])}</span></span>
            {/if}
        </h2>
        {/if}

        <ul class="lb-implica__list">
            {foreach 1..3 as $i}
            {set $name = $_modx->resource['title-' ~ $i ~ '-bl3']}
            {if $name}
            <li class="lb-implica__item lb-implica__item--{$i}">
                <span class="lb-implica__dot" aria-hidden="true"></span>
                <span class="lb-implica__ic" aria-hidden="true">{if $svc}<span class="lb-implica__num">0{$i}</span>{else}{$icons[$i]}{/if}</span>
                <div class="lb-implica__body">
                    <div class="lb-implica__name">{$name}</div>
                    <p class="lb-implica__text">{$_modx->resource['text-' ~ $i ~ '-bl3']}</p>
                </div>
            </li>
            {/if}
            {/foreach}
        </ul>

        <div class="lb-implica__btns">
            <a class="lb-btn lb-btn--solid lb-implica__cta js-lb-book" href="#bl8-form">{'lbar.rd.implica.cta' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
            <a class="lb-implica__play" href="{$video}" data-fancybox="lb-video">
                <span class="lb-implica__playic" aria-hidden="true"><svg viewBox="0 0 12 14"><path fill="currentColor" d="M1.5 1.6v10.8c0 .5.5.8.9.5l8.6-5.4c.4-.2.4-.8 0-1L2.4 1.1c-.4-.3-.9 0-.9.5z"/></svg></span>
                <span class="lb-implica__playtxt">{'lbar.rd.implica.video' | lexicon}</span>
            </a>
        </div>
    </div>
</section>
