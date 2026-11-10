{* Страница «О нас» (шаг 47): «За кулисами» — H2, короткий текст и 5 фото с подписями (2 в первом ряду, 3 во втором),
   по клику — окно просмотра (fancybox старого main.js, группа lb-aculise). Фото — с сайта: студия, мастер-класс и дипломы —
   галерея «Фрагменты обучения» (ресурс 126), чемпионат — вырезка мастера с кубком (img/master-v2.webp, как в блоке «Мастер»),
   процедура — кадр «implică» (img/about-procedure.webp). Подписи — лексикон lbar.rd.ab.cul.* .
   Ниже — видео с канала YouTube @kseniyalbarstudio (ролики — по выбору пользователя, шаг 48): превью i.ytimg.com (hqdefault,
   4:3 с полосами — в карточке 16:9 полосы обрезаются), по клику — ролик в окне fancybox (группа lb-avideo, как «implică»).
   Подписи — лексикон lbar.rd.ab.vid.1–5, ссылка «Все видео» — на канал. Порядок роликов — массив $videos ниже. *}
{$_modx->lexicon->load('babel:translate')}
{set $tiles = [
    ['src' => '/assets/images/resources/126/obuch1-min-1.jpg', 'w' => 800, 'h' => 600, 'cut' => 0],
    ['src' => '/assets/templates/redesign/img/master-v2.webp', 'w' => 860, 'h' => 1106, 'cut' => 1],
    ['src' => '/assets/templates/redesign/img/about-procedure.webp', 'w' => 760, 'h' => 730, 'cut' => 0],
    ['src' => '/assets/images/resources/126/obuch20-min.jpg', 'w' => 700, 'h' => 700, 'cut' => 0],
    ['src' => '/assets/images/resources/126/obuch26-min.jpg', 'w' => 700, 'h' => 700, 'cut' => 0],
]}
{set $videos = ['PJqHE2pRXgY', 'PhwprTgrmi0', 'N0eVKPtpJFA', '3uWCXcCothQ', 'Qjl6Ia0EuTk']}
{set $arr = '<svg class="lb-avideo__arr" viewBox="0 0 22 12" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 6h19M15.5 1.5 20 6l-4.5 4.5"/></svg>'}
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

        <div class="lb-avideo">
            <div class="lb-avideo__head">
                <h3 class="lb-avideo__title">{'lbar.rd.ab.vid.title' | lexicon}</h3>
                <a class="lb-avideo__all" href="https://www.youtube.com/@kseniyalbarstudio/videos" target="_blank" rel="nofollow noopener">{'lbar.rd.ab.vid.all' | lexicon}{$arr}</a>
            </div>
            <ul class="lb-avideo__list">
                {foreach $videos as $i => $v}
                {set $cap = ('lbar.rd.ab.vid.' ~ ($i + 1)) | lexicon}
                <li class="lb-avideo__item">
                    <a class="lb-avideo__link" href="https://www.youtube.com/watch?v={$v}" data-fancybox="lb-avideo" data-caption="{$cap}">
                        <span class="lb-avideo__thumb">
                            <img src="https://i.ytimg.com/vi/{$v}/hqdefault.jpg" width="480" height="360" alt="{$cap}" loading="lazy" decoding="async">
                            <span class="lb-avideo__play" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M8 5.6v12.8c0 .7.8 1.1 1.4.7l10-6.4c.5-.3.5-1.1 0-1.4l-10-6.4C8.8 4.5 8 4.9 8 5.6z"/></svg></span>
                        </span>
                        <span class="lb-avideo__cap">{$cap}</span>
                    </a>
                </li>
                {/foreach}
            </ul>
        </div>
    </div>
</section>
