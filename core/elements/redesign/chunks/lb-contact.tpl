{* Блок «Контакты» (редизайн: главная и внутренние страницы перед подвалом; страница «Контакты» — режим page) — вместо bl-contact /
   bl-contact-page. Вид — по макету: слева заголовок с линией и звездой, подзаголовок и карта; справа стеклянная карточка — телефон,
   почта, адрес, разделитель, график, три плашки «как добраться» (метро / трамвай) и кнопка «By appointment only» (запись: якорь
   #bl8-form, нет формы на странице — окно «Заказать звонок», js-lb-book).
   H2 — прежний лексикон lbar.contacts.title (на странице «Контакты» вместо него — H1, см. ниже). Телефон и почта — настройки phone-1 / e-mail, карта — настройка google-map (iframe Google),
   как раньше (в {disableSource} — карта не отдаётся Lighthouse); язык карточки Google — язык контекста (RO — румынский, EN — английский, RU — как в настройке). Адрес, метро, трамвай, график —
   лексикон lbar.rd.contacts.* (у метро время после « – » выводится второй строкой).
   Страница «Контакты» (шаблон «Контакты», 9): блок — первый экран под шапкой (баннера нет): заголовок блока — H1 с исходным текстом
   (pagetitle, как в старом banner-interial-contact), хлебные крошки — pdoCrumbs с прежними параметрами и микроразметкой — под картой.
   Якорь #conract (старые ссылки) сохранён. *}
{set $lang = $_modx->config.cultureKey}
{set $page = $_modx->resource.template == 9}
{* настройки ClientConfig выводим MODX-тегами (++ключ): в $_modx->config Fenom их может не оказаться (снимок конфига до ClientConfig) — в кэш попало бы пусто *}
{set $mapTitle = 'lbar.rd.contacts.map' | lexicon}
{set $sub = 'lbar.rd.contacts.sub' | lexicon}
{set $star = '<svg viewBox="0 0 20 20" aria-hidden="true"><path fill="currentColor" d="M10 0c.5 5.3 4.2 9.3 10 10-5.8.7-9.5 4.7-10 10-.5-5.3-4.2-9.3-10-10C5.8 9.3 9.5 5.3 10 0z"/></svg>'}
{set $walk = '<svg class="lb-contact__walk" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" role="img" aria-label="' ~ ('lbar.rd.contacts.walk' | lexicon) ~ '"><circle cx="13.2" cy="3.6" r="1.8"/><path d="m10 21 2-6.5 3 3V22M8 12.5l1.5-4.2a2 2 0 0 1 2.4-1.2l1.4.4a2 2 0 0 1 1.3 1.3l.9 2.8 2.5 1.4M12 14.5l-.9-4.3-2.6 2.3L6.5 11"/></svg>'}
<div id="conract"></div>
<section class="lb-contact{$page ? ' lb-contact--page' : ''}" id="lb-contact">
    <div class="lb-contact__bg" aria-hidden="true"></div>
    <div class="lb-contact__inner">
        <div class="lb-contact__main">
            <div class="lb-contact__head">
                {if $page}
                <h1 class="lb-contact__title">{$_modx->resource.pagetitle}</h1>
                {else}
                <h2 class="lb-contact__title">{$_modx->lexicon('lbar.contacts.title')}</h2>
                {/if}
                <span class="lb-contact__line" aria-hidden="true">{$star}</span>
            </div>
            <p class="lb-contact__sub">{foreach ($sub | split : '*') as $k => $part}{if $k % 2}<span class="lb-contact__accent">{$part}</span>{else}{$part}{/if}{/foreach}</p>
            <div class="lb-contact__map">
                <div class="lb-contact__mapph" aria-hidden="true"></div>
                <div class="lb-contact__frame">{disableSource}{if $lang == 'ru'}[[++google-map:replace=`<iframe ==<iframe title="{$mapTitle}" `]]{elseif $lang == 'en'}[[++google-map:replace=`!1sru!2sro==!1sen!2sro`:replace=`<iframe ==<iframe title="{$mapTitle}" `]]{else}[[++google-map:replace=`!1sru!2sro==!1sro!2sro`:replace=`<iframe ==<iframe title="{$mapTitle}" `]]{/if}{/disableSource}</div>
            </div>
            {if $page}
            <nav class="lb-crumbs lb-contact__crumbs" aria-label="{'lbar.rd.aria.crumbs' | lexicon}">
                {$_modx->runSnippet('!pdoCrumbs', [
                    'showHome' => 1,
                    'showAtHome' => 0,
                    'tplWrapper' => '@INLINE <ol class="lb-crumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">[[+output]]</ol>',
                    'tplHome' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link lb-crumbs__link--home" href="[[+link]]" itemprop="item"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.2 10 3l7 6.2"/><path d="M5 8v9h4v-5h2v5h4V8"/></svg><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                    'tpl' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link" href="[[+link]]" itemprop="item"><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                    'tplCurrent' => '@INLINE <li class="lb-crumbs__item lb-crumbs__item--current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">[[+menutitle]]</span><div itemprop="item" content="[[++site_url]][[+link]]"></div><meta itemprop="position" content="[[+idx]]" /></li>',
                ])}
            </nav>
            {/if}
        </div>

        <div class="lb-contact__card">
            <ul class="lb-contact__list">
                <li class="lb-contact__row">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16.4v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 1.1 3.7 2 2 0 0 1 3.1 1.5h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L7.1 9.3a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.8 2.1z"/></svg></span>
                    <a class="lb-contact__big" href="tel:[[++phone-1:replace=` ==`]]" aria-label="{'lbar.rd.contacts.phone' | lexicon}: [[++phone-1]]">[[++phone-1]]</a>
                </li>
                <li class="lb-contact__row">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="4.5" width="19" height="15" rx="2"/><path d="m3 6 9 7 9-7"/></svg></span>
                    <a class="lb-contact__mail" href="mailto:[[++e-mail]]" aria-label="{'lbar.rd.contacts.email' | lexicon}: [[++e-mail]]">[[++e-mail]]</a>
                </li>
                <li class="lb-contact__row">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21.5s-7-6.1-7-11.7a7 7 0 0 1 14 0c0 5.6-7 11.7-7 11.7z"/><circle cx="12" cy="9.8" r="2.6"/></svg></span>
                    <address class="lb-contact__addr"><b>{'lbar.rd.contacts.city' | lexicon}</b><span>{'lbar.rd.contacts.street' | lexicon}</span></address>
                </li>
            </ul>

            <div class="lb-contact__sep" aria-hidden="true">{$star}</div>

            <div class="lb-contact__row lb-contact__row--time">
                <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg></span>
                <div class="lb-contact__time">
                    <b>{'lbar.rd.contacts.schedule.title' | lexicon}</b>
                    <span>{'lbar.rd.contacts.schedule' | lexicon}</span>
                </div>
            </div>

            <ul class="lb-contact__route">
                {foreach ['metro1', 'metro2'] as $m}
                {set $mt = ('lbar.rd.contacts.' ~ $m) | lexicon}
                {set $mn = $mt | ereplace : '~\s+[–-]\s+.*$~u' : ''}
                {set $mm = ($mn != $mt) ? ($mt | ereplace : '~^.*\s[–-]\s+~u' : '') : ''}
                <li class="lb-contact__tile">
                    <span class="lb-contact__tic lb-contact__tic--metro" aria-hidden="true">M</span>
                    <span class="lb-contact__ttxt"><span class="lb-contact__tname">{$mn}</span>{if $mm}<span class="lb-contact__tmeta">~ {$mm}{$walk}</span>{/if}</span>
                </li>
                {/foreach}
                <li class="lb-contact__tile">
                    <span class="lb-contact__tic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="5.5" width="14" height="12" rx="3"/><path d="M5 12.5h14M9 2.5h6M12 2.5v3M8.5 15h.01M15.5 15h.01M8 17.5l-1.5 3M16 17.5l1.5 3"/></svg></span>
                    <span class="lb-contact__ttxt"><span class="lb-contact__tname">{'lbar.rd.contacts.tram' | lexicon}</span></span>
                </li>
            </ul>

            <a class="lb-btn lb-btn--solid lb-contact__btn js-lb-book" href="#bl8-form">{'lbar.rd.contacts.appointment' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
        </div>
    </div>
</section>
