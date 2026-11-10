{* Подвал (редизайн) — вместо footer, ТОЛЬКО в шаблоне «Главная» (старый footer остаётся на остальных шаблонах). Макета не было — в стилистике сайта.
   Данные — как в старом подвале: копирайт (лексикон lbar.footer.copyright), меню — поля foot-link-l / foot-link-r главной (pdoField, вывод как есть;
   в RU там текст без ссылок — так и было), соцсети — настройки youtube / facebook / insta (+ telegram / viber / whatsapp, которые были в старом блоке
   контактов), кнопка «Solicită un apel» + окно с формой — та же разметка и AjaxForm, что в старом подвале (открывает старый custom.js: .btn-mobal →
   соседний .form-modal-overlay; вид окна переопределён в _footer.scss). Контакты и график — как в блоке «Контакты» (лексикон lbar.rd.contacts.*).
   Иконки соцсетей — набор Simple Icons (CC0). Кнопка «наверх» (.cd-top, старый main.js) и кнопка WhatsApp — прежняя разметка. *}
{* настройки ClientConfig — MODX-тегами (++ключ) (как в старом подвале): в $_modx->config Fenom их может не оказаться — в кэш попало бы пусто *}
</main>{* открыт в конце lb-header *}
<footer class="lb-footer" id="lb-footer">
    <div class="lb-footer__bg" aria-hidden="true"></div>
    <div class="lb-footer__inner">
        <div class="lb-footer__top">
            <div class="lb-footer__brand">
                <a class="lb-footer__logo" href="[[++site_url]]" aria-label="[[++site_name]]"><img src="/assets/templates/redesign/img/logo-light.svg?v=3" width="242" height="119" alt="LBar" loading="lazy"></a>
                <p class="lb-footer__copy">&copy; 2016 - {'' | date : 'Y'}. <br/>{$_modx->lexicon("lbar.footer.copyright")}</p>
                <div class="lb-footer__social">
            <a class="lb-footer__soc" href="[[++youtube]]" rel="nofollow" target="_blank" aria-label="YouTube"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M23.498 6.186a3.02 3.02 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.02 3.02 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.02 3.02 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.02 3.02 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814M9.545 15.568V8.432L15.818 12z"/></svg></a>
            <a class="lb-footer__soc" href="[[++facebook]]" rel="nofollow" target="_blank" aria-label="Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978c.401 0 .955.042 1.468.103a9 9 0 0 1 1.141.195v3.325a9 9 0 0 0-.653-.036a27 27 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.7 1.7 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103l-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647"/></svg></a>
            <a class="lb-footer__soc" href="[[++insta]]" rel="nofollow" target="_blank" aria-label="Instagram"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M7.03.084c-1.277.06-2.149.264-2.91.563a5.9 5.9 0 0 0-2.124 1.388a5.9 5.9 0 0 0-1.38 2.127C.321 4.926.12 5.8.064 7.076s-.069 1.688-.063 4.947s.021 3.667.083 4.947c.061 1.277.264 2.149.563 2.911c.308.789.72 1.457 1.388 2.123a5.9 5.9 0 0 0 2.129 1.38c.763.295 1.636.496 2.913.552c1.278.056 1.689.069 4.947.063s3.668-.021 4.947-.082c1.28-.06 2.147-.265 2.91-.563a5.9 5.9 0 0 0 2.123-1.388a5.9 5.9 0 0 0 1.38-2.129c.295-.763.496-1.636.551-2.912c.056-1.28.07-1.69.063-4.948c-.006-3.258-.02-3.667-.081-4.947c-.06-1.28-.264-2.148-.564-2.911a5.9 5.9 0 0 0-1.387-2.123a5.9 5.9 0 0 0-2.128-1.38c-.764-.294-1.636-.496-2.914-.55C15.647.009 15.236-.006 11.977 0S8.31.021 7.03.084m.14 21.693c-1.17-.05-1.805-.245-2.228-.408a3.7 3.7 0 0 1-1.382-.895a3.7 3.7 0 0 1-.9-1.378c-.165-.423-.363-1.058-.417-2.228c-.06-1.264-.072-1.644-.08-4.848c-.006-3.204.006-3.583.061-4.848c.05-1.169.246-1.805.408-2.228c.216-.561.477-.96.895-1.382a3.7 3.7 0 0 1 1.379-.9c.423-.165 1.057-.361 2.227-.417c1.265-.06 1.644-.072 4.848-.08c3.203-.006 3.583.006 4.85.062c1.168.05 1.804.244 2.227.408c.56.216.96.475 1.382.895s.681.817.9 1.378c.165.422.362 1.056.417 2.227c.06 1.265.074 1.645.08 4.848c.005 3.203-.006 3.583-.061 4.848c-.051 1.17-.245 1.805-.408 2.23c-.216.56-.477.96-.896 1.38a3.7 3.7 0 0 1-1.378.9c-.422.165-1.058.362-2.226.418c-1.266.06-1.645.072-4.85.079s-3.582-.006-4.848-.06m9.783-16.192a1.44 1.44 0 1 0 1.437-1.442a1.44 1.44 0 0 0-1.437 1.442M5.839 12.012a6.161 6.161 0 1 0 12.323-.024a6.162 6.162 0 0 0-12.323.024M8 12.008A4 4 0 1 1 12.008 16A4 4 0 0 1 8 12.008"/></svg></a>
                </div>
            </div>

            <nav class="lb-footer__nav" aria-label="[[++site_name]]">
                <div class="lb-footer__col">[[pdoField? &id=`[[++site_start]]` &field=`foot-link-l`]]</div>
                <div class="lb-footer__col">[[pdoField? &id=`[[++site_start]]` &field=`foot-link-r`]]</div>
            </nav>

            <div class="lb-footer__contacts">
                <div class="lb-footer__label">{$_modx->lexicon('lbar.contacts.title')}</div>
                <a class="lb-footer__phone" href="tel:[[++phone-1:replace=` ==`]]">[[++phone-1]]</a>
                <a class="lb-footer__mail" href="mailto:[[++e-mail]]">[[++e-mail]]</a>
                <a class="lb-footer__addr" href="{'lbar.rd.contacts.mapurl' | lexicon}" target="_blank" rel="nofollow noopener">{'lbar.rd.contacts.city' | lexicon}, {'lbar.rd.contacts.street' | lexicon}</a>
                <div class="lb-footer__time">
                    <span class="lb-footer__time-t">{'lbar.rd.contacts.schedule.title' | lexicon}</span>
                    <span>{'lbar.rd.contacts.schedule' | lexicon}</span>
                    <span class="lb-footer__badge">{'lbar.rd.contacts.appointment' | lexicon}</span>
                </div>
                <div class="lb-footer__call">
                    <button class="lb-btn lb-btn--solid btn-mobal" type="button">{$_modx->lexicon("lbar.footer.button.callback")}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></button>
                    <div class="form-modal-overlay">
                        <div class="form-modal-body">
                            <div class="form-modal-content">
                                <div class="ic-close modal-close"></div>
                                <div class="form-modal-title-content">
                                    <div class="form-modal-title-big">{$_modx->lexicon("lbar.footer.popup.title")}</div>
                                </div>
                                {disableSource}
                                [[!AjaxForm?
                                    &form=`tpl.Form.Modal`
                                    &snippet=`FormIt`
                                    &hooks=`spam,email,FormItSaveForm,GoogleSheetsSaveForm`
                                    &emailSubject=`Заявка "[[++tema.form.aparat]]"`
                                    &emailTo=`[[++form-mail]]`
                                    &emailFrom=`[[++form-mail]]`
                                    &emailFromName=`[[++site_name]]`
                                    &emailTpl=`tpl.email`
                                    &spamCheckIp=`true`
                                    &validate=`name:required,phone:minLength=^10^:required,workemail:blank`
                                    &validationErrorMessage=`Будь ласка, заповніть обов'язкові поля*`
                                    &successMessage=`Ваше повідомлення було успішно відправлено!`
                                    &frontend_css=``
                                    &frontend_js=``
                                    &formFields = `name,phone,title,link`
                                ]]
                                {/disableSource}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lb-footer__bottom">
            <p class="lb-footer__dev">{$_modx->lexicon("lbar.footer.sitedev")}&nbsp;<a href="https://impulse-design.com.ua/" target="_blank" title="Impulse Design" rel="noopener"><img src="/images/design/copyright-white-min.png" alt="" width="152" height="23" class="jcepopup" title="{if $_modx->config.cultureKey == 'ro'}Crearea site-ului - studio Impulse Design{elseif $_modx->config.cultureKey == 'en'}Website by Impulse Design{else}Создание сайта - студия Impulse Design{/if}" /></a></p>
        </div>
    </div>
</footer>
<a href="#0" class="cd-top"></a>
<a href="[[++whatsapp]]" id="whatsapp-button" target="_blank" title="{if $_modx->config.cultureKey == 'ro'}Scrie-ne pe WhatsApp{elseif $_modx->config.cultureKey == 'en'}Message us on WhatsApp{else}Написать в Whatsapp{/if}" rel="nofollow noopener noreferrer" aria-label="whatsapp">
    <div class="whatsapp-button">
        <svg height="23px" style="fill:#fff;fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" viewBox="0 0 512 512" width="23px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path d="M373.295,307.064c-6.37,-3.188 -37.687,-18.596 -43.526,-20.724c-5.838,-2.126 -10.084,-3.187 -14.331,3.188c-4.246,6.376 -16.454,20.725 -20.17,24.976c-3.715,4.251 -7.431,4.785 -13.8,1.594c-6.37,-3.187 -26.895,-9.913 -51.225,-31.616c-18.935,-16.89 -31.72,-37.749 -35.435,-44.126c-3.716,-6.377 -0.397,-9.824 2.792,-13c2.867,-2.854 6.371,-7.44 9.555,-11.16c3.186,-3.718 4.247,-6.377 6.37,-10.626c2.123,-4.252 1.062,-7.971 -0.532,-11.159c-1.591,-3.188 -14.33,-34.542 -19.638,-47.298c-5.171,-12.419 -10.422,-10.737 -14.332,-10.934c-3.711,-0.184 -7.963,-0.223 -12.208,-0.223c-4.246,0 -11.148,1.594 -16.987,7.969c-5.838,6.377 -22.293,21.789 -22.293,53.14c0,31.355 22.824,61.642 26.009,65.894c3.185,4.252 44.916,68.59 108.816,96.181c15.196,6.564 27.062,10.483 36.312,13.418c15.259,4.849 29.145,4.165 40.121,2.524c12.238,-1.827 37.686,-15.408 42.995,-30.286c5.307,-14.882 5.307,-27.635 3.715,-30.292c-1.592,-2.657 -5.838,-4.251 -12.208,-7.44m-116.224,158.693l-0.086,0c-38.022,-0.015 -75.313,-10.23 -107.845,-29.535l-7.738,-4.592l-80.194,21.037l21.405,-78.19l-5.037,-8.017c-21.211,-33.735 -32.414,-72.726 -32.397,-112.763c0.047,-116.825 95.1,-211.87 211.976,-211.87c56.595,0.019 109.795,22.088 149.801,62.139c40.005,40.05 62.023,93.286 62.001,149.902c-0.048,116.834 -95.1,211.889 -211.886,211.889m180.332,-392.224c-48.131,-48.186 -112.138,-74.735 -180.335,-74.763c-140.514,0 -254.875,114.354 -254.932,254.911c-0.018,44.932 11.72,88.786 34.03,127.448l-36.166,132.102l135.141,-35.45c37.236,20.31 79.159,31.015 121.826,31.029l0.105,0c140.499,0 254.87,-114.366 254.928,-254.925c0.026,-68.117 -26.467,-132.166 -74.597,-180.352" id="WhatsApp-Logo"></path>
        </svg>
    </div>
</a>
