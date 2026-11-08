{* Блок «SEO-текст» (редизайн, главная, после FAQ) — вместо bl-seo.
   ВАЖНО: тексты выводятся как есть, теми же тегами MODX, что в старом чанке (TV title-bl-seo, text-bl-seo, text-bl-seo-2).
   В HTML текста ничего не добавляется и не меняется (никаких span/em/классов внутри): всё оформление — только CSS по существующим тегам
   (h2, h3, p, ul/li, strong) в scss/_seo.scss. Новые здесь только обёртки блока.
   Картинка TV img-bl-seo (seo-img-1.jpg — файла на сайте нет) и декоративная opacity-text-bl11.png не выводятся: в макете их нет.
   Страницы услуг: картинка TV img-bl-seo (alt — img-bl-alt, как в старом bl-seo) выводится в шапке над H2 (модификатор --img). *}
{set $pic = ($_modx->resource.id != $_modx->config.site_start) ? ('[[*img-bl-seo]]' | trim) : ''}
<section class="lb-seo" id="lb-seo">
    <div class="lb-seo__bg" aria-hidden="true"></div>
    <div class="lb-seo__inner">
        <div class="lb-seo__head{$pic ? ' lb-seo__head--img' : ''}">
            {if $pic}
            <img class="lb-seo__img" src="/{$pic | replace : ' ' : '%20'}" alt="{('[[*img-bl-alt]]' | trim) | escape}" width="560" height="400" loading="lazy" decoding="async">
            {/if}
            <h2 class="lb-seo__title">[[*title-bl-seo]]</h2>
            <div class="lb-seo__lead">[[*text-bl-seo]]</div>
        </div>
        <div class="lb-seo__body">[[*text-bl-seo-2]]</div>
    </div>
</section>
