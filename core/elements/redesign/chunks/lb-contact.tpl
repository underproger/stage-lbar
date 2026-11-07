{* Блок «Контакты» (редизайн, главная, перед подвалом) — вместо bl-contact.
   H2 — прежний лексикон lbar.contacts.title. Телефон и почта — настройки phone-1 / e-mail, карта — настройка google-map (iframe Google),
   как раньше; в RO язык карточки Google переключается на румынский (в коде карты стоит ru). Адрес, метро, трамвай, график —
   тексты старого чанка, вынесены в лексикон lbar.rd.contacts.* (RO — как в макете, RU — перевод; названия станций — как есть).
   Якорь #conract (старые ссылки) сохранён. Иконки мессенджеров и логотип из старого блока не выводятся — в макете их нет. *}
{set $isRu = $_modx->config.cultureKey == 'ru'}
{set $phone = $_modx->config['phone-1'] | trim}
{set $mail = $_modx->config['e-mail'] | trim}
{set $map = $_modx->config['google-map'] | trim}
{if !$isRu}{set $map = $map | replace : '!1sru!2sro' : '!1sro!2sro'}{/if}
{set $map = $map | replace : '<iframe ' : ('<iframe title="' ~ ('lbar.rd.contacts.map' | lexicon) ~ '" ')}
{set $sub = 'lbar.rd.contacts.sub' | lexicon}
<div id="conract"></div>
<section class="lb-contact" id="lb-contact">
    <div class="lb-contact__bg" aria-hidden="true"></div>
    <div class="lb-contact__inner">
        <div class="lb-contact__main">
            <h2 class="lb-contact__title">{$_modx->lexicon('lbar.contacts.title')}</h2>
            <p class="lb-contact__sub">{foreach ($sub | split : '*') as $k => $part}{if $k % 2}<span class="lb-contact__accent">{$part}</span>{else}{$part}{/if}{/foreach}</p>
            {if $map}
            <div class="lb-contact__map">
                <div class="lb-contact__mapph" aria-hidden="true"></div>
                <div class="lb-contact__frame">{$map}</div>
            </div>
            {/if}
        </div>

        <div class="lb-contact__side">
            <ul class="lb-contact__list">
                {if $phone}
                <li class="lb-contact__row">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16.4v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 1.1 3.7 2 2 0 0 1 3.1 1.5h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L7.1 9.3a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.8 2.1z"/></svg></span>
                    <a class="lb-contact__big" href="tel:{$phone | replace : ' ' : ''}" aria-label="{'lbar.rd.contacts.phone' | lexicon}: {$phone}">{$phone}</a>
                </li>
                {/if}
                {if $mail}
                <li class="lb-contact__row">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="4.5" width="19" height="15" rx="2"/><path d="m3 6 9 7 9-7"/></svg></span>
                    <a class="lb-contact__mail" href="mailto:{$mail}" aria-label="{'lbar.rd.contacts.email' | lexicon}: {$mail}">{$mail}</a>
                </li>
                {/if}
                <li class="lb-contact__row lb-contact__row--top">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21.5s-7-6.1-7-11.7a7 7 0 0 1 14 0c0 5.6-7 11.7-7 11.7z"/><circle cx="12" cy="9.8" r="2.6"/></svg></span>
                    <address class="lb-contact__addr"><b>{'lbar.rd.contacts.city' | lexicon}</b><span>{'lbar.rd.contacts.street' | lexicon}</span></address>
                </li>
            </ul>

            <ul class="lb-contact__list lb-contact__list--route">
                <li class="lb-contact__row">
                    <span class="lb-contact__ic lb-contact__ic--metro" aria-hidden="true">M</span>
                    <span class="lb-contact__txt">{'lbar.rd.contacts.metro1' | lexicon}</span>
                    <svg class="lb-contact__walk" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" role="img" aria-label="{'lbar.rd.contacts.walk' | lexicon}"><circle cx="13.2" cy="3.6" r="1.8"/><path d="m10 21 2-6.5 3 3V22M8 12.5l1.5-4.2a2 2 0 0 1 2.4-1.2l1.4.4a2 2 0 0 1 1.3 1.3l.9 2.8 2.5 1.4M12 14.5l-.9-4.3-2.6 2.3L6.5 11"/></svg>
                </li>
                <li class="lb-contact__row">
                    <span class="lb-contact__ic lb-contact__ic--metro" aria-hidden="true">M</span>
                    <span class="lb-contact__txt">{'lbar.rd.contacts.metro2' | lexicon}</span>
                    <svg class="lb-contact__walk" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" role="img" aria-label="{'lbar.rd.contacts.walk' | lexicon}"><circle cx="13.2" cy="3.6" r="1.8"/><path d="m10 21 2-6.5 3 3V22M8 12.5l1.5-4.2a2 2 0 0 1 2.4-1.2l1.4.4a2 2 0 0 1 1.3 1.3l.9 2.8 2.5 1.4M12 14.5l-.9-4.3-2.6 2.3L6.5 11"/></svg>
                </li>
                <li class="lb-contact__row">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="5.5" width="14" height="12" rx="3"/><path d="M5 12.5h14M9 2.5h6M12 2.5v3M8.5 15h.01M15.5 15h.01M8 17.5l-1.5 3M16 17.5l1.5 3"/></svg></span>
                    <span class="lb-contact__txt">{'lbar.rd.contacts.tram' | lexicon}</span>
                </li>
            </ul>

            <ul class="lb-contact__list lb-contact__list--time">
                <li class="lb-contact__row lb-contact__row--top">
                    <span class="lb-contact__ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.2 2"/></svg></span>
                    <div class="lb-contact__time">
                        <b>{'lbar.rd.contacts.schedule.title' | lexicon}</b>
                        <span>{'lbar.rd.contacts.schedule' | lexicon}</span>
                        <span class="lb-contact__badge">{'lbar.rd.contacts.appointment' | lexicon}</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>
