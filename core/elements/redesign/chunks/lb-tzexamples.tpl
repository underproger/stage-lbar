{* Удаление тату (шаблон «Категория NEW», шаг 62): «Цена на примерах» — под таблицей цен, внутри старого блока bl5-service-prices.
   Данные — TV ресурса: tz_price_examples-title (заголовок H3) и MIGX tz_price_examples (фото, что удаляем, цена, примечание; в админке —
   вкладка «Блок 5 - Цены»). Пока фото не загружено — графическая заглушка. Фото — по клику крупно (fancybox, как галерея страницы).
   Стили — scss/_tzex.scss; подсказка «листайте» под лентой гаснет после прокрутки (redesign.js). Вызов — в bl5-service-prices (TV tz_price_examples :notempty → этот чанк).
   Внимание: MODX-теги в этом комментарии не писать — MODX разбирает их раньше Fenom (вызов самого себя → рекурсия, шаг 62). *}
{set $r = $_modx->resource}
{set $list = ($r['tz_price_examples'] ?: '[]') | fromJSON}
{set $title = $r['tz_price_examples-title'] | trim}
{if $list}
<div class="lb-tzex">
    {if $title}<h3 class="lb-tzex__title">{$title}</h3>{/if}
    <ul class="lb-tzex__list">
        {foreach $list as $it}
        {set $src = $it.image | trim}
        {if $src && !($src | ematch : '~^(/|https?:)~')}{set $src = '/' ~ $src}{/if}
        {set $name = $it.title | trim}
        <li class="lb-tzex__item">
            {if $src}
            <a class="lb-tzex__photo" href="{$src}" data-fancybox="lb-tzex" data-caption="{($name ~ ' — ' ~ ($it.price | trim)) | escape}">
                <img src="{$src}" alt="{$name | escape}" width="300" height="300" loading="lazy" decoding="async">
            </a>
            {else}
            <div class="lb-tzex__photo lb-tzex__photo--empty" aria-hidden="true">
                <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="9" width="34" height="30" rx="5"/><circle cx="18" cy="20" r="3.5"/><path d="m9 35 10-10 7 7 5-5 8 8"/></svg>
            </div>
            {/if}
            <div class="lb-tzex__body">
                <p class="lb-tzex__name">{$name | replace : ' cm' : '&nbsp;cm'}</p>{* «5 cm²» не рвётся по строкам *}
                <p class="lb-tzex__price">{$it.price | trim}</p>
                {if $it.note | trim}<p class="lb-tzex__note">{$it.note | trim}</p>{/if}
            </div>
        </li>
        {/foreach}
    </ul>
    {* подсказка «листайте» — видна только на телефоне / планшете, где лента прокручивается (шаг 63) *}
    <div class="lb-tzex__hint" aria-hidden="true">
        <svg class="lb-tzex__hint-arr" viewBox="0 0 68 12" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 6h65M60 1l6 5-6 5"/></svg>
        <svg class="lb-tzex__hint-hand" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13V4.5a1.75 1.75 0 0 1 3.5 0V11"/><path d="M13.5 10.5a1.75 1.75 0 0 1 3.5 0V12"/><path d="M17 11.5a1.75 1.75 0 0 1 3.5 0v3.5a7 7 0 0 1-7 7h-1.6a6.5 6.5 0 0 1-4.9-2.2l-3.4-3.9a1.8 1.8 0 0 1 2.6-2.5L10 15.2"/></svg>
    </div>
</div>
{/if}
