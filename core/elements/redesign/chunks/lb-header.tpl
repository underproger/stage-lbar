{* Шапка (редизайн). Меню строится из дерева ресурсов. Без пунктов «Главная» (site_start контекста) и «Вакансии» (RO 105 / RU 299 / EN 1105 —
   остаются в подвале). «Curs» (RO 182) и «Recenzii» (171 / 300 / 1171) — в корне дерева, «Instruire» (60) — веб-ссылка-редирект на курс, скрыта.
   Родительские пункты — чанк lb.navParent; «Servicii / Услуги» — мега-меню lb.navMega.
   Выбор языка — в правом блоке: десктоп — перед телефоном, мобильный — между телефоном и бургером (выпадающий список). *}
{set $menu = $_modx->runSnippet('!pdoMenu', [
    'level' => 3,
    'parents' => 0,
    'resources' => '-' ~ $_modx->config.site_start ~ ',-105,-299,-1105',
    'outerClass' => 'lb-nav__list',
    'rowClass' => 'lb-nav__item',
    'parentClass' => 'lb-nav__item--parent',
    'hereClass' => 'lb-nav__item--active',
    'selfClass' => 'lb-nav__item--self',
    'firstClass' => '',
    'lastClass' => '',
    'levelClass' => '',
    'tpl' => '@INLINE <li[[+classes]]><a class="lb-nav__link" href="[[+link]]" [[+attributes]]>[[+menutitle]]</a>[[+wrapper]]</li>',
    'tplParentRow' => 'lb.navParent',
    'tplInner' => '@INLINE <ul class="lb-nav__sub">[[+wrapper]]</ul>',
    'tplCategoryFolder' => '@INLINE <li[[+classes]]><span class="lb-nav__link">[[+menutitle]]</span>[[+wrapper]]</li>',
])}
<header class="lb-header" id="lb-header">
    <div class="lb-header__bar"></div>
    <div class="lb-header__inner">
        <a class="lb-header__logo" href="[[++site_url]]" aria-label="[[++site_name]]"><img src="/assets/templates/redesign/img/logo.svg?v=3" width="242" height="119" alt="LBar" loading="eager"></a>

        <div class="lb-mnav" id="lb-mnav">
            <nav class="lb-nav" aria-label="{'lbar.rd.aria.nav' | lexicon}">
                {$menu}
            </nav>
            <div class="lb-mnav__foot">
                <a class="lb-mnav__phone" href="tel:[[++phone-1:replace=` ==`]]">[[++phone-1]]</a>
                <p class="lb-mnav__addr">
                    <a href="{'lbar.rd.contacts.mapurl' | lexicon}" target="_blank" rel="nofollow noopener">{'lbar.rd.contacts.city' | lexicon}<br>
                    {'lbar.rd.contacts.street' | lexicon}</a><br>
                    {'lbar.rd.header.days' | lexicon}: [[++schedule]]
                </p>
                <a class="lb-btn lb-btn--solid lb-mnav__cta js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
            </div>
        </div>

        <div class="lb-header__right">
            <div class="lb-lang">
                <button class="lb-lang__btn" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="lb-lang-list"><span>{$_modx->config.cultureKey}</span><span class="lb-sr"> – {'lbar.rd.aria.lang' | lexicon}</span><svg class="lb-lang__chev" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 1l4 4 4-4"/></svg></button>
                <ul class="lb-lang__list" id="lb-lang-list">
                    [[!BabelLinks? &showCurrent=`1` &tpl=`lb.babelLink`]]
                </ul>
            </div>
            <a class="lb-header__phone" href="tel:[[++phone-1:replace=` ==`]]">
                <span class="lb-header__phone-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16.4v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 1.1 3.7 2 2 0 0 1 3.1 1.5h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L7.1 9.3a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.8 2.1z"/></svg></span>
                <span>[[++phone-1]]</span>
            </a>
            <a class="lb-btn lb-btn--solid lb-header__cta js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg></a>
            <button class="lb-header__burger" type="button" aria-label="{'lbar.rd.aria.burger' | lexicon}" aria-controls="lb-mnav" aria-expanded="false"><span></span><span></span></button>
        </div>
    </div>
</header>
{* основное содержимое страницы — landmark <main> (PageSpeed: «Document has a main landmark»); закрывается в начале lb-footer *}
<main class="lb-main" id="lb-main">
