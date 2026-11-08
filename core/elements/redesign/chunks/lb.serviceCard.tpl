{* Карточка услуги (pdoResources tpl). Фото — из макета для трёх услуг главной, для остальных — TV im-category. *}
{$_modx->lexicon->load('babel:translate')}
{set $map = [2 => 'brows', 303 => 'brows', 1002 => 'brows', 162 => 'eyeliner', 317 => 'eyeliner', 1162 => 'eyeliner', 167 => 'lips', 319 => 'lips', 1167 => 'lips']}
{set $title = $_pls['tv.title-bl2'] ?: $menutitle ?: $pagetitle}
{set $src = $map[$id] ? ('/assets/templates/redesign/img/service-' ~ $map[$id] ~ '.webp') : $_pls['tv.im-category']}
<article class="lb-scard">
    <a class="lb-scard__img" href="{$uri}" aria-label="{$title | escape}">
        <img src="{$src}" alt="{($_pls['tv.alt-im-category'] ?: $title) | escape}" width="498" height="483" loading="lazy" decoding="async">
    </a>
    <div class="lb-scard__body">
        <div class="lb-scard__num" aria-hidden="true">{$idx < 10 ? '0' : ''}{$idx}</div>
        <div class="lb-scard__title"><a href="{$uri}">{$title}</a></div>
        <div class="lb-scard__text">{$_pls['tv.intro-text-bl2']}</div>
        <a class="lb-btn lb-btn--ghost lb-btn--sm lb-scard__btn" href="{$uri}">{'lbar.buttons.category.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
    </div>
</article>
