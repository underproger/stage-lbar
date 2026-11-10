{* Страница «О нас» (шаг 47, видео — шаг 49): «За кулисами» — H2, короткий текст, ссылка на канал YouTube
   @kseniyalbarstudio и 5 роликов в сетке (2 в первом ряду, 3 во втором; на мобильном — лента с прокруткой пальцем).
   Плитка — превью 16:9 с кнопкой play и подписью; по клику — ролик в окне fancybox старого main.js (группа lb-aculise).
   Превью: src — hqdefault (есть у любого ролика, 4:3 с полосами — в плитке 16:9 полосы обрезаются ровно),
   data-yt-hd — maxresdefault (1280×720): redesign.js подменяет, если у ролика он есть (иначе YouTube отдаёт заглушку 120×90).
   Порядок роликов — массив $videos, подписи — лексикон lbar.rd.ab.vid.1–5 (по порядку роликов). *}
{$_modx->lexicon->load('babel:translate')}
{set $videos = ['PJqHE2pRXgY', 'PhwprTgrmi0', 'N0eVKPtpJFA', '3uWCXcCothQ', 'Qjl6Ia0EuTk']}
<section class="lb-aculise" id="lb-aculise">
    <div class="lb-aculise__inner">
        <div class="lb-aculise__head">
            <h2 class="lb-aculise__title"><span class="lb-aculise__t1">{'lbar.rd.ab.cul.h2a' | lexicon}</span> <span class="lb-aculise__t2">{'lbar.rd.ab.cul.h2b' | lexicon}</span></h2>
            <div class="lb-aculise__aside">
                <p class="lb-aculise__side">{'lbar.rd.ab.cul.side' | lexicon}</p>
                <a class="lb-aculise__all" href="https://www.youtube.com/@kseniyalbarstudio/videos" target="_blank" rel="nofollow noopener">{'lbar.rd.ab.vid.all' | lexicon}<svg class="lb-aculise__arr" viewBox="0 0 22 12" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 6h19M15.5 1.5 20 6l-4.5 4.5"/></svg></a>
            </div>
        </div>
        <ul class="lb-aculise__grid">
            {foreach $videos as $i => $v}
            {set $cap = ('lbar.rd.ab.vid.' ~ ($i + 1)) | lexicon}
            <li class="lb-aculise__item">
                <a class="lb-aculise__tile" href="https://www.youtube.com/watch?v={$v}" data-fancybox="lb-aculise" data-caption="{$cap}">
                    <img src="https://i.ytimg.com/vi/{$v}/hqdefault.jpg" data-yt-hd="https://i.ytimg.com/vi/{$v}/maxresdefault.jpg" width="480" height="360" alt="" loading="lazy" decoding="async">
                    <span class="lb-aculise__play" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M8 5.6v12.8c0 .7.8 1.1 1.4.7l10-6.4c.5-.3.5-1.1 0-1.4l-10-6.4C8.8 4.5 8 4.9 8 5.6z"/></svg></span>
                    <span class="lb-aculise__cap">{$cap}</span>
                </a>
            </li>
            {/foreach}
        </ul>
    </div>
</section>
