{* Удаление тату (шаблон «Удаление тату», шаг 54): «Какое оборудование используем» — вместо bl3-service-equipment.
   Тексты — прежние TV, без правок: H2 — bl3_service_equipment-title (span.gold-word → курсив, текст тот же), подзаголовок —
   bl3_service_equipment-subtitle, карточки — MIGX bl3_service_equipment-list (фото + название; название — H4, как было),
   примечание — bl3_service_equipment-notification (strong → b, как в старом блоке). Стоит на месте «implică» услуг: сверху — из
   «О процедуре», снизу — в «Консультацию» (стыки — _seam.scss). Стили — scss/_tz.scss. *}
{set $r = $_modx->resource}
{set $title = $r['bl3_service_equipment-title'] | trim | replace : '<span class="gold-word">' : '<em>' | replace : '</span>' : '</em>'}
{set $sub = $r['bl3_service_equipment-subtitle'] | trim}
{set $list = ($r['bl3_service_equipment-list'] ?: '[]') | fromJSON}
{set $note = $r['bl3_service_equipment-notification'] | trim | replace : '<strong>' : '<b>' | replace : '</strong>' : '</b>'}
<section class="lb-tzequip" id="lb-tzequip">
    <div class="lb-tzequip__bg" aria-hidden="true"></div>
    <div class="lb-tzequip__inner">
        <div class="lb-tzequip__head">
            <h2 class="lb-tzequip__title">{$title}</h2>
            {if $sub}<div class="lb-tzequip__sub">{$sub}</div>{/if}
        </div>
        <div class="lb-tzequip__grid">
            {if $list}
            <ul class="lb-tzequip__list">
                {foreach $list as $i => $it}
                {set $src = $it.image | trim}
                {if $src && !($src | ematch : '~^(/|https?:)~')}{set $src = '/' ~ $src}{/if}
                <li class="lb-tzequip__item">
                    <div class="lb-tzequip__photo">
                        {if $src}<img src="{$src}" alt="{$it.title | striptags | escape}" loading="lazy" decoding="async">{/if}
                    </div>
                    <span class="lb-tzequip__num" aria-hidden="true">{($i + 1) | ereplace : '~^(\d)$~' : '0$1'}</span>
                    <h4 class="lb-tzequip__name">{$it.title}</h4>
                </li>
                {/foreach}
            </ul>
            {/if}
            {if $note}
            <div class="lb-tzequip__note">
                <span class="lb-tzequip__ic" aria-hidden="true"><svg viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 4v8M20 28v8M4 20h8M28 20h8M8.7 8.7l5.6 5.6M25.7 25.7l5.6 5.6M31.3 8.7l-5.6 5.6M14.3 25.7l-5.6 5.6"/><circle cx="20" cy="20" r="3"/></svg></span>
                <div class="lb-tzequip__text">{$note}</div>
            </div>
            {/if}
        </div>
    </div>
</section>
