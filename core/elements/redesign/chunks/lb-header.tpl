{* Шапка (редизайн). Меню строится из дерева ресурсов, как и раньше — набор ссылок не меняется. *}
{set $menu = $_modx->runSnippet('!pdoMenu', [
    'level' => 3,
    'parents' => 0,
    'outerClass' => 'lb-nav__list',
    'rowClass' => 'lb-nav__item',
    'parentClass' => 'lb-nav__item--parent',
    'hereClass' => 'lb-nav__item--active',
    'selfClass' => 'lb-nav__item--self',
    'firstClass' => '',
    'lastClass' => '',
    'levelClass' => '',
    'tpl' => '@INLINE <li[[+classes]]><a class="lb-nav__link" href="[[+link]]" [[+attributes]]>[[+menutitle]]</a>[[+wrapper]]</li>',
    'tplParentRow' => '@INLINE <li[[+classes]]><a class="lb-nav__link" href="[[+link]]" [[+attributes]]>[[+menutitle]]</a><button class="lb-nav__toggle" type="button" aria-label="[[+menutitle]]" aria-expanded="false"></button>[[+wrapper]]</li>',
    'tplInner' => '@INLINE <ul class="lb-nav__sub">[[+wrapper]]</ul>',
    'tplCategoryFolder' => '@INLINE <li[[+classes]]><span class="lb-nav__link">[[+menutitle]]</span>[[+wrapper]]</li>',
])}
{set $isRo = $_modx->config.cultureKey == 'ro'}
{set $phone = $_modx->config['phone-1']}
<header class="lb-header" id="lb-header">
    <div class="lb-header__bar"></div>
    <div class="lb-header__inner">
        <a class="lb-header__logo" href="[[++site_url]]" aria-label="[[++site_name]]">LBAR</a>

        <div class="lb-mnav" id="lb-mnav">
            <nav class="lb-nav" aria-label="{$isRo ? 'Meniul site' : 'Меню сайта'}">
                {$menu}
            </nav>
            <ul class="lb-lang">
                [[!BabelLinks? &showCurrent=`1` &tpl=`lb.babelLink`]]
            </ul>
            <div class="lb-mnav__foot">
                <a class="lb-mnav__phone" href="tel:{$phone | replace : ' ' : ''}">{$phone}</a>
                <p class="lb-mnav__addr">
                    București, Dorobanti, Sector 1<br>
                    Șoseaua Ștefan cel Mare Nr 1<br>
                    {$isRo ? 'Luni-Duminică' : 'Пн-Вс'}: [[++schedule]]
                </p>
                <a class="lb-btn lb-btn--solid lb-mnav__cta js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}</a>
                <div class="lb-mnav__social">
                    <a href="[[++insta]]" target="_blank" rel="nofollow noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4.2"/><circle cx="17.4" cy="6.6" r=".9" fill="currentColor" stroke="none"/></svg></a>
                    <a href="[[++facebook]]" target="_blank" rel="nofollow noopener" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M13.5 21v-7.5h2.6l.4-3h-3V8.6c0-.9.3-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.9 1.4-3.9 4v2.2H7.8v3h2.6V21h3.1z"/></svg></a>
                    <a href="[[++whatsapp]]" target="_blank" rel="nofollow noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path d="M12 2.2A9.7 9.7 0 0 0 3.7 16.9L2.3 21.8l5-1.3A9.7 9.7 0 1 0 12 2.2zm0 17.7c-1.5 0-2.9-.4-4.2-1.1l-.3-.2-3 .8.8-2.9-.2-.3A8 8 0 1 1 12 19.9zm4.4-6c-.2-.1-1.4-.7-1.7-.8-.2-.1-.4-.1-.5.1l-.8 1c-.1.2-.3.2-.5.1a6.5 6.5 0 0 1-3.2-2.8c-.2-.4.2-.4.7-1.3.1-.2 0-.3 0-.4l-.8-1.8c-.2-.5-.4-.4-.5-.4h-.5c-.2 0-.4.1-.7.3-.2.3-.9.9-.9 2.2s.9 2.5 1 2.7c.1.2 1.8 2.8 4.4 3.9 1.6.7 2.3.8 3.1.6.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .1-1.1l-.6-.2z"/></svg></a>
                    <a href="[[++facebook-messenger]]" target="_blank" rel="nofollow noopener" aria-label="Messenger"><svg viewBox="0 0 24 24"><path d="M12 2.5C6.6 2.5 2.5 6.4 2.5 11.6c0 2.8 1.1 5.1 3 6.8V22l3.3-1.8c1 .3 2.1.4 3.2.4 5.4 0 9.5-3.9 9.5-9S17.4 2.5 12 2.5zm1 12.1-2.4-2.6-4.7 2.6 5.2-5.5 2.5 2.6 4.6-2.6-5.2 5.5z"/></svg></a>
                </div>
            </div>
        </div>

        <div class="lb-header__right">
            <a class="lb-header__phone" href="tel:{$phone | replace : ' ' : ''}">
                <span class="lb-header__phone-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16.4v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 1.1 3.7 2 2 0 0 1 3.1 1.5h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L7.1 9.3a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.8 2.1z"/></svg></span>
                <span>{$phone}</span>
            </a>
            <a class="lb-btn lb-btn--solid lb-header__cta js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}</a>
            <button class="lb-header__burger" type="button" aria-label="{$isRo ? 'Meniu' : 'Меню'}" aria-controls="lb-mnav" aria-expanded="false"><span></span><span></span></button>
        </div>
    </div>
</header>
