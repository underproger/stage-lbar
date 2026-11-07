{* Блок «Запись на процедуру» (редизайн, форма перед отзывами на главной) — вместо bl8-form. Сделан по образцу lb-consult.
   Заголовок и подзаголовок — прежние TV: main-title-bl8, sub-title-bl8 (сначала -interial, как в старом чанке); текст кнопки — TV link-form-bl8.
   Разбивка заголовка на строки и курсив — лексикон lbar.rd.book.title («|» — перенос, *слово* — курсив);
   если TV изменят и он перестанет совпадать с лексиконом — заголовок выводится как есть.
   Заголовок — не H2 (как и в старом блоке), чтобы не менять структуру заголовков страницы.
   Форма: AjaxForm + FormIt с прежними параметрами bl8-form, id формы — form-bl8 (на него завязан редирект после отправки).
   Якорь #bl8-form (кнопки «Записаться» в шапке, баннере, «Ценах») — прежний пустой div перед блоком. *}
{set $title = ($_modx->resource['main-title-bl8-interial'] ?: $_modx->resource['main-title-bl8']) | trim}
{set $sub = $_modx->resource['sub-title-bl8-interial'] ?: $_modx->resource['sub-title-bl8']}
{set $fmt = 'lbar.rd.book.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
<div id="bl8-form"></div>
<section class="lb-book" id="lb-book">
    <div class="lb-book__bg" aria-hidden="true"></div>

    <div class="lb-book__intro">
        {if $title}
        <div class="lb-book__title">
            {if $plain == $title}
            {foreach ($fmt | split : '|') as $line}
            <span class="lb-book__line"><span class="lb-book__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
            {/foreach}
            {else}
            <span class="lb-book__line"><span class="lb-book__lin">{$title}</span></span>
            {/if}
        </div>
        <svg class="lb-book__flourish" viewBox="0 0 440 50" aria-hidden="true">
            <defs>
                <linearGradient id="lb-book-fl" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0" stop-color="#a87856" stop-opacity=".2"/>
                    <stop offset=".25" stop-color="#a87856" stop-opacity=".9"/>
                    <stop offset=".6" stop-color="#a87856" stop-opacity=".85"/>
                    <stop offset="1" stop-color="#a87856" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <path fill="url(#lb-book-fl)" d="M12 45C110 25 240 9 392 13C250 14 120 30 12 45Z"/>
            <path fill="url(#lb-book-fl)" d="M100 40C140 26 190 15 250 11C195 18 150 30 106 42C101 44 97 42 100 40Z"/>
        </svg>
        {/if}

        {if $sub}
        <div class="lb-book__text">{$sub}</div>
        {/if}
    </div>

    <div class="lb-book__card">
        [[!AjaxForm?
            &form=`lb.formBook`
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
            &validate=`name:required,phone:minLength=^10^:required,workemail:blank`
            &validationErrorMessage=`Пожалуйста, заполните обязательные поля*`
            &successMessage=`Ваше сообщение было успешно отправлено!`
            &frontend_css=``
            &frontend_js=``
            &formFields=`name,phone,title,link`
        ]]
    </div>
</section>
