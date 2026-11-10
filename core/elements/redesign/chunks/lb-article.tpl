{* Статья блога (шаблон «Блог - статья», id 5) — вместо content-blog. Баннера нет (шаг 45) — структура как у старой статьи:
   хлебные крошки (pdoCrumbs, как в баннере общих страниц) и H1 (pagetitle, itemprop="headline") во всю ширину; в колонке текста —
   строка сведений, как была (рубрика — itemprop="genre", автор — itemprop="author" Person, просмотры — HitsPage, комментарии — #review;
   дата — только в meta datePublished),
   затем текст. Страница обёрнута в itemscope schema.org/Article (в шаблоне); здесь — те же скрытые свойства, что в старом чанке
   (mainEntityOfPage, inLanguage, publisher, datePublished/dateModified, image) и itemprop="articleBody" с текстом —
   [[*content]] с прежней заменой путей картинок (галереи в тексте — чанки gallery_tagN, как раньше).
   Под текстом: блок-призыв (TV title-action / sub-title-action / link-action, как было), автор, соседние статьи (pdoNeighbors).
   Справа: популярные (5, по просмотрам) и новые (3) статьи — как blog-popular-page / blog-new-page. *}
{$_modx->lexicon->load('babel:translate')}
{set $r = $_modx->resource}
{set $isRo = $_modx->config.cultureKey == 'ro'}
{set $arr = '<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-article" id="lb-article">
    <div class="lb-article__bg" aria-hidden="true"></div>

    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="" content=""/>
    <meta itemprop="inLanguage" content="uk" />
    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" hidden>
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <img itemprop="url" src="[[!++site_url]]images/design/logo-schema.jpg" alt="[[++autor]]" loading="lazy">
            <meta itemprop="width" content="190">
            <meta itemprop="height" content="36">
        </div>
        <meta itemprop="name" content="[[++site_name]]">
    </div>
    <meta itemprop="datePublished dateModified" content="[[*publishedon:strtotime:date=`%d/%m/%Y`]]">
    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject" hidden>
        <img itemprop="image url" alt="" src="[[pthumb? &input=`[[*img-blog-prew]]` &options=`w=180&h=180`]]" loading="lazy">
        <meta itemprop="width" content="180">
        <meta itemprop="height" content="180">
    </div>

    {set $si = ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"'}
    <div class="lb-article__inner">
        <header class="lb-article__head">
            <nav class="lb-crumbs lb-crumbs--flow" aria-label="{'lbar.rd.aria.crumbs' | lexicon}">
                {$_modx->runSnippet('!pdoCrumbs', [
                    'showHome' => 1,
                    'showAtHome' => 0,
                    'tplWrapper' => '@INLINE <ol class="lb-crumbs__list" itemscope itemtype="http://schema.org/BreadcrumbList">[[+output]]</ol>',
                    'tplHome' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link lb-crumbs__link--home" href="[[+link]]" itemprop="item"><svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 9.2 10 3l7 6.2"/><path d="M5 8v9h4v-5h2v5h4V8"/></svg><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                    'tpl' => '@INLINE <li class="lb-crumbs__item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a class="lb-crumbs__link" href="[[+link]]" itemprop="item"><span itemprop="name">[[+menutitle]]</span><meta itemprop="position" content="[[+idx]]" /></a></li>',
                    'tplCurrent' => '@INLINE <li class="lb-crumbs__item lb-crumbs__item--current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><span itemprop="name">[[+menutitle]]</span><div itemprop="item" content="[[++site_url]][[+link]]"></div><meta itemprop="position" content="[[+idx]]" /></li>',
                ])}
            </nav>
            <h1 class="lb-article__title" itemprop="headline">{$r.pagetitle}</h1>
        </header>

        <article class="lb-article__main">
            <ul class="lb-article__info">
                <li class="lb-article__info-i lb-article__info-i--cat"><a href="{$r.parent | url}" itemprop="genre"><svg{$si}><path d="M3 12.2V4.5A1.5 1.5 0 0 1 4.5 3h7.7l8.8 8.8a1.5 1.5 0 0 1 0 2.1l-7.1 7.1a1.5 1.5 0 0 1-2.1 0z"/><circle cx="8" cy="8" r="1.6"/></svg>{$_modx->runSnippet('pdoField', ['id' => $r.parent, 'field' => 'pagetitle'])}</a></li>
                <li class="lb-article__info-i" itemprop="author" itemscope itemtype="https://schema.org/Person"><svg{$si}><circle cx="12" cy="8" r="4"/><path d="M4.5 20.5c.9-3.9 3.9-6 7.5-6s6.6 2.1 7.5 6"/></svg><span itemprop="name">[[++autor]]</span><span itemprop="url" hidden>[[ThisPageURL? &id=`[[*id]]`]]</span></li>
                <li class="lb-article__info-i" title="{'lbar.rd.blog.views' | lexicon}"><svg{$si}><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg><span class="lb-article__info-v">[[!HitsPage? &saveTv=`true`]]</span><span class="lb-article__info-l">{'lbar.rd.blog.views' | lexicon}</span></li>
                <li class="lb-article__info-i"><a href="#review"><svg{$si}><path d="M20.5 14.5a2 2 0 0 1-2 2H8l-4.5 4V5.5a2 2 0 0 1 2-2h13a2 2 0 0 1 2 2z"/></svg><span class="lb-article__info-v">[[!ecMessagesCount]]</span><span class="lb-article__info-l">{'lbar.rd.blog.ncomments' | lexicon}</span></a></li>
            </ul>

            <div class="lb-article__body" itemprop="articleBody">[[*content:replace=`<img src="==<img src="/`]]</div>

            {if $r['title-action'] | trim}
            <div class="lb-article__action">
                <div class="lb-article__action-t">{$r['title-action']}</div>
                {if $r['sub-title-action'] | trim}<div class="lb-article__action-s">{$r['sub-title-action']}</div>{/if}
                <a class="lb-btn lb-btn--solid" href="{$r['link-action']}">{'lbar.buttons.category.more' | lexicon}{$arr}</a>
            </div>
            {/if}

            <div class="lb-article__author">
                <img class="lb-article__author-img" src="/images/design/autio-blog.jpg" alt="" width="150" height="150" loading="lazy">
                <div class="lb-article__author-info">
                    <div class="lb-article__author-name">{$isRo ? 'Autor – Ksenia Kobilianskaia' : 'Автор - <span>Ксения Кобылянская</span>'}</div>
                    <div class="lb-article__author-role">{$isRo ? 'Master de Top/fondatorul studioului' : 'ТОП-мастер/Основатель студии'}</div>
                    <div class="lb-article__author-text">{$isRo ? 'Abonează-te la rețelele noastre de socializare și la canalul YouTube. <br/>Avem mult conținut interesant' : 'Подписывайтесь на наши социальные сети и YouTube канал. <br/>У нас много крутого контента'}</div>
                </div>
                <div class="lb-article__soc">
                    <a class="lb-article__soc-a" href="[[++youtube]]" rel="nofollow" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M21.6 7.2a2.6 2.6 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4a2.6 2.6 0 0 0-1.8 1.8C2 8.8 2 12 2 12s0 3.2.4 4.8a2.6 2.6 0 0 0 1.8 1.8c1.6.4 7.8.4 7.8.4s6.2 0 7.8-.4a2.6 2.6 0 0 0 1.8-1.8c.4-1.6.4-4.8.4-4.8s0-3.2-.4-4.8zM10 15V9l5.2 3z"/></svg></a>
                    <a class="lb-article__soc-a" href="[[++facebook]]" rel="nofollow" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.6h2.6l.4-3h-3V8.5c0-.9.3-1.5 1.5-1.5h1.6V4.3c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.3H7.9v3h2.6V21z"/></svg></a>
                    <a class="lb-article__soc-a" href="[[++insta]]" rel="nofollow" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.3" cy="6.7" r=".9" fill="currentColor" stroke="none"/></svg></a>
                </div>
            </div>

            [[!pdoNeighbors?
                &id=`[[*id]]`
                &tplPrev=`lb.blogPrev`
                &tplNext=`lb.blogNext`
                &includeTVs=`img-blog-prew`
                &tplWrapper=`@INLINE <nav class="lb-article__nb">[[+prev]][[+next]]</nav>`
            ]]
        </article>

        <aside class="lb-article__side">
            {$_modx->runSnippet('!pdoResources', [
                'parents' => $r.parent,
                'limit' => 5,
                'hideContainers' => 1,
                'resources' => '-' ~ $r.id,
                'tpl' => 'lb.blogSide',
                'tplWrapper' => '@INLINE <div class="lb-side"><div class="lb-side__title">' ~ ($isRo ? 'Publicații populare' : 'Популярные публикации') ~ '</div><div class="lb-side__list">[[+output]]</div></div>',
                'includeTVs' => 'img-blog-prew,HitsPage',
                'sortby' => 'HitsPage',
                'sortdir' => 'DESC'
            ])}
            {$_modx->runSnippet('!pdoResources', [
                'parents' => $r.parent,
                'limit' => 3,
                'hideContainers' => 1,
                'resources' => '-' ~ $r.id,
                'tpl' => 'lb.blogSide',
                'tplWrapper' => '@INLINE <div class="lb-side"><div class="lb-side__title">' ~ ($isRo ? 'Publicații noi' : 'Последние публикации') ~ '</div><div class="lb-side__list">[[+output]]</div></div>',
                'includeTVs' => 'img-blog-prew',
                'sortby' => 'publishedon',
                'sortdir' => 'DESC'
            ])}
            <div class="lb-side lb-side--cta">
                <div class="lb-side__cta-t">{'lbar.rd.blog.cta' | lexicon}</div>
                <a class="lb-btn lb-btn--solid lb-btn--sm js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}{$arr}</a>
            </div>
        </aside>
    </div>
</section>
