{* Главный баннер (редизайн).
   H1 — TV title-banner, исходный текст сайта («Micropigmentare Bucuresti Studio Lbar» / «Перманентный макияж в Бухаресте от LBar»).
   Разбивка на три строки композиции макета (обычная / крупный курсив / мелкая) — лексикон lbar.rd.hero.title («|» — граница строк);
   применяется, только если без «|» он совпадает с TV, иначе H1 — одной строкой. «|» прямо в TV тоже работает. Подзаголовок — TV suptitle-banner.
   Длинная 2-я строка (больше 9 знаков, RU «в Бухаресте») — мельче (lb-hero__title--t2l), чтобы строка помещалась.
   Кнопки — как на исходном сайте: «Fă o programare» (скролл к форме #bl8-form) и «Primește o consultație» (скролл к «Контактам» #conract). *}
{set $tb = $_modx->resource['title-banner'] | trim}
{set $lay = 'lbar.rd.hero.title' | lexicon}
{if !($tb | ematch : '~[|]~') && ($lay | replace : '|' : ' ') == $tb}{set $tb = $lay}{/if}
{set $parts = $tb | split : '|'}
{set $img = '/assets/templates/redesign/img/'}
<section class="lb-hero" id="lb-hero">
    {* Сцена (десктоп): фон без декора + буквы «BAR», линия и арки (SVG, чёткие на любом экране) + мастер (вырезка, отдельный слой).
       На мобильном — одна картинка hero-mobile-v2.webp (фон + мастер, _dev/hero2/make_hero.py; шаг 66: + уменьшенные -480 / -800 для srcset — браузер берёт
       по ширине экрана и плотности), слои скрыты; мастер на мобильном не скачивается (пустой source). *}
    {set $px = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'}
    <div class="lb-hero__bg">
        <div class="lb-hero__scene">
            <picture class="lb-hero__pic">
                <source media="(max-width: 1024px)" srcset="{$img}hero-mobile-v2-480.webp 480w, {$img}hero-mobile-v2-800.webp 800w, {$img}hero-mobile-v2.webp 1060w" sizes="100vw" width="1060" height="1107">
                <img src="{$img}hero-bg.webp" srcset="{$img}hero-bg-1440.webp 1440w, {$img}hero-bg.webp 2166w, {$img}hero-bg-2880.webp 2880w" sizes="100vw" width="2166" height="1218" alt="{'lbar.rd.hero.alt' | lexicon}" loading="eager" fetchpriority="high" decoding="async">
            </picture>
            <div class="lb-hero__art" aria-hidden="true">
                <img class="lb-hero__arches" src="{$img}hero-arches.svg" width="220" height="600" alt="" loading="eager">
                <img class="lb-hero__vline" src="{$img}hero-line.svg" width="44" height="660" alt="" loading="eager">
                <img class="lb-hero__letters" src="{$img}hero-letters.svg" width="912" height="410" alt="" loading="eager">
            </div>
            <div class="lb-hero__deco" aria-hidden="true">
                <span class="lb-hero__spark lb-hero__spark--p1"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
                <span class="lb-hero__spark lb-hero__spark--s lb-hero__spark--p2"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
                <span class="lb-hero__spark lb-hero__spark--s lb-hero__spark--p3"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
                <span class="lb-hero__spark lb-hero__spark--p4"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
                <span class="lb-hero__spark lb-hero__spark--s lb-hero__spark--p5"><svg viewBox="0 0 40 40"><path fill="currentColor" d="M20 0c.9 10.6 8.4 18.6 20 20-11.6 1.4-19.1 9.4-20 20-.9-10.6-8.4-18.6-20-20C11.6 18.6 19.1 10.6 20 0z"/></svg></span>
            </div>
            <picture class="lb-hero__master" aria-hidden="true">
                <source media="(max-width: 1024px)" srcset="{$px}">
                <img src="{$img}hero-master-v2.webp" srcset="{$img}hero-master-v2.webp 570w, {$img}hero-master-v2-2x.webp 1140w" sizes="30vw" width="570" height="760" alt="" loading="eager" decoding="async">
            </picture>
        </div>
    </div>

    <div class="lb-hero__content">
        {if $parts | length > 2}
        <h1 class="lb-hero__title{($parts[1] | trim | length) > 9 ? ' lb-hero__title--t2l' : ''}"><span class="lb-hero__t1">{$parts[0] | trim}</span> <span class="lb-hero__t2">{$parts[1] | trim}</span> <span class="lb-hero__t3">{$parts[2] | trim}</span></h1>
        {elseif $tb}
        <h1 class="lb-hero__title lb-hero__title--plain">{$tb}</h1>
        {/if}
        <span class="lb-hero__line" aria-hidden="true"></span>
        {if $_modx->resource['suptitle-banner']}
        <p class="lb-hero__sub">{$_modx->resource['suptitle-banner']}</p>
        {/if}
        <div class="lb-hero__btns">
            <a class="lb-btn lb-btn--solid js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
            <a class="lb-btn lb-btn--ghost" href="#conract">{'lbar.buttons.banner.consultation' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
        </div>
    </div>

    <ul class="lb-hero__cards">
        {* преимущества: число / подпись — лексикон lbar.rd.hero.cardN.num / .txt; иконки — бриллиант, песочные часы, корона *}
        <li class="lb-card">
            <span class="lb-card__ic" aria-hidden="true"><svg viewBox="0 0 56 44" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M12 2h32l10 12-26 28L2 14 12 2z"/><path d="M2 14h52M12 2l8 12 8-12 8 12 8-12M20 14l8 28 8-28"/></svg></span>
            <span class="lb-card__num">{'lbar.rd.hero.card1.num' | lexicon}</span>
            <span class="lb-card__txt">{'lbar.rd.hero.card1.txt' | lexicon}</span>
        </li>
        <li class="lb-card">
            <span class="lb-card__ic" aria-hidden="true"><svg viewBox="0 0 36 46" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 2h26M5 44h26"/><path d="M8 2c0 8.5 3.6 13.5 10 21 6.4-7.5 10-12.5 10-21"/><path d="M8 44c0-8.5 3.6-13.5 10-21 6.4 7.5 10 12.5 10 21"/><path d="M12.5 9.5h11M18 23v6M11.5 40.5c1.6-3.6 3.8-6 6.5-7.8 2.7 1.8 4.9 4.2 6.5 7.8z"/></svg></span>
            <span class="lb-card__num">{'lbar.rd.hero.card2.num' | lexicon}</span>
            <span class="lb-card__txt">{'lbar.rd.hero.card2.txt' | lexicon}</span>
        </li>
        <li class="lb-card">
            <span class="lb-card__ic" aria-hidden="true"><svg viewBox="0 0 54 44" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M6 14l10 12 11-20 11 20 10-12-4 22H10L6 14z"/><path d="M10 41h34"/><circle cx="27" cy="4.5" r="2.6"/><circle cx="5" cy="12" r="2.4"/><circle cx="49" cy="12" r="2.4"/></svg></span>
            <span class="lb-card__num">{'lbar.rd.hero.card3.num' | lexicon}</span>
            <span class="lb-card__txt">{'lbar.rd.hero.card3.txt' | lexicon}</span>
        </li>
    </ul>
</section>
