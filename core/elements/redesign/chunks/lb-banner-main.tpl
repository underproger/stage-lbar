{* Главный баннер (редизайн).
   H1 берётся из TV title-banner. Строки разделяются символом «|»: «Micropigmentare|premium|în București».
   Без «|» заголовок выводится одной строкой. Подзаголовок — TV suptitle-banner. *}
{set $tb = $_modx->resource['title-banner'] | trim}
{set $parts = $tb | split : '|'}
{set $isRo = $_modx->config.cultureKey == 'ro'}
{set $img = '/assets/templates/redesign/img/'}
<section class="lb-hero" id="lb-hero">
    <div class="lb-hero__bg">
        <picture>
            <source media="(max-width: 1024px)" srcset="{$img}hero-mobile.webp" width="1060" height="1100">
            <img src="{$img}hero-bg.webp" srcset="{$img}hero-bg-1440.webp 1440w, {$img}hero-bg.webp 2166w" sizes="100vw" width="2166" height="1218" alt="{'lbar.rd.hero.alt' | lexicon}" loading="eager" fetchpriority="high" decoding="async">
        </picture>
    </div>

    <div class="lb-hero__deco" aria-hidden="true">
        <span class="lb-hero__spark lb-hero__spark--p1"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
        <span class="lb-hero__spark lb-hero__spark--s lb-hero__spark--p2"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
        <span class="lb-hero__spark lb-hero__spark--s lb-hero__spark--p3"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
        <span class="lb-hero__spark lb-hero__spark--p4"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
        <span class="lb-hero__spark lb-hero__spark--s lb-hero__spark--p5"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
    </div>

    <div class="lb-hero__content">
        {if $parts | length > 2}
        <h1 class="lb-hero__title"><span class="lb-hero__t1">{$parts[0] | trim}</span> <span class="lb-hero__t2">{$parts[1] | trim}</span> <span class="lb-hero__t3">{$parts[2] | trim}</span></h1>
        {elseif $tb}
        <h1 class="lb-hero__title lb-hero__title--plain">{$tb}</h1>
        {/if}
        <span class="lb-hero__line" aria-hidden="true"></span>
        {if $_modx->resource['suptitle-banner']}
        <p class="lb-hero__sub">{$_modx->resource['suptitle-banner']}</p>
        {/if}
        <div class="lb-hero__btns">
            <a class="lb-btn lb-btn--solid" href="#form-bl4">{'lbar.rd.hero.consult' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
            <a class="lb-btn lb-btn--ghost" href="{$_modx->makeUrl($isRo ? 100 : 198)}">{'lbar.rd.hero.portfolio' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
        </div>
    </div>

    <ul class="lb-hero__cards">
        <li class="lb-card">
            <span class="lb-card__ic" aria-hidden="true"><svg viewBox="0 0 56 44" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M12 2h32l10 12-26 28L2 14 12 2z"/><path d="M2 14h52M12 2l8 12 8-12 8 12 8-12M20 14l8 28 8-28"/></svg></span>
            <span class="lb-card__num">{'lbar.rd.hero.card1.num' | lexicon}</span>
            <span class="lb-card__txt">{'lbar.rd.hero.card1.txt' | lexicon}</span>
        </li>
        <li class="lb-card">
            <span class="lb-card__ic" aria-hidden="true"><svg viewBox="0 0 60 46" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 12c6-7 22-10 36-4 3 1 5 2 7 3-9-3-25-4-41 3"/><path d="M4 30c7-8 16-12 26-12s19 4 26 12c-7 7-16 10-26 10S11 37 4 30z"/><circle cx="30" cy="29" r="7.5"/><circle cx="30" cy="29" r="2.6" fill="currentColor"/><path d="M8 34l-3 4M14 38l-2 4M50 34l3 4"/></svg></span>
            <span class="lb-card__txt">{'lbar.rd.hero.card2.txt' | lexicon}</span>
        </li>
        <li class="lb-card">
            <span class="lb-card__ic" aria-hidden="true"><svg viewBox="0 0 54 44" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M6 14l10 12 11-20 11 20 10-12-4 22H10L6 14z"/><path d="M10 41h34"/><circle cx="27" cy="4.5" r="2.6"/><circle cx="5" cy="12" r="2.4"/><circle cx="49" cy="12" r="2.4"/></svg></span>
            <span class="lb-card__txt">{'lbar.rd.hero.card3.txt' | lexicon}</span>
        </li>
    </ul>
</section>
