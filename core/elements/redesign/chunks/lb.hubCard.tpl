{* Карточка услуги на общей странице «Услуги» (tpl pdoResources в lb-subservices, режим hub) — вид lb-scard.
   Название — menutitle (как в меню; TV title-bl2 у многих услуг заполнен копией чужого названия).
   Фото: у трёх услуг главной — фото из макета (как в lb.serviceCard), иначе TV img_banner_main → TV im-category → первое фото галереи (у EN-ресурса — галерея RO-двойника, BabelTranslation).
   Текст: TV intro-text-bl2 → TV sub-title-banner (на RO-странице текст на кириллице пропускается — в базе есть RU-текст у RO-ресурса). *}
{$_modx->lexicon->load('babel:translate')}
{set $map = [2 => 'brows', 303 => 'brows', 1002 => 'brows', 162 => 'eyeliner', 317 => 'eyeliner', 1162 => 'eyeliner', 167 => 'lips', 319 => 'lips', 1167 => 'lips']}
{set $title = $menutitle ?: $pagetitle}
{set $src = $map[$id] ? ('/assets/templates/redesign/img/service-' ~ $map[$id] ~ '.webp') : (($_pls['tv.img_banner_main'] | trim) ?: ($_pls['tv.im-category'] | trim))}
{if !$src}
{set $gid = $id}
{if $context_key == 'en'}{set $ro = $_modx->runSnippet('BabelTranslation', ['resourceId' => $id, 'contextKey' => 'web']) | trim}{if $ro}{set $gid = $ro}{/if}{/if}
{set $src = $_modx->runSnippet('ms2Gallery', ['resources' => $gid, 'limit' => 1, 'frontend_css' => '', 'frontend_js' => '', 'tpl' => '@INLINE {foreach $files as $f}{$f.medium}{/foreach}']) | trim}
{/if}
{if $src && !($src | ematch : '~^(/|https?:)~')}{set $src = '/' ~ $src}{/if}
{set $text = $_pls['tv.intro-text-bl2'] | trim}
{if !$text}
{set $text = $_pls['tv.sub-title-banner'] | trim}
{if $context_key == 'web' && ($text | ematch : '~\p{Cyrillic}~u')}{set $text = ''}{/if}
{/if}
<article class="lb-scard">
    <a class="lb-scard__img" href="{$uri}" aria-label="{$title | escape}">
        {if $src}<img src="{$src | replace : ' ' : '%20'}" alt="{$title | escape}" width="420" height="400" loading="lazy" decoding="async">{/if}
    </a>
    <div class="lb-scard__body">
        <div class="lb-scard__num" aria-hidden="true">{$idx < 10 ? '0' : ''}{$idx}</div>
        <div class="lb-scard__title"><a href="{$uri}">{$title}</a></div>
        {if $text}<div class="lb-scard__text">{$text}</div>{/if}
        <a class="lb-btn lb-btn--ghost lb-btn--sm lb-scard__btn" href="{$uri}">{'lbar.buttons.category.more' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
    </div>
</article>
