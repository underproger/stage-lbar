{* Блок «SEO-текст» (редизайн, главная, после FAQ) — вместо bl-seo.
   ВАЖНО: тексты выводятся как есть, теми же тегами MODX, что в старом чанке (TV title-bl-seo, text-bl-seo, text-bl-seo-2).
   В HTML текста ничего не добавляется и не меняется (никаких span/em/классов внутри): всё оформление — только CSS по существующим тегам
   (h2, h3, p, ul/li, strong) в scss/_seo.scss. Новые здесь только обёртки блока.
   Картинка TV img-bl-seo (seo-img-1.jpg — файла на сайте нет) и декоративная opacity-text-bl11.png не выводятся: в макете их нет. *}
<section class="lb-seo" id="lb-seo">
    <div class="lb-seo__bg" aria-hidden="true"></div>
    <div class="lb-seo__inner">
        <div class="lb-seo__head">
            <h2 class="lb-seo__title">[[*title-bl-seo]]</h2>
            <div class="lb-seo__lead">[[*text-bl-seo]]</div>
        </div>
        <div class="lb-seo__body">[[*text-bl-seo-2]]</div>
    </div>
</section>
