{* Удаление тату (шаблон «Удаление тату», шаг 54): «Специалисты» — вместо bl7-service-specialists.
   Тексты — прежние TV, без правок: H2 — bl7_service_specialists-title (span.gold-word → курсив, текст тот же), карточки — MIGX
   bl7_service_specialists-list (фото, имя, описание — как было). Тёмный блок на месте «Мастера» услуг: сверху — тёмная волна
   из «Консультации», снизу — волна в «Галерею» (как у «Мастера»: фон — img/master-bg.webp, низ картинки по низу блока). *}
{set $r = $_modx->resource}
{set $title = $r['bl7_service_specialists-title'] | trim | replace : '<span class="gold-word">' : '<em>' | replace : '</span>' : '</em>'}
{set $list = ($r['bl7_service_specialists-list'] ?: '[]') | fromJSON}
<section class="lb-tzteam" id="lb-tzteam">
    <div class="lb-tzteam__bg" aria-hidden="true"></div>
    <div class="lb-tzteam__inner">
        <h2 class="lb-tzteam__title">{$title}</h2>
        {if $list}
        <ul class="lb-tzteam__list">
            {foreach $list as $it}
            {set $src = $it.image | trim}
            {if $src && !($src | ematch : '~^(/|https?:)~')}{set $src = '/' ~ $src}{/if}
            <li class="lb-tzteam__item">
                <div class="lb-tzteam__photo">
                    {if $src}<img src="{$src}" alt="{$it.name | striptags | escape}" loading="lazy" decoding="async">{/if}
                </div>
                <div class="lb-tzteam__info">
                    <p class="lb-tzteam__name">{$it.name}</p>
                    <p class="lb-tzteam__text">{$it.text}</p>
                </div>
            </li>
            {/foreach}
        </ul>
        {/if}
    </div>
</section>
