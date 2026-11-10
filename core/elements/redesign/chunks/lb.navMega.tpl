{* Мега-меню пункта «Servicii / Услуги / Services» (шапка, вызывается из lb.navParent). Ссылки — дочерние ресурсы раздела, как и в прежнем
   выпадающем списке (pdoMenu: опубликованные, не скрытые из меню; текст ссылки — menutitle, иначе pagetitle) — набор ссылок раздела не меняется.
   Раскладка по колонкам (как в макете):
     «Micropigmentare» — брови, глаза, губы, коррекция, удаление (id ниже, RO / RU / EN), «Sprâncene» — подразделы бровей (дети id 2 / 303 / 1002),
     «Alte servicii» — все остальные дети раздела (новые услуги попадут сюда автоматически), «Acces rapid» — Gift Voucher (177 / 323 / 1177) +
     «Despre mine» (блок «Мастер» главной, #lb-master), портфолио (100 / 198 / 1100), цены (44 / 270 / 1044). EN-id = RO-id + 1000.
   Карточки «Рекомендуем» слева больше нет (убрана по просьбе пользователя). Подписи колонок — лексикон lbar.rd.mega.*.
   Десктоп — панель под шапкой (наведение / фокус), мобильный — раскрывается кнопкой +, как прежние подменю. *}
{$_modx->lexicon->load('babel:translate')}
{set $L = ($id == 302) ? 'ru' : (($id == 1080) ? 'en' : 'ro')}
{set $cfgs = [
    'ro' => ['brows' => 2, 'micro' => [2, 162, 167, 119, 625], 'quick' => [177], 'pages' => [100, 44]],
    'ru' => ['brows' => 303, 'micro' => [303, 317, 319, 316, 321], 'quick' => [323], 'pages' => [198, 270]],
    'en' => ['brows' => 1002, 'micro' => [1002, 1162, 1167, 1119], 'quick' => [1177], 'pages' => [1100, 1044]]
]}
{set $cfg = $cfgs[$L]}
{set $opts = ['sortby' => ['menuindex' => 'ASC', 'id' => 'ASC'], 'select' => 'id,pagetitle,menutitle', 'limit' => 0]}
{set $items = $_modx->getResources(['parent' => $id, 'published' => 1, 'deleted' => 0, 'hidemenu' => 0], $opts)}
{set $browsId = $cfg.brows}
{set $brows = $_modx->getResources(['parent' => $browsId, 'published' => 1, 'deleted' => 0, 'hidemenu' => 0], $opts)}
{set $microIds = $cfg.micro}
{set $quickIds = $cfg.quick}
{set $byId = []}
{foreach $items as $r}{set $byId[$r.id] = $r}{/foreach}
{set $icons = [
    163 => 'eye', 318 => 'eye', 627 => 'laser', 628 => 'laser', 168 => 'dots', 320 => 'dots',
    1163 => 'eye', 1627 => 'laser', 1168 => 'dots'
]}
{set $svg = [
    'lash'  => '<path d="M3 13c3.5-3 14.5-3 18 0"/><path d="M6 11.2 5 8.5M9.5 10.3 9 7.3M14.5 10.3l.5-3M18 11.2l1-2.7"/>',
    'eye'   => '<path d="M2.5 12S6 6.5 12 6.5 21.5 12 21.5 12 18 17.5 12 17.5 2.5 12 2.5 12z"/><circle cx="12" cy="12" r="2.8"/>',
    'laser' => '<path d="M13 2.5 5 13.5h6l-1 8 8-11h-6z"/>',
    'nail'  => '<path d="M9.5 9.5h5l1 11h-7z"/><path d="M10.5 9.5V6a1.5 1.5 0 0 1 3 0v3.5M8.5 13.5h7"/>',
    'foot'  => '<path d="M8 21c-2.5 0-3.5-3-3-6.5S7 8 9.5 8.5 11 13 10.5 16 10 21 8 21zM15.5 17c-2 0-2.5-2.5-2.2-5s1.5-4.5 3.4-4.2 1.3 3.5.9 5.5-.4 3.7-2.1 3.7z"/><circle cx="8.6" cy="4.6" r="1.2"/><circle cx="16.4" cy="4.4" r="1"/>',
    'dots'  => '<circle cx="8" cy="9" r="1.3"/><circle cx="15.5" cy="7" r=".9"/><circle cx="13" cy="14.5" r="1.6"/><circle cx="6.5" cy="16" r=".8"/><circle cx="18" cy="15" r=".8"/>',
    'spark' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M6 6l2.5 2.5M15.5 15.5 18 18M18 6l-2.5 2.5M8.5 15.5 6 18"/>'
]}
{set $chev = '<svg class="lb-mega__chev" viewBox="0 0 24 24" aria-hidden="true"><path d="m9.5 6.5 5.5 5.5-5.5 5.5"/></svg>'}
{set $pages = $_modx->getResources(['id:IN' => $cfg.pages, 'published' => 1, 'deleted' => 0], $opts)}
{set $qicons = [100 => 'photo', 198 => 'photo', 1100 => 'photo', 44 => 'coins', 270 => 'coins', 1044 => 'coins']}
{set $qsvg = [
    'gift'  => '<rect x="3.5" y="8.5" width="17" height="4" rx="1"/><path d="M5 12.5v8h14v-8M12 8.5v12M12 8.5S10.5 4 8 4.5 7 8.5 12 8.5zM12 8.5S13.5 4 16 4.5 17 8.5 12 8.5z"/>',
    'user'  => '<circle cx="12" cy="8" r="4"/><path d="M4.5 20.5c.8-4 3.8-6.5 7.5-6.5s6.7 2.5 7.5 6.5"/>',
    'cal'   => '<rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4M8 14h2M14 14h2M8 17h2"/>',
    'photo' => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><circle cx="8.5" cy="9.5" r="1.8"/><path d="m3.5 17.5 5-4.5 3.5 3 3-2.5 5.5 4.5"/>',
    'coins' => '<ellipse cx="9" cy="6.5" rx="5.5" ry="2.5"/><path d="M3.5 6.5v4c0 1.4 2.5 2.5 5.5 2.5s5.5-1.1 5.5-2.5v-4"/><path d="M9.5 15.5c.6 1.2 2.9 2 5.5 2 3 0 5.5-1.1 5.5-2.5v-4c0-1.2-1.8-2.2-4.3-2.4"/><path d="M20.5 15v4c0 1.4-2.5 2.5-5.5 2.5s-5.5-1.1-5.5-2.5v-3.5"/>'
]}
<li{$classes | replace : 'class="' : 'class="lb-nav__item--mega '}><a class="lb-nav__link" href="{$link}" {$attributes}>{$menutitle}</a><button class="lb-nav__toggle" type="button" aria-label="{$menutitle}" aria-expanded="false"></button>
    <div class="lb-mega">
        <div class="lb-mega__panel">
            <div class="lb-mega__col">
                <div class="lb-mega__h"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2.5 14c4-5 11-6.5 19-2.5"/><path d="M3.5 15.5c4-3.5 10-4.5 16-2"/></svg>{'lbar.rd.mega.micro' | lexicon}</div>
                <ul class="lb-mega__list">
                    {foreach $microIds as $mid}
                    {if $byId[$mid]?}
                    <li><a class="lb-mega__link" href="{$_modx->makeUrl($mid)}"><span>{$byId[$mid].menutitle ?: $byId[$mid].pagetitle}</span>{$chev}</a></li>
                    {/if}
                    {/foreach}
                </ul>
            </div>

            {if $brows}
            <div class="lb-mega__col">
                <div class="lb-mega__h"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 13.5C6.5 8 14 7 21 10"/><path d="M5 12.5c.4-1 .9-1.8 1.5-2.5M8.5 10.3c.3-.9.7-1.6 1.2-2.2M12.3 9.4c.2-.8.5-1.5.9-2.1M16 9.4c.1-.7.3-1.4.6-2"/></svg>{'lbar.rd.mega.brows' | lexicon}</div>
                <ul class="lb-mega__list">
                    {foreach $brows as $r}
                    <li><a class="lb-mega__link" href="{$_modx->makeUrl($r.id)}"><span>{$r.menutitle ?: $r.pagetitle}</span>{$chev}</a></li>
                    {/foreach}
                </ul>
            </div>
            {/if}

            <div class="lb-mega__col">
                <div class="lb-mega__h"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19.5c-3-2.5-4.5-5.5-4.5-8.5S9.5 5.5 12 4c2.5 1.5 4.5 4 4.5 7s-1.5 6-4.5 8.5z"/><path d="M12 19.5c-4 .2-8-2.4-9-7 2.6-.5 4.7 0 6.3 1.2M12 19.5c4 .2 8-2.4 9-7-2.6-.5-4.7 0-6.3 1.2"/></svg>{'lbar.rd.mega.other' | lexicon}</div>
                <ul class="lb-mega__list lb-mega__list--ic">
                    {foreach $items as $r}
                    {if !($r.id in $microIds) && !($r.id in $quickIds)}
                    <li><a class="lb-mega__link" href="{$_modx->makeUrl($r.id)}"><svg class="lb-mega__ic" viewBox="0 0 24 24" aria-hidden="true">{$svg[$icons[$r.id] ?: 'spark']}</svg><span>{$r.menutitle ?: $r.pagetitle}</span></a></li>
                    {/if}
                    {/foreach}
                </ul>
            </div>

            <div class="lb-mega__col lb-mega__col--quick">
                <div class="lb-mega__h"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 14a4.5 4.5 0 0 0 6.4 0l3-3a4.5 4.5 0 0 0-6.4-6.4l-1.2 1.2"/><path d="M14 10a4.5 4.5 0 0 0-6.4 0l-3 3a4.5 4.5 0 0 0 6.4 6.4l1.2-1.2"/></svg>{'lbar.rd.mega.quick' | lexicon}</div>
                <ul class="lb-mega__quick">
                    {foreach $quickIds as $qid}
                    {if $byId[$qid]?}
                    <li><a class="lb-mega__pill" href="{$_modx->makeUrl($qid)}"><svg class="lb-mega__ic" viewBox="0 0 24 24" aria-hidden="true">{$qsvg['gift']}</svg><span>{$byId[$qid].menutitle ?: $byId[$qid].pagetitle}</span>{$chev}</a></li>
                    {/if}
                    {/foreach}
                    {* «Despre mine» — к блоку «Мастер» главной: на главной — скролл к #lb-master, с других страниц — переход на главную с якорем *}
                    {set $start = $_modx->config.site_start}
                    <li><a class="lb-mega__pill" href="{($_modx->resource.id == $start) ? '' : $_modx->makeUrl($start)}#lb-master"><svg class="lb-mega__ic" viewBox="0 0 24 24" aria-hidden="true">{$qsvg['user']}</svg><span>{'lbar.rd.mega.aboutme' | lexicon}</span>{$chev}</a></li>
                    {foreach $pages as $r}
                    <li><a class="lb-mega__pill" href="{$_modx->makeUrl($r.id)}"><svg class="lb-mega__ic" viewBox="0 0 24 24" aria-hidden="true">{$qsvg[$qicons[$r.id]]}</svg><span>{$r.menutitle ?: $r.pagetitle}</span>{$chev}</a></li>
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
</li>
