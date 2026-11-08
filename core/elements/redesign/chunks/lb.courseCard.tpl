{* Карточка курса (tpl pdoResources в lb-courses). Фото — TV im-category (alt — alt-im-category), название — TV title-bl2
   (как в старом tpl.category.study), текст — TV intro-text-bl2 или подзаголовок баннера курса sub-title-2-banner-study,
   пункты — text-1..4-banner-study (преимущества из баннера курса). Ссылка — страница курса. *}
{$_modx->lexicon->load('babel:translate')}
{set $title = ($_pls['tv.title-bl2'] | trim) ?: ($menutitle ?: $pagetitle)}
{set $src = $_pls['tv.im-category'] | trim}
{if $src && !($src | ematch : '~^(/|https?:)~')}{set $src = '/' ~ $src}{/if}
{set $text = ($_pls['tv.intro-text-bl2'] | trim) ?: ($_pls['tv.sub-title-2-banner-study'] | trim)}
<article class="lb-course">
    <a class="lb-course__img" href="{$uri}" aria-label="{$title | escape}">
        {if $src}<img src="{$src | replace : ' ' : '%20'}" alt="{($_pls['tv.alt-im-category'] ?: $title) | escape}" width="760" height="560" loading="lazy" decoding="async">{/if}
    </a>
    <div class="lb-course__body">
        <div class="lb-course__num" aria-hidden="true">{$idx < 10 ? '0' : ''}{$idx}</div>
        <div class="lb-course__title"><a href="{$uri}">{$title}</a></div>
        {if $text}<p class="lb-course__text">{$text}</p>{/if}
        <ul class="lb-course__list">
            {foreach 1..4 as $i}
            {set $it = $_pls['tv.text-' ~ $i ~ '-banner-study'] | trim}
            {if $it}<li class="lb-course__li">{$it}</li>{/if}
            {/foreach}
        </ul>
        <a class="lb-btn lb-btn--solid lb-course__btn" href="{$uri}">{'lbar.buttons.category.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
    </div>
</article>
