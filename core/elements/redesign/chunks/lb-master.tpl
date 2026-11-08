{* Блок «Познакомьтесь с мастером» (редизайн, 6-й экран главной) — вместо bl2-study-trener.
   Заголовок (H2) — TV title-bl2-study (выделенная часть — <span class="gold-word">), пункты — TV text-1..5-bl2-study.
   Если TV у ресурса пустые — берутся с главной своего контекста (как в старом блоке).
   Кнопка открывает прежний попап .overlay-trainer (обработчик по классу trainer-btn в main.js / script.js). *}
{$_modx->lexicon->load('babel:translate')}
{set $start = $_modx->config.site_start}
{set $title = $_modx->resource['title-bl2-study'] ?: $_modx->runSnippet('pdoField', ['id' => $start, 'field' => 'title-bl2-study'])}
{set $isRu = $_modx->config.cultureKey == 'ru'}
{set $ic = [
    'diamond' => '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"><path d="M12 9h16l6 7.5L20 33 6 16.5 12 9z"/><path d="M6 16.5h28M12 9l4 7.5L20 9l4 7.5L28 9M16 16.5 20 33l4-16.5"/></svg>',
    'people' => '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="15" cy="14" r="5"/><circle cx="26.5" cy="14.5" r="4.3"/><path d="M5.5 31c.6-5.6 4.4-9 9.5-9s8.9 3.4 9.5 9H5.5zM22.5 22.6c1.2-.5 2.5-.8 4-.8 4.4 0 7.7 3 8.2 8.2H26"/></svg>',
    'building' => '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 33V12l11-5 11 5v21M5.5 33h29"/><path d="M13.5 15.5h3M23.5 15.5h3M13.5 20.5h3M23.5 20.5h3M13.5 25.5h3M23.5 25.5h3M17.5 33v-5.5h5V33"/></svg>',
    'cap' => '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10 4.5 17 20 24l15.5-7L20 10z"/><path d="M11 20v6.5c2.4 2.3 5.4 3.5 9 3.5s6.6-1.2 9-3.5V20M35.5 17v8"/></svg>',
    'star' => '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"><path d="m20 6.5 4.2 8.7 9.5 1.3-6.9 6.6 1.7 9.4L20 28l-8.5 4.5 1.7-9.4-6.9-6.6 9.5-1.3L20 6.5z"/></svg>',
    'feather' => '<svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 32 30 11"/><path d="M31 9.5c-6-2-14.6.8-18.1 8.5-1.8 3.7-1.9 7.6-1.4 10.8 3.3.5 7.2.2 10.9-1.5 7.6-3.6 10.4-12 8.6-17.8z"/><path d="M14.7 24h7M18 20.2h6.5M21.8 16.4h4.9"/></svg>'
]}
{* иконки по смыслу пунктов: в RO (и EN — перевод RO) и RU порядок пунктов разный *}
{set $icons = $isRu ? ['diamond', 'star', 'cap', 'feather', 'building'] : ['diamond', 'people', 'building', 'cap', 'star']}
<section class="lb-master" id="lb-master">
    <div class="lb-master__bg" aria-hidden="true">
        <svg class="lb-master__lines" viewBox="0 0 1920 890" preserveAspectRatio="none">
            <defs>
                <linearGradient id="lb-master-arc" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0" stop-color="#d8b39a" stop-opacity=".75"/>
                    <stop offset=".45" stop-color="#cfa48a" stop-opacity=".85"/>
                    <stop offset="1" stop-color="#b98a70" stop-opacity=".15"/>
                </linearGradient>
                <linearGradient id="lb-master-sheen" x1="0" y1="1" x2="1" y2="0">
                    <stop offset="0" stop-color="#f3d2bd" stop-opacity="0"/>
                    <stop offset=".55" stop-color="#f6dccb" stop-opacity=".9"/>
                    <stop offset="1" stop-color="#f3d2bd" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <path class="lb-master__arc" d="M247 0A803 803 0 0 1 693 890" stroke="url(#lb-master-arc)"/>
            <path class="lb-master__sheen" d="M1560 890C1680 835 1790 772 1920 700" stroke="url(#lb-master-sheen)"/>
        </svg>
    </div>

    <div class="lb-master__photo">
        <img src="/assets/templates/redesign/img/master.webp" alt="{'lbar.rd.master.alt' | lexicon}" width="860" height="1004" loading="lazy" decoding="async">
    </div>

    <div class="lb-master__col">
        {if $title}
        <h2 class="lb-master__title">{$title}</h2>
        {/if}

        <div class="lb-master__lists">
            {* пункты 1–3 — в первой колонке, 4–5 — во второй *}
            {foreach [ [1, 2, 3], [4, 5] ] as $col}
            <ul class="lb-master__list">
                {foreach $col as $i}
                {set $t = $_modx->resource['text-' ~ $i ~ '-bl2-study'] ?: $_modx->runSnippet('pdoField', ['id' => $start, 'field' => 'text-' ~ $i ~ '-bl2-study'])}
                {if $t}
                <li class="lb-master__item">
                    {set $key = $icons[$i - 1]}
                    <span class="lb-master__ic" aria-hidden="true">{$ic[$key]}</span>
                    <span class="lb-master__text">{$t | ereplace : '/(\d{3,}\s?\+?)/u' : '<b>$1</b>'}</span>
                </li>
                {/if}
                {/foreach}
            </ul>
            {/foreach}
        </div>

        <button class="lb-btn lb-btn--light lb-master__btn trainer-btn" type="button">{'lbar.trainer.button.consultation' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></button>
    </div>
</section>
<div class="overlay-trainer">
  <div class="popup">
    <h2 class="popup-title">{$_modx->lexicon("lbar.popup.trainer.title")}</h2>
        <p class="popup-subtitle">{$_modx->lexicon("lbar.popup.trainer.subtitle")}</p>
      [[!AjaxForm?
              &form=`tpl.Form.Study.Modal.BL2`
              &snippet=`FormIt`
              &formFields=`name,phone,title,link`
              &hooks=`spam,email,FormItSaveForm,GoogleSheetsSaveForm`
              &emailSubject=`Заявка "Получить личную консультацию"`
              &emailTo=`[[++form-mail]]`
              &emailFrom=`[[++form-mail]]`
              &emailFromName=`[[++site_name]]`
              &emailTpl=`tpl.email.study`
              &spamCheckIp=`true`
              &validate=`name:required,phone:minLength=^10^:required,workemail:blank`
              &validationErrorMessage=`Пожалуйста, заполните обязательные поля*`
              &successMessage=`Ваше сообщение было успешно отправлено!`
              &frontend_css=``
              &frontend_js=``
        ]]
        <div class="close-popup"></div>
  </div>
</div>
