{* Страница «О нас» (шаг 47): «Шесть шагов» — тёмный блок (тон как у «Мастера» на главной). Слева (десктоп) — крупный номер
   текущего шага, «01 / 06» и полоса прогресса, прилипают при прокрутке; справа — шаги (H3 + текст). Текущий шаг —
   redesign.js: data-step у секции (0–5) и is-active у пункта; без JS видны все шаги и номер 01.
   На телефоне номер — перед заголовком каждого шага. Тексты — лексикон lbar.rd.ab.steps.* . *}
{$_modx->lexicon->load('babel:translate')}
<section class="lb-asteps" id="lb-asteps" data-step="0">
    <div class="lb-asteps__bg" aria-hidden="true"></div>

    <div class="lb-asteps__inner">
        <div class="lb-asteps__head">
            <h2 class="lb-asteps__title"><span class="lb-asteps__t1">{'lbar.rd.ab.steps.h2a' | lexicon}</span> <span class="lb-asteps__t2">{'lbar.rd.ab.steps.h2b' | lexicon}</span></h2>
            <p class="lb-asteps__side">{'lbar.rd.ab.steps.side' | lexicon}</p>
        </div>

        <div class="lb-asteps__body">
            <div class="lb-asteps__counter" aria-hidden="true">
                <span class="lb-asteps__nums">{foreach [1, 2, 3, 4, 5, 6] as $i}<span class="lb-asteps__n">0{$i}</span>{/foreach}</span>
                <span class="lb-asteps__of">{foreach [1, 2, 3, 4, 5, 6] as $i}<span class="lb-asteps__ofn">0{$i}</span>{/foreach} / 06</span>
                <span class="lb-asteps__bar"><span class="lb-asteps__fill"></span></span>
            </div>
            <ol class="lb-asteps__list">
                {foreach [1, 2, 3, 4, 5, 6] as $i}
                <li class="lb-asteps__item{if $i == 1} is-active{/if}">
                    <span class="lb-asteps__in" aria-hidden="true">0{$i}</span>
                    <h3 class="lb-asteps__it">{('lbar.rd.ab.steps.' ~ $i ~ 't') | lexicon}</h3>
                    <p class="lb-asteps__id">{('lbar.rd.ab.steps.' ~ $i ~ 'd') | lexicon}</p>
                </li>
                {/foreach}
            </ol>
        </div>
    </div>
</section>
