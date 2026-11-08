{* Блок «Подуслуги» на странице услуги (шаблон «Категория») — вместо bl2-category-inerial: дочерние ресурсы (как было:
   pdoResources, parents = текущий, до 12, по menuindex). Выводится, только если дети есть. H2 — TV main-title-bl2,
   подзаголовок — TV sub-title-bl2 (как в tpl.moreWrap-category.main). Вид — блок «Услуги» главной (lb-scard). *}
{set $list = $_modx->runSnippet('pdoResources', [
    'parents' => $_modx->resource.id,
    'limit' => 12,
    'tpl' => 'lb.subserviceCard',
    'sortby' => 'menuindex',
    'sortdir' => 'ASC',
    'includeTVs' => 'im-category,alt-im-category,intro-text-bl2,title-bl2'
])}
{if $list | trim}
{set $title = $_modx->resource['main-title-bl2'] | trim}
<section class="lb-services lb-services--sub" id="lb-services">
    <div class="lb-services__bg" aria-hidden="true">
        <img src="/assets/templates/redesign/img/services-bg.webp?v=2" srcset="/assets/templates/redesign/img/services-bg-1440.webp?v=2 1440w, /assets/templates/redesign/img/services-bg.webp?v=2 2166w" sizes="100vw" width="2166" height="1218" alt="" loading="lazy" decoding="async">
    </div>

    <div class="lb-services__intro">
        <div class="lb-services__eyebrow">{'lbar.rd.subservices.eyebrow' | lexicon}</div>
        {if $title}
        <h2 class="lb-services__title">{$_modx->getChunk('lb.accent', ['t' => $title])}</h2>
        {/if}
        {if $_modx->resource['sub-title-bl2']}
        <div class="lb-services__text">{$_modx->resource['sub-title-bl2']}</div>
        {/if}
    </div>

    <div class="lb-services__list">
        {$list}
    </div>
</section>
{/if}
