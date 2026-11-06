{* Галерея главной (tpl для ms2Gallery): сетка 4 / 3 / 2 в ряд, первые 8 фото видны, остальные — по кнопке.
   Ссылки на полноразмерные фото с data-fancybox — как в старом tpl.ms2GalleryPortfolioFrontPage. *}
{if $files?}
<div class="lb-gallery" id="lb-gallery">
    {foreach $files as $key => $file}
    <a class="lb-gallery__item{$key > 7 ? ' lb-gallery__item--more' : ''}" href="{$file['url']}" data-fancybox="gallery-{$file['resource_id']}" aria-label="{$file['description'] ?: $file['name']}">
        <img src="{$file['medium']}" srcset="{$file['medium']} 400w, {$file['url']} 1200w" sizes="(max-width: 600px) 50vw, (max-width: 1024px) 33vw, 22vw" alt="{$file['description']}" width="400" height="400" loading="lazy" decoding="async">
        <span class="lb-gallery__zoom" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.5 15.5 5 5M10.5 7.5v6M7.5 10.5h6"/></svg></span>
    </a>
    {/foreach}
</div>
{/if}
