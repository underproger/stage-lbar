{* Страница «О нас» (шаг 47): «Шесть причин выбрать нас» (строки: что / цифра или факт / пояснение — лексикон lbar.rd.ab.why.*)
   и карточка «О студии»: H2 — pagetitle ресурса (прежний H1 страницы, согласовано; первая половина слов прямо, остальное курсивом —
   только разметка), текст — прежний TV description-banner-inerial без правок (в нём и ссылки «Отзывы» / «Вакансии»), в две колонки.
   Низ блока уходит в «Вопросы и ответы» лентой seam-faq (как «Отзывы» → FAQ на главной). *}
{$_modx->lexicon->load('babel:translate')}
{set $r = $_modx->resource}
{set $words = $r.pagetitle | trim | split : ' '}
{set $n = $words | length}
{set $k = ($n + 1 - ($n + 1) % 2) / 2}
<section class="lb-areasons" id="lb-areasons">
    <div class="lb-areasons__inner">
        <h2 class="lb-areasons__title"><span class="lb-areasons__t1">{'lbar.rd.ab.why.h2a' | lexicon}</span> <span class="lb-areasons__t2">{'lbar.rd.ab.why.h2b' | lexicon}</span></h2>
        <ul class="lb-areasons__list">
            {foreach [1, 2, 3, 4, 5, 6] as $i}
            <li class="lb-areasons__row">
                <span class="lb-areasons__l">{('lbar.rd.ab.why.' ~ $i ~ 'l') | lexicon}</span>
                <span class="lb-areasons__v">{('lbar.rd.ab.why.' ~ $i ~ 'v') | lexicon}</span>
                <span class="lb-areasons__t">{('lbar.rd.ab.why.' ~ $i ~ 't') | lexicon}</span>
            </li>
            {/foreach}
        </ul>

        <article class="lb-astudio">
            <h2 class="lb-astudio__title">{foreach $words as $j => $w}{if $j == $k}<span class="lb-astudio__t2">{/if}{if $j} {/if}{$w}{/foreach}{if $n > $k}</span>{/if}</h2>
            <div class="lb-astudio__text">{$r['description-banner-inerial']}</div>
        </article>
    </div>
</section>
