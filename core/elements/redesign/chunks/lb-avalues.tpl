{* Страница «О нас» (шаг 47): «Мой принцип» (цитата с подписью и фото) и «Ценности» — H2, короткий текст, четыре карточки
   (первая тёмная, как в макете). Верх блока — волна из тёмного «Шесть шагов» (как «Мастер» → «Галерея» на главной).
   Тексты — лексикон lbar.rd.ab.man.* / val.* . *}
{$_modx->lexicon->load('babel:translate')}
<section class="lb-avalues" id="lb-avalues">
    <div class="lb-avalues__bg" aria-hidden="true"></div>

    <div class="lb-avalues__inner">
        <figure class="lb-avalues__man">
            <blockquote class="lb-avalues__quote"><p>{'lbar.rd.ab.man.text' | lexicon} <span class="lb-avalues__tail">{'lbar.rd.ab.man.tail' | lexicon}</span></p></blockquote>
            <figcaption class="lb-avalues__author">
                <img class="lb-avalues__ava" src="/assets/templates/redesign/img/about-avatar.webp" width="160" height="160" alt="" loading="lazy" decoding="async">
                <span class="lb-avalues__who"><span class="lb-avalues__name">{'lbar.rd.ab.name' | lexicon}</span><span class="lb-avalues__role">{'lbar.rd.ab.man.role' | lexicon}</span></span>
            </figcaption>
        </figure>

        <div class="lb-avalues__head">
            <h2 class="lb-avalues__title"><span class="lb-avalues__t1">{'lbar.rd.ab.val.h2a' | lexicon}</span> <span class="lb-avalues__t2">{'lbar.rd.ab.val.h2b' | lexicon}</span></h2>
            <p class="lb-avalues__side">{'lbar.rd.ab.val.side' | lexicon}</p>
        </div>
        <ul class="lb-avalues__list">
            {foreach [1, 2, 3, 4] as $i}
            <li class="lb-avalues__card{if $i == 1} lb-avalues__card--dark{/if}">
                <span class="lb-avalues__n" aria-hidden="true">0{$i}</span>
                <span class="lb-avalues__t">{('lbar.rd.ab.val.' ~ $i ~ 't') | lexicon}</span>
                <span class="lb-avalues__d">{('lbar.rd.ab.val.' ~ $i ~ 'd') | lexicon}</span>
            </li>
            {/foreach}
        </ul>
    </div>
</section>
