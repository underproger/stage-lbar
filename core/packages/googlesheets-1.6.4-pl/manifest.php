<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => 'Список изменений

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
      'guid' => 'c75c449d3768aaac3b02f3f1de5bd13b',
      'native_key' => 'c75c449d3768aaac3b02f3f1de5bd13b',
      'filename' => 'xPDOFileVehicle/43ce265ec67577e61a6caf482d3c3d68.vehicle',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOScriptVehicle',
      'class' => 'xPDOScriptVehicle',
      'guid' => '58eb0722f38b487775675e3fba555a28',
      'native_key' => '58eb0722f38b487775675e3fba555a28',
      'filename' => 'xPDOScriptVehicle/c11e3e297940ec63dd632ff2304e19d9.vehicle',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '0d1df08ca12c3796e589b3c2d5fa1828',
      'native_key' => 'googlesheets',
      'filename' => 'modNamespace/3c4aaa54931f76de992240a0ad53963f.vehicle',
      'namespace' => 'googlesheets',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '2f099f489259525e4d997225832dfc1e',
      'native_key' => 'gsOnBeforeImportValues',
      'filename' => 'modEvent/a24200cf45ea6a92bec0c99849766f94.vehicle',
      'namespace' => 'googlesheets',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '728b8e1ccdf9ba3b94cd3b47a3260dc1',
      'native_key' => 'gsOnImportValues',
      'filename' => 'modEvent/5d2fd6fd172df50c7d76611d7216975a.vehicle',
      'namespace' => 'googlesheets',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'cc62b63b6612413112dbbab018694bf5',
      'native_key' => 'gsOnAfterImportValues',
      'filename' => 'modEvent/89b1c6967e3af986c7698b65537cf239.vehicle',
      'namespace' => 'googlesheets',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'eee821681afa3a2fe3ebe63f7aa877e5',
      'native_key' => 'gsOnBeforeExportValues',
      'filename' => 'modEvent/f52db85c3d4ff11f4081d2f70a33bbc4.vehicle',
      'namespace' => 'googlesheets',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'dd534144eb22b870052a8b5a6eccacec',
      'native_key' => 'gsOnExportValues',
      'filename' => 'modEvent/2a639e0bdc4501d543c588bcd2e6d621.vehicle',
      'namespace' => 'googlesheets',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '6267c2ed90e1e04fe51a5cc88e4ab0d8',
      'native_key' => 'gsOnAfterExportValues',
      'filename' => 'modEvent/0ce2fd7d39c03b052d70cb28b909dba8.vehicle',
      'namespace' => 'googlesheets',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd8931613cbfd5f3abd19352ad266515a',
      'native_key' => 'gsOnBeforeGetResource',
      'filename' => 'modEvent/87571b50cca8c362ba87a14ef9e33410.vehicle',
      'namespace' => 'googlesheets',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'b0251603b9aeb98b4b0ece42eaac90df',
      'native_key' => 'gsOnGetResource',
      'filename' => 'modEvent/bcbf80783df16e8944386ed0ad48adca.vehicle',
      'namespace' => 'googlesheets',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '31e7e8f8abbfd681f787eb5aed8c34af',
      'native_key' => 'gsOnBeforeGetCategories',
      'filename' => 'modEvent/8a03ccc45ee351aa6f35abbdf0cf58f6.vehicle',
      'namespace' => 'googlesheets',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '8dad45fbc09987e1d7faceea19fb61c3',
      'native_key' => 'gsOnGetCategories',
      'filename' => 'modEvent/4f7dda34045cd86a85ddfe15b251062d.vehicle',
      'namespace' => 'googlesheets',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '604070abc56cd8ed574b69c1b4590d10',
      'native_key' => 'gsOnBeforeGetProducts',
      'filename' => 'modEvent/ee8dfcc68e879acc91f5245f800e16ec.vehicle',
      'namespace' => 'googlesheets',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '292baf9a31f3bf5098036be307934ad1',
      'native_key' => 'gsOnGetProducts',
      'filename' => 'modEvent/b1f52d36506dd461d33c07f61dd0d155.vehicle',
      'namespace' => 'googlesheets',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '6455f3da3fe77801983b7f8810adeaab',
      'native_key' => 'gsOnBeforeGetOrders',
      'filename' => 'modEvent/09e198dd0baa6836d10332bd6f2d8dd6.vehicle',
      'namespace' => 'googlesheets',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '12eb2aaeac577c19a31774e8010e96fb',
      'native_key' => 'gsOnGetOrders',
      'filename' => 'modEvent/822d78ea28fa0a9988eb9c18e43b64d8.vehicle',
      'namespace' => 'googlesheets',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '9deaf2b61d1aa9ed6c9df66892a1ba33',
      'native_key' => 'gsOnBeforeGetVendors',
      'filename' => 'modEvent/f84993961f837cf4312a25a6477b1809.vehicle',
      'namespace' => 'googlesheets',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '2007addf99eecde81786d8f327eba138',
      'native_key' => 'gsOnGetVendors',
      'filename' => 'modEvent/96d0cd38f57fc681c0c7038df0e7f45b.vehicle',
      'namespace' => 'googlesheets',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '015624c4678c80c08c7f287f57d0c8de',
      'native_key' => 'gsOnBeforeGetUsers',
      'filename' => 'modEvent/8652b0ec1d68a7ccade2a87ff6b05530.vehicle',
      'namespace' => 'googlesheets',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '78a667c6efb8c83dd7193fb397736dfb',
      'native_key' => 'gsOnGetUsers',
      'filename' => 'modEvent/81a8dc63805c6a0cf589f3c4831a0917.vehicle',
      'namespace' => 'googlesheets',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '455ccd147f7c4de1cd5cbc3b28ad3327',
      'native_key' => 'gsOnBeforeGetClients',
      'filename' => 'modEvent/ccc7b839e579eab47f651bb253e8b54d.vehicle',
      'namespace' => 'googlesheets',
    ),
    22 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'bf72f4ece8b1d25c5fa5be253a8f8f7f',
      'native_key' => 'gsOnGetClients',
      'filename' => 'modEvent/ac6a4f6a1e1b913da6541f385c5720f4.vehicle',
      'namespace' => 'googlesheets',
    ),
    23 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '80699d947056d1ff8d5c0614cea1c241',
      'native_key' => 'gsOnBeforeGetOptionsPrice2',
      'filename' => 'modEvent/c42997f3d4431a2b68d09ed7fb047c7a.vehicle',
      'namespace' => 'googlesheets',
    ),
    24 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '9008f2a069f9f97833928e9caec29a26',
      'native_key' => 'gsOnGetOptionsPrice2',
      'filename' => 'modEvent/a21a8aca769296955f4bcf651d5b0a45.vehicle',
      'namespace' => 'googlesheets',
    ),
    25 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'b1a943d8179d3b76d2691af4041e029a',
      'native_key' => 'gsOnBeforeGetRemains',
      'filename' => 'modEvent/720d338dc25b15046a185daf8a123bdc.vehicle',
      'namespace' => 'googlesheets',
    ),
    26 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'a61fdb1229ac503b4196bf29e2846c42',
      'native_key' => 'gsOnGetRemains',
      'filename' => 'modEvent/3f1ec65e1a5777f6d81c0ab69e5dae97.vehicle',
      'namespace' => 'googlesheets',
    ),
    27 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '0e3361968c7acc872d94baef82bff2c7',
      'native_key' => 'googlesheets',
      'filename' => 'modMenu/d813c6524f57cb73a7fe4302900a0deb.vehicle',
      'namespace' => 'googlesheets',
    ),
    28 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9798e17cb91f62d3b72be1595b45552d',
      'native_key' => 'googlesheets_client_id',
      'filename' => 'modSystemSetting/6f8bf9fecfa62a970b3e143667c3324f.vehicle',
      'namespace' => 'googlesheets',
    ),
    29 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7fb453a80afa85771b010ba0b217d6c9',
      'native_key' => 'googlesheets_client_secret',
      'filename' => 'modSystemSetting/2fe3820f742bfa7256256cc5dc836f1c.vehicle',
      'namespace' => 'googlesheets',
    ),
    30 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '98b17976552e77e644df6375e6e86339',
      'native_key' => 'googlesheets_token',
      'filename' => 'modSystemSetting/78cc8af67e8de48e4802ea3b00ed52b8.vehicle',
      'namespace' => 'googlesheets',
    ),
    31 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0c39e6a23f4b86ef164522ffa143a6b1',
      'native_key' => 'googlesheets_auth_code',
      'filename' => 'modSystemSetting/8f7b609b591dc6194218a6ec17389680.vehicle',
      'namespace' => 'googlesheets',
    ),
    32 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'e20bec9354a6c467210fc58e47fa42ff',
      'native_key' => 'googlesheets_form_table',
      'filename' => 'modSystemSetting/462617718b63ac167f299d7fff07747c.vehicle',
      'namespace' => 'googlesheets',
    ),
    33 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2585cb3766c78693b142135b44e9ce9d',
      'native_key' => 'googlesheets_form_range',
      'filename' => 'modSystemSetting/b2d3ef5d1dc14e963a91c657f5164cc4.vehicle',
      'namespace' => 'googlesheets',
    ),
    34 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '3d018d64fd0f1713f6900179551f2e97',
      'native_key' => 'googlesheets_form_fields',
      'filename' => 'modSystemSetting/f9098f44c1f8584d65f0523fa941bbde.vehicle',
      'namespace' => 'googlesheets',
    ),
    35 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'encryptedVehicle',
      'class' => 'modCategory',
      'guid' => 'ca8deedfac385b1d7926f1ff7a2e359f',
      'native_key' => NULL,
      'filename' => 'modCategory/a98bd0ab8fd5cfacf538a6ae3e24190f.vehicle',
      'namespace' => 'googlesheets',
    ),
    36 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOScriptVehicle',
      'class' => 'xPDOScriptVehicle',
      'guid' => '2722439694a69cfe649eb529b688137d',
      'native_key' => '2722439694a69cfe649eb529b688137d',
      'filename' => 'xPDOScriptVehicle/78c262d9b081154011decb9df8a94c28.vehicle',
      'namespace' => 'googlesheets',
    ),
  ),
);