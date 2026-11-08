{* Внутренние страницы портфолио (шаблон «Внутренняя - Галерея», id 13) — вместо bl6-portfolio-interial.
   Фото — ms2Gallery ресурса (tpl lb.galleryPage): первые 16 видны, дальше — кнопкой по 16 (redesign.js), увеличение — fancybox.
   Кнопка на TV link-bl6 — как в старом блоке. Заголовка у старого блока не было — здесь тоже.
   Длинный TV description-banner-inerial (> 300 знаков; у мастеров — биография) в баннер не помещается — выводится здесь,
   карточкой над галереей, в одну колонку. Короткий выводит баннер (lb-shero). *}
{set $r = $_modx->resource}
{set $gallery = $_modx->runSnippet('!ms2Gallery', ['tpl' => 'lb.galleryPage', 'frontend_css' => '', 'frontend_js' => ''])}
{set $link = $r['link-bl6'] | trim}
{set $desc = $r['description-banner-inerial'] | trim}
{if !$desc || ($desc | striptags | trim | length) <= 300}{set $desc = ''}{/if}
<section class="lb-pgallery" id="lb-pgallery">
    <div class="lb-pgallery__bg" aria-hidden="true"></div>
    <div class="lb-pgallery__inner">
        {if $desc}
        <div class="lb-pgallery__intro">
            <div class="lb-pgallery__text">{$desc}</div>
        </div>
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
