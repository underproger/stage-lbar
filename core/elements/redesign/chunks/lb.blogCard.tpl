{* Карточка статьи в списке блога (tpl pdoPage в lb-bloglist). Данные — как в старом tpl.subcat.blog: превью TV img-blog-prew
   (нет — настройка img-blog-prew-default), рубрика — родитель, название — menutitle или pagetitle, просмотры — TV HitsPage,
   число комментариев — EasyComm ветки статьи (как было), анонс — introtext. Значки «видео» / «галерея» — TV video-icon / gallery-icon. *}
{$_modx->lexicon->load('babel:translate')}
{set $img = ($_pls['tv.img-blog-prew'] | trim) ?: ('[[++img-blog-prew-default]]' | trim)}
{if $img && !($img | ematch : '~^(/|https?:)~')}{set $img = '/' ~ $img}{/if}
{set $title = $menutitle ?: $pagetitle}
<article class="lb-bcard">
    <a class="lb-bcard__img" href="{$uri}" tabindex="-1" aria-hidden="true">
        {if $img}<img src="{$img | replace : ' ' : '%20'}" alt="{$title | escape}" width="600" height="400" loading="lazy" decoding="async">{/if}
        {if $_pls['tv.video-icon'] || $_pls['tv.gallery-icon']}
        <span class="lb-bcard__badges">
            {if $_pls['tv.video-icon']}<span class="lb-bcard__badge"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13c0 .6.6.9 1.1.6l10-6.5c.5-.3.5-1 0-1.3l-10-6.5C8.6 4.6 8 4.9 8 5.5z"/></svg></span>{/if}
            {if $_pls['tv.gallery-icon']}<span class="lb-bcard__badge"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2.5"/><circle cx="9" cy="10" r="1.8"/><path d="m21 16-5-5-8 8"/></svg></span>{/if}
        </span>
        {/if}
    </a>
    <div class="lb-bcard__body">
        <div class="lb-bcard__meta">
            <a class="lb-bcard__cat" href="{$parent | url}">{$_modx->runSnippet('pdoField', ['id' => $parent, 'field' => 'pagetitle'])}</a>
            <span class="lb-bcard__stat"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>{$_pls['tv.HitsPage'] ?: 0}</span>
        </div>
        <div class="lb-bcard__title"><a href="{$uri}">{$title}</a></div>
        {if $introtext}<p class="lb-bcard__text">{$introtext}</p>{/if}
        <div class="lb-bcard__foot">
            <a class="lb-bcard__stat lb-bcard__comments" href="{$uri}#review"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.5 14.5a2 2 0 0 1-2 2H8l-4.5 4V5.5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z"/></svg>[[!ecMessagesCount? &tpl=`tpl.ecThreadRating.BlogList` &thread=`resource-[[+id]]`]]</a>
            <a class="lb-btn lb-btn--ghost lb-btn--sm lb-bcard__btn" href="{$uri}">{'lbar.buttons.category.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
        </div>
    </div>
</article>
