{* Форма блока «Запись на процедуру» (tpl для AjaxForm). Поля и скрытые поля — как в старом tpl.Form.Bl8, вёрстка — как lb.formConsult.
   Телефон оформляет intlTelInput (чанк inttelinput): флаг, код страны и разделитель встают слева в поле. *}
{$_modx->lexicon->load('babel:translate')}
{set $phName = $_modx->lexicon('lbar.form.input.name')}
{set $phTel = $_modx->lexicon('lbar.form.input.phone')}
<form method="post" id="form-bl8" class="lb-cform">
    <label class="lb-cform__field lb-cform__field--name">
        <span class="lb-cform__ic" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="16" cy="10.5" r="6"/><path d="M4.5 29c.9-6.2 5.6-10 11.5-10s10.6 3.8 11.5 10"/></svg></span>
        <input type="text" name="name" value="" placeholder="{$phName}" aria-label="{$phName | replace : '*' : ''}" autocomplete="name">
    </label>
    <div class="lb-cform__field lb-cform__field--phone">
        <input type="tel" name="phone" value="" placeholder="{$phTel}" aria-label="{$phTel | replace : '*' : ''}" autocomplete="tel">
    </div>
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="lb-btn lb-btn--solid lb-cform__btn">[[*link-form-bl8:default=`[[pdoField? &id=`[[++site_start]]` &field=`link-form-bl8`]]`]]<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></button>
    <p class="lb-cform__policy">
        <svg viewBox="0 0 26 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="12.5" width="22" height="16" rx="3"/><path d="M7 12.5V8.5a6 6 0 0 1 12 0v4"/><path d="M13 19v3.5"/></svg>
        <span>{$_modx->lexicon('lbar.form.policy') | replace : '<br/>' : ' ' | replace : '<br>' : ' '}</span>
    </p>
</form>
