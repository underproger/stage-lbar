{* Страница «О нас» (шаг 47): «Обо мне» — H2, фото в арке (вырезка img/about-me-v2.webp), текст с цитатой, техники, подпись;
   ниже — четыре цифры (10+ лет, 6 000+ процедур, 400+ учеников, призёр). Тексты — лексикон lbar.rd.ab.story.* / num.* .
   Низ блока уходит в тёмный блок «Шесть шагов» волной (как «Консультация» → «Мастер» на главной, _apage.scss). *}
{$_modx->lexicon->load('babel:translate')}
<section class="lb-astory" id="lb-astory">
    <div class="lb-astory__bg" aria-hidden="true"></div>

    <div class="lb-astory__inner">
        <div class="lb-astory__aside">
            <h2 class="lb-astory__title"><span class="lb-astory__t1">{'lbar.rd.ab.story.h2a' | lexicon}</span> <span class="lb-astory__t2">{'lbar.rd.ab.story.h2b' | lexicon}</span></h2>
            <div class="lb-astory__media">
                <span class="lb-astory__frame" aria-hidden="true"></span>
                <span class="lb-astory__photo"><img src="/assets/templates/redesign/img/about-me-v2.webp" width="920" height="1227" alt="{'lbar.rd.ab.name' | lexicon}" loading="lazy" decoding="async"></span>
            </div>
        </div>

        <div class="lb-astory__text">
            <p>{'lbar.rd.ab.story.p1' | lexicon}</p>
            <p>{'lbar.rd.ab.story.p2' | lexicon}</p>
            <blockquote class="lb-astory__quote"><p>{'lbar.rd.ab.story.quote' | lexicon}</p></blockquote>
            <p>{'lbar.rd.ab.story.p3' | lexicon}</p>
            <p>{'lbar.rd.ab.story.p4' | lexicon}</p>
            <ul class="lb-astory__chips">
                {foreach ('lbar.rd.ab.story.chips' | lexicon | split : '|') as $chip}
                <li class="lb-astory__chip">{$chip}</li>
                {/foreach}
            </ul>
            <div class="lb-astory__sign"><span class="lb-astory__sname">{'lbar.rd.ab.name' | lexicon}</span><span class="lb-astory__srole">{'lbar.rd.ab.story.signrole' | lexicon}</span></div>
        </div>
    </div>

    <ul class="lb-astory__nums">
        {foreach [1, 2, 3, 4] as $i}
        <li class="lb-astory__num{if $i == 4} lb-astory__num--word{/if}">
            <span class="lb-astory__nv">{('lbar.rd.ab.num.' ~ $i ~ 'v') | lexicon}{if $i < 4}<span class="lb-astory__nu">{('lbar.rd.ab.num.' ~ $i ~ 'u') | lexicon}</span>{/if}</span>
            <span class="lb-astory__nt">{('lbar.rd.ab.num.' ~ $i ~ 't') | lexicon}</span>
        </li>
        {/foreach}
    </ul>
</section>
