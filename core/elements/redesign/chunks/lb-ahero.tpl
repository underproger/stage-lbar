{* Страница «О нас» (шаблон «О нас», шаг 47): первый экран + бегущая строка. Структура и тексты — по макету пользователя
   (LBAR Despre noi), оформление — в стиле сайта (шкала заголовков lb-h, контейнер lb-wrap, кнопки lb-btn, крошки lb-crumbs).
   Тексты — лексикон lbar.rd.ab.* (источник — _dev/about/ab.py). H1 — из макета (согласовано): прежний H1 (pagetitle)
   выводится H2 в карточке «О студии» (lb-areasons). Надзаголовков нет (как на всём сайте).
   Слева: крошки (pdoCrumbs, как в баннере общих страниц), H1, вводный текст, три цифры, кнопки «Записаться» (#bl8-form) и
   «Смотреть работы» (портфолио 100 / 198 / 1100). Справа — фото в арке (вырезка img/hero-master-v2*.webp, как на главной)
   с подписью. Фон — только графика: тон, контур «2016», две арки справа. Бегущая строка — CSS-анимация (второй список —
   копия для бесшовного цикла, скрыт от экранных чтецов). *}
{$_modx->lexicon->load('babel:translate')}
{set $ck = $_modx->config.cultureKey}
{set $pfs = ['ro' => 100, 'ru' => 198, 'en' => 1100]}
{set $pf = $pfs[$ck] ?: 100}
{set $arr = '<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-ahero" id="lb-ahero">
    <div class="lb-ahero__bg" aria-hidden="true">
        <span class="lb-ahero__year">2016</span>
        <span class="lb-ahero__arch"></span>
        <span class="lb-ahero__arch lb-ahero__arch--in"></span>
    </div>

    <div class="lb-ahero__inner">
        <div class="lb-ahero__content">
            <nav class="lb-crumbs lb-crumbs--flow" aria-label="{'lbar.rd.aria.crumbs' | lexicon}">
                {$_modx->runSnippet('!pdoCrumbs', [
                    'showHome' => 1,
                    'showAtHome' => 0,
                    'tplWrapper' => '@INLINE <ol class="lb-crumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">[[+output]]</ol>',
                    'tplHome' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link lb-crumbs__link--home" href="[[+link]]" itemprop="item"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.2 10 3l7 6.2"/><path d="M5 8v9h4v-5h2v5h4V8"/></svg><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                    'tpl' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link" href="[[+link]]" itemprop="item"><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                    'tplCurrent' => '@INLINE <li class="lb-crumbs__item lb-crumbs__item--current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">[[+menutitle]]</span><div itemprop="item" content="[[++site_url]][[+link]]"></div><meta itemprop="position" content="[[+idx]]" /></li>',
                ])}
            </nav>
            <h1 class="lb-ahero__title"><span class="lb-ahero__t1">{'lbar.rd.ab.hero.h1a' | lexicon}</span> <span class="lb-ahero__t2">{'lbar.rd.ab.hero.h1b' | lexicon}</span></h1>
            <p class="lb-ahero__lead">{'lbar.rd.ab.hero.lead' | lexicon}</p>
            <ul class="lb-ahero__stats">
                {foreach [1, 2, 3] as $i}
                <li class="lb-ahero__stat"><span class="lb-ahero__sn">{('lbar.rd.ab.hero.s' ~ $i ~ 'n') | lexicon}</span><span class="lb-ahero__sl">{('lbar.rd.ab.hero.s' ~ $i ~ 'l') | lexicon}</span></li>
                {/foreach}
            </ul>
            <div class="lb-ahero__btns">
                <a class="lb-btn lb-btn--solid js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}{$arr}</a>
                <a class="lb-btn lb-btn--ghost" href="{$pf | url}">{'lbar.rd.ab.hero.works' | lexicon}{$arr}</a>
            </div>
        </div>

        <figure class="lb-ahero__media">
            <span class="lb-ahero__frame" aria-hidden="true"></span>
            <span class="lb-ahero__photo">
                <img src="/assets/templates/redesign/img/hero-master-v2.webp" srcset="/assets/templates/redesign/img/hero-master-v2.webp 570w, /assets/templates/redesign/img/hero-master-v2-2x.webp 1140w" sizes="(max-width: 1024px) 90vw, 30vw" width="570" height="760" alt="{'lbar.rd.ab.name' | lexicon}" loading="eager" fetchpriority="high" decoding="async">
            </span>
            <figcaption class="lb-ahero__card"><span class="lb-ahero__name">{'lbar.rd.ab.name' | lexicon}</span><span class="lb-ahero__role">{'lbar.rd.ab.hero.role' | lexicon}</span></figcaption>
            <svg class="lb-ahero__spark" viewBox="0 0 20 20" aria-hidden="true"><path d="M10 0c.8 6.5 3.5 9.2 10 10-6.5.8-9.2 3.5-10 10-.8-6.5-3.5-9.2-10-10 6.5-.8 9.2-3.5 10-10z"/></svg>
        </figure>
    </div>
</section>

<div class="lb-ticker">
    <div class="lb-ticker__track">
        {foreach [0, 1] as $copy}
        <ul class="lb-ticker__list"{if $copy} aria-hidden="true"{/if}>
            {foreach [1, 2, 3, 4, 5, 6] as $i}
            <li class="lb-ticker__item{if $i % 2 == 0} lb-ticker__item--accent{/if}">{('lbar.rd.ab.tick.' ~ $i) | lexicon}</li>
            {/foreach}
        </ul>
        {/foreach}
    </div>
</div>
