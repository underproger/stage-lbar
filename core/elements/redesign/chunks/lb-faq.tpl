{* Блок «Вопросы и ответы» (редизайн, главная, после «Отзывов») — вместо bl-faq (условие migx_questions:notempty в шаблоне сохранено).
   H2 — прежний TV title-bl-faq (текст не менялся); разбивка на строки и курсив — лексикон lbar.rd.faq.title
   («|» — перенос, *…* — курсив; сравнение — без тегов: в RU-TV есть <br/>). Если TV изменят — H2 выводится как есть.
   Вопросы и ответы — прежний MIGX TV migx_questions (questions-title / questions-text, до 18 шт., как в старом getImageList).
   Микроразметка schema.org FAQPage / Question / Answer — как в старом блоке. Аккордеон — redesign.js (первый вопрос открыт).
   Слева — короткий текст и кнопки (лексикон lbar.rd.faq.*): консультация → блок «Консультация», телефон — настройка phone-1
   (настройки ClientConfig — MODX-тегами (++ключ): в $_modx->config Fenom их может не оказаться, и в кэш попадёт пусто). *}
{set $raw = $_modx->resource['title-bl-faq'] | trim}
{set $title = $raw | striptags | replace : '  ' : ' ' | trim}
{set $fmt = 'lbar.rd.faq.title' | lexicon}
{set $plain = $fmt | replace : '|' : ' ' | replace : '*' : ''}
{set $items = $_modx->resource['migx_questions'] | fromJSON}
{if $items}
<section class="lb-faq" id="lb-faq">
    <div class="lb-faq__bg" aria-hidden="true"></div>

    <div class="lb-faq__inner">
        <div class="lb-faq__intro">
            {if $raw}
            <h2 class="lb-faq__title">
                {if $plain == $title}
                {foreach ($fmt | split : '|') as $line}
                <span class="lb-faq__line"><span class="lb-faq__lin">{foreach ($line | split : '*') as $k => $part}{if $k % 2}<em>{$part}</em>{else}{$part}{/if}{/foreach}</span></span>
                {/foreach}
                {else}
                <span class="lb-faq__line"><span class="lb-faq__lin">{$_modx->getChunk('lb.accent', ['t' => $raw])}</span></span>
                {/if}
            </h2>
            <svg class="lb-faq__flourish" viewBox="0 0 440 50" aria-hidden="true">
                <defs>
                    <linearGradient id="lb-faq-fl" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0" stop-color="#a87856" stop-opacity=".2"/>
                        <stop offset=".25" stop-color="#a87856" stop-opacity=".9"/>
                        <stop offset=".6" stop-color="#a87856" stop-opacity=".85"/>
                        <stop offset="1" stop-color="#a87856" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path fill="url(#lb-faq-fl)" d="M12 45C110 25 240 9 392 13C250 14 120 30 12 45Z"/>
                <path fill="url(#lb-faq-fl)" d="M100 40C140 26 190 15 250 11C195 18 150 30 106 42C101 44 97 42 100 40Z"/>
            </svg>
            {/if}
            <p class="lb-faq__text">{'lbar.rd.faq.text' | lexicon}</p>
            <div class="lb-faq__ctas">
                <a class="lb-btn lb-btn--solid lb-faq__btn js-lb-book" href="#lb-consult">{'lbar.rd.faq.cta' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
                <a class="lb-btn lb-btn--ghost lb-faq__btn lb-faq__btn--tel" href="tel:[[++phone-1:replace=` ==`]]"><svg class="lb-faq__tel" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 16.4v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 1.1 3.7 2 2 0 0 1 3.1 1.5h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L7.1 9.3a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.8 2.1z"/></svg>[[++phone-1]]</a>
            </div>
        </div>

        <ul class="lb-faq__list" itemscope="itemscope" itemtype="https://schema.org/FAQPage">
            {foreach $items as $i => $it}
            {if $i >= 18}{break}{/if}
            {set $n = $i + 1}
            <li class="lb-faq__item{if $n == 1} is-open{/if}" itemprop="mainEntity" itemscope="itemscope" itemtype="https://schema.org/Question">
                <button class="lb-faq__q" type="button" id="lb-faq-q{$n}" aria-controls="lb-faq-a{$n}" aria-expanded="{$n == 1 ? 'true' : 'false'}">
                    <span class="lb-faq__num" aria-hidden="true">{$n < 10 ? '0' : ''}{$n}</span>
                    <span class="lb-faq__qt" itemprop="name">{$it['questions-title']}</span>
                    <span class="lb-faq__ic" aria-hidden="true"></span>
                </button>
                <div class="lb-faq__a" id="lb-faq-a{$n}" role="region" aria-labelledby="lb-faq-q{$n}" itemprop="acceptedAnswer" itemscope="itemscope" itemtype="https://schema.org/Answer">
                    <div class="lb-faq__ain">
                        <div class="lb-faq__body" itemprop="text">{$it['questions-text']}</div>
                    </div>
                </div>
            </li>
            {/foreach}
        </ul>
    </div>
</section>
{/if}
