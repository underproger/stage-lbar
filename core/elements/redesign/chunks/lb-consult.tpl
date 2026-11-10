{* Блок «Консультация» (редизайн, 5-й экран главной) — вместо bl4-form.
   Заголовок и подзаголовок — прежние TV: main-title-bl4, sub-title-bl4; текст кнопки — TV link-form-bl4.
   Разбивка заголовка на строки и курсив — лексикон lbar.rd.consult.title («|» — перенос, *слово* — курсив);
   если TV изменят и он перестанет совпадать с лексиконом — заголовок выводится как есть.
   Заголовок — не H2 (как и в старом блоке), чтобы не менять структуру заголовков страницы.
   Форма: AjaxForm + FormIt с прежними параметрами, id формы — form-bl4 (на него завязаны якоря и редирект после отправки). *}
{* на страницах услуг TV пустые — берутся с главной контекста (как :default в старом bl4-form) *}
{set $start = $_modx->config.site_start}
{set $title = ($_modx->resource['main-title-bl4'] ?: $_modx->runSnippet('pdoField', ['id' => $start, 'field' => 'main-title-bl4'])) | trim}
{set $sub = $_modx->resource['sub-title-bl4'] ?: $_modx->runSnippet('pdoField', ['id' => $start, 'field' => 'sub-title-bl4'])}
{set $fmt = 'lbar.rd.consult.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
<div id="conract"></div>
<section class="lb-consult" id="lb-consult">
    <div class="lb-consult__bg" aria-hidden="true"></div>

    <div class="lb-consult__intro">

        {if $title}
        <div class="lb-consult__title">
            {if $plain == $title}
            {foreach ($fmt | split : '|') as $line}
            <span class="lb-consult__line"><span class="lb-consult__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
            {/foreach}
            {else}
            <span class="lb-consult__line"><span class="lb-consult__lin">{$title}</span></span>
            {/if}
        </div>
        <svg class="lb-consult__flourish" viewBox="0 0 440 50" aria-hidden="true">
            <defs>
                <linearGradient id="lb-consult-fl" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#a87856" stop-opacity=".2"/>
                    <stop offset=".25" stop-color="#a87856" stop-opacity=".9"/>
                    <stop offset=".6" stop-color="#a87856" stop-opacity=".85"/>
                    <stop offset="1" stop-color="#a87856" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <path fill="url(#lb-consult-fl)" d="M12 45C110 25 240 9 392 13C250 14 120 30 12 45Z"/>
            <path fill="url(#lb-consult-fl)" d="M100 40C140 26 190 15 250 11C195 18 150 30 106 42C101 44 97 42 100 40Z"/>
        </svg>
        {/if}

        {if $sub}
        <div class="lb-consult__text">{$sub}</div>
        {/if}
    </div>

    <div class="lb-consult__card">
        [[!AjaxForm?
            &form=`lb.formConsult`
            &snippet=`FormIt`
            &hooks=`spam,email,FormItSaveForm,GoogleSheetsSaveForm`
            &emailSubject=`Заявка "[[++tema.form]]"`
            &emailTo=`[[++form-mail]]`
            &emailFrom=`[[++form-mail]]`
            &emailFromName=`[[++site_name]]`
            &emailTpl=`tpl.email`
            &fiarSubject=`Спасибо за Ваше сообщение!`
            &fiarTpl=`tpl.email.client`
            &fiarFromName=`[[++site_name]]`
            &fiarFrom=`[[++form-mail]]`
            &spamCheckIp=`true`
            &validate=`name:required,phone:minLength=^8^:required,workemail:blank`
            &validationErrorMessage=`Пожалуйста, заполните обязательные поля*`
            &successMessage=`Ваше сообщение было успешно отправлено!`
            &frontend_css=``
            &frontend_js=``
            &formFields=`name,phone,title,link`
        ]]
    </div>
</section>
