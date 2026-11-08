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
   Подписи колонок — прежние ключи lbar.price.table.title*. Длинная цена («100% din prețul…») переносится.
   Таблица — общий чанк lb.ptable (он же на странице «Цены»). *}
{set $title = $_modx->resource['title-bl7'] | trim}
{set $fmt = 'lbar.rd.price.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
{set $rows = $_modx->resource['table-res-bl7'] | trim}
{set $intro = $_modx->resource['table-bl7'] | trim}
{set $sel = $_modx->resource['table_select'] | trim}
{set $mode = ($sel | ematch : '/two-col/') ? 'two' : (($sel | ematch : '/three-col-bl7/') ? 'three' : (($sel | ematch : '/without-top/') ? 'notop' : 'full'))}
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
            {$_modx->getChunk('lb.ptable', ['rows' => $_modx->resource['table-res-bl7'], 'mode' => $mode, 'label' => $title, 'uid' => 'p'])}
        </div>
        {/if}
    </div>
</section>
