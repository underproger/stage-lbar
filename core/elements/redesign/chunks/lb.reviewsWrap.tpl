{* Обёртка ecMessages для блока «Отзывы» (tplWrapper): рейтинг ветки EasyComm + карусель карточек.
   Поля ветки: rating_simple (средняя оценка), count (число опубликованных отзывов); {$output} — карточки lb.reviewCard.
   Навигация (стрелки, точки) — JS (redesign.js): если карточки помещаются в ширину экрана — ряд без карусели. *}
{$_modx->lexicon->load('babel:translate')}
{set $lang = $_modx->config.cultureKey}
{set $n = $count | number_format : 0 : '' : ''}
{set $forms = $_modx->lexicon('lbar.rd.reviews.forms') | split : '|'}
{if $lang == 'ru'}
{set $word = $count | declension : $_modx->lexicon('lbar.rd.reviews.forms')}
{else}
{set $m = $count % 100}
{set $word = ($count == 1) ? $forms[0] : (($m >= 1 && $m <= 19) ? $forms[1] : $forms[2])}
{/if}
{set $star = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.4l2.95 6.02 6.63.95-4.8 4.67 1.13 6.6L12 17.52l-5.91 3.12 1.13-6.6-4.8-4.67 6.63-.95z"/></svg>'}
{if $output}
<div class="lb-reviews__pill">
    {* значок «Google Reviews» (как в макете); логотип — google-icon из набора @iconify-json/logos *}
    <div class="lb-reviews__google">
        <svg class="lb-reviews__g" viewBox="0 0 256 262" aria-hidden="true"><path fill="#4285f4" d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622l38.755 30.023l2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"/><path fill="#34a853" d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055c-34.523 0-63.824-22.773-74.269-54.25l-1.531.13l-40.298 31.187l-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"/><path fill="#fbbc05" d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82c0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602z"/><path fill="#eb4335" d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0C79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"/></svg>
        <span>{$_modx->lexicon('lbar.rd.reviews.google')}</span>
    </div>
    <span class="lb-reviews__sep" aria-hidden="true"></span>
    {if $rating_simple > 0}
    <div class="lb-reviews__score"><b class="lb-reviews__num">{$rating_simple | number_format : 1 : '.' : ''}</b><span class="lb-reviews__max">/5</span></div>
    <div class="lb-reviews__stars" role="img" aria-label="{$rating_simple | number_format : 1 : '.' : ''} {$_modx->lexicon('lbar.rd.reviews.of')} 5">
        {foreach 1..5 as $i}<span class="lb-reviews__star{if $i > ($rating_simple + 0.25)} is-off{/if}">{$star}</span>{/foreach}
    </div>
    <span class="lb-reviews__sep" aria-hidden="true"></span>
    {/if}
    <div class="lb-reviews__based">{$_modx->lexicon('lbar.rd.reviews.based')} {$n} {$word}</div>
</div>

<div class="lb-reviews__carousel" data-prev="{$_modx->lexicon('lbar.rd.reviews.prev')}" data-next="{$_modx->lexicon('lbar.rd.reviews.next')}" data-dot="{$_modx->lexicon('lbar.rd.reviews.dot')}" data-read="{$_modx->lexicon('lbar.rd.reviews.read')}">
    <div class="lb-reviews__viewport">
        <div class="lb-reviews__track">
            {$output}
        </div>
    </div>
    <div class="lb-reviews__nav">
        <button class="lb-reviews__arrow lb-reviews__arrow--prev" type="button" aria-label="{$_modx->lexicon('lbar.rd.reviews.prev')}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14.5 6.5 9 12l5.5 5.5"/></svg></button>
        <div class="lb-reviews__dots"></div>
        <button class="lb-reviews__arrow lb-reviews__arrow--next" type="button" aria-label="{$_modx->lexicon('lbar.rd.reviews.next')}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9.5 6.5 15 12l-5.5 5.5"/></svg></button>
    </div>
</div>
{/if}
