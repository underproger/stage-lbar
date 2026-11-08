{* Блок «SEO-текст» (редизайн, главная и страницы услуг, после FAQ) — вместо bl-seo.
   ВАЖНО: тексты выводятся как есть, теми же тегами MODX, что в старом чанке (TV title-bl-seo, text-bl-seo, text-bl-seo-2).
   В HTML текста ничего не добавляется и не меняется (никаких span/em/классов внутри): всё оформление — только CSS по существующим тегам
   (h2, h3, p, ul/li, strong) в scss/_seo.scss. Новые здесь только обёртки блока. Декоративная opacity-text-bl11.png не выводится.
   Картинка TV img-bl-seo (alt — img-bl-alt, как в старом bl-seo; пусто — текст H2): слева, справа — H2 и первый текст за медной линией
   (модификатор --img). Нет картинки — H2 слева, текст справа (как в макете главной). *}
{set $pic = '[[*img-bl-seo]]' | trim}
<section class="lb-seo" id="lb-seo">
    <div class="lb-seo__bg" aria-hidden="true"></div>
    <div class="lb-seo__inner">
        {if $pic}
        <div class="lb-seo__head lb-seo__head--img">
            <img class="lb-seo__img" src="/{$pic | replace : ' ' : '%20'}" alt="{(('[[*img-bl-alt]]' | trim) ?: ('[[*title-bl-seo]]' | striptags | trim)) | escape}" width="560" height="400" loading="lazy" decoding="async">
            <div class="lb-seo__side">
                <h2 class="lb-seo__title">[[*title-bl-seo]]</h2>
                <div class="lb-seo__lead">[[*text-bl-seo]]</div>
            </div>
        </div>
        {else}
        <div class="lb-seo__head">
            <h2 class="lb-seo__title">[[*title-bl-seo]]</h2>
            <div class="lb-seo__lead">[[*text-bl-seo]]</div>
        </div>
        {/if}
        <div class="lb-seo__body">[[*text-bl-seo-2]]</div>
    </div>
</section>
