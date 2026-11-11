{* Блок «Курсы» на общей странице «Обучение» (шаблон «Внутренняя - Обучение», id 21) — вместо bl2-category-study.
   Список — как было: pdoResources, parents = текущий, resources = TV id-bl2, по menuindex (при равном — по id, шаг 65). Карточка — lb.courseCard.
   Заголовка H2 у старого блока не было — и здесь нет (надзаголовок убран вместе со всеми eyebrow), структура заголовков страницы та же. *}
{set $list = $_modx->runSnippet('pdoResources', [
    'parents' => $_modx->resource.id,
    'resources' => $_modx->resource['id-bl2'] | trim,
    'limit' => 12,
    'tpl' => 'lb.courseCard',
    'sortby' => ['menuindex' => 'ASC', 'id' => 'ASC'],
    'includeTVs' => 'im-category,alt-im-category,title-bl2,intro-text-bl2,sub-title-2-banner-study,text-1-banner-study,text-2-banner-study,text-3-banner-study,text-4-banner-study',
    'processTVs' => 'im-category'
])}
{if $list | trim}
<section class="lb-courses" id="lb-courses">
    <div class="lb-courses__bg" aria-hidden="true"></div>
    <div class="lb-courses__inner">
        <div class="lb-courses__list">
            {$list}
        </div>
    </div>
</section>
{/if}
