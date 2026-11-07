{* Карточка отзыва (tpl для ecMessages) в блоке «Отзывы». Поля EasyComm: user_name, text (с <br>), rating, reply_author, reply_text.
   Аватар — инициалы (фото клиенток нет); цвет — от имени. Текст в карточке обрезается CSS (8 строк), полный — в окне по кнопке ⋮
   (берётся из этой же разметки). Ответ студии виден только в окне. *}
{$_modx->lexicon->load('babel:translate')}
{set $name = $user_name | trim}
{set $parts = $name | replace : ',' : ' ' | split : ' '}
{set $ini = $parts[0] | truncate : 1 : ''}
{if $parts[1]?}{set $ini = $ini ~ ($parts[1] | truncate : 1 : '')}{/if}
{set $star = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.4l2.95 6.02 6.63.95-4.8 4.67 1.13 6.6L12 17.52l-5.91 3.12 1.13-6.6-4.8-4.67 6.63-.95z"/></svg>'}
<article class="lb-rcard" id="lb-rcard-{$id}">
    <div class="lb-rcard__head">
        <span class="lb-rcard__ava lb-rcard__ava--{($name | crc32) % 4}" aria-hidden="true">{$ini | upper}</span>
        <div class="lb-rcard__who">
            <div class="lb-rcard__name">{$name}</div>
            {if $rating > 0}
            <div class="lb-rcard__stars" role="img" aria-label="{$rating} / 5">{foreach 1..5 as $i}<span class="lb-rcard__star{if $i > $rating} is-off{/if}">{$star}</span>{/foreach}</div>
            {/if}
        </div>
        <button class="lb-rcard__more" type="button" aria-haspopup="dialog" aria-controls="lb-rmodal" aria-label="{$_modx->lexicon('lbar.rd.reviews.read')}: {$name | escape}"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="5.5" r="1.7"/><circle cx="12" cy="12" r="1.7"/><circle cx="12" cy="18.5" r="1.7"/></svg></button>
    </div>
    <div class="lb-rcard__text">{$text}</div>
    {if $reply_text}
    <div class="lb-rcard__reply" hidden>{if $reply_author}<b>{$reply_author}</b>{/if}<div>{$reply_text}</div></div>
    {/if}
</article>
