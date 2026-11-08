{* Блок «Статьи» (редизайн, главная, после SEO-текста) — вместо bl-blog. Макета не было — сделан в стилистике сайта.
   Данные — прежние TV главной: заголовок title-blog-bl12 (как и раньше — не заголовок h2, а подпись блока; разбивка/курсив — лексикон
   lbar.rd.blog.title, если TV изменят — выводится как есть), карточки img-st-N / alt-st-N / title-st-N / text-st-N (N = 1…3; 2-я и 3-я —
   если заполнен заголовок, как в старом чанке). В старом чанке у 2-й карточки по ошибке выводился text-st-1 — здесь text-st-2.
   Ссылка карточки — TV link-st-N (id или путь статьи, разбор — чанк lb.blogHref): если статья опубликована, заголовок становится ссылкой,
   а её область (::after) растянута на всю карточку; удалённые / снятые статьи — карточка без ссылки. Кнопка «Toate articolele» — на блог (RO, id 31);
   в RU блога нет — кнопка не выводится. Картинки — pthumb, как раньше; если файла нет — под ним графическая подложка. *}
{set $raw = $_modx->resource['title-blog-bl12'] | trim}
{set $title = $raw | striptags | replace : '  ' : ' ' | trim}
{set $fmt = 'lbar.rd.blog.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
{set $isRu = $_modx->config.cultureKey == 'ru'}
{set $read = 'lbar.rd.blog.read' | lexicon}
{* Карточки — развёрнуты по номерам. Порядок обработки: сначала MODX-теги, потом Fenom — поэтому переменные Fenom внутри MODX-тегов нельзя
   (pThumb получал имя TV с «{$i}» буквально), а значения TV — не в строковые литералы Fenom (кавычки в тексте сломали бы шаблон). *}
<section class="lb-blog" id="lb-blog">
    <div class="lb-blog__bg" aria-hidden="true"></div>
    <div class="lb-blog__inner">
        {if $raw}
        <div class="lb-blog__head">
            <div class="lb-blog__title">
                {if $plain == $title}
                {foreach ($fmt | split : '|') as $line}
                <span class="lb-blog__line"><span class="lb-blog__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
                {/foreach}
                {else}
                <span class="lb-blog__line"><span class="lb-blog__lin">{$_modx->getChunk('lb.accent', ['t' => $raw])}</span></span>
                {/if}
            </div>
            <svg class="lb-blog__flourish" viewBox="0 0 440 50" aria-hidden="true">
                <defs>
                    <linearGradient id="lb-blog-fl" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0" stop-color="#a87856" stop-opacity="0"/>
                        <stop offset=".3" stop-color="#a87856" stop-opacity=".9"/>
                        <stop offset=".7" stop-color="#a87856" stop-opacity=".85"/>
                        <stop offset="1" stop-color="#a87856" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path fill="url(#lb-blog-fl)" d="M12 45C110 25 240 9 392 13C250 14 120 30 12 45Z"/>
                <path fill="url(#lb-blog-fl)" d="M100 40C140 26 190 15 250 11C195 18 150 30 106 42C101 44 97 42 100 40Z"/>
            </svg>
        </div>
        {/if}

        <div class="lb-blog__list">
            {set $href1 = $_modx->getChunk('lb.blogHref', ['v' => $_modx->resource['link-st-1']]) | trim}
            <article class="lb-blog__card{if $href1} lb-blog__card--link{/if}">
                <div class="lb-blog__img">
                    <img src="[[pthumb? &input=`[[*img-st-1]]` &options=`w=1040&h=700&zc=1`]]" alt="[[*alt-st-1]]" width="520" height="350">
                </div>
                <div class="lb-blog__info">
                    <span class="lb-blog__num" aria-hidden="true">01</span>
                    <div class="lb-blog__name">{if $href1}<a class="lb-blog__link" href="{$href1}">[[*title-st-1]]</a>{else}[[*title-st-1]]{/if}</div>
                    <div class="lb-blog__text">[[*text-st-1]]</div>
                    {if $href1}<span class="lb-blog__more" aria-hidden="true">{$read}<svg viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></span>{/if}
                </div>
            </article>
            {if ($_modx->resource['title-st-2'] | trim)}
            {set $href2 = $_modx->getChunk('lb.blogHref', ['v' => $_modx->resource['link-st-2']]) | trim}
            <article class="lb-blog__card{if $href2} lb-blog__card--link{/if}">
                <div class="lb-blog__img">
                    <img src="[[pthumb? &input=`[[*img-st-2]]` &options=`w=1040&h=700&zc=1`]]" alt="[[*alt-st-2]]" width="520" height="350">
                </div>
                <div class="lb-blog__info">
                    <span class="lb-blog__num" aria-hidden="true">02</span>
                    <div class="lb-blog__name">{if $href2}<a class="lb-blog__link" href="{$href2}">[[*title-st-2]]</a>{else}[[*title-st-2]]{/if}</div>
                    <div class="lb-blog__text">[[*text-st-2]]</div>
                    {if $href2}<span class="lb-blog__more" aria-hidden="true">{$read}<svg viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></span>{/if}
                </div>
            </article>
            {/if}
            {if ($_modx->resource['title-st-3'] | trim)}
            {set $href3 = $_modx->getChunk('lb.blogHref', ['v' => $_modx->resource['link-st-3']]) | trim}
            <article class="lb-blog__card{if $href3} lb-blog__card--link{/if}">
                <div class="lb-blog__img">
                    <img src="[[pthumb? &input=`[[*img-st-3]]` &options=`w=1040&h=700&zc=1`]]" alt="[[*alt-st-3]]" width="520" height="350">
                </div>
                <div class="lb-blog__info">
                    <span class="lb-blog__num" aria-hidden="true">03</span>
                    <div class="lb-blog__name">{if $href3}<a class="lb-blog__link" href="{$href3}">[[*title-st-3]]</a>{else}[[*title-st-3]]{/if}</div>
                    <div class="lb-blog__text">[[*text-st-3]]</div>
                    {if $href3}<span class="lb-blog__more" aria-hidden="true">{$read}<svg viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></span>{/if}
                </div>
            </article>
            {/if}
        </div>

        {if !$isRu}
        <div class="lb-blog__cta">
            <a class="lb-btn lb-btn--ghost" href="[[~31]]">{'lbar.rd.blog.all' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
        </div>
        {/if}
    </div>
</section>
