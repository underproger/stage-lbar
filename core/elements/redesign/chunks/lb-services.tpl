{* Блок «Услуги» (редизайн, 3-й экран главной).
   Заголовок, подзаголовок и список услуг — прежние TV: main-title-bl2, sub-title-bl2, id-bl2.
   Карточка — чанк lb.serviceCard. *}
<section class="lb-services" id="lb-services">
    <div class="lb-services__bg" aria-hidden="true">
        <img src="/assets/templates/redesign/img/services-bg.webp" srcset="/assets/templates/redesign/img/services-bg-1440.webp 1440w, /assets/templates/redesign/img/services-bg.webp 2166w" sizes="100vw" width="2166" height="1218" alt="" loading="lazy" decoding="async">
    </div>

    <div class="lb-services__intro">
        <div class="lb-services__eyebrow">{'lbar.rd.services.eyebrow' | lexicon}</div>
        {if $_modx->resource['main-title-bl2']}
        <h2 class="lb-services__title">{$_modx->resource['main-title-bl2']}</h2>
        {/if}
        {if $_modx->resource['sub-title-bl2']}
        <div class="lb-services__text">{$_modx->resource['sub-title-bl2']}</div>
        {/if}
    </div>

    <div class="lb-services__list">
        [[pdoResources?
            &parents=`0`
            &resources=`[[*id-bl2]]`
            &limit=`12`
            &tpl=`lb.serviceCard`
            &sortby=`menuindex`
            &sortdir=`ASC`
            &includeTVs=`im-category,alt-im-category,intro-text-bl2,title-bl2`
        ]]
    </div>
</section>
