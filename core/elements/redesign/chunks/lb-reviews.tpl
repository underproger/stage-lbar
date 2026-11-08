{* Блок «Отзывы» (редизайн, главная, после «Записи на процедуру») — вместо bl9-reviews.
   H2 — TV title-bl9 (текст не менялся); разбивка на строки и курсив — лексикон lbar.rd.reviews.title
   («|» — перенос, *…* — курсив; сравнение — без тегов: в RU-TV есть <br>). Если TV изменят — H2 выводится как есть.
   Отзывы — EasyComm, как раньше: [[!ecMessages]] (некэшируемо, ветка resource-<id>, только опубликованные, новые сверху),
   карточка — lb.reviewCard, обёртка с рейтингом ветки и каруселью — lb.reviewsWrap. Рейтинг и число — данные ветки EasyComm.
   «Vezi toate recenziile» — страница отзывов (RO 171 / RU 300). «Lăsați o recenzie» — окно с формой EasyComm [[!ecForm]]
   (прежние письма и модерация; шаблон формы — lb.ecForm, JS отправки — easyComm из старого custom.js).
   Полный текст отзыва (и ответ студии) — окно по кнопке ⋮ в карточке. *}
{set $raw = $_modx->resource['title-bl9'] | trim}
{set $title = $raw | striptags | replace : '  ' : ' ' | trim}
{set $fmt = 'lbar.rd.reviews.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
{set $allId = ($_modx->config.cultureKey == 'ru') ? 300 : 171}
<section class="lb-reviews" id="lb-reviews">
    <div class="lb-reviews__bg" aria-hidden="true"></div>

    <div class="lb-reviews__head">
        {if $raw}
        <h2 class="lb-reviews__title">
            {if $plain == $title}
            {foreach ($fmt | split : '|') as $line}
            <span class="lb-reviews__line"><span class="lb-reviews__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
            {/foreach}
            {else}
            <span class="lb-reviews__line"><span class="lb-reviews__lin">{$_modx->getChunk('lb.accent', ['t' => $raw])}</span></span>
            {/if}
        </h2>
        {/if}
        <p class="lb-reviews__sub">{'lbar.rd.reviews.sub' | lexicon}</p>
    </div>

    <div id="review"></div>
    [[!ecMessages?
        &tpl=`lb.reviewCard`
        &tplWrapper=`lb.reviewsWrap`
        &limit=`80`
    ]]

    <div class="lb-reviews__btns">
        <a class="lb-btn lb-btn--solid lb-btn--sm lb-reviews__btn" href="{$allId | url}">{'lbar.rd.reviews.all' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
        <button class="lb-btn lb-btn--ghost lb-btn--sm lb-reviews__btn js-lb-review-form" type="button" aria-haspopup="dialog" aria-controls="lb-rform">{'lbar.reviews.form.title' | lexicon}<svg class="lb-reviews__pen" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 20h4.2L19.4 8.8a2.3 2.3 0 0 0 0-3.2l-1-1a2.3 2.3 0 0 0-3.2 0L4 15.8V20z"/><path d="m13.6 6.2 4.2 4.2"/></svg></button>
    </div>

    {* окно: полный текст отзыва (заполняется из карточки) *}
    <dialog class="lb-rmodal" id="lb-rmodal" aria-labelledby="lb-rmodal-name">
        <div class="lb-rmodal__box">
            <button class="lb-rmodal__close" type="button" aria-label="{'lbar.rd.reviews.close' | lexicon}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
            <div class="lb-rmodal__body"></div>
        </div>
    </dialog>

    {* окно: форма отзыва EasyComm *}
    <dialog class="lb-rmodal lb-rmodal--form" id="lb-rform" aria-labelledby="lb-rform-title">
        <div class="lb-rmodal__box">
            <button class="lb-rmodal__close" type="button" aria-label="{'lbar.rd.reviews.close' | lexicon}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
            <div class="lb-rmodal__title" id="lb-rform-title">{'lbar.reviews.form.title' | lexicon}</div>
            [[!ecForm?
                &tplForm=`lb.ecForm`
                &tplSuccess=`tpl.ecForm.Success.Blog`
                &tplNewEmailManager=`tpl.ecForm.New.Email.Manager.Blog`
                &tplUpdateEmailUser=`tpl.ecForm.Update.Email.User.Blog`
                &tplNewEmailUser=`tpl.ecForm.New.Email.User.Blog`
            ]]
        </div>
    </dialog>
</section>
