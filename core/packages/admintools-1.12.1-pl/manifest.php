<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => '1.12.1-pl
==============
- Some bugfixes.

1.12.0-pl
==============
- Added package action management which allows to prevent from installing, uninstalling, updating and removing packages.

1.11.2-pl
==============
- Some code optimization (special thanks to Fi1osof).

1.11.1-pl
==============
- Fixed error in the names of the two last added system settings.
- Changed order of including css files.

1.11.0-pl
==============
- Added 2 system settings - "admintools_custom_css" and "admintools_custom_js" which allow to add to the manager interface custom style and javascript files.
- Tuned the purple theme.

1.10.1-beta
==============
- Added the \'purple\' color theme.
- Bugfixes.

1.10.0-beta
==============
- Added color themes.
- The resource tree can be moved to the right side.

1.9.0-pl
==============
- Added plugin interface with bound events.

1.8.2-pl
==============
- Added a checkbox "Create cache" to the resource form which allows to save the resource to the cache when you save it.
- Admin notes can be imported and exported.

1.8.1-beta
==============
- Fixed issue #8 with mbstring.

1.8.0-beta
==============
- Added alternative permissions for resources.
- Template link in the resource form is made as icon.
- The "description" and "introtext" fields now are resizable.

1.7.0-pl
==============
- Added animation for the main menu.
- Added system setting to disable templates and resources relationship.

1.6.0-pl
==============
- Added templates and resources relationship.

1.5.0-pl
==============
- Added user notes functionality.

1.4.1-pl
==============
- Made the alternate login interface in pure javascript. Remove the jQuery from the AdminLogin snippet.
- Automatic logout inactive or blocked user if he is logged in.

1.4.1-beta
==============
- Element names in the elements log are links now.
- Fixed bug of the email authorization.

1.4.0-beta
==============
- Backend users can authorize via email.
- Some code optimization.

1.3.0-pl
==============
- Added system setting for switching on/off the favorite elements function.
- Added ability to clear only the saved resource cache (system setting "clear_only resource_cache").
- Added system setting for hiding component description at menu "Extras".
- The list of the edited elements is getting from the system \'manager_log\' table.
- Added filter to the last edited elements grid.
- The user settings of the favorite elements and the system settings save to the extended field of the user (special thanks to Lukas Zahnd).
- Fixed some bugs (special thanks to Lukas Zahnd).

1.2.1-pl
==============
- Fixed bug with favorites elements.

1.2.0-pl
==============
- Added a log of recently edited elements to the tree toolbar.
- Switch off check the elements permission for users with sudo while the tree is building.
- Fixed some bugs.

1.1.1-pl
==============
- Fixed session array for admintools.

1.1.0-pl
==============
- Remember system settings state.
- Added system setting allowing to switch off check the elements permission while the tree is building.
- Show favorite elements without category folders.

1.0.2-pl
==============
- Personal setting for each user.

1.0.1-pl
==============
- Changed the cache path.

1.0.0-pl
==============
- Initial release.',
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
AdminTools
--------------------
Author: Sergey Shlokov <sergant210{at}bk.ru>
--------------------

A basic Extra for MODx Revolution Administrators.

Feel free to suggest ideas/improvements/bugs on GitHub:
http://github.com/sergant210/AdminTools/issues',
    'chunks' => 
    array (
      'tpl.login.form' => '<div id="container">
	<div id="modx-login-logo">
		<!--[if gte IE 9]><!--><img src="/manager/templates/default/images/modx-logo-color.svg" alt="MODX CMS/CMF"><!--<![endif]-->
		<!--[if lt IE 9]><img alt="MODX CMS/CMF" src="/manager/templates/default/images/modx-logo-color.png" /><![endif]-->
	</div>

	<div class="modx-form" id="modx-login-panel">
		<div class="panel-title">
			<h2>[[++site_name]]</h2>
		</div>
		<div id="errormsg">[[+errormsg]]</div>
		<div class="panel-body">
			<form method="post" action="" id="manager-login-form">
				<div class="login-form-item">
					<div class="login-form-element">
						<input type="text" placeholder="[[%admintools_username_email]]" class="form-text" name="userdata" id="userdata" autocomplete="on">
					</div>
				</div>
				<div class="form-action">
					<button id="send-email-btn" value="1" type="button" class="primary-button login-form-btn">[[%admintools_send_authorization_link]]</button>
				</div>
			</form>
		</div>
	</div>
</div>',
    ),
    'setup-options' => 'admintools-1.12.1-pl/setup-options.php',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '51f2570f001edfe4c465cc3bbb904b25',
      'native_key' => 'admintools',
      'filename' => 'modNamespace/f5dd86b519706be222f240c324a6dc23.vehicle',
      'namespace' => 'admintools',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'cdfd2f498aa7d70c89754b7bb6363334',
      'native_key' => 'admintools_favorites_icon',
      'filename' => 'modSystemSetting/f92928d1cfd12e7a673e9cfc54748692.vehicle',
      'namespace' => 'admintools',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '9a394f96c9a3ba73fa20be90e209ae8e',
      'native_key' => 'admintools_check_elements_permissions',
      'filename' => 'modSystemSetting/2cd984f3e613193aa6e513e401b650dd.vehicle',
      'namespace' => 'admintools',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2288e9ba28e21545d7d57b50016db2d2',
      'native_key' => 'admintools_remember_system_settings',
      'filename' => 'modSystemSetting/251118e1264821a3aa2b4ecdc10f4416.vehicle',
      'namespace' => 'admintools',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '816726b829a8066f30f2c2b794c57d21',
      'native_key' => 'admintools_enable_elements_log',
      'filename' => 'modSystemSetting/2e68aad42269b21ec64e2cb86217c8a5.vehicle',
      'namespace' => 'admintools',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b9c4d195757c8aca5c23c748cd9fb549',
      'native_key' => 'admintools_enable_favorite_elements',
      'filename' => 'modSystemSetting/77defa1588e48794ffd440ab27a5b17b.vehicle',
      'namespace' => 'admintools',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '1ff7f84b61d5ca5b7a1470e4d4cc2aca',
      'native_key' => 'admintools_clear_only_resource_cache',
      'filename' => 'modSystemSetting/82bb85be47e151367eed5f223d5e20d5.vehicle',
      'namespace' => 'admintools',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '8ba55f7786462bfb8ee72edc45102f29',
      'native_key' => 'admintools_hide_component_description',
      'filename' => 'modSystemSetting/a733259d02d4f273ff4d6c407a2698ef.vehicle',
      'namespace' => 'admintools',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b4904d77b12d0aaf5e43cd9ca9362fec',
      'native_key' => 'admintools_email_authorization',
      'filename' => 'modSystemSetting/6ad28e0bc53b2e1b94905737efd052bc.vehicle',
      'namespace' => 'admintools',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '86a2281417a6ad4854a9ec1c07df045c',
      'native_key' => 'admintools_authorization_ttl',
      'filename' => 'modSystemSetting/110947763bc12bce5267506aae56d8b2.vehicle',
      'namespace' => 'admintools',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b10f105f439b477d2943ec056adb87f6',
      'native_key' => 'admintools_loginform_resource',
      'filename' => 'modSystemSetting/0e1829b410748b387d4c35d000357171.vehicle',
      'namespace' => 'admintools',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '842e4aeb923f299231278f964bdbac66',
      'native_key' => 'admintools_enable_notes',
      'filename' => 'modSystemSetting/885a3f83c98874beb47e267a57edfb12.vehicle',
      'namespace' => 'admintools',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'dee4f07c2b2902012097bbc0ffd52caa',
      'native_key' => 'admintools_template_resource_relationship',
      'filename' => 'modSystemSetting/505f87b89d88e205379130de396f8a88.vehicle',
      'namespace' => 'admintools',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '453f27f99620c4704c1b43ae1a885cbd',
      'native_key' => 'admintools_animate_menu',
      'filename' => 'modSystemSetting/377490bfe761e9d98c59a64eaf0df367.vehicle',
      'namespace' => 'admintools',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '8fb7f2f0f3977365905ec89a73321659',
      'native_key' => 'admintools_alternative_permissions',
      'filename' => 'modSystemSetting/48508ebb99730139a0851e995e4b792c.vehicle',
      'namespace' => 'admintools',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0098dc7effdda6a449edfafdcc0c317a',
      'native_key' => 'admintools_plugins_events',
      'filename' => 'modSystemSetting/20a68f77746f9b2552aba629573df461.vehicle',
      'namespace' => 'admintools',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6b56deeba51c4788cf7685c8852ab068',
      'native_key' => 'admintools_theme',
      'filename' => 'modSystemSetting/87c587d03f7daff94ff8e2928765a909.vehicle',
      'namespace' => 'admintools',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '37fa509d2b0cb0b55d5411fb60b3d501',
      'native_key' => 'admintools_modx_tree_position',
      'filename' => 'modSystemSetting/19d8a31f642ab433e2000c8204a176c6.vehicle',
      'namespace' => 'admintools',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7d788d823ff85409e426afbcdc2ab7a1',
      'native_key' => 'admintools_custom_css',
      'filename' => 'modSystemSetting/9374ff562eb838a5d4588b380ad20bd8.vehicle',
      'namespace' => 'admintools',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f4dada91bf1c6c1c2223883b27534415',
      'native_key' => 'admintools_custom_js',
      'filename' => 'modSystemSetting/ac7ea28f4fa921a90f8689202e101be1.vehicle',
      'namespace' => 'admintools',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f4edddd1e6d63d01dc1122e3f8af8dc7',
      'native_key' => 'admintools_package_actions',
      'filename' => 'modSystemSetting/b8ef8fcb5aace6a3c7af4bdd7b57f438.vehicle',
      'namespace' => 'admintools',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modCategory',
      'guid' => '75ab1a27dbb724574ab71ea1bb1d5864',
      'native_key' => NULL,
      'filename' => 'modCategory/b8919ade5e5e0740d0b653a3be73aee3.vehicle',
      'namespace' => 'admintools',
    ),
  ),
);