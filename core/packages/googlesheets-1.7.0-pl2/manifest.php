<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => 'Список изменений

1.7.0 (20.11.2021)
==============
 - Обновлено: Google API Client Library

1.6.5 (23.09.2021)
==============
  - Исправлено: ошибки

1.6.4 (21.04.2021)
==============
- Исправлено:
    экспорт больших данных
    создание модификаций при импорте

1.6.3 (26.03.2021)
==============
 - Исправлено: ошибки

1.6.2 (26.03.2021)
==============
 - Исправлено: экспорт остатков

1.6.1 (20.03.2021)
==============
 - Улучшен импорт опций товара

1.6.0 (02.02.2021)
==============
 - Исправлена ошибка при импорте опций товара

1.5.15 (21.01.21)
==============
 - Исправлена ошибка передачи пустого значения для изображения при импорте
 - Исправлен сниипет GoogleSheetsFront для крона
 - Добавлены параметры query и where в сниппет GoogleSheets

1.5.14 (08.12.20)
==============
 - Исправлен импорт поля categories

1.5.13 (05.07.20)
==============
 - Добавлена синхронизация по любому полю
 - Добавлено событие: gsOnAfterExportValues

1.5.12 (15.06.20)
==============
 - Исправлено получение поля address_properties в плагине
 - Исправлено сообщение после экспорта

1.5.11 (09.06.20)
==============
 - Добавление TV в экспорт категории
 - Исправлен экспорт изображений
 - Исправлена ошибка поиска в таблице

1.5.10 (07.06.20)
==============
 - Добавлены события: gsOnAfterImportValues, gsOnAfterExportValues
 - Добавлено: копирование настроек

1.5.9 (03.06.20)
==============
 - Поправлен экспорт заказов
 - Поправлен импорт/экспорт migx поля
 - Исправлен redirect_uri при авторизации

1.5.8 (21.05.20)
==============
 - Обновлена авторизация
 - Исправлен экспорт товаров

1.5.7 (12.05.20)
==============
 - Решена проблема с ограничением при экспорте
 - Добавлено: создание опций товара

1.5.6 (11.05.20)
==============
 - Исправлен импорт товаров и опций
 - Удаление старых изображений в галереи товара(msGallery) при импорте 
 - Добавлена ссылка для авторизации
 - Обновлен сниппет GoogleSheets
 - Исправлено удаление данных
 
1.5.5 (02.05.20)
==============
 - Исправлена ошибка импорта при создании товара 

1.5.4 (02.05.20)
==============
 - Исправлена ошибка при экспорте картинок
 - Исправлена ошибка при инициализации класса GoogleSheets

1.5.3 (23.04.20)
============== 
 - Исправлены сниппеты
 - Исправлена функция hasError
 
1.5.2 (20.04.20)
============== 
 - Улучшен экспорт/импорт
 - Исправлен плагин GoogleSheetsSyncOrder
 - Добавлены события: gsOnBeforeGetVendors, gsOnGetVendors, gsOnBeforeGetClients, gsOnGetClients
 - Добавлена возможность получение данных через js

1.5.1 (17.04.20)
============== 
 - Исправление ошибок
    - подключение пользователей в getOrders
    - убран parent c дефолтных полей
    - исправлен разделитель для опций модификации товара
    - исправлен импорт по артиклу товара
    

1.5.0 (15.04.20)
============== 
 - Добавлены события
 - Импорт/Экспорт MIGX полей
 - Импорт/Экспорт msVendor(производители товара minishop2) 
 - Импорт
    - переделан импорт
    - добавлен импорт категорий minishop2(msCategory)
    - возможность пропускать первую строку
 - Экспорт
    - добавлен экспорт покупателей minishop2(msClient)
    - изменены параметры заказов
    - добавлены параметры template_name, vendor_name(minishop2)
    - возможность использовать поля экспорта как заголовки
 - Интеграция
     - ms2Gallery2
     - msOptionsPrice2
     - msProductRemains 
     - SEO Tab
     - SEO Pro    
 - Поправлена синхронизация
 - Добавлена сортировка грида

1.4.0 (03.03.20)
==============
 - Добавлен экспорт/импорт опций товара
 - Исправлены ошибка экспорта при создании заказа
 - Исправлена ошибка экспорта tv полей

1.3.9 (21.01.20)
==============
 - Добавлен экспорт категорий(msCategory)

1.3.8 (24.12.19)
==============
 - Добавлена фильтрация по условию category_id/category_name
 - Округление времени выполнения операции
 - Исправление ошибок при экспорте товаров

1.3.7 (21.11.19)
==============
 - Исправлен баг с кешем при авторизации
 - Добавлена кнопка сброса авторизации
 - Переделан импорт(исправлена синхронизация)

1.3.6 (28.08.19)
==============
 - Исправлена авторизация
 - Исправлены ошибки экспорта/импорта

1.3.5 (15.08.19)
==============
 - Исправлен баг импорта при отсутствии условий
 - Пропуск пустой строчки в таблице

1.3.4 (08.08.19)
==============
 - Улучшен импорт/экспорт

1.3.3 (01.08.19)
==============
- Добавлена поддержка TV для экспорта

1.3.2 (19.05.19)
==============
 - Исправление ошибки при экспорте в режиме Update
 - Добавлен сниппет GoogleSheetsFront - для запуска экспорта/импорта с фронта
 - Добавлен файл action.php для запуска экспорта/импорта по ajax

1.3.1 (14.05.19)
==============
 - Добавлены условия для Импорта и Экспорта
 - Экспорт в режиме Update теперь пропускает 1 строку в таблице
 - Рефакторинг кода
 - Исправлен лексикон import

1.3.0-pl (12.05.19)
==============
 - Синхронизация ресурсов/товаров/пользователей
 - Удалены системные настройки для создание заказов

1.2.6-pl (09.05.19)
==============
 - Синхронизация заказов minishop2
 - Добавлено описание для системных настроек

1.2.5-pl (19.04.19)
==============
 - Обновлен хук GoogleSheetsSaveForm

1.2.4-pl (16.02.19)
==============
 - Добавлена поддерджа TV
 - Автоматически создание категорий, если указан родитель.

1.2.3-pl (17.12.18)
==============
 - Добавлена поддержка мультикатегорий
 - Добавлены поля для экспорта: parent_name, category_name
 - Добавлена поддержка заголовков для полей импорта: parent, category

1.2.2-pl (16.12.18)
==============
 - Добавлена поддержка галереи minishop2
 - Исправлены ошибки при импорте
 - Добавлены поля производителя товара для экспорта (vendor.name, vendor.logo, vendor.country...)

1.2.1-pl (12.12.18)
==============
 - Добавлена проверка списка полей для импорта
 - Добавлена проверка уникального поля при импорте

1.2.0-pl (04.12.18)
==============
 - Добавлено поле \'список полей для импорта\'
 - Удаление ресурсов/товаров через импорт
 - Добавлен экспорт ресурсов/товаров/заказов/пользователей
 - Добавлен тег ignore для пропуска ячейки при сохранении заказов/форм
 - Добавлены свойства товара при сохранении заказа
 - Добавлены доп. поля к заказу по инструкции https://modx.pro/solutions/10040
 - Улучшен модификатор table
 - Добавлены новые параметры для сниппета GoogleSheets: fields,ignore

1.1.0-pl (30.10.18)
==============
 - Добавлен плагин для сохранение заказов minishop2
 - Добавлен импорт товаров minishop2
 - Добавлены сообщение о кол-во обновленных и созданных ресурсов
 - Добавлены настройки импорта
 - Добавлены лексиконы
 - Добавлен модификатор table

1.0.1-pl (29.10.18)
==============
 - Добавлена защита дополнения

1.0.0-pl (29.10.18)
==============
- Первый релиз',
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
GoogleSheets
--------------------
Author: Aleksandr Huz <Superboshnik@gmail.com>
--------------------
',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOFileVehicle',
      'class' => 'xPDOFileVehicle',
      'guid' => 'ceaf7aecfbffaad1176a184a58ec7d4f',
      'native_key' => 'ceaf7aecfbffaad1176a184a58ec7d4f',
      'filename' => 'xPDOFileVehicle/00545704ee96eb6d26358b1446f4c10a.vehicle',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOScriptVehicle',
      'class' => 'xPDOScriptVehicle',
      'guid' => '95875559bd8c3d2f46cca89bc0916fdf',
      'native_key' => '95875559bd8c3d2f46cca89bc0916fdf',
      'filename' => 'xPDOScriptVehicle/336f3d994939fdc2a6dc4b591c8e6002.vehicle',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '16079a6ce0f4629d965d3e597c445a20',
      'native_key' => 'googlesheets',
      'filename' => 'modNamespace/192fd0ea968eb89af08bbd5fac64dc1c.vehicle',
      'namespace' => 'googlesheets',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'fa75086568dd55ffbfb5668ec6d0e553',
      'native_key' => 'gsOnBeforeImportValues',
      'filename' => 'modEvent/87fb47694611a672fdb6987fca5e1797.vehicle',
      'namespace' => 'googlesheets',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '1ea85d6c1fbc13b86820d36ac3a8e9e7',
      'native_key' => 'gsOnImportValues',
      'filename' => 'modEvent/d3262c92afe65a3a01587ffc2b91e455.vehicle',
      'namespace' => 'googlesheets',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '6bdf3f2481b63b2166c3f52aa737e2a7',
      'native_key' => 'gsOnAfterImportValues',
      'filename' => 'modEvent/627c6eb40b2e94e22a9f6d3016c0ce7d.vehicle',
      'namespace' => 'googlesheets',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd8e9273e273429ae0dbf881aa369ced6',
      'native_key' => 'gsOnBeforeExportValues',
      'filename' => 'modEvent/3f6ad8765399202950f0dbeabd42f983.vehicle',
      'namespace' => 'googlesheets',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'abf2560338739d19ad508ec1c2adb1b3',
      'native_key' => 'gsOnExportValues',
      'filename' => 'modEvent/24d227c442e768e882e1518dda47a624.vehicle',
      'namespace' => 'googlesheets',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '9822004b91f64ffcbddaee87ffeebceb',
      'native_key' => 'gsOnAfterExportValues',
      'filename' => 'modEvent/8f9879321dab3c45f8492eaad560886c.vehicle',
      'namespace' => 'googlesheets',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '60c078d8a292313649897c304d2f1948',
      'native_key' => 'gsOnBeforeGetResource',
      'filename' => 'modEvent/36b330e36072e71f0186c8bb4e8ac9a5.vehicle',
      'namespace' => 'googlesheets',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '57f0ef2b0d3befcd60f384d775f053a1',
      'native_key' => 'gsOnGetResource',
      'filename' => 'modEvent/e6f9e6f2e96b5046facf6a49964b2180.vehicle',
      'namespace' => 'googlesheets',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '1af896165c30e6d0e620180a1e8f580c',
      'native_key' => 'gsOnBeforeGetCategories',
      'filename' => 'modEvent/5e718e95a2dca3b15a8ce7cdaf819782.vehicle',
      'namespace' => 'googlesheets',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '6ec7337f38adad998cf980c3ecf2e2be',
      'native_key' => 'gsOnGetCategories',
      'filename' => 'modEvent/873c0539efbe6d8dcbbf0764efc1f9ad.vehicle',
      'namespace' => 'googlesheets',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '98ec0cdef408c667705da5b7543015d9',
      'native_key' => 'gsOnBeforeGetProducts',
      'filename' => 'modEvent/97f6551f01a6c80511dcf13cb5ee9096.vehicle',
      'namespace' => 'googlesheets',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'ba58f2c310b3f4b1b9a10d43e1c8889d',
      'native_key' => 'gsOnGetProducts',
      'filename' => 'modEvent/cc88e50d65c73b06d4115ece9592c4a6.vehicle',
      'namespace' => 'googlesheets',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '2ec1f014aa61d2d31e6b7dfab6253fd4',
      'native_key' => 'gsOnBeforeGetOrders',
      'filename' => 'modEvent/c9443a9a7aa54411b3d7900e8fe91118.vehicle',
      'namespace' => 'googlesheets',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '6c8f08b5e3e4dec48ecd8a80da61eb7a',
      'native_key' => 'gsOnGetOrders',
      'filename' => 'modEvent/091dad3ad11893e9be27a787b92b7c91.vehicle',
      'namespace' => 'googlesheets',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'c7c081d75b7bc005c45e7aaa4ab8d465',
      'native_key' => 'gsOnBeforeGetVendors',
      'filename' => 'modEvent/bd7afb2a32c48c6584a8acfd90b25bec.vehicle',
      'namespace' => 'googlesheets',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '572f5624c38c64707a670b2ab87f7672',
      'native_key' => 'gsOnGetVendors',
      'filename' => 'modEvent/79035ef8d74b48f123e1c2c64a7aba78.vehicle',
      'namespace' => 'googlesheets',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '4ba673b58b8b8509d7c85e9b6b5ccdc2',
      'native_key' => 'gsOnBeforeGetUsers',
      'filename' => 'modEvent/6f16b30e6e7ca964e0d3630f16126ae2.vehicle',
      'namespace' => 'googlesheets',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '352c6071f0d905fd2eeddb194b673182',
      'native_key' => 'gsOnGetUsers',
      'filename' => 'modEvent/01d843590a105ce6f410f2d7c2bbd8a3.vehicle',
      'namespace' => 'googlesheets',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '30c8691ab05c22a7d5fcd8f707d56c3a',
      'native_key' => 'gsOnBeforeGetClients',
      'filename' => 'modEvent/11c153a1300b54c9559a6d0f88aca75b.vehicle',
      'namespace' => 'googlesheets',
    ),
    22 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'e127dc8664626b7a66dc9f39f72df828',
      'native_key' => 'gsOnGetClients',
      'filename' => 'modEvent/808a73817e1a386f3bade408c322fd94.vehicle',
      'namespace' => 'googlesheets',
    ),
    23 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '679cbbe4e523e1d8bec55f49e43a4a7c',
      'native_key' => 'gsOnBeforeGetOptionsPrice2',
      'filename' => 'modEvent/782d999349a17d25b2d6d0f8b3616292.vehicle',
      'namespace' => 'googlesheets',
    ),
    24 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '1488aa199e797fccc8264285758aaa85',
      'native_key' => 'gsOnGetOptionsPrice2',
      'filename' => 'modEvent/749070e016de028a0fda0c7235a00583.vehicle',
      'namespace' => 'googlesheets',
    ),
    25 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '2d47db662a35cdff12151314b8248d1b',
      'native_key' => 'gsOnBeforeGetRemains',
      'filename' => 'modEvent/26e6457ac3f01f824947a0e7f8254793.vehicle',
      'namespace' => 'googlesheets',
    ),
    26 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '200e01b5c610bb48b11272a9ac76e5fd',
      'native_key' => 'gsOnGetRemains',
      'filename' => 'modEvent/62be5e3987824ef4679b922ca80168ab.vehicle',
      'namespace' => 'googlesheets',
    ),
    27 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '75d191cb9d76780f75c8b98425a4a944',
      'native_key' => 'googlesheets',
      'filename' => 'modMenu/996653be767f57536e17bf26332c125a.vehicle',
      'namespace' => 'googlesheets',
    ),
    28 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '04091db9728bb623925deb1ad28cb3e3',
      'native_key' => 'googlesheets_client_id',
      'filename' => 'modSystemSetting/47e9c04436d3f99307702b45a5788cc6.vehicle',
      'namespace' => 'googlesheets',
    ),
    29 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '80d017330c068ff89d39989fae29de71',
      'native_key' => 'googlesheets_client_secret',
      'filename' => 'modSystemSetting/59989e7b83ba03546c6d8cc04c800b80.vehicle',
      'namespace' => 'googlesheets',
    ),
    30 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b9ead761f376fc5791014df413fa5541',
      'native_key' => 'googlesheets_token',
      'filename' => 'modSystemSetting/c0a67d81c956fc08779b103afc8a5dcc.vehicle',
      'namespace' => 'googlesheets',
    ),
    31 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '721834cd642ccfebb0d4ad668f182df0',
      'native_key' => 'googlesheets_auth_code',
      'filename' => 'modSystemSetting/9cbd1fcd318571fd3f3ba87a26e29ea0.vehicle',
      'namespace' => 'googlesheets',
    ),
    32 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '459c8b81506b8c3dd69f5a67edb73d6a',
      'native_key' => 'googlesheets_form_table',
      'filename' => 'modSystemSetting/d807d39d450ee99062c05cd2afd31216.vehicle',
      'namespace' => 'googlesheets',
    ),
    33 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f78a262380f06ab0ad4160af069ec378',
      'native_key' => 'googlesheets_form_range',
      'filename' => 'modSystemSetting/488fd1866988735bd3ba70fa567e058a.vehicle',
      'namespace' => 'googlesheets',
    ),
    34 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'bca9711d18ed958b66760e64b9985913',
      'native_key' => 'googlesheets_form_fields',
      'filename' => 'modSystemSetting/c48aca9e68c7022d171cae922b32f930.vehicle',
      'namespace' => 'googlesheets',
    ),
    35 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'encryptedVehicle',
      'class' => 'modCategory',
      'guid' => 'e841698d4f9f3ffedcf05bab9c277b68',
      'native_key' => NULL,
      'filename' => 'modCategory/298b6f4b58ec31d0da3ffeba7b836a4f.vehicle',
      'namespace' => 'googlesheets',
    ),
    36 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOScriptVehicle',
      'class' => 'xPDOScriptVehicle',
      'guid' => '0785cdf631a6ed2acd22fffa7ee5ebf9',
      'native_key' => '0785cdf631a6ed2acd22fffa7ee5ebf9',
      'filename' => 'xPDOScriptVehicle/b281ef57d0307c28c72b3b2e3d2afab6.vehicle',
      'namespace' => 'googlesheets',
    ),
  ),
);