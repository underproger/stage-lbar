{* Страница «О нас» (шаг 47): «За кулисами» — H2, короткий текст и 5 фото с подписями (2 в первом ряду, 3 во втором),
   по клику — окно просмотра (fancybox старого main.js, группа lb-aculise). Фото — с сайта: студия, мастер-класс и дипломы —
   галерея «Фрагменты обучения» (ресурс 126), чемпионат — вырезка мастера с кубком (img/master-v2.webp, как в блоке «Мастер»),
   процедура — кадр «implică» (img/about-procedure.webp). Подписи — лексикон lbar.rd.ab.cul.* . *}
{$_modx->lexicon->load('babel:translate')}
{set $tiles = [
    ['src' => '/assets/images/resources/126/obuch1-min-1.jpg', 'w' => 800, 'h' => 600, 'cut' => 0],
    ['src' => '/assets/templates/redesign/img/master-v2.webp', 'w' => 860, 'h' => 1106, 'cut' => 1],
    ['src' => '/assets/templates/redesign/img/about-procedure.webp', 'w' => 760, 'h' => 730, 'cut' => 0],
    ['src' => '/assets/images/resources/126/obuch20-min.jpg', 'w' => 700, 'h' => 700, 'cut' => 0],
    ['src' => '/assets/images/resources/126/obuch26-min.jpg', 'w' => 700, 'h' => 700, 'cut' => 0],
]}
<section class="lb-aculise" id="lb-aculise">
    <div class="lb-aculise__inner">
        <div class="lb-aculise__head">
            <h2 class="lb-aculise__title"><span class="lb-aculise__t1">{'lbar.rd.ab.cul.h2a' | lexicon}</span> <span class="lb-aculise__t2">{'lbar.rd.ab.cul.h2b' | lexicon}</span></h2>
            <p class="lb-aculise__side">{'lbar.rd.ab.cul.side' | lexicon}</p>
        </div>
        <div class="lb-aculise__grid">
            {foreach $tiles as $i => $t}
            {set $cap = ('lbar.rd.ab.cul.' ~ ($i + 1)) | lexicon}
            <a class="lb-aculise__tile{if $t.cut} lb-aculise__tile--cut{/if}" href="{$t.src}" data-fancybox="lb-aculise" data-caption="{$cap}">
                <img src="{$t.src}" width="{$t.w}" height="{$t.h}" alt="{$cap}" loading="lazy" decoding="async">
                <span class="lb-aculise__cap">{$cap}</span>
            </a>
            {/foreach}
        </div>
    </div>
</section>
