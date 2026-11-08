{* Блок «Цены» (редизайн, 8-й экран главной) — вместо bl7-price (условие [[*title-bl7:notempty=…]] в шаблоне сохранено).
   H2 — TV title-bl7 (текст не менялся); разбивка на строки и курсив — лексикон lbar.rd.price.title
   («|» — перенос, *…* — курсив); если TV изменят и он перестанет совпадать — H2 выводится как есть.
   Текст над таблицей — TV table-bl7 (свёрнут до 3 строк + «Citește mai mult»). Таблица — MIGX TV table-res-bl7:
   col-1 — процедура (часть в скобках выводится второй строкой), col-2 — длительность, цена — col-4 (TOP Trainer, как в
   выбранной на главной таблице «3 колонки, без топ-мастера»), если пусто — col-3. Иконки — по ключевым словам названия.
   Кнопка — прежний текст lbar.prices.button.book, якорь #bl8-form (на других страницах — попап, js-lb-book).
   Страницы услуг: вид таблицы — по TV table_select, как в старом bl7-price: «3 колонки без топ-мастера» — как на главной;
   table-defult-bl7 (по умолчанию) — длительность + две цены (TOP Master col-3 / TOP Trainer col-4); table-three-col-bl7 —
   две цены (col-2 / col-3, «за сеанс» / «8 сеансов»), без длительности; table-two-col-bl7 — одна цена (col-3).
   Подписи колонок — прежние ключи lbar.price.table.title*. Длинная цена («100% din prețul…») переносится. *}
{set $title = $_modx->resource['title-bl7'] | trim}
{set $fmt = 'lbar.rd.price.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
{set $rows = ($_modx->resource['table-res-bl7'] ?: '[]') | fromJSON}
{set $intro = $_modx->resource['table-bl7'] | trim}
{set $sel = $_modx->resource['table_select'] | trim}
{if $sel | ematch : '/two-col/'}
    {set $mode = 'two'}{set $pcols = [['col-3', 'lbar.price.table.title5']]}
{elseif $sel | ematch : '/three-col-bl7/'}
    {set $mode = 'three'}{set $pcols = [['col-2', 'lbar.price.table.title6'], ['col-3', 'lbar.price.table.title7']]}
{elseif $sel | ematch : '/without-top/'}
    {set $mode = 'notop'}{set $pcols = [['col-4', 'lbar.price.table.title5']]}
{else}
    {set $mode = 'full'}{set $pcols = [['col-3', 'lbar.price.table.title3'], ['col-4', 'lbar.price.table.title4']]}
{/if}
{set $hasDur = $mode == 'notop' || $mode == 'full'}
{set $ic = [
    'brow' => '<svg viewBox="0 0 80 40"><defs><linearGradient id="lb-pi-brow" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#b98a6a" stop-opacity=".25"/><stop offset=".35" stop-color="#8d5a3c"/><stop offset="1" stop-color="#7a4528"/></linearGradient></defs><path fill="url(#lb-pi-brow)" d="M6 27.5c8.5-6.6 19.6-11 31.7-12.2 11.6-1.1 22.6.6 31.9 5.7 2.6 1.4 4.6 3.1 6 5.2.5.8-.4 1.7-1.2 1.2-8.2-5.3-18.1-7.6-28.7-7.1-13.1.6-25.4 4.7-37 9.5-1.8.7-3.9-.9-2.7-2.3z"/><path fill="none" stroke="#a7795a" stroke-opacity=".5" stroke-width=".9" stroke-linecap="round" d="M10 27.2 12.6 22M15 25.6l2.4-5.6M20 23.8l2-5.6M25 22.3l1.6-5.6"/></svg>',
    'eye' => '<svg viewBox="0 0 80 40" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 21c7.9-8.6 19-13 34-13s26.1 4.4 34 13c-7.9 8.3-19 12.5-34 12.5S13.9 29.3 6 21z"/><circle cx="40" cy="20.5" r="8.4"/><circle cx="40" cy="20.5" r="3.6" fill="currentColor" stroke="none"/><path d="M57 11.6 60 6.8M63 14.2l4-4.2M68 17.6l4.6-3M3.5 22.4 6 21l3.4 1.1"/><path d="M74 21c1.7.6 3.2 1.7 4.4 3.2" stroke-width="1.3"/></svg>',
    'lashes' => '<svg viewBox="0 0 80 40" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M8 15.5c8.6 7.6 19.4 11.4 32 11.4s23.4-3.8 32-11.4"/><path d="M14.5 21.5 11 26.5M21 25l-2.6 5.4M28.2 27.6l-1.5 5.7M36 28.8v5.8M44 28.8v5.8M51.8 27.6l1.5 5.7M59 25l2.6 5.4M65.5 21.5l3.5 5"/></svg>',
    'lips' => '<svg viewBox="0 0 80 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round"><path d="M5 20.5c6.6-6.8 13.2-11.6 20-11.6 5.6 0 10 2.6 15 2.6s9.4-2.6 15-2.6c6.8 0 13.4 4.8 20 11.6-8.2 7.8-20 12-35 12s-26.8-4.2-35-12z"/><path d="M5 20.5c11 1.6 22.6 2.4 35 .2 12.4 2.2 24 1.4 35-.2"/></svg>',
    'retouch' => '<svg viewBox="0 0 80 40" fill="currentColor"><circle cx="40" cy="6" r="1.5"/><circle cx="40" cy="34" r="1.5"/><circle cx="26" cy="20" r="1.5"/><circle cx="54" cy="20" r="1.5"/><circle cx="30.5" cy="10.5" r="1.3"/><circle cx="49.5" cy="10.5" r="1.3"/><circle cx="30.5" cy="29.5" r="1.3"/><circle cx="49.5" cy="29.5" r="1.3"/><circle cx="40" cy="13" r="1.1"/><circle cx="40" cy="27" r="1.1"/><circle cx="33" cy="20" r="1.1"/><circle cx="47" cy="20" r="1.1"/><circle cx="35" cy="15" r=".9"/><circle cx="45" cy="25" r=".9"/><circle cx="45" cy="15" r=".9"/><circle cx="35" cy="25" r=".9"/><circle cx="20" cy="13" r="1"/><circle cx="60" cy="27" r="1"/><circle cx="21" cy="28" r=".9"/><circle cx="59" cy="12" r=".9"/></svg>',
    'laser' => '<svg viewBox="0 0 80 40" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><path d="M40 3v10M40 27v10M23 20h10M47 20h10M28 8.5l7 7M45 24.5l7 7M52 8.5l-7 7M35 24.5l-7 7"/><path d="M38 17.5 40 20l2.5-2" stroke-width="1.3"/></svg>',
    'drop' => '<svg viewBox="0 0 80 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M40 5c5.6 7.2 9.5 13 9.5 18.2a9.5 9.5 0 0 1-19 0C30.5 18 34.4 12.2 40 5z"/></svg>'
]}
{* иконка — по первому совпадению ключевого слова в названии процедуры (RO / RU) *}
{set $keys = [
    ['/sprânc|spranc|бров/iu', 'brow'],
    ['/buze|губ/iu', 'lips'],
    ['/pleoap|intergen|межреснич|ресниц/iu', 'lashes'],
    ['/ochi|săgeț|sageti|eyeliner|глаз|век/iu', 'eye'],
    ['/îndepărt|indepart|laser|удален|лазер/iu', 'laser'],
    ['/retu|corect|remover|коррекц|ремувер/iu', 'retouch']
]}
{set $clock = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9.6"/><path d="M12 6.8V12l3.6 2.4"/></svg>'}
<section class="lb-price{($_modx->resource.id != $_modx->config.site_start) ? ' lb-price--svc' : ''}" id="lb-price">
    <div class="lb-price__bg" aria-hidden="true">
        <svg class="lb-price__lines" viewBox="0 0 1920 1080" preserveAspectRatio="none">
            <defs>
                <linearGradient id="lb-price-line" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#c9a38a" stop-opacity=".1"/>
                    <stop offset=".4" stop-color="#c9a38a" stop-opacity=".8"/>
                    <stop offset="1" stop-color="#c9a38a" stop-opacity=".05"/>
                </linearGradient>
                <linearGradient id="lb-price-silk" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#fff" stop-opacity="0"/>
                    <stop offset=".35" stop-color="#fff" stop-opacity=".7"/>
                    <stop offset="1" stop-color="#fff" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <path class="lb-price__silk" d="M-20 742C120 760 230 818 330 900S540 1040 720 1088L520 1088C390 1060 300 990 220 925S80 812-20 800Z" fill="url(#lb-price-silk)"/>
            <path class="lb-price__line" d="M-20 742C120 760 230 818 330 900S540 1040 720 1088" stroke="url(#lb-price-line)"/>
            <path class="lb-price__line lb-price__line--thin" d="M-20 800C80 812 160 852 220 925S390 1060 520 1088" stroke="url(#lb-price-line)"/>
        </svg>
    </div>

    <div class="lb-price__intro">
        {if $title}
        <h2 class="lb-price__title">
            {if $plain == $title}
            {foreach ($fmt | split : '|') as $line}
            <span class="lb-price__line-t"><span class="lb-price__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
            {/foreach}
            {else}
            <span class="lb-price__line-t"><span class="lb-price__lin">{$_modx->getChunk('lb.accent', ['t' => $title])}</span></span>
            {/if}
        </h2>
        {/if}
        <a class="lb-btn lb-btn--solid lb-price__cta js-lb-book" href="#bl8-form">{'lbar.prices.button.book' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
    </div>

    <div class="lb-price__main{$intro ? '' : ' lb-price__main--notext'}">
        {if $intro}
        <div class="lb-price__textwrap">
            <div class="lb-price__text" id="lb-price-text">{$intro}</div>
            <button class="lb-price__more" type="button" aria-controls="lb-price-text" aria-expanded="false">
                <span class="lb-price__moretxt">{'lbar.rd.about.more' | lexicon}</span><span class="lb-price__less">{'lbar.rd.about.less' | lexicon}</span>
                <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2.5 4.5 6 8l3.5-3.5"/></svg>
            </button>
        </div>
        {/if}

        {if $rows}
        <div class="lb-price__card">
            {* таблица — div с ARIA-ролями: старый custom.js клонирует все <table> (resTables) и прячет их на мобильном *}
            <div class="lb-ptable lb-ptable--{$mode}" role="table" aria-label="{$title | escape}">
                <div class="lb-ptable__head" role="row">
                    <div class="lb-ptable__h lb-ptable__h--name" role="columnheader"><span>{'lbar.price.table.title1' | lexicon}</span><i class="lb-ptable__orn" aria-hidden="true"><svg viewBox="0 0 20 20"><path fill="currentColor" d="M10 0c.5 5.3 4.2 9.3 10 10-5.8.7-9.5 4.7-10 10-.5-5.3-4.2-9.3-10-10C5.8 9.3 9.5 5.3 10 0z"/></svg></i></div>
                    {if $hasDur}<div class="lb-ptable__h lb-ptable__h--dur" role="columnheader">{'lbar.price.table.title2' | lexicon}</div>{/if}
                    {foreach $pcols as $pc}
                    <div class="lb-ptable__h lb-ptable__h--price" role="columnheader">{$pc[1] | lexicon}</div>
                    {/foreach}
                </div>
                <div class="lb-ptable__body" role="rowgroup">
                    {foreach $rows as $row}
                    {set $full = $row['col-1'] | trim}
                    {set $name = $full | ereplace : '/\s*\([^()]*\)\s*$/u' : ''}
                    {set $sub = ($name != $full) ? ($full | ereplace : '/^.*?(\([^()]*\))\s*$/u' : '$1') : ''}
                    {set $price = ($row['col-4'] | trim) ?: ($row['col-3'] | trim)}
                    {set $icon = 'drop'}
                    {foreach $keys as $kw}
                    {if $full | ematch : $kw[0]}{set $icon = $kw[1]}{break}{/if}
                    {/foreach}
                    <div class="lb-ptable__row" role="row">
                        <div class="lb-ptable__name" role="cell">
                            <span class="lb-ptable__ic lb-ptable__ic--{$icon}" aria-hidden="true">{$ic[$icon]}</span>
                            <span class="lb-ptable__proc"><b>{$name}</b>{if $sub}<span class="lb-ptable__sub">{$sub}</span>{/if}</span>
                        </div>
                        {if $hasDur}<div class="lb-ptable__dur" role="cell">{if $row['col-2']}<span class="lb-ptable__clock" aria-hidden="true">{$clock}</span>{$row['col-2']}{/if}</div>{/if}
                        {foreach $pcols as $pc}
                        {set $pv = ($mode == 'notop') ? $price : ($row[$pc[0]] | trim)}
                        <div class="lb-ptable__price{($pv | length) > 12 ? ' lb-ptable__price--long' : ''}" role="cell"{if ($pcols | length) > 1} data-label="{$pc[1] | lexicon | striptags | escape}"{/if}>{$pv | ereplace : '/(\d)(?=(\d{3})+(?!\d))/u' : '$1&nbsp;'}</div>
                        {/foreach}
                    </div>
                    {/foreach}
                </div>
            </div>
        </div>
        {/if}
    </div>
</section>
