{* Скрипты редизайна (перед </body>). *}
<script src="/assets/templates/redesign/js/vendor/gsap.min.js" defer></script>
<script src="/assets/templates/redesign/js/vendor/ScrollTrigger.min.js" defer></script>
<script src="/assets/templates/redesign/js/redesign.js?v=1.33.0" defer></script>
{if $_modx->config.cultureKey == 'en'}
{* EN: после отправки формы — своя страница «Thank you» (1040). Старый обработчик af_complete в чанке script ведёт на RO 40 / RU 269 (RU для всех,
   кроме RO); этот обработчик зарегистрирован после него и переназначает адрес (последнее присваивание location выигрывает). *}
<script>
jQuery(document).on('af_complete', function (e, r) {
    if (r && r.success && r.form && ['form-bl4', 'form-bl8', 'form-study-banner', 'form-study-bl2', 'form-study-bl18'].indexOf(r.form.attr('id')) > -1) {
        window.location.href = '[[~1040]]';
    }
});
</script>
{/if}
