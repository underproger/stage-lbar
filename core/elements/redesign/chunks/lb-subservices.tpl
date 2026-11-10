{* Блок «Подуслуги» на странице услуги (шаблон «Категория») — вместо bl2-category-inerial: дочерние ресурсы (как было:
   pdoResources, parents = текущий, до 12, по menuindex). Выводится, только если дети есть. H2 — TV main-title-bl2,
   подзаголовок — TV sub-title-bl2 (как в tpl.moreWrap-category.main). Вид — блок «Услуги» главной (lb-scard).
   Общая страница «Услуги» (шаблон «Услуги — общая», вместо bl2-category-inerial-2; режим hub): все опубликованные услуги-потомки
   (шаблоны «Категория» 8 и «Категория NEW» 19, по menuindex), карточка lb.hubCard; H2 и подзаголовок — те же TV.
   Шаг 54: и страницы шаблона «Удаление тату» (Redesign; id шаблона на серверах разный — по имени, через JOIN modTemplate). *}
{set $hub = $_modx->resource.template != 8}
{if $hub}
{set $list = $_modx->runSnippet('pdoResources', [
    'parents' => $_modx->resource.id,
    'depth' => 0,
    'limit' => 0,
    'leftJoin' => ['Tpl' => ['class' => 'modTemplate', 'on' => 'Tpl.id = modResource.template']],
    'where' => '[{"template:IN":[8,19],"OR:Tpl.templatename:=":"Удаление тату"},{"class_key:!=":"modWebLink"}]',
    'tpl' => 'lb.hubCard',
    'sortby' => 'menuindex',
    'sortdir' => 'ASC',
    'includeTVs' => 'img_banner_main,im-category,intro-text-bl2,sub-title-banner',
    'processTVs' => 'img_banner_main,im-category'
])}
{else}
{set $list = $_modx->runSnippet('pdoResources', [
    'parents' => $_modx->resource.id,
    'limit' => 12,
    'where' => ['class_key:!=' => 'modWebLink'],
    'tpl' => 'lb.subserviceCard',
    'sortby' => 'menuindex',
    'sortdir' => 'ASC',
    'includeTVs' => 'im-category,alt-im-category,intro-text-bl2,title-bl2'
])}
{/if}
{if $list | trim}
{set $title = $_modx->resource['main-title-bl2'] | trim}
<section class="lb-services lb-services--sub{$hub ? ' lb-services--hub' : ''}" id="lb-services">
    <div class="lb-services__bg" aria-hidden="true">
        <img src="/assets/templates/redesign/img/services-bg.webp?v=2" srcset="/assets/templates/redesign/img/services-bg-1440.webp?v=2 1440w, /assets/templates/redesign/img/services-bg.webp?v=2 2166w" sizes="100vw" width="2166" height="1218" alt="" loading="lazy" decoding="async">
    </div>

    <div class="lb-services__intro">
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
