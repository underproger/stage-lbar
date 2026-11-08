{* Комментарий к статье (tpl ecMessages в lb-comments): имя, звёзды, текст и ответ студии — полностью (как в старом tpl.ecMessages.Row.Blog). *}
{set $name = $user_name | trim}
{set $parts = $name | replace : ',' : ' ' | split : ' '}
{set $ini = $parts[0] | truncate : 1 : ''}
{if $parts[1]?}{set $ini = $ini ~ ($parts[1] | truncate : 1 : '')}{/if}
{set $star = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.4l2.95 6.02 6.63.95-4.8 4.67 1.13 6.6L12 17.52l-5.91 3.12 1.13-6.6-4.8-4.67 6.63-.95z"/></svg>'}
<article class="lb-comment" id="ec-{$thread_name}-message-{$id}">
    <div class="lb-comment__head">
        <span class="lb-rcard__ava lb-rcard__ava--{($name | crc32) % 4}" aria-hidden="true">{$ini | upper}</span>
        <div class="lb-comment__who">
            <div class="lb-comment__name">{$name}</div>
            {if $rating > 0}
            <div class="lb-rcard__stars" role="img" aria-label="{$rating} / 5">{foreach 1..5 as $i}<span class="lb-rcard__star{if $i > $rating} is-off{/if}">{$star}</span>{/foreach}</div>
            {/if}
        </div>
    </div>
    <div class="lb-comment__text">{$text}</div>
    {if $reply_text}
    <div class="lb-comment__reply">{if $reply_author}<b>{$reply_author}</b>{/if}<div>{$reply_text}</div></div>
    {/if}
</article>
