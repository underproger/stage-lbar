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
