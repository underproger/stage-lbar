{* Удаление тату (шаблон «Удаление тату», шаг 54): «Цены» — вместо bl5-service-prices, в виде блока «Цены» услуг (lb-price).
   H2 — TV bl5_services_prices-title (span.gold-word → курсив, текст тот же). TV bl5_services_prices-table — HTML: текст до таблицы
   выводится над карточкой (свёрнут до 3 строк + «Читать далее»; выделение цветом из TV → жирный), таблица разбирается на строки
   и выводится общим чанком lb.ptable (div + ARIA-роли — старый custom.js клонирует все <table>), подписи колонок — из шапки таблицы TV.
   Пустая цена — «—». Кнопка «Записаться» — как в блоке «Цены» услуг. *}
{set $r = $_modx->resource}
{set $title = $r['bl5_services_prices-title'] | trim | replace : '<span class="gold-word">' : '<em>' | replace : '</span>' : '</em>'}
{set $html = $r['bl5_services_prices-table'] | trim}
{set $intro = $html | ereplace : '~<table.*$~si' : '' | ereplace : '~<span[^>]*background[^>]*>(.*?)</span>~si' : '<b>$1</b>' | ereplace : '~</?span[^>]*>~i' : '' | trim}
{set $heads = []}
{set $rows = []}
{if $html | ematch : '~<table~i'}
{set $hpart = $html | ereplace : '~^.*?<thead[^>]*>(.*?)</thead>.*$~si' : '$1'}
{foreach ($hpart | split : '</th>') as $c}
{set $c = $c | striptags | replace : '&nbsp;' : ' ' | replace : ' ' : ' ' | ereplace : '~\s+~u' : ' ' | trim}
{if $c}{set $heads[] = $c}{/if}
{/foreach}
{set $bpart = $html | ereplace : '~^.*?<tbody[^>]*>(.*?)</tbody>.*$~si' : '$1'}
{foreach ($bpart | split : '</tr>') as $tr}
{set $cells = []}
{foreach ($tr | split : '</td>') as $c}
{set $cells[] = $c | striptags | replace : '&nbsp;' : ' ' | replace : ' ' : ' ' | ereplace : '~\s+~u' : ' ' | trim}
{/foreach}
{if $cells[0]}{set $rows[] = ['col-1' => $cells[0], 'col-2' => ($cells[1] ?: '—'), 'col-3' => ($cells[2] ?: '—'), 'col-4' => '']}{/if}
{/foreach}
{/if}
<section class="lb-price lb-price--svc lb-price--tz" id="lb-price">
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
        <h2 class="lb-price__title"><span class="lb-price__line-t"><span class="lb-price__lin">{$title}</span></span></h2>
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
            {$_modx->getChunk('lb.ptable', ['rows' => ($rows | toJSON), 'mode' => 'three', 'label' => ($title | striptags), 'uid' => 'tz', 'hl1' => ($heads[0] ?: ''), 'hl2' => ($heads[1] ?: ''), 'hl3' => ($heads[2] ?: '')])}
        </div>
        {/if}
    </div>
</section>
