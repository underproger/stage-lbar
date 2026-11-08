{* Текст и галерея внутренней страницы. Шаблоны «Внутренняя - Галерея» (13, портфолио — вместо bl6-portfolio-interial),
   «Внутренняя» (3: «О нас», вакансии, сертификат) и «Отзывы» (16) — вместо [[*gallery_select:notempty=`[[$bl6-portfolio-interial-2]]`]].
   Текст — длинный TV description-banner-inerial (> 300 знаков; в баннер не помещается; короткий выводит баннер lb-shero), карточкой,
   в одну колонку. Галерея — ms2Gallery ресурса (tpl lb.galleryPage): в шаблоне 13 — всегда, в остальных — если задан TV gallery_select
   (как раньше); первые 16 фото, дальше — кнопкой по 16 (redesign.js), увеличение — fancybox. Кнопка на TV link-bl6 — как в старом блоке.
   Нет ни текста, ни фото — блок не выводится. Заголовка у старого блока не было — здесь тоже. *}
{set $r = $_modx->resource}
{set $showGal = $r.template == 13 || ($r['gallery_select'] | trim)}
{set $gallery = $showGal ? ($_modx->runSnippet('!ms2Gallery', ['tpl' => 'lb.galleryPage', 'frontend_css' => '', 'frontend_js' => '']) | trim) : ''}
{set $link = $r['link-bl6'] | trim}
{set $desc = $r['description-banner-inerial'] | trim}
{if !$desc || ($desc | striptags | trim | length) <= 300}{set $desc = ''}{/if}
{if $desc || $gallery}
<section class="lb-pgallery{$gallery ? '' : ' lb-pgallery--text'}" id="lb-pgallery">
    <div class="lb-pgallery__bg" aria-hidden="true"></div>
    <div class="lb-pgallery__inner">
        {if $desc}
        <div class="lb-pgallery__intro">
            <div class="lb-pgallery__text">{$desc}</div>
        </div>
        {/if}
        {if $gallery}
        {$gallery}
        <div class="lb-pgallery__foot">
            <button class="lb-btn lb-btn--solid lb-pgallery__more" type="button" aria-controls="lb-gallery">{'lbar.rd.pf.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></button>
            {if $link}
            <a class="lb-btn lb-btn--ghost" href="{$link}">{'lbar.portfolio.button.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
            {/if}
        </div>
        {/if}
    </div>
</section>
{/if}
