<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => 'Changelog for SeoFilter.

1.5.4-beta (16.07.2018)
=======================
- Настройка seofilter_url_scheme по умолчанию "full";
- Новый параметр сниппета sfLink - "link_classes". Классы для ссылки;
- Слова теперь можно отключать и они не будут участвовать в формировании ссылок. Ссылки с ними - удалятся. Повторное включение создаст новые ссылки;
- Добавлен учёт настройки seofilter_admin_version, который отвечает за версионность скриптов в админке. Если версионность не нужна - добавьте настройку в ручную со значением 0;
- Поправлено формирование ссылок, адресов когда ссылки в один уровень и привязаны к главной;
- Поправлен подсчёт для слайдеров, если они на основе ТВ полей;
- Мелкие улучшения и переименования в админ-панели.

1.5.3-beta (19.06.2018)
=======================
- Небольшие изменения для подсчётов через расширение класса
- Неактивные поля теперь только для того, чтобы не собирать значения

1.5.2-beta (01.06.2018)
=======================
- Поправлен процессор вывода списка страниц
- Поправлена установка pdoTools при отсутствии на сайте

1.5.1-beta (24.05.2018)
=======================
- Поправлен сниппет sfLink для работы с Pro-режимом
- Поправлено поле editedon в mysql-схеме

1.5.0-beta (21.05.2018)
=======================
- Добавлен PRO-режим, который позволяет привязывать к правилу несколько страниц
- Интеграция с компонентом Tagger, включая подсчёты
- Добавлена возможность получать SEO-ссылки без вложенности через слеш (настройка seofilter_level_separator)
- Добавлена возможность генерации SEO-ссылок в 1 уровень от корня сайта (настройка seofilter_between_urls)
- Добавлен класс seoPage для переопределения класса pdoPage для получения более точных ссылок в пагинации
- Мелкие удобства с подсчётами:
- Локальный счётчик обновляется, если значения отличаются
- Новая настройка для подстановки условий в новые правила
- Добавлен файл для пересчёта через cron
- Новые поля по умолчанию в строгом поиске, так подсчёты гораздо точнее
- Добавлен пункт пересчёт результатов ссылок по слову и правилу в таблице через правую кнопку мыши
- Оптимизация и исправление всех предыдущих ошибок

1.4.8-beta (16.04.2018)
=======================
- Сниппет sfLink теперь принимает параметры pages, where, as_name для простоты поиска ссылок
- Поправил работу с группировкой в sfMenu, поддерживает сортировку правил, при пустом sortby сортировка согласно переданным правилам
- Сниппет sfWord вовзращает весь массив со всеми падежами для Fenom (можете использовать для склонения любых слов)
- В шаблон генерации ссылок добавлена переменная id ресурса {$id} для использования полей
- Добавлена настройка seofilter_replace_host (для тех сайтов, у которых одна страница доступна на нескольких доменах)
- Подчистил компонент от лишних записей в лог и исправил мелкие ошибки, оптимизировано под PHP 7.2

1.4.7-beta
==============
- Поправлен механизм поиска страницы в плагине для сайтов с дубликатами синонимов
- Поправлена работа с parents в sfMenu, теперь строго "page:IN" (без OR)

1.4.6-beta
==============
- Поправил ошибку в плагине при отключенных подсчётах

1.4.5-beta
==============
- Добавил забытый where для sfMenu
- Добавлена поддержка PHP 5.3

1.4.4-beta
==============
- Повышена стабильность работы
- Больше "связанных" функций
- Исправлено множество ошибок
- Добавлена зависимость полей
- Исправлены подсчёты
- Для подсчётов добавлен новый класс, который можно расширять
- Интеграция tvSuperSelect - указать компонент в Поле
- Обрабатываются замороженные адресов страниц
- Поправлено формирование ссылок
- Учитываются различный суффиксы контейнером
- Перегенерация названий ссылок при изменении слова
- Промежуточные подсчёты для ускорения меню
- Пересчёт результатов при изменениях или по кнопке
- Улучшено копирование правила
- Добавление правила за один подход
- Ajax хлебные крошки
- Добавлено поле keywords в правила и ссылки
- Передача параметра LastModified (настройка)
- Поддержка браузерной истории по кнопкам назад, вперёд
- Версионнирование js,css файлов
- Обновления в склонениях. Теперь нужен только токен.
- Интеграция с msVendorCollections
- Добавлены скрытые возможности
- Мелкие улучшения в работе


1.3.1-beta
==============
- Мелкие исправления по ТВ-полям
- Убрал забытый из меню вывод в лог
- Изменён поиск пути в action.php

1.3.0-beta
==============
- Добавлен сниппет sfMenu для формирования меню с подсчётом ресурсов
- Добавлен сниппет sfSitemap для формирования карты сайта
- Полностью переработан сниппет sfLink - гораздо быстрее и удобнее
- Поправил работу плагина с вложенностью страниц
- Добавлен новый класс для работы с меню

1.2.2-beta
==============
- Добавлена поддержка JSON полей, включая tvSuperSelect
- Изменён приоритет на событие onDocFormSave для поддержки TVSS
- Добавлена работа с любыми суффиксами контейнера (/,.html и т.д)
- Добавлена настройка для добавления своего суффикса к сгенерированным страницам
- Добавлена настройка переадресации на правильный суффикс
- Добавлена настройка с названием параметра пагинации, для передачи № страницы в СЕО тексты

1.2.1-beta
==============
- Добавлена поддержка значений из других таблиц для ТВ полей

1.2.0-beta
==============
- Добавлена работа для работы полей-слайдеров (недорогие товары и т.д)
- Устранены некоторые ошибки в js и в классе
- Автоматическая генерация названия для новых ссылок при добавлении новых слов
- Лексиконы компонента переведены на английский язык
- Убраны из класса значения по-умолчанию, чтобы не было подстановок на пустых js полях

1.1.3-beta
==============
- Добавлено копирование правил
- Шаблоны для названия ссылки и галочка перегенерировать
- Изменён механизм подсчёта потомков и выборок
- Добавление правил с учётом полей-слайдеров (цена и т.д)
- Две новые настройки для названия ссылки

1.1.2-beta
==============
- Поправлена работа с ТВ-полями

1.1.1-beta
==============
- Соседние вкладки теперь обновляются автоматически
- Мелкие фиксы

1.1.0-beta
==============
- Поправлены лексиконы
- Поправлен js-файл для обработки заголовков
- Убраны лишние комментарии
- Устанены мелкие баги и ошибки

1.0.10-beta
==============
- Добавлены условия для полей в правиле, чтобы создавать определённые страницы
- Добавил поле editedon для правила и комбобокс с выбором страницы
- Поправил подсчёт мин/макс выборок по ТВ значениям
- Мощный апгрейд кода в логике поиска правил, приоритеты для правил
- Добавлен сниппет sfLink для создания ссылки по нескольким правилам

1.0.9-beta
==============
- Новые комбобоксы в словаре, по полю и значению для более быстрого поиска нужных адресов

1.0.8-beta
==============
- Добавил столбик с датой редактирования для словаря

1.0.7-beta
==============
- Вернул добавление слова в словарь, так удобнее
- Сделал нормальную 404-ую страницу при несуществующих страницах (из админки можно проверить страницу по get-параметрам)

1.0.6-beta
==============
- Вывел для редактирования в окнах URL пункты, связанные с выводом меню

1.0.5-beta
==============
- Добавлен контроллёр для редактирования уникальных мета-тегов с фронтенда для каждой страницы
- Добавлена новый класс для связи URL с полями и словами
- Теперь после редактирования поля, слова обновляются все связанные данные

1.0.4-beta
==============
- Добавил функцию выборки минимальных и максимальных значений.
- Добавил prepareSnippet для подстановки обработанных значений в мета-теги

1.0.3-beta
==============
- Исправление ошибок
- Добавил функцию подсчёта. Активировать в настройках. В шаблонах плейсхолдер count

1.0.2-beta
==============
- Конкретно переписана логика компонента

1.0.1-beta
==============
- Добавлена работа со всеми полями

1.0.0-beta
==============
- First Release',
    'license' => 'GNU GENERAL PUBLIC LICENSE
   Version 2, June 1991
--------------------------

Copyright (C) 1989, 1991 Free Software Foundation, Inc.
59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

Everyone is permitted to copy and distribute verbatim copies
of this license document, but changing it is not allowed.

Preamble
--------

  The licenses for most software are designed to take away your
freedom to share and change it.  By contrast, the GNU General Public
License is intended to guarantee your freedom to share and change free
software--to make sure the software is free for all its users.  This
General Public License applies to most of the Free Software
Foundation\'s software and to any other program whose authors commit to
using it.  (Some other Free Software Foundation software is covered by
the GNU Library General Public License instead.)  You can apply it to
your programs, too.

  When we speak of free software, we are referring to freedom, not
price.  Our General Public Licenses are designed to make sure that you
have the freedom to distribute copies of free software (and charge for
this service if you wish), that you receive source code or can get it
if you want it, that you can change the software or use pieces of it
in new free programs; and that you know you can do these things.

  To protect your rights, we need to make restrictions that forbid
anyone to deny you these rights or to ask you to surrender the rights.
These restrictions translate to certain responsibilities for you if you
distribute copies of the software, or if you modify it.

  For example, if you distribute copies of such a program, whether
gratis or for a fee, you must give the recipients all the rights that
you have.  You must make sure that they, too, receive or can get the
source code.  And you must show them these terms so they know their
rights.

  We protect your rights with two steps: (1) copyright the software, and
(2) offer you this license which gives you legal permission to copy,
distribute and/or modify the software.

  Also, for each author\'s protection and ours, we want to make certain
that everyone understands that there is no warranty for this free
software.  If the software is modified by someone else and passed on, we
want its recipients to know that what they have is not the original, so
that any problems introduced by others will not reflect on the original
authors\' reputations.

  Finally, any free program is threatened constantly by software
patents.  We wish to avoid the danger that redistributors of a free
program will individually obtain patent licenses, in effect making the
program proprietary.  To prevent this, we have made it clear that any
patent must be licensed for everyone\'s free use or not licensed at all.

  The precise terms and conditions for copying, distribution and
modification follow.


GNU GENERAL PUBLIC LICENSE
TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
---------------------------------------------------------------

  0. This License applies to any program or other work which contains
a notice placed by the copyright holder saying it may be distributed
under the terms of this General Public License.  The "Program", below,
refers to any such program or work, and a "work based on the Program"
means either the Program or any derivative work under copyright law:
that is to say, a work containing the Program or a portion of it,
either verbatim or with modifications and/or translated into another
language.  (Hereinafter, translation is included without limitation in
the term "modification".)  Each licensee is addressed as "you".

Activities other than copying, distribution and modification are not
covered by this License; they are outside its scope.  The act of
running the Program is not restricted, and the output from the Program
is covered only if its contents constitute a work based on the
Program (independent of having been made by running the Program).
Whether that is true depends on what the Program does.

  1. You may copy and distribute verbatim copies of the Program\'s
source code as you receive it, in any medium, provided that you
conspicuously and appropriately publish on each copy an appropriate
copyright notice and disclaimer of warranty; keep intact all the
notices that refer to this License and to the absence of any warranty;
and give any other recipients of the Program a copy of this License
along with the Program.

You may charge a fee for the physical act of transferring a copy, and
you may at your option offer warranty protection in exchange for a fee.

  2. You may modify your copy or copies of the Program or any portion
of it, thus forming a work based on the Program, and copy and
distribute such modifications or work under the terms of Section 1
above, provided that you also meet all of these conditions:

    a) You must cause the modified files to carry prominent notices
    stating that you changed the files and the date of any change.

    b) You must cause any work that you distribute or publish, that in
    whole or in part contains or is derived from the Program or any
    part thereof, to be licensed as a whole at no charge to all third
    parties under the terms of this License.

    c) If the modified program normally reads commands interactively
    when run, you must cause it, when started running for such
    interactive use in the most ordinary way, to print or display an
    announcement including an appropriate copyright notice and a
    notice that there is no warranty (or else, saying that you provide
    a warranty) and that users may redistribute the program under
    these conditions, and telling the user how to view a copy of this
    License.  (Exception: if the Program itself is interactive but
    does not normally print such an announcement, your work based on
    the Program is not required to print an announcement.)

These requirements apply to the modified work as a whole.  If
identifiable sections of that work are not derived from the Program,
and can be reasonably considered independent and separate works in
themselves, then this License, and its terms, do not apply to those
sections when you distribute them as separate works.  But when you
distribute the same sections as part of a whole which is a work based
on the Program, the distribution of the whole must be on the terms of
this License, whose permissions for other licensees extend to the
entire whole, and thus to each and every part regardless of who wrote it.

Thus, it is not the intent of this section to claim rights or contest
your rights to work written entirely by you; rather, the intent is to
exercise the right to control the distribution of derivative or
collective works based on the Program.

In addition, mere aggregation of another work not based on the Program
with the Program (or with a work based on the Program) on a volume of
a storage or distribution medium does not bring the other work under
the scope of this License.

  3. You may copy and distribute the Program (or a work based on it,
under Section 2) in object code or executable form under the terms of
Sections 1 and 2 above provided that you also do one of the following:

    a) Accompany it with the complete corresponding machine-readable
    source code, which must be distributed under the terms of Sections
    1 and 2 above on a medium customarily used for software interchange; or,

    b) Accompany it with a written offer, valid for at least three
    years, to give any third party, for a charge no more than your
    cost of physically performing source distribution, a complete
    machine-readable copy of the corresponding source code, to be
    distributed under the terms of Sections 1 and 2 above on a medium
    customarily used for software interchange; or,

    c) Accompany it with the information you received as to the offer
    to distribute corresponding source code.  (This alternative is
    allowed only for noncommercial distribution and only if you
    received the program in object code or executable form with such
    an offer, in accord with Subsection b above.)

The source code for a work means the preferred form of the work for
making modifications to it.  For an executable work, complete source
code means all the source code for all modules it contains, plus any
associated interface definition files, plus the scripts used to
control compilation and installation of the executable.  However, as a
special exception, the source code distributed need not include
anything that is normally distributed (in either source or binary
form) with the major components (compiler, kernel, and so on) of the
operating system on which the executable runs, unless that component
itself accompanies the executable.

If distribution of executable or object code is made by offering
access to copy from a designated place, then offering equivalent
access to copy the source code from the same place counts as
distribution of the source code, even though third parties are not
compelled to copy the source along with the object code.

  4. You may not copy, modify, sublicense, or distribute the Program
except as expressly provided under this License.  Any attempt
otherwise to copy, modify, sublicense or distribute the Program is
void, and will automatically terminate your rights under this License.
However, parties who have received copies, or rights, from you under
this License will not have their licenses terminated so long as such
parties remain in full compliance.

  5. You are not required to accept this License, since you have not
signed it.  However, nothing else grants you permission to modify or
distribute the Program or its derivative works.  These actions are
prohibited by law if you do not accept this License.  Therefore, by
modifying or distributing the Program (or any work based on the
Program), you indicate your acceptance of this License to do so, and
all its terms and conditions for copying, distributing or modifying
the Program or works based on it.

  6. Each time you redistribute the Program (or any work based on the
Program), the recipient automatically receives a license from the
original licensor to copy, distribute or modify the Program subject to
these terms and conditions.  You may not impose any further
restrictions on the recipients\' exercise of the rights granted herein.
You are not responsible for enforcing compliance by third parties to
this License.

  7. If, as a consequence of a court judgment or allegation of patent
infringement or for any other reason (not limited to patent issues),
conditions are imposed on you (whether by court order, agreement or
otherwise) that contradict the conditions of this License, they do not
excuse you from the conditions of this License.  If you cannot
distribute so as to satisfy simultaneously your obligations under this
License and any other pertinent obligations, then as a consequence you
may not distribute the Program at all.  For example, if a patent
license would not permit royalty-free redistribution of the Program by
all those who receive copies directly or indirectly through you, then
the only way you could satisfy both it and this License would be to
refrain entirely from distribution of the Program.

If any portion of this section is held invalid or unenforceable under
any particular circumstance, the balance of the section is intended to
apply and the section as a whole is intended to apply in other
circumstances.

It is not the purpose of this section to induce you to infringe any
patents or other property right claims or to contest validity of any
such claims; this section has the sole purpose of protecting the
integrity of the free software distribution system, which is
implemented by public license practices.  Many people have made
generous contributions to the wide range of software distributed
through that system in reliance on consistent application of that
system; it is up to the author/donor to decide if he or she is willing
to distribute software through any other system and a licensee cannot
impose that choice.

This section is intended to make thoroughly clear what is believed to
be a consequence of the rest of this License.

  8. If the distribution and/or use of the Program is restricted in
certain countries either by patents or by copyrighted interfaces, the
original copyright holder who places the Program under this License
may add an explicit geographical distribution limitation excluding
those countries, so that distribution is permitted only in or among
countries not thus excluded.  In such case, this License incorporates
the limitation as if written in the body of this License.

  9. The Free Software Foundation may publish revised and/or new versions
of the General Public License from time to time.  Such new versions will
be similar in spirit to the present version, but may differ in detail to
address new problems or concerns.

Each version is given a distinguishing version number.  If the Program
specifies a version number of this License which applies to it and "any
later version", you have the option of following the terms and conditions
either of that version or of any later version published by the Free
Software Foundation.  If the Program does not specify a version number of
this License, you may choose any version ever published by the Free Software
Foundation.

  10. If you wish to incorporate parts of the Program into other free
programs whose distribution conditions are different, write to the author
to ask for permission.  For software which is copyrighted by the Free
Software Foundation, write to the Free Software Foundation; we sometimes
make exceptions for this.  Our decision will be guided by the two goals
of preserving the free status of all derivatives of our free software and
of promoting the sharing and reuse of software generally.

NO WARRANTY
-----------

  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
REPAIR OR CORRECTION.

  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
POSSIBILITY OF SUCH DAMAGES.

---------------------------
END OF TERMS AND CONDITIONS',
    'readme' => '--------------------
SeoFilter - convenient control of friendly URL, meta tags and text generation
--------------------
Author: Evgeniy Sheronov <webrush@bk.ru>
--------------------

SeoFilter for Minishop2 & mSearch2 and not only for MODX Revolution.

The articles about SeoFilter:
https://modx.pro/components/12921/
https://modx.pro/components/13407/
https://modx.pro/components/14899/
https://modx.pro/components/15476/

Full Documentation: https://docs.modx.pro/components/seofilter/
Demo: http://s9767.h8.modhost.pro

Possible additional paid modifications for a specific project.',
    'chunks' => 
    array (
      'tpl.SeoFilter.crumbs.current' => '{if !$sflink}{set $sflink = $_modx->getPlaceholder(\'sf.link\')}{/if}
{if !$sfurl}{set $sfurl = $_modx->getPlaceholder(\'sf.url\')}{/if}
<li class="sf_crumb{if !$sflink} active{/if}" data-idx="{$idx}" data-separator="{$outputSeparator|htmlentities}">
    {if $sflink}
        <a href="{$link}">{$menutitle}</a>
    {else}
        {$menutitle}
    {/if}
</li>{if $sflink}{$outputSeparator}<li class="active sf_crumbs" data-idx="{++$idx}">
<span class="sf_link">{$sflink}</span>
    {*закомментированный ниже вариант позволит возвращать ссылку *}
    {*{set $page_link = $link}
    {foreach [\'.html\',\'.php\'] as $suffix}
        {set $msufx = \'*\'~$suffix}
        {if $page_link | match : $msufx}
            {set $r_mask = \'/\'~$suffix~\'$/\'}
            {set $page_link = ($page_link | ereplace: $r_mask:\'/\')}
            {break}
        {/if}
    {/foreach}
    <a href="{$page_link}{$sfurl}" class="sf_link">{$sflink}</a>
    *}
</li>
{/if}
',
    ),
    'setup-options' => 'seofilter-1.5.4-beta/setup-options.php',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '5908309905a89fd0a0c8ae9249d35199',
      'native_key' => 'seofilter',
      'filename' => 'modNamespace/3d074fe0ead4959cfb3243d48823e04d.vehicle',
      'namespace' => 'seofilter',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOFileVehicle',
      'class' => 'xPDOFileVehicle',
      'guid' => 'bf13a1ae0f2a41bad833a26936e803d1',
      'native_key' => 'bf13a1ae0f2a41bad833a26936e803d1',
      'filename' => 'xPDOFileVehicle/cc9ccd3507878c18d7aca27e1ac7ac83.vehicle',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'de73d9f6de5fce871bc9f3e877618c6d',
      'native_key' => 'seofilter_separator',
      'filename' => 'modSystemSetting/c044ea35419be886a79bdd2aab72bd68.vehicle',
      'namespace' => 'seofilter',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f80f3db6818dd5e24000843d848e470a',
      'native_key' => 'seofilter_base_get',
      'filename' => 'modSystemSetting/8deba6e49c50f466d067faffef6e8e05.vehicle',
      'namespace' => 'seofilter',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'c3cc5fb7fe624f7e035a92ee14ecaa20',
      'native_key' => 'seofilter_ajax',
      'filename' => 'modSystemSetting/514e780495342c59acfeed235e070565.vehicle',
      'namespace' => 'seofilter',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '1d1fcb05a7a5eb18f3ee6e061aaba87b',
      'native_key' => 'seofilter_decline',
      'filename' => 'modSystemSetting/27bb1bcba96955badbae28c2cc839053.vehicle',
      'namespace' => 'seofilter',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7a815cf325447d852f14d7ffd94c3652',
      'native_key' => 'seofilter_morpher_token',
      'filename' => 'modSystemSetting/a33163db89952b9cf8227367ebb5709a.vehicle',
      'namespace' => 'seofilter',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2ed9c110e873931ffd4b1877e71d1545',
      'native_key' => 'seofilter_classes',
      'filename' => 'modSystemSetting/32362d7ea26578e8a90d1df209246ec2.vehicle',
      'namespace' => 'seofilter',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'c3913205f120f2158b04718b351135a4',
      'native_key' => 'seofilter_templates',
      'filename' => 'modSystemSetting/5923671e0be6cfc94ef21025b1970317.vehicle',
      'namespace' => 'seofilter',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '94ec536841987ce9fc3b45172b9e6a13',
      'native_key' => 'seofilter_page_key',
      'filename' => 'modSystemSetting/6f922a50dbaa5fac3076d6fc352f3fbf.vehicle',
      'namespace' => 'seofilter',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'faba93000326b77b6e69ccc4dccb0ee1',
      'native_key' => 'seofilter_page_tpl',
      'filename' => 'modSystemSetting/eec7279ba1465c76f88b5ce23682db1f.vehicle',
      'namespace' => 'seofilter',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'ae8fbb33ca7ee469bfe7fd52aff63b9c',
      'native_key' => 'seofilter_url_suffix',
      'filename' => 'modSystemSetting/8a58089c7c91a8f2fe9de7b51d610b7a.vehicle',
      'namespace' => 'seofilter',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '1bba94a327dc7b601bc6e598a94c5930',
      'native_key' => 'seofilter_url_redirect',
      'filename' => 'modSystemSetting/43378d43c7162f9b4832f37ff9e54091.vehicle',
      'namespace' => 'seofilter',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '07b0e41e478ebfe5328c21ba6b911d98',
      'native_key' => 'seofilter_last_modified',
      'filename' => 'modSystemSetting/cba7dfb448f10c86def0becee3a1c33e.vehicle',
      'namespace' => 'seofilter',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b9efcf49ef05c0b0953a2f9cb38674ea',
      'native_key' => 'seofilter_mfilter_words',
      'filename' => 'modSystemSetting/3f8860989892e043dd33701096d2ab4b.vehicle',
      'namespace' => 'seofilter',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'bd434ca88501093870cf060ff0a14d59',
      'native_key' => 'seofilter_values_separator',
      'filename' => 'modSystemSetting/b5b87141077f7043986db29ad5fc5b9c.vehicle',
      'namespace' => 'seofilter',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6bbdab4412252cedd76a0684b6519ed0',
      'native_key' => 'seofilter_values_delimeter',
      'filename' => 'modSystemSetting/c3578517ad5096345ce227b9a58162c7.vehicle',
      'namespace' => 'seofilter',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9e3b7e7a28fef1bcd4aee859819d72c2',
      'native_key' => 'seofilter_snippet',
      'filename' => 'modSystemSetting/af5afbbc8a037bc52f39f6ca87c1f8d2.vehicle',
      'namespace' => 'seofilter',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '700afe480ec1933f84b663c3d7ba1789',
      'native_key' => 'seofilter_replace_host',
      'filename' => 'modSystemSetting/14fb23e9dc7a408d690f0074aa9876ba.vehicle',
      'namespace' => 'seofilter',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '065b4cbe82075ab38346c86a1f858d59',
      'native_key' => 'seofilter_pro_mode',
      'filename' => 'modSystemSetting/bc8a7ffa645e8a96b53a3d46f74b073d.vehicle',
      'namespace' => 'seofilter',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2203c98ce8119e817f86055bed8ac901',
      'native_key' => 'seofilter_url_scheme',
      'filename' => 'modSystemSetting/393fa20683e03cd862333bf5ad1dd8c8.vehicle',
      'namespace' => 'seofilter',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '8ca769d10136cbdf5fc2b88e82630147',
      'native_key' => 'seofilter_level_separator',
      'filename' => 'modSystemSetting/699b425526ad26ab9b4c61ae9689266d.vehicle',
      'namespace' => 'seofilter',
    ),
    22 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '68c3f7e748b491c600081e5fc68c4aaa',
      'native_key' => 'seofilter_between_urls',
      'filename' => 'modSystemSetting/feed937ab6181ad38fef71a39dc143d0.vehicle',
      'namespace' => 'seofilter',
    ),
    23 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd9eec8130f8f6ac9662311395317f9bf',
      'native_key' => 'seofilter_main_alias',
      'filename' => 'modSystemSetting/72fa54a4a67ac540066e83b97049e4c6.vehicle',
      'namespace' => 'seofilter',
    ),
    24 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6eff4929b4e26397a7536412de45f0b1',
      'native_key' => 'seofilter_frontend_js',
      'filename' => 'modSystemSetting/13f5ed92cfcd481d742563640efef35e.vehicle',
      'namespace' => 'seofilter',
    ),
    25 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f96da14a8531278177461cd0af135450',
      'native_key' => 'seofilter_hide_empty',
      'filename' => 'modSystemSetting/bc67f1a00c96b2322825b933624ddc4c.vehicle',
      'namespace' => 'seofilter',
    ),
    26 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '36405fc4de9f88dff05eea9591471723',
      'native_key' => 'seofilter_count',
      'filename' => 'modSystemSetting/9d1df69256403ba384c58ad42d760b27.vehicle',
      'namespace' => 'seofilter',
    ),
    27 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5606d34934d8e29663a3b9ab8bc05f5a',
      'native_key' => 'seofilter_choose',
      'filename' => 'modSystemSetting/72b5259263706c9ceb54204461f52cbe.vehicle',
      'namespace' => 'seofilter',
    ),
    28 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2302f2e054eefc1f46aae42f5501c985',
      'native_key' => 'seofilter_count_handler_class',
      'filename' => 'modSystemSetting/94dfe63c1aa584fa7a19ce1c1524a633.vehicle',
      'namespace' => 'seofilter',
    ),
    29 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '636e0e9080a706b30de7eb4ef8c616cd',
      'native_key' => 'seofilter_select',
      'filename' => 'modSystemSetting/6ee079214ef8fa07c9759aaae26d27f8.vehicle',
      'namespace' => 'seofilter',
    ),
    30 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd7626bdcbb6a077cea6258b1a04ca4e7',
      'native_key' => 'seofilter_default_where',
      'filename' => 'modSystemSetting/6b245c76605af6b6f57e5549ef7df67e.vehicle',
      'namespace' => 'seofilter',
    ),
    31 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '173683a530b2fedca5942953213fce67',
      'native_key' => 'seofilter_title',
      'filename' => 'modSystemSetting/25f4f584a0e498f410326406392cfa71.vehicle',
      'namespace' => 'seofilter',
    ),
    32 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '09397fdcf5d97497d78ba9c804be2721',
      'native_key' => 'seofilter_description',
      'filename' => 'modSystemSetting/80133f3808459071286c4d87f748a74a.vehicle',
      'namespace' => 'seofilter',
    ),
    33 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '54bff3a371f97d682956b7707c7d4296',
      'native_key' => 'seofilter_introtext',
      'filename' => 'modSystemSetting/dad41b6f3abf777d7f7b64ece8213094.vehicle',
      'namespace' => 'seofilter',
    ),
    34 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'a8abf341639ce6994cc2ab3d168db872',
      'native_key' => 'seofilter_keywords',
      'filename' => 'modSystemSetting/8bca4b7f94b552782f22a58e1f3ba48e.vehicle',
      'namespace' => 'seofilter',
    ),
    35 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'e47574e81d43c52ebcd39c5f3757cfd7',
      'native_key' => 'seofilter_link',
      'filename' => 'modSystemSetting/2fbf03a11ee3af8138a0b213a663c29a.vehicle',
      'namespace' => 'seofilter',
    ),
    36 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '34e105954f51f33b26c8af05ae64905d',
      'native_key' => 'seofilter_h1',
      'filename' => 'modSystemSetting/7c1eb06a8baad9ae9551b8f4dee098b9.vehicle',
      'namespace' => 'seofilter',
    ),
    37 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '23229efa69b16434d281dfc5ac5dbb26',
      'native_key' => 'seofilter_h2',
      'filename' => 'modSystemSetting/feb293e7c34939d82789466bf0bc62ad.vehicle',
      'namespace' => 'seofilter',
    ),
    38 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '1af54ac68b55686ca4c2c677fdbbd1c1',
      'native_key' => 'seofilter_text',
      'filename' => 'modSystemSetting/5043c744595fe8107a71c966cc358775.vehicle',
      'namespace' => 'seofilter',
    ),
    39 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '61ed943d8a0469706f880d6f082085fb',
      'native_key' => 'seofilter_content',
      'filename' => 'modSystemSetting/928875dbca700a48d1ec20b1e3417d9e.vehicle',
      'namespace' => 'seofilter',
    ),
    40 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '14497f8fb9ca2e0e269b9aa64a91226e',
      'native_key' => 'seofilter_crumbs_tpl_current',
      'filename' => 'modSystemSetting/e3e3d1d86504eacf5842f138b4a174cd.vehicle',
      'namespace' => 'seofilter',
    ),
    41 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '41237381f0e1aa47e1fe15b6f50062c9',
      'native_key' => 'seofilter_replacebefore',
      'filename' => 'modSystemSetting/654d348852bf00714c37d2a1629a6802.vehicle',
      'namespace' => 'seofilter',
    ),
    42 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '28b408a1f6122e31a7a2bfae8f234733',
      'native_key' => 'seofilter_replaceseparator',
      'filename' => 'modSystemSetting/e66c68a668d60531e5a704062b591cd3.vehicle',
      'namespace' => 'seofilter',
    ),
    43 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'e977b564a445218a63239167c78965ed',
      'native_key' => 'seofilter_jtitle',
      'filename' => 'modSystemSetting/cb42755beaa0a344081bde47ac7a1aad.vehicle',
      'namespace' => 'seofilter',
    ),
    44 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'c6b36723ba86ab47c195d5cc18fbc7d5',
      'native_key' => 'seofilter_jdescription',
      'filename' => 'modSystemSetting/b44009a909c2edb5263d7d5df4db3a81.vehicle',
      'namespace' => 'seofilter',
    ),
    45 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7df6cfdd492c318d756cf3284ef47343',
      'native_key' => 'seofilter_jintrotext',
      'filename' => 'modSystemSetting/688715bc49c1527e27edcfff67dfa997.vehicle',
      'namespace' => 'seofilter',
    ),
    46 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '8e616b414033a08a82611fb2cea60dbf',
      'native_key' => 'seofilter_jkeywords',
      'filename' => 'modSystemSetting/310e2bbdfd8d4bf55de0fae575e100b4.vehicle',
      'namespace' => 'seofilter',
    ),
    47 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '3694b64d76d424bed7d49e6e22ac8ccf',
      'native_key' => 'seofilter_jlink',
      'filename' => 'modSystemSetting/f204cbeb44af09e6e36660e4ae086da1.vehicle',
      'namespace' => 'seofilter',
    ),
    48 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '16e66edf755012f7f78d929beb79ca8d',
      'native_key' => 'seofilter_jh1',
      'filename' => 'modSystemSetting/d0b677223fab74eb34eca528a3462fd8.vehicle',
      'namespace' => 'seofilter',
    ),
    49 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7482aebd187cee9f75babeb40fbb1d82',
      'native_key' => 'seofilter_jh2',
      'filename' => 'modSystemSetting/d42557d5124b72aeea13371ae0742853.vehicle',
      'namespace' => 'seofilter',
    ),
    50 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'fbefdaae9cab8a5da1bc17a82b523ea0',
      'native_key' => 'seofilter_jtext',
      'filename' => 'modSystemSetting/ed095aa74702bf467a00f7ee36e92037.vehicle',
      'namespace' => 'seofilter',
    ),
    51 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '85fad7b96ae8756ea6357538c5601933',
      'native_key' => 'seofilter_jcontent',
      'filename' => 'modSystemSetting/b9c002e58e6f9dec31e795fa7615390d.vehicle',
      'namespace' => 'seofilter',
    ),
    52 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '34b8085009a0b674d9cd18e1fc3b54b7',
      'native_key' => 'seofilter_crumbs_replace',
      'filename' => 'modSystemSetting/92dde81967c58569cdac58d99ace04bf.vehicle',
      'namespace' => 'seofilter',
    ),
    53 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '248855400c395087848ae3f382312c0c',
      'native_key' => 'seofilter',
      'filename' => 'modMenu/ef824c5ca713d695025ebbbca6a104f9.vehicle',
      'namespace' => 'seofilter',
    ),
    54 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'encryptedVehicle',
      'class' => 'modCategory',
      'guid' => '9a63cd7b36572ea48fe3e3d100603efb',
      'native_key' => NULL,
      'filename' => 'modCategory/fbf77a3fb575e101e44ee7347759ffe7.vehicle',
      'namespace' => 'seofilter',
    ),
    55 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOScriptVehicle',
      'class' => 'xPDOScriptVehicle',
      'guid' => 'caba9a4bf0a721695792fd90e95d5035',
      'native_key' => 'caba9a4bf0a721695792fd90e95d5035',
      'filename' => 'xPDOScriptVehicle/301a9562b1570de78d48745b792b61b9.vehicle',
      'namespace' => 'seofilter',
    ),
  ),
);