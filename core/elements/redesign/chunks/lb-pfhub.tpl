{* Страница «Портфолио» (шаблон «Портфолио», id 10) — карточки мастеров и разделов (вместо сеток в banner-interial-portfolio).
   Данные — прежние TV ресурса: мастера — img-master-N / alt-master-N / master-N / link-master-N (N = 1…3),
   разделы — img-p-N / alt-p-N / title-p-N / link-p-N (N = 1…5). Карточка без ссылки не выводится (в старом блоке 5-я была пустой).
   Заголовков H2 у старого блока не было — здесь тоже (надзаголовки из лексикона). Фото — исходные файлы
   (они 390×390, как и резал старый pthumb; карточки — квадратные фото, без лишнего пережатия). *}
{set $r = $_modx->resource}
{set $tvs = $_modx->getResource($r.id, ['includeTVs' => 'img-master-1,img-master-2,img-master-3,img-p-1,img-p-2,img-p-3,img-p-4,img-p-5', 'processTVs' => 1, 'tvPrefix' => '', 'select' => 'id'])}
{set $arr = '<svg class="lb-pfcard__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-pfhub" id="lb-pfhub">
    <div class="lb-pfhub__bg" aria-hidden="true"></div>
    <div class="lb-pfhub__inner">
        <div class="lb-pfhub__eyebrow">{'lbar.rd.pf.masters' | lexicon}</div>
        <div class="lb-pfhub__masters">
            {foreach 1..3 as $i}
            {set $link = $r['link-master-' ~ $i] | trim}
            {if $link}
            {set $img = $tvs['img-master-' ~ $i] | trim}
            {if $img && !($img | ematch : '~^(/|https?:)~')}{set $img = '/' ~ $img}{/if}
            <a class="lb-pfcard lb-pfcard--master" href="{$link}">
                <span class="lb-pfcard__img">{if $img}<img src="{$img | replace : ' ' : '%20'}" alt="{($r['alt-master-' ~ $i] ?: $r['master-' ~ $i]) | striptags | escape}" width="390" height="390" loading="lazy" decoding="async">{/if}</span>
                <span class="lb-pfcard__body">
                    <span class="lb-pfcard__title">{$r['master-' ~ $i]}</span>
                    <span class="lb-pfcard__more">{'lbar.rd.implica.portfolio' | lexicon}{$arr}</span>
                </span>
            </a>
            {/if}
            {/foreach}
        </div>

        <div class="lb-pfhub__eyebrow lb-pfhub__eyebrow--cats">{'lbar.rd.pf.cats' | lexicon}</div>
        <div class="lb-pfhub__cats">
            {foreach 1..5 as $i}
            {set $link = $r['link-p-' ~ $i] | trim}
            {if $link}
            {set $img = $tvs['img-p-' ~ $i] | trim}
            {if $img && !($img | ematch : '~^(/|https?:)~')}{set $img = '/' ~ $img}{/if}
            <a class="lb-pfcard lb-pfcard--cat" href="{$link}">
                <span class="lb-pfcard__img">{if $img}<img src="{$img | replace : ' ' : '%20'}" alt="{($r['alt-p-' ~ $i] ?: $r['title-p-' ~ $i]) | striptags | escape}" width="390" height="390" loading="lazy" decoding="async">{/if}</span>
                <span class="lb-pfcard__body">
                    <span class="lb-pfcard__num" aria-hidden="true">0{$i}</span>
                    <span class="lb-pfcard__title">{$r['title-p-' ~ $i]}</span>
                    <span class="lb-pfcard__more">{'lbar.rd.pf.open' | lexicon}{$arr}</span>
                </span>
            </a>
            {/if}
            {/foreach}
        </div>
    </div>
</section>
