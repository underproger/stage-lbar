{* tpl родительского пункта pdoMenu в шапке (tplParentRow). Пункт «Servicii / Услуги» (id 80 / 302) — мега-меню lb.navMega,
   остальные пункты с подменю — как раньше (выпадающий список .lb-nav__sub). *}
{if $id == 80 || $id == 302}
{$_modx->getChunk('lb.navMega', ['id' => $id, 'link' => $link, 'menutitle' => $menutitle, 'classes' => $classes, 'attributes' => $attributes])}
{else}
<li{$classes}><a class="lb-nav__link" href="{$link}" {$attributes}>{$menutitle}</a><button class="lb-nav__toggle" type="button" aria-label="{$menutitle}" aria-expanded="false"></button>{$wrapper}</li>
{/if}
