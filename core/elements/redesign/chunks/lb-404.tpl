{* Страница 404 (редизайн; шаблон «404 eror page», 2: RO 20, RU 206) — вместо секции content-eror старого шаблона.
   H1 — как было: «Hopa!» / «Упс!» (прежний текст из шаблона, теперь лексикон lbar.rd.msg.oops) + pagetitle.
   Над H1 — графическое «404» (цифры шрифтом, ноль — овал-«портал», aria-hidden) вместо картинки images/design/404.png из content.
   Текст — content ресурса без этой картинки и без списка со ссылкой; ссылка из списка («Înapoi la pagina principală» / «перейти на главную»,
   href [[++site_url]]) — кнопкой с её же текстом. Вторая кнопка — запись (на странице нет формы — окно «Заказать звонок», js-lb-book).
   Внимание: в выражениях Fenom не писать «*» + «/» подряд. *}
{$_modx->lexicon->load('babel:translate')}
{set $r = $_modx->resource}
{set $c = $r.content}
{set $text = $c | ereplace : '~<p>\s*<img[^>]*>\s*</p>~iu' : '' | ereplace : '~<ul\b.*?</ul>~isu' : ''}
{set $home = ''}
{set $href = ''}
{if $c | ematch : '~<a\s[^>]*href="[^"]+"[^>]*>.+?</a>~isu'}
    {set $home = $c | ereplace : '~^.*?<a\s[^>]*>(.*?)</a>.*$~isu' : '$1'}
    {set $href = $c | ereplace : '~^.*?<a\s[^>]*href="([^"]*)".*$~isu' : '$1'}
{/if}
{set $arr = '<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-msg lb-msg--404" id="lb-msg">
    <div class="lb-msg__bg" aria-hidden="true"></div>
    <div class="lb-msg__inner">
        <div class="lb-msg__num" aria-hidden="true">
            <span class="lb-msg__digit">4</span>
            <span class="lb-msg__digit lb-msg__digit--zero"><svg class="lb-msg__zero" viewBox="0 0 240 300">
                <defs>
                    <linearGradient id="lb404-f" gradientUnits="userSpaceOnUse" x1="0" y1="18" x2="0" y2="282"><stop offset="0" stop-color="#dcae93"/><stop offset=".58" stop-color="#ab7152"/><stop offset="1" stop-color="#875840"/></linearGradient>
                    <radialGradient id="lb404-g" cx=".5" cy=".42" r=".55"><stop offset="0" stop-color="#fff" stop-opacity=".95"/><stop offset=".65" stop-color="#f7e9e0" stop-opacity=".6"/><stop offset="1" stop-color="#efd9cb" stop-opacity="0"/></radialGradient>
                </defs>
                <ellipse cx="120" cy="150" rx="86" ry="118" fill="url(#lb404-g)"/>
                <path class="lb-msg__o" fill="url(#lb404-f)" fill-rule="evenodd" d="M120 18c-56 0-98 59-98 132s42 132 98 132 98-59 98-132S176 18 120 18zm0 13c-35 0-62 53-62 119s27 119 62 119 62-53 62-119-27-119-62-119z"/>
                <ellipse class="lb-msg__ring" cx="120" cy="150" rx="112" ry="144" fill="none" stroke="url(#lb404-f)" stroke-width="1.2" stroke-opacity=".55" pathLength="1"/>
                <path class="lb-msg__spark" fill="#b07455" d="M206 20c.7 7.4 5.8 12.9 13.8 13.8-8 .9-13.1 6.4-13.8 13.8-.7-7.4-5.8-12.9-13.8-13.8 8-.9 13.1-6.4 13.8-13.8z"/>
                <path class="lb-msg__spark" fill="#c99278" d="M28 248c.5 4.6 3.6 8 8.6 8.6-5 .6-8.1 4-8.6 8.6-.5-4.6-3.6-8-8.6-8.6 5-.6 8.1-4 8.6-8.6z"/>
            </svg></span>
            <span class="lb-msg__digit">4</span>
        </div>
        <h1 class="lb-msg__title"><span class="lb-msg__accent">{'lbar.rd.msg.oops' | lexicon}</span> {$r.pagetitle}</h1>
        {if $text | trim}<div class="lb-msg__text">{$text}</div>{/if}
        <div class="lb-msg__btns">
            <a class="lb-btn lb-btn--solid" href="{$href ?: '[[++site_url]]'}">{$home ?: ('lbar.rd.thanks.home' | lexicon)}{$arr}</a>
            <a class="lb-btn lb-btn--ghost js-lb-book" href="#bl8-form">{'lbar.buttons.banner.book' | lexicon}{$arr}</a>
        </div>
    </div>
</section>
