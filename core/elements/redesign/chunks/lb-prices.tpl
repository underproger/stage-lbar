{* Страница «Цены» (шаблон «Цены», id 14) — вместо таблиц в banner-interial-price.
   Текст над таблицами — TV description-banner-inerial (короткий — до 300 знаков — показывает баннер lb-shero, здесь не дублируется).
   Таблицы — прежние TV table-price-N (N = 1…6), над каждой H2 — TV title-price-N (как раньше), под ним — TV text-price-N.
   Колонки — как в старом чанке: 1–3 — длительность col-2 + цена col-4 (пусто — col-3), 4 — длительность + цена col-3, 5–6 — цена col-2.
   Таблица — общий чанк lb.ptable (вид блока «Цены» главной). Кнопка — запись (#bl8-form). *}
{set $r = $_modx->resource}
{set $intro = $r['description-banner-inerial'] | trim}
{if ($intro | striptags | trim | length) <= 300}{set $intro = ''}{/if}
{set $modes = [1 => 'notop', 2 => 'notop', 3 => 'notop', 4 => 'dur3', 5 => 'two2', 6 => 'two2']}
{set $arr = '<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-prices" id="lb-prices">
    <div class="lb-prices__bg" aria-hidden="true"></div>
    <div class="lb-prices__inner">
        {if $intro}
        <div class="lb-prices__intro">{$intro}</div>
        {/if}
        {foreach 1..6 as $i}
        {set $rows = $r['table-price-' ~ $i] | trim}
        {if $rows && $rows != '[]'}
        {set $t = $r['title-price-' ~ $i] | trim}
        <div class="lb-prices__group">
            <div class="lb-prices__head">
                <span class="lb-prices__num" aria-hidden="true">0{$i}</span>
                {if $t}<h2 class="lb-prices__title">{$_modx->getChunk('lb.accent', ['t' => $t])}</h2>{/if}
                {if $r['text-price-' ~ $i] | trim}<div class="lb-prices__text">{$r['text-price-' ~ $i]}</div>{/if}
                <a class="lb-btn lb-btn--solid lb-prices__cta js-lb-book" href="#bl8-form">{'lbar.prices.button.book' | lexicon}{$arr}</a>
            </div>
            <div class="lb-price__card lb-prices__card">
                {$_modx->getChunk('lb.ptable', ['rows' => $rows, 'mode' => $modes[$i], 'label' => $t, 'uid' => $i])}
            </div>
        </div>
        {/if}
        {/foreach}
    </div>
</section>
