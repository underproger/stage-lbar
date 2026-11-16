{* Удаление тату (шаблон «Категория NEW», шаг 62): «Цена на примерах» — под таблицей цен, внутри старого блока bl5-service-prices.
   Данные — TV ресурса: tz_price_examples-title (заголовок H3) и MIGX tz_price_examples (до 6 фото — image, image2…image6, что удаляем, цена,
   примечание; в админке — вкладка «Блок 5 - Цены»). Шаг 77: у карточки свой слайдер фото (стрелки и точки; свайп листает ленту карточек,
   а не фото — на телефоне лента сама прокручивается пальцем); фото — по клику крупно (fancybox, галерея карточки). Пока фото нет —
   графическая заглушка. Под лентой — «пришлите фото в WhatsApp» и кнопка (номер — настройка whatsapp, ссылка wa.me с готовым текстом).
   Стили — scss/_tzex.scss; слайдеры и подсказка «листайте» — redesign.js. Вызов — в bl5-service-prices (TV tz_price_examples :notempty → этот чанк).
   Внимание: MODX-теги в этом комментарии не писать — MODX разбирает их раньше Fenom (вызов самого себя → рекурсия, шаг 62). *}
{set $r = $_modx->resource}
{set $list = ($r['tz_price_examples'] ?: '[]') | fromJSON}
{set $title = $r['tz_price_examples-title'] | trim}
{set $foto = 'lbar.rd.tzex.photo' | lexicon}
{if $list}
<div class="lb-tzex">
    {if $title}<h3 class="lb-tzex__title">{$title}</h3>{/if}
    <ul class="lb-tzex__list">
        {foreach $list as $k => $it}
        {set $name = $it.title | trim}
        {set $imgs = []}
        {foreach ['image', 'image2', 'image3', 'image4', 'image5', 'image6'] as $f}
            {set $src = $it[$f] | trim}
            {if $src}
                {if !($src | ematch : '~^(/|https?:)~')}{set $src = '/' ~ $src}{/if}
                {set $imgs[] = $src}
            {/if}
        {/foreach}
        {set $n = $imgs | length}
        <li class="lb-tzex__item">
            {if $n}
            <div class="lb-tzex__media{if $n > 1} lb-tzex__media--slider{/if}"{if $n > 1} data-count="{$n}"{/if}>
                <div class="lb-tzex__track">
                    {foreach $imgs as $i => $src}
                    <a class="lb-tzex__photo" href="{$src}" data-fancybox="lb-tzex-{$k}" data-caption="{($name ~ ' — ' ~ ($it.price | trim)) | escape}"{if $i} tabindex="-1"{/if}>
                        <img src="{$src}" alt="{($n > 1 ? $name ~ ' — ' ~ $foto ~ ' ' ~ ($i + 1) : $name) | escape}" width="600" height="600" loading="lazy" decoding="async">
                    </a>
                    {/foreach}
                </div>
                {if $n > 1}
                <button class="lb-tzex__nav lb-tzex__nav--prev" type="button" aria-label="{'lbar.rd.tzex.prev' | lexicon}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m14.5 6-6 6 6 6"/></svg></button>
                <button class="lb-tzex__nav lb-tzex__nav--next" type="button" aria-label="{'lbar.rd.tzex.next' | lexicon}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9.5 6 6 6-6 6"/></svg></button>
                <div class="lb-tzex__dots">
                    {foreach $imgs as $i => $src}<button class="lb-tzex__dot{if !$i} is-active{/if}" type="button" aria-label="{$foto} {$i + 1}"{if !$i} aria-current="true"{/if}></button>{/foreach}
                </div>
                {/if}
            </div>
            {else}
            <div class="lb-tzex__media lb-tzex__media--empty" aria-hidden="true">
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
    {* точная оценка — по фото в WhatsApp (шаг 77): номер — из настройки whatsapp (там ссылка whatsapp://send?phone=…), ссылка — wa.me
       с готовым текстом сообщения (открывается и на компьютере — в WhatsApp Web) *}
    {set $wa = $_modx->config['whatsapp'] | ereplace : '~\D+~' : ''}
    {if $wa}
    <div class="lb-tzex__cta">
        <p class="lb-tzex__cta-text">{'lbar.rd.tzex.cta.text' | lexicon}</p>
        <a class="lb-btn lb-btn--solid lb-tzex__wa" href="https://wa.me/{$wa}?text={'lbar.rd.tzex.cta.msg' | lexicon | escape : 'url' | replace : '+' : '%20'}" target="_blank" rel="nofollow noopener noreferrer">
            <svg class="lb-tzex__wa-ico" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.87 1.21 3.07c.15.2 2.1 3.2 5.08 4.48.71.31 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35zM12.04 21.5h-.01a9.45 9.45 0 0 1-4.82-1.32l-.35-.21-3.58.94.96-3.49-.23-.36a9.43 9.43 0 0 1-1.45-5.03c0-5.22 4.25-9.47 9.48-9.47 2.53 0 4.91.99 6.7 2.78a9.41 9.41 0 0 1 2.77 6.7c0 5.22-4.25 9.46-9.47 9.46zm8.07-17.54A11.33 11.33 0 0 0 12.04.62C5.75.62.63 5.74.63 12.03c0 2.01.52 3.97 1.52 5.7L.53 23.62l6.04-1.58a11.4 11.4 0 0 0 5.46 1.39h.01c6.29 0 11.41-5.12 11.41-11.41 0-3.05-1.19-5.91-3.34-8.07z"/></svg>
            <span>{'lbar.rd.tzex.cta.btn' | lexicon}</span>
        </a>
    </div>
    {/if}
</div>
{/if}
