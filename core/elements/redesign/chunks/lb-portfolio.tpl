{* Блок «Галерея фото» (редизайн, 7-й экран главной) — вместо bl6-portfolio-front-page.
   H2 — TV title-bl6 (текст не менялся); разбивка на строки и курсив — лексикон lbar.rd.portfolio.title
   («|» — перенос, *…* — курсив); если TV изменят и он перестанет совпадать — H2 выводится как есть.
   Подзаголовок — TV sub-title-bl6 (с главной контекста, как было). Фото — ms2Gallery ресурса (у EN — RO-двойника, lb.roId; tpl lb.galleryItem):
   первые 8 видны, остальные раскрываются кнопкой; увеличение — fancybox (data-fancybox, как было). *}
{set $title = $_modx->resource['title-bl6'] | trim}
{set $fmt = 'lbar.rd.portfolio.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
<section class="lb-portfolio" id="lb-portfolio">
    <div class="lb-portfolio__bg" aria-hidden="true">
        <svg class="lb-portfolio__lines" viewBox="0 0 1920 1160" preserveAspectRatio="none">
            <defs>
                <linearGradient id="lb-portfolio-arc" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stop-color="#c49a80" stop-opacity=".05"/>
                    <stop offset=".35" stop-color="#c49a80" stop-opacity=".75"/>
                    <stop offset="1" stop-color="#c49a80" stop-opacity=".1"/>
                </linearGradient>
            </defs>
            <path class="lb-portfolio__arc" d="M1560 40C1440 150 1370 260 1340 360" stroke="url(#lb-portfolio-arc)"/>
            <path class="lb-portfolio__arc" d="M0 600C190 640 300 760 320 1160" stroke="url(#lb-portfolio-arc)"/>
        </svg>
    </div>

    <div class="lb-portfolio__head">
        {if $title}
        <h2 class="lb-portfolio__title">
            {if $plain == $title}
            {foreach ($fmt | split : '|') as $line}
            <span class="lb-portfolio__line"><span class="lb-portfolio__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
            {/foreach}
            {else}
            <span class="lb-portfolio__line"><span class="lb-portfolio__lin">{$_modx->getChunk('lb.accent', ['t' => $title])}</span></span>
            {/if}
        </h2>
        {/if}
        {set $sub = $_modx->runSnippet('pdoField', ['id' => $_modx->config.site_start, 'field' => 'sub-title-bl6'])}
        {if $sub}
        <p class="lb-portfolio__sub">{$sub}</p>
        {/if}
    </div>

    {if !$gallery = $_modx->cacheManager->get('lb-portfolio' ~ $_modx->config.cultureKey ~ $_modx->resource.id)}
        {set $gallery = $_modx->runSnippet('!ms2Gallery', [
            'resources' => ($_modx->getChunk('lb.roId') | trim),
            'tpl' => 'lb.galleryItem',
            'frontend_css' => '',
            'frontend_js' => '',
        ])}
        {set $null = $_modx->cacheManager->set('lb-portfolio' ~ $_modx->config.cultureKey ~ $_modx->resource.id, $gallery, 3600 * 24)}
    {/if}
    {$gallery}

    <div class="lb-portfolio__foot">
        <button class="lb-btn lb-btn--solid lb-portfolio__more" type="button" aria-controls="lb-gallery" aria-expanded="false">
            <span class="lb-portfolio__moretxt">{'lbar.portfolio.button.more' | lexicon}</span><span class="lb-portfolio__lesstxt">{'lbar.rd.portfolio.less' | lexicon}</span>
            <svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>
        </button>
        {* страницы услуг: ссылка на портфолио из TV link-bl6 (как кнопка старого bl6-portfolio) *}
        {set $link = ($_modx->resource.id != $_modx->config.site_start) ? ($_modx->resource['link-bl6'] | trim) : ''}
        {if $link}
        <a class="lb-btn lb-btn--ghost lb-portfolio__all" href="{$link}">{'lbar.rd.implica.portfolio' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
        {/if}
    </div>
</section>
