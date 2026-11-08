{* Внутренние страницы портфолио (шаблон «Внутренняя - Галерея», id 13) — вместо bl6-portfolio-interial.
   Сверху — переходы по разделам портфолио: родитель («Все работы») и соседние страницы (menutitle, по menuindex; у них hidemenu).
   Фото — ms2Gallery ресурса (tpl lb.galleryPage): первые 16 видны, дальше — кнопкой по 16 (redesign.js), увеличение — fancybox.
   Кнопка на TV link-bl6 — как в старом блоке. Заголовка у старого блока не было — здесь тоже. *}
{set $r = $_modx->resource}
{set $nav = $_modx->runSnippet('pdoResources', [
    'parents' => $r.parent,
    'depth' => 0,
    'limit' => 0,
    'showHidden' => 1,
    'sortby' => 'menuindex',
    'sortdir' => 'ASC',
    'tpl' => 'lb.pfTab'
])}
{set $gallery = $_modx->runSnippet('!ms2Gallery', ['tpl' => 'lb.galleryPage', 'frontend_css' => '', 'frontend_js' => ''])}
{set $link = $r['link-bl6'] | trim}
<section class="lb-pgallery" id="lb-pgallery">
    <div class="lb-pgallery__bg" aria-hidden="true"></div>
    <div class="lb-pgallery__inner">
        {if $nav | trim}
        <nav class="lb-pgallery__nav" aria-label="{'lbar.rd.pf.nav' | lexicon}">
            <a class="lb-pgallery__tab lb-pgallery__tab--all" href="{$r.parent | url}">{'lbar.rd.pf.all' | lexicon}</a>
            {$nav}
        </nav>
        {/if}
        {$gallery}
        <div class="lb-pgallery__foot">
            <button class="lb-btn lb-btn--solid lb-pgallery__more" type="button" aria-controls="lb-gallery">{'lbar.rd.pf.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></button>
            {if $link}
            <a class="lb-btn lb-btn--ghost" href="{$link}">{'lbar.portfolio.button.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
            {/if}
        </div>
    </div>
</section>
