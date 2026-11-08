{* Карточка подуслуги на странице услуги (tpl pdoResources в lb-subservices) — вид карточки услуг главной (lb-scard).
   Данные — как в старом tpl.category.main: фото TV im-category (alt — alt-im-category), название TV title-bl2, текст TV intro-text-bl2. *}
{$_modx->lexicon->load('babel:translate')}
{set $title = $_pls['tv.title-bl2'] ?: $menutitle ?: $pagetitle}
{* у EN путь картинки TV (источник файлов) приходит с base_url контекста «/en/» — файл лежит от корня *}
{set $img = $_pls['tv.im-category'] | ereplace : '~^/en/(?=(?:images|assets)/)~' : '/'}
<article class="lb-scard">
    <a class="lb-scard__img" href="{$uri}" aria-label="{$title | escape}">
        {if $img}<img src="{$img}" alt="{($_pls['tv.alt-im-category'] ?: $title) | escape}" width="420" height="400" loading="lazy" decoding="async">{/if}
    </a>
    <div class="lb-scard__body">
        <div class="lb-scard__num" aria-hidden="true">{$idx < 10 ? '0' : ''}{$idx}</div>
        <div class="lb-scard__title"><a href="{$uri}">{$title}</a></div>
        <div class="lb-scard__text">{$_pls['tv.intro-text-bl2']}</div>
        <a class="lb-btn lb-btn--ghost lb-btn--sm lb-scard__btn" href="{$uri}">{'lbar.buttons.category.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
    </div>
</article>
