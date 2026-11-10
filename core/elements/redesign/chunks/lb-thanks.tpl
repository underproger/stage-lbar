{* Страница «Спасибо» после отправки формы (редизайн; шаблон «Success-Page-RU», 6: RO 40 /thanx-you, RU 269) — вместо overlay/thanks-wrap.
   Тексты — прежние из шаблона (были [[++cultureKey:is=…]]), перенесены в лексикон без изменений: lbar.rd.thanks.studio / .by
   («Studiou micropigmentare by Ksenia Kobilianskaia»), .title («Mulțumesc» — как и раньше не заголовок, а div), .text, .home (кнопка на главную).
   Логотип-картинка images/inner/LBarlogo.png заменён печатью с галочкой (графика, aria-hidden): логотип уже в шапке. Заголовков на странице
   нет, как и было. *}
{$_modx->lexicon->load('babel:translate')}
{set $arr = '<svg class="lb-btn__arr" viewBox="0 0 27 14" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 7h24.5M19.5 1.2 25.5 7l-6 5.8"/></svg>'}
<section class="lb-msg lb-msg--thanks" id="lb-msg">
    <div class="lb-msg__bg" aria-hidden="true"></div>
    <div class="lb-msg__inner">
        <div class="lb-msg__seal" aria-hidden="true"><svg viewBox="0 0 220 220">
            <defs>
                <linearGradient id="lbty-f" gradientUnits="userSpaceOnUse" x1="0" y1="20" x2="0" y2="200"><stop offset="0" stop-color="#dcae93"/><stop offset=".58" stop-color="#ab7152"/><stop offset="1" stop-color="#875840"/></linearGradient>
                <radialGradient id="lbty-g" cx=".5" cy=".42" r=".55"><stop offset="0" stop-color="#fff" stop-opacity=".95"/><stop offset=".7" stop-color="#f7e9e0" stop-opacity=".75"/><stop offset="1" stop-color="#efd9cb" stop-opacity=".2"/></radialGradient>
            </defs>
            <circle cx="110" cy="110" r="84" fill="url(#lbty-g)"/>
            <circle class="lb-msg__ring" cx="110" cy="110" r="84" fill="none" stroke="url(#lbty-f)" stroke-width="4" pathLength="1"/>
            <circle class="lb-msg__ring" cx="110" cy="110" r="70" fill="none" stroke="url(#lbty-f)" stroke-width="1" stroke-opacity=".55" pathLength="1"/>
            <circle class="lb-msg__dots" cx="110" cy="110" r="99" fill="none" stroke="#c39077" stroke-width="2.2" stroke-linecap="round" stroke-dasharray=".01 9.3" stroke-opacity=".7"/>
            <path class="lb-msg__check" fill="none" stroke="url(#lbty-f)" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" pathLength="1" d="M76 112.5 98.5 135 145 86"/>
            <path class="lb-msg__spark" fill="#b07455" d="M188 22c.7 7.4 5.8 12.9 13.8 13.8-8 .9-13.1 6.4-13.8 13.8-.7-7.4-5.8-12.9-13.8-13.8 8-.9 13.1-6.4 13.8-13.8z"/>
            <path class="lb-msg__spark" fill="#c99278" d="M26 168c.5 4.6 3.6 8 8.6 8.6-5 .6-8.1 4-8.6 8.6-.5-4.6-3.6-8-8.6-8.6 5-.6 8.1-4 8.6-8.6z"/>
        </svg></div>
        <div class="lb-msg__big">{'lbar.rd.thanks.title' | lexicon}</div>
        <svg class="lb-msg__flourish" viewBox="0 0 440 50" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" d="M8 34c60-14 128-20 196-18 52 1 98 8 126 14M330 30c22 5 52 4 102-18"/><path fill="currentColor" d="M214 4c.6 6 4.6 10.4 11 11-6.4.6-10.4 5-11 11-.6-6-4.6-10.4-11-11 6.4-.6 10.4-5 11-11z"/></svg>
        <div class="lb-msg__text">{'lbar.rd.thanks.text' | lexicon}</div>
        <div class="lb-msg__btns">
            <a class="lb-btn lb-btn--solid" href="[[++site_url]]">{'lbar.rd.thanks.home' | lexicon}{$arr}</a>
        </div>
    </div>
</section>
