{* Форма отзыва EasyComm (tplForm для ecForm) в окне блока «Отзывы». Поля, имена и id — как в старом tpl.ecForm.Blog.2:
   на них завязан JS easyComm из custom.js (ajax-отправка, ошибки #ec-<поле>-error-<fid>, звёзды .ec-rating, успех #ec-form-success-<fid>).
   Антиспам-поле скрыто CSS. Отзыв публикуется после модерации (как раньше). *}
{$_modx->lexicon->load('babel:translate')}
<form class="ec-form lb-rform" method="post" id="ec-form-[[+fid]]" data-fid="[[+fid]]" action="">
    <input type="hidden" name="thread" value="[[+thread]]">
    <div class="form-group ec-antispam">
        <label for="ec-[[+antispam_field]]-[[+fid]]" class="control-label">[[%ec_fe_message_antismap]]</label>
        <input type="text" name="[[+antispam_field]]" class="form-control" id="ec-[[+antispam_field]]-[[+fid]]" value="" tabindex="-1" autocomplete="off">
    </div>

    <div class="lb-rform__row">
        <div class="form-group lb-rform__field">
            <input type="text" name="user_name" class="form-control" placeholder="[[%ec_fe_message_user_name]]*" aria-label="[[%ec_fe_message_user_name]]" id="ec-user_name-[[+fid]]" value="[[+user_name]]" autocomplete="name">
            <span class="ec-error help-block" id="ec-user_name-error-[[+fid]]"></span>
        </div>
        <div class="form-group lb-rform__field">
            <input type="text" name="user_email" class="form-control" placeholder="[[%ec_fe_message_user_email]]" aria-label="[[%ec_fe_message_user_email]]" id="ec-user_email-[[+fid]]" value="[[+user_email]]" autocomplete="email" inputmode="email">
            <span class="ec-error help-block" id="ec-user_email-error-[[+fid]]"></span>
        </div>
    </div>
    <div class="form-group lb-rform__field lb-rform__field--text">
        <textarea name="text" class="form-control" rows="5" placeholder="[[%ec_fe_message_text]]*" aria-label="[[%ec_fe_message_text]]" id="ec-text-[[+fid]]">[[+text]]</textarea>
        <span class="ec-error help-block" id="ec-text-error-[[+fid]]"></span>
    </div>

    [[+recaptcha]]

    <div class="lb-rform__foot">
        <div class="form-group lb-rform__rating">
            <label for="ec-rating-[[+fid]]" class="control-label">{$_modx->lexicon("lbar.reviews.rating.label")}:</label>
            <input type="hidden" name="rating" id="ec-rating-[[+fid]]" value="[[+rating]]">
            <div class="ec-rating" data-storage-id="ec-rating-[[+fid]]">
                <div class="ec-rating-stars">
                    <span data-rating="1" data-description="[[%ec_fe_message_rating_1]]"></span>
                    <span data-rating="2" data-description="[[%ec_fe_message_rating_2]]"></span>
                    <span data-rating="3" data-description="[[%ec_fe_message_rating_3]]"></span>
                    <span data-rating="4" data-description="[[%ec_fe_message_rating_4]]"></span>
                    <span data-rating="5" data-description="[[%ec_fe_message_rating_5]]"></span>
                </div>
            </div>
            <span class="ec-error help-block" id="ec-rating-error-[[+fid]]"></span>
        </div>
        <button type="submit" class="lb-btn lb-btn--solid lb-btn--sm lb-rform__btn" name="send" value="1">[[%ec_fe_send]]<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></button>
    </div>
</form>
<div class="lb-rform__success" id="ec-form-success-[[+fid]]"></div>
