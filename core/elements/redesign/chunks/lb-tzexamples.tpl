{* Удаление тату (шаблон «Категория NEW», шаг 62): «Цена на примерах» — под таблицей цен, внутри старого блока bl5-service-prices.
   Данные — TV ресурса: tz_price_examples-title (заголовок H3) и MIGX tz_price_examples (фото, что удаляем, цена, примечание; в админке —
   вкладка «Блок 5 - Цены»). Пока фото не загружено — графическая заглушка. Фото — по клику крупно (fancybox, как галерея страницы).
   Стили — scss/_tzex.scss. Вызов — в bl5-service-prices (TV tz_price_examples :notempty → этот чанк).
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
                <p class="lb-tzex__name">{$name}</p>
                <p class="lb-tzex__price">{$it.price | trim}</p>
                {if $it.note | trim}<p class="lb-tzex__note">{$it.note | trim}</p>{/if}
            </div>
        </li>
        {/foreach}
    </ul>
</div>
{/if}
