{* Таблица цен (div + ARIA-роли: старый custom.js клонирует все <table> и прячет их на мобильном) — общая для блока «Цены»
   (lb-price: главная, страницы услуг) и страницы «Цены» (lb-prices). Параметры:
   rows — JSON MIGX-таблицы (col-1 — процедура, часть в скобках — второй строкой; col-2…col-4 — по виду таблицы);
   mode — вид: notop (длительность col-2 + цена col-4, пусто — col-3), full (длительность + TOP Master col-3 + TOP Trainer col-4),
   three (цена col-2 «за сеанс» + col-3 «8 сеансов»), two (цена col-3), dur3 (длительность + цена col-3), two2 (цена col-2);
   label — подпись таблицы (aria-label); uid — суффикс id градиента иконки (несколько таблиц на странице).
   Подписи колонок — прежние ключи lbar.price.table.title*. Иконки — по ключевым словам названия. *}
{$_modx->lexicon->load('babel:translate')}
{set $rows = ($rows ?: '[]') | fromJSON}
{set $uid = $uid ?: '1'}
{if $mode == 'two'}
    {set $pcols = [['col-3', 'lbar.price.table.title5']]}{set $hasDur = false}{set $lay = 'two'}
{elseif $mode == 'two2'}
    {set $pcols = [['col-2', 'lbar.price.table.title5']]}{set $hasDur = false}{set $lay = 'two'}
{elseif $mode == 'three'}
    {set $pcols = [['col-2', 'lbar.price.table.title6'], ['col-3', 'lbar.price.table.title7']]}{set $hasDur = false}{set $lay = 'three'}
{elseif $mode == 'full'}
    {set $pcols = [['col-3', 'lbar.price.table.title3'], ['col-4', 'lbar.price.table.title4']]}{set $hasDur = true}{set $lay = 'full'}
{elseif $mode == 'dur3'}
    {set $pcols = [['col-3', 'lbar.price.table.title5']]}{set $hasDur = true}{set $lay = 'notop'}
{else}
    {set $mode = 'notop'}{set $pcols = [['col-4', 'lbar.price.table.title5']]}{set $hasDur = true}{set $lay = 'notop'}
{/if}
{set $ic = [
    'brow' => '<svg viewBox="0 0 80 40"><defs><linearGradient id="lb-pi-brow-' ~ $uid ~ '" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#b98a6a" stop-opacity=".25"/><stop offset=".35" stop-color="#8d5a3c"/><stop offset="1" stop-color="#7a4528"/></linearGradient></defs><path fill="url(#lb-pi-brow-' ~ $uid ~ ')" d="M6 27.5c8.5-6.6 19.6-11 31.7-12.2 11.6-1.1 22.6.6 31.9 5.7 2.6 1.4 4.6 3.1 6 5.2.5.8-.4 1.7-1.2 1.2-8.2-5.3-18.1-7.6-28.7-7.1-13.1.6-25.4 4.7-37 9.5-1.8.7-3.9-.9-2.7-2.3z"/><path fill="none" stroke="#a7795a" stroke-opacity=".5" stroke-width=".9" stroke-linecap="round" d="M10 27.2 12.6 22M15 25.6l2.4-5.6M20 23.8l2-5.6M25 22.3l1.6-5.6"/></svg>',
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
{if $rows}
<div class="lb-ptable lb-ptable--{$lay}" role="table" aria-label="{$label | striptags | escape}">
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
{/if}
