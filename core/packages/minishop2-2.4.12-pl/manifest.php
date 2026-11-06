<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => 'Changelog for miniShop2.

2.4.12 pl
==============
- Added dutch lexicons by Sterc
- Added greek frontend lexicon
- When you change the price of a product with msOnGetProductPrice, the old_price will be changed only if the new price is lower.
- Fixed method msProductData:rankProductImages()

2.4.11 pl
==============
- Fixed default path to loading services in the loadCustomClasses() method.
- Update the cost of an orders after product addition.
- Improved processing of products options.
- Removed call of ms2Gallery::syncFiles() from msProductData::updateProductImage().
- [mgr] Add contexts list into filters at the orders page.
- [mgr] Fixed possible error on get orders statuses list.
- [mgr] Fix "xcheckbox" in a Product options.
- [mgr] Add "expand,collapse,check,uncheck" actions to the categories and options trees.

2.4.10 pl
==============
- Fixed possible E_WARNING in the snippet msOrder.
- Added events in the processors of msOrderProduct.

2.4.9 pl
==============
- Improved loading of pdoTools in snippets

2.4.8 pl
==============
- Added support of ms2Gallery 2.0.
- Media source option "thumbnails" now uses key of array with parameters as alias for thumbnail.
- Removed system setting "ms2_product_thumbnail_size".
- Fixed bug of gallery with drag-over in Firefox.

2.4.7 pl
==============
- Fixed the loading of product plugins when they can be loaded multiple times.
- Fixed fatal error on get classes in settings with some 3rd party payment methods.
- Fixed bug with incorrect rank of thumbnails after a sorting.

2.4.6 pl
==============
- Added the checking of users email when getting a customer id for new order.
- Improved compatibility with MODX 2.5.2.

2.4.5 pl
==============
- Fixed possible error in log on create a new product from cli mode.
- Updated jGrowl to version 1.4.5.

2.4.4 pl
==============
- [#242] Ability to specify only needed options in the snippet msProductOptions.
- [#212, #241] Fixed handling of a product options with a dot in the name.
- [#240] Fixed the reset of date fields when product has been edited via category grid.
- [#239] Fixed duplicate and empty options in msProductData.
- [#229, #238] Categories tree now respects the "resource_tree_node_name_fallback" system setting.

2.4.3 pl
==============
- [#237] Fixed msProductData::get(\'options\') method.
- [#236] Ability to display category columns of an ordered product.
- [#231] Snippet msOptions now transfers id of a product into a chunk.
- [#230] Fixed the inability to change vendor of a product more than 1 times.
- [#228] Possible fix for "empty file" in product gallery on some server configurations.
- [#227] Improved performance of the grid with options in settings.

2.4.2 pl
==============
- Fixed error when system setting "ms2_product_tab_gallery" is disabled.

2.4.1 pl2
==============
- Fixed error with overwrite product options when update from category grid.

2.4.0 pl
==============
- [#222] Optimized some code in chunks.

2.4.0 rc11
==============
- [msGallery] Improved fetching of thumbnails in the snippet.
- [#220] [mgr] Improved the total numbers in the form of orders.

2.4.0 rc10
==============
- msPaymentHandler::getOrderHash() now includes order num.

2.4.0 rc9
==============
- [#215] Ability to specify working context for cart.

2.4.0 rc8
==============
- [#218] The product options are active immediately after assigning them to categories.

2.4.0 rc7
==============
- Reverted back #216 due to issues.
- [#216] [msGetOrder] Need to update pdoTools to version 2.5.6-pl to fix this.
- [msGetOrder] Orders are show to all if parameter &id is set.
- [mgr] Fixed number of rows in orders panel.

2.4.0 rc6
==============
- [#216] [msGetOrder] Fixed ability to &includeTVs.

2.4.0 rc5
==============
- Removed wrong "requires" field in msPayment settings.

2.4.0 rc4
==============
- Improved migration of system settings when upgrade from older versions.

2.4.0 rc3
==============
- [msGallery] Improved snippet in case when product has no media source set.
- Fixed work with autocomplete product options.

2.4.0 rc2
==============
- Fixed duplicate of order number in msOrderHandler.

2.4.0 rc1
==============
- Fixed loop error on change class key from modResource to msProduct.

2.4.0 rc
==============
- All snippets are completely rewritten.
- All chunks uses Fenom syntax.
- Improved compatibility with MySQL 5.7.
- Improved orders form panel.
- [msOrder] Removed chunks tpl.msOrder.delivery, tpl.msOrder.payment and tpl.msOrder.success.
- [msOrder] Chunk tpl.msOrder.outer renamed to tpl.msOrder.
- [msOrder] New parameter &userFields.
- [msCart] Removed chunks tpl.msCart.row and tpl.msCart.empty.
- [msCart] Chunk tpl.msCart.outer renamed to tpl.msCart.
- [msGetOrder] Now acts as usual snippet and do not set placeholders to the page by default.
- [msGetOrder] Removed chunk tpl.msGetOrder.row.
- [msGetOrder] Added chunk tpl.msGetOrder.
- [msOptions] Removed chunks tpl.msOptions.outer and tpl.msOptions.row.
- [msOptions] Added chunk tpl.msOptions.
- [msProductOptions] Removed chunks tpl.msProductOptions.outer and tpl.msProductOptions.row.
- [msProductOptions] Added chunk tpl.msProductOptions.
- [msGallery] Removed chunks tpl.msGallery.outer, tpl.msGallery.row and tpl.msGallery.empty.
- [msGallery] Added chunk tpl.msGallery.
- [msGallery] Added Fotorama script out from the box.
- Improved email chunks. Added common email template.

2.4.0 beta3
==============
- Small improvements of product gallery.
- Improved ExtJS settings panel.

2.4.0 beta2
==============
- Added system setting "ms2_template_category_default".
- Improved referrals registration.
- Improved ExtJS product panel.
- Emails chunks are now processed by pdoTools.
- Replaced modX::toJSON and modX::fromJSON calls to native functions.
- New system to register 3rd party classes of extensions.
- New system to register 3rd party plugins for objects model.
- Improved duplicate of products and categories.
- The data fields of the product are added to the tags of the resource: [[*price]], [[*article]] etc.
- Improved registration of JS and CSS on frontend.
- Javascript callbacks now are arrays with functions. New functions to register and remove callbacks.
- Updated model for MySQL 5.7.
- Improved product gallery.
- New logo.

2.4.0 beta1
==============
- Improved categories with products.
- Improved menu of categories in resources tree.
- Ability to change class_key of category.
- Many improvements of ExtJS category panel and products grid.
- Setting ms2_category_content_default is now empty by default.

2.4.0 beta0
==============
- Fixed php type of "article" in msProductData xPDO object.
- Improved orders panel.
- Updated builder.
- Added icons for CRCs in managers tree.
- Minimum version is MODX 2.3.

2.2.0 pl2
==============
- ID for Category\'s options tab
- Fix installation for MODX 2.4.0
- msProductOptions product property

2.2.0 beta4
==============
- Category pagination fix.
- Fixed bug removal options when modifying and generating images of products
- Don\'t display tplOuter when all options are empty with hideEmpty=1

2.2.0 beta3
==============
- Measure units for options.
- Restrictions for option names.
- Superboxselect and checkbox option types.
- Fixed bug with empty options after modResource save.

2.2.0 beta2
==============
- Groups of options support.
- hideEmpty parameter in msProductOptions snippet.
- Fixed some bugs.

2.2.0 beta
==============
- Custom product options support. More info at modx.pro.
- Fixed TV showing under content.
- Some code refactoring.

2.1.12 pl
==============
- Improved installation script for MODX 2.4.

2.1.11 pl
==============
- Added new events: "msOnBeforeGetOrderCost" and "msOnGetOrderCost".
- [mgr] Direct links to orders in manager.

2.1.10 pl1
==============
- Added support of Tickets 1.6.
- Updated pdoTools version in the installer.

2.1.9 beta
==============
- Fixed modification of order price by delivery and payment in default order handler.
- Fixed processing of decimal prices in PayPal payment class.
- Improved chunk tpl.msOrder.payment.

2.1.8 pl3
==============
- Fixed controllers for MODX 2.3.
- Fixed routes to processors for MODX 2.3.
- Fixed product getlist processor for MODX 2.3.
- Fixed sorting products in category grid by clicking on column header.
- Disabled Bootstrap icons for MODX 2.3.
- Fixed product gallery for MODX 2.3.
- Fixed issue with deleting product files children in MODX 2.3.
- Fixed "autocomplete_err_noquery" error in MODX 2.3.
- [#148] Fixed duplicate connector.
- Fixed work of "minishop2-combo-user" in MODX 2.3.

2.1.8 beta
==============
- Added field "name" in object msOrderProduct for storing pagetitle of the product.
- Fixed log level in PayPal method.
- Added integer field "type" to msOrder.
- Fixed CustomerProfile connection in schema.
- Improved price and weight formatting in orders table.
- Some UI improvements and fixes.

2.1.7 pl5
==============
- [#131] Fixed update of product thumb when you update thumbnails.
- [#129] [msGetOrder] Fixed setting of placeholders.
- Fixed work with comments on product panel.
- [msOrder] Now snippet loads "building", "room" and "comment" from extended field of users profile.
- [mgr] Fixed parameter "maxUploadSize" in gallery.

2.1.7 pl1
==============
- [#119] Improved compatibility with AjaxManager.
- [#118] Fixed negative cost in payment and delivery methods.
- [#113] Added Lithuanian lexicons.
- [#112] Restrict cart items to specific contexts.
- [#111] Fixed remove of products links.
- [#107] Fixed empty customer field if fullname is not specified.
- [#106] Additional check of friendly filename in gallery.
- New system setting "ms2_category_remember_grid".

2.1.6 pl4
==============
- [#110] Fix generate thumbs on upload for Amazon S3.
- Fixed counting money spent in new customers.
- [#104] Fixed placeholder [[+cart_weight]] in emails.
- [#102] Improved checking of thumbnails url.
- [#98] Refactored permissions in processors.
- [#94] Formatted placeholder [[+cost]] in snippet msCart
- [#78] Fixed setting flag isfolder to false for old category of the product.
- Fixed handling of non-ajax requests.
- Removed unnecessary ajax request on add to cart. Fixed possibly E_NOTICE.

2.1.5 pl
==============
- Improved rename of files in gallery.
- Added default media source in product "create" processor.
- Added default template in product "create" processor.
- Added buttons in orders management page.

2.1.4 pl5
==============
- Added script for import products in core/components/minishop2/import/csv.php.
- Fixed icons in chunks.
- [#95] Fixed price and weight format.
- Improved installator. Now you can update chunks on install.
- Fixed possible errors on thumbnail generation.
- Progressive thumbnails in gallery.

2.1.3 pl2
==============
- Support Bootstrap3.
- Fixed E_WARNING in snippet msOptions.
- Fixed bug with php-apc on create order.

2.1.2 pl2
==============
- Fixed possibly E_NOTICE in snippets.

2.1.2 pl
==============
- [#77] Fixed change type of existing resource to "msProduct".
- Added ability to hide tabs of product page in manager. See new system settings.
- Improved style of horizontal product tabs.
- Improved proportions in settings tab of category.
- Improved rename of product images.
- Improved retrieving of first thumbnail of image in gallery.
- If you specified wrong "ms2_product_thumbnail_size" parameter, gallery will still work.
- Added support of non-image files in gallery.
- Improved snippet "msGallery" for display non-image files.
- [#84] Fixed displaying of  email of vendor in manager.

2.1.1 pl2
==============
- Fixed parameter "&parents" in msProducts.

2.1.1 pl
==============
- Snippet msProducts supports pdoTools 1.8.0. Parameter "&showHidden" enabled by default.
- Fixed fatal error with "clearCache" when msProduct created trough processor and it`s parent is not msCategory.
- Improved generation of thumbnails.

2.1.1 pl
==============
- Fixed access permissions tab on product update.
- Fixed getPrice and getWeight calls in snippet msProducts.
- Improved xtype "minishop2-combo-user".
- Added support of component "msDiscount".
- Added counting of total spent sum by every customer in msCustomerProfile.

2.1.0 pl2
==============
- Fixed placeholders on msProduct page due to issues with @INLINE chunks.

2.1.0 pl1
==============
- Added new events: "msOnGetProductPrice" and "msOnGetProductWeight".
- Fixed wrong events in database from previous release.
- Changed "vendor_" to "vendor." in msProduct::toArray() for sameness with the snippet msProducts.
- Moved all logic from old action.php to new plugin. File leaved for compatibility with users modified javascript.

2.1.0 pl
==============
- Changed default sort in goods grid on "menuindex, ASC".
- Improved method msDelivery::getCost().
- Added method msPayment::getCost().
- Improved method msOrderHandler::getCost(). Now you can specify additional percent for delivery and payment in manager.
- New object "msCustomerProfile". It can be extended by plugins like "msProductData".
- Plugin "miniShop2" can automatic save referrers.
- In snippet "msProducts" you can override "where", "select", "leftJoin", "innerJoin" and "rightJoin" properties. Added pdoFetch 1.4.1 support.
- Improved other snippets.
- Added new fields in "msProductFile": "hash" for sha1 of file and json field "properties".
- Changed uploader in product gallery to "Plupload" (Thanks to Alex Rahimov).
- Added check for duplicate images in product gallery by checking hash of the content of file.
- Added new parameters for media source: "maxUploadWidth" and "maxUploadHeight" for frontend image resize.
- Gallery upload processor now can receive parameters "id" and "file" for external images upload.
- Added renaming files of product gallery together with thumbnails.
- [#77] Fixed changing type of existing resource to "msCategory".
- [#76] Fixed parameter "offset" in msGallery.
- [#75] Remove multi-category links when category removed.
- [#74] Refresh data in order from users profile if he is authenticated.
- [#73] Added virtual vendor fields. You can get it by $res->get(\'vendor_name\');
- [#66] Fixed saving payments methods when create a new delivery.
- [#65] Added new system events: "msOnBeforeValidateOrderValue" and "msOnValidateOrderValue".
- [#64] Added ability to stop switching order status from system plugin.
- [#63] Added new parameters for media source: "imageNameType". Switching to "friendly" will generate names for uploaded files by FURLs algorithm.
- [#61] Added ability to sort products in category by drag and drop.
- [#62] Fixed work with "*.gif" files in products gallery.
- [#59] Improved regular expression for email verification.
- [#59] Improved validation of customer name and email when create order.
- [#59] msOrderHandler::add() now can return an error.
- [#59] Improved registration of javascript on frontend.
- [#59] Improved show\\hide of msMiniCart with css.
- [#59] Refactored default frontend javascript.
- [#59] Works with no javascript. (Thanks to Alexey Kartashov)
- [#58] Fixed PayPal non-USD currency.
- [#56] Added JSON field "properties" to "msProductFile".
- [#52] Added ability to customize orders in manager by 3 system setting: "ms2_order_grid_fields", "ms2_order_address_fields" and "ms2_order_product_fields".
- [#50] Fixed checking of the existence of the Tickets component.
- [#5] Possible fixed "Cannot execute queries while other unbuffered queries are active" on php < 5.3.
- Some fixes for MySql STRICT_TRANS_TABLES mode.
- Updated jQuery to version 1.10.2
- Added method PayPal::getPaymentLink() for continuing interrupted payment process. You will see [[+payment_link]] in emails.
- Added parameters "&tplSingle" and "&toSeparatePlaceholders" to snippet msGallery.
- Gallery UI improvements for MODX 2.2.9
- Returned action.php for backward compatibility with the old javascript

2.0.1 pl3
==============
- Added german lexicon.
- Now you can specify version of file in "ms2_frontend_js".
- [#60] Fixed type of field "index" in "msOrder".
- Improved listing of products in the categories of manager.

2.0.1 pl2
==============
- Improved submit of order form.
- msProducts saves order of ids received through &resources=``. It need for smooth work with mSearch2.
- [mgr] Fixed search in vendors combo

2.0.1 pl1
==============
- Added loading of lexicons for 3rd party payment methods. They must be named in "msp.%name%.inc.php" format.
- Added placeholder [[+payment_link]] in the new user email. It will work only if payment method has function getPaymentLink(msOrder $order);
- Removed placeholder [[+id]] from product page because of issues.
- [#53] Completely refactored call and processing plugin events.
- [#45] Added system setting for specify default content of category.

2.0.1 pl
==============
- Added 2 new events on order remove: "msOnBeforeRemoveOrder" and "msOnRemoveOrder".
- Improved classes: "msProduct" and "msCategory". Now $modx->getCollection(\'msProduct\'); returns only products.

2.0.1 beta3
==============
- Fixed msGallery

2.0.1 beta2
==============
- [#44] Enabled duplicate of category.
- [#42] Added parameter "returnIds" to snippet msProducts.
- [#41] Fixed panel with tvs on product create.
- Parameter "resources" not suppressing "parents" in msProducts anymore. Now they working together: resources that are not in parents will not be returned.
- Snippet msGallery now can to display placeholders like [[+600x]] or [[+x600]].
- Fixed display an original image in msGallery. If upgrade, replace placeholders [[+image]] to [[+url]] in chunk "tpl.msGallery.row" manually.
- Added setting placeholder [[+idx]] to snippets msGallery and msProducts.
- Added parameter "where" in snippet msGallery, for specify JSON encoded string with additional query data.
- Added parameters "limit" and "offset" for pagination. msGallery can be used with getPage now.

2.0.1 beta1
==============
- Maybe fixed bug with php-apc and sessions
- Fixed plugin params on events "msOnBeforeCreateOrder" and "msOnCreateOrder". Now you can change $msOrder by link.
- Fixed error with no changing status of order in manager.

2.0.1 beta
==============
- [#38] Added "menuindex" in product fields.
- [#37] Ability to override method miniShop2::changeOrderStatus() in custom order class.
- [#36] Removed filter_var(), because of issues on stupid hostings.
- [#35] Added 2 system setting to enable or disable the remembering of panel tabs.
- [#32] Enabled displaying of errors when uploading files in product gallery.
- [#30] "miniShopManagerPolicy" is automatically assigned to a group "Administrators".
- [#29] Added verification of object instance, when loading neighborhood resources in manager.
- [#28] Returned the lost fields in images of msGallery.
- [#27] Improved ajax requests in default javascript.
- [#26] Improvements of categories tree.
- [#25] Removed replacing of empty alias to id. Added 2 system setting for switching using resource id as alias for categories and products.
- Fixed quick fields in snippet msOrder. Update your chunks for delivery and payment methods.
- Improved "totalVar" placeholder in snippet msGallery.
- Fixed model. Added proper primary keys for xPDOObjects.
- Ability to load only "miniShop2Config" object on frontend, without default javascript and jQuery.
- Fixed parameter "depth" in snippet "msProducts".
- New permissions for work with order: "save" and "view". New events for update order.
- Added ability to add\\update\\remove products in order.

2.0.0 pl3
==============
- Compatibility with pdoTools 1.2.0

2.0.0 pl2
==============
- [mgr] Fixed formatting of dates in category grid.
- [mgr] Fixed decimals in product category grid.
- Added ability to create system setting "ms2_cart_max_count" to override maximum number of products for one operation.
- Fixed placeholders in emails subjects.
- Fixed generation of thumbnails in gallery for working with ImageMagick.
- Fixed link type "Many to many".
- Fixed requirement of non-existing permission "update_document" in processors.
- Added system setting "ms2_price_snippet" for modification of product price.
- Added system setting "ms2_weight_snippet" for modification of product weight.
- Product key in msCartHandler now generates with using "$price" and "$weight", because they can be modified when adding to cart.

2.0.0 pl1
==============
- [mgr] Changing of product image now cleans its cache.
- [mgr] New icons in tree
- Small improvements of the snippets at initialization.
- Added selection of product links in snippet msProducts. See the new snippet properties.
- Added ability to use msProducts with any modResource class.
- Added property "tvPrefix" to msProducts for compatibility with getResources.
- Added property "outputSeparator" to snippets msOptions and msProducts.
- Added system parameter "ms2_price_format" for specifying how to format price of product.
- Added system parameter "ms2_price_format_no_zeros" for optional removing extra zeros at the end of price.
- Added system parameter "ms2_weight_format" for specifying how to format weight of product.
- Added system parameter "ms2_weight_format_no_zeros" for optional removing extra zeros at the end of weight.

2.0.0 rc6
==============
- Fixed cleaning pdoTools in msGallery
- Improved saving payment method in order when quickly switch delivery.

2.0.0 rc5
==============
- Integration of PayPal express-checkout payment method.

2.0.0 rc4
==============
- Fixed bugs in snippets
- Fixed joining images by rank when includeThumbs.

2.0.0 rc
==============
- [mgr] Added displaying of nested products in categories. System setting "ms2_category_show_nested_products" can disable it.
- [mgr] Added the ability to link products together.
- [mgr] Added link to resource from ordered products.
- [mgr] Added ability to specify web document for Vendor by property "resource".
- [#6] Fixed error when order makes authenticated user without email.
- [#8] Fixed remove of order.
- [#9] Fixed date formatting in manager for working in Firefox.
- [#10] Added checking for negative value of adding products in cart.
- [#12] Added regeneration site maps after new product create.
- [#14] Added check of "register_globals" on cart/add.
- Added system setting "ms2_product_thumbnail_size" for setting default size of product thumbnail.
- Added vendor placeholders on product page. Now you can use [[+vendor.name]], [[+vendor.logo]] etc.
- Added beta scripts for console converting miniShop1 to miniShop2.
- Added partial french translation.
- Added method miniShop2::getTagged() from MS1.
- Added ability to load plugins, that can add new or overload existing product fields in model and manager.
- Added parameters for joining thumbnails and tvs in snippets msProducts, msCart and msGetOrder.
- Improved save of product options.
- Fixed automatic install of pdoTools.
- Fixed fetching images in snippet msGallery
- Other fixes and improvements.

2.0.0 beta-1
==============
- Added manager pages
- Added create and manage orders

2.0.0 beta-0
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
miniShop2
--------------------
Author: Vasiliy Naumkin <bezumkin@yandex.ru>
--------------------

Feel free to suggest ideas/improvements/bugs on GitHub:
http://github.com/bezumkin/miniShop2/issues',
    'chunks' => 
    array (
      'msProduct.content' => '<h1>[[*pagetitle]]</h1>
<div id="msProduct" class="row">
    <div class="col-md-6">
        [[!msGallery]]
    </div>
    <div class="col-md-6">
        <form class="form-horizontal ms2_form" method="post">
            <input type="hidden" name="id" value="[[*id]]"/>
            <div class="form-group">
                <label class="col-md-2 control-label">[[%ms2_product_article]]:</label>
                <div class="col-md-10 form-control-static">
                    [[+article:default=`-`]]
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">[[%ms2_product_price]]:</label>
                <div class="col-md-10 form-control-static">
                    [[+price]] [[%ms2_frontend_currency]]
                    [[+old_price:gt=`0`:then=`
                    <span class="old_price">[[+old_price]] [[%ms2_frontend_currency]]</span>
                    `:else=``]]
                </div>
            </div>
            <div class="form-group form-inline">
                <label class="col-md-2 control-label" for="product_price">[[%ms2_cart_count]]:</label>
                <div class="col-md-10">
                    <input type="number" name="count" id="product_price" class="input-sm form-control" value="1"/>
                    [[%ms2_frontend_count_unit]]
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">[[%ms2_product_weight]]:</label>
                <div class="col-md-10 form-control-static">
                    [[+weight]] [[%ms2_frontend_weight_unit]]
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">[[%ms2_product_made_in]]:</label>
                <div class="col-md-10 form-control-static">
                    [[+made_in:default=`-`]]
                </div>
            </div>

            [[msOptions?options=`color,size`]]

            [[msProductOptions]]

            <div class="form-group">
                <div class="col-md-offset-2 col-md-10">
                    <button type="submit" class="btn btn-default" name="ms2_action" value="cart/add">
                        <i class="glyphicon glyphicon-barcode"></i> [[%ms2_frontend_add_to_cart]]
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
[[*content]]',
      'tpl.msCart' => '<div id="msCart">
    {if !count($products)}
        {\'ms2_cart_is_empty\' | lexicon}
    {else}
        <div class="table-responsive">
            <table class="table table-striped">
                <tr class="header">
                    <th class="image">&nbsp;</th>
                    <th class="title">{\'ms2_cart_title\' | lexicon}</th>
                    <th class="count">{\'ms2_cart_count\' | lexicon}</th>
                    <th class="weight">{\'ms2_cart_weight\' | lexicon}</th>
                    <th class="price">{\'ms2_cart_price\' | lexicon}</th>
                    <th class="remove">{\'ms2_cart_remove\' | lexicon}</th>
                </tr>

                {foreach $products as $product}
                    <tr id="{$product.key}">
                        <td class="image">
                            {if $product.thumb?}
                                <img src="{$product.thumb}" alt="{$product.pagetitle}" title="{$product.pagetitle}"/>
                            {else}
                                <img src="{\'assets_url\' | option}components/minishop2/img/web/ms2_small.png"
                                     srcset="{\'assets_url\' | option}components/minishop2/img/web/ms2_small@2x.png 2x"
                                     alt="{$product.pagetitle}" title="{$product.pagetitle}"/>
                            {/if}
                        </td>
                        <td class="title">
                            {if $product.id?}
                                <a href="{$product.id | url}">{$product.pagetitle}</a>
                            {else}
                                {$product.name}
                            {/if}
                            {if $product.options?}
                                <div class="small">
                                    {$product.options | join : \'; \'}
                                </div>
                            {/if}
                        </td>
                        <td class="count">
                            <form method="post" class="ms2_form form-inline" role="form">
                                <input type="hidden" name="key" value="{$product.key}"/>
                                <div class="form-group">
                                    <input type="number" name="count" value="{$product.count}"
                                           class="input-sm form-control"/>
                                    <span class="hidden-xs">{\'ms2_frontend_count_unit\' | lexicon}</span>
                                    <button class="btn btn-default" type="submit" name="ms2_action" value="cart/change">
                                        <i class="glyphicon glyphicon-refresh"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="weight">
                            <span>{$product.weight}</span> {\'ms2_frontend_weight_unit\' | lexicon}
                        </td>
                        <td class="price">
                            <span>{$product.price}</span> {\'ms2_frontend_currency\' | lexicon}
                            {if $product.old_price?}
                            <span class="old_price">{$product.old_price}</span> {\'ms2_frontend_currency\' | lexicon}
                                {/if}
                        </td>
                        <td class="remove">
                            <form method="post" class="ms2_form">
                                <input type="hidden" name="key" value="{$product.key}">
                                <button class="btn btn-default" type="submit" name="ms2_action" value="cart/remove">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                {/foreach}

                <tr class="footer">
                    <th class="total" colspan="2">{\'ms2_cart_total\' | lexicon}:</th>
                    <th class="total_count">
                        <span class="ms2_total_count">{$total.count}</span>
                        {\'ms2_frontend_count_unit\' | lexicon}
                    </th>
                    <th class="total_weight">
                        <span class="ms2_total_weight">{$total.weight}</span>
                        {\'ms2_frontend_weight_unit\' | lexicon}
                    </th>
                    <th class="total_cost">
                        <span class="ms2_total_cost">{$total.cost}</span>
                        {\'ms2_frontend_currency\' | lexicon}
                    </th>
                    <th>&nbsp;</th>
                </tr>
            </table>
        </div>
        <form method="post">
            <button class="btn btn-default" type="submit" name="ms2_action" value="cart/clean">
                <i class="glyphicon glyphicon-remove"></i> {\'ms2_cart_clean\' | lexicon}
            </button>
        </form>
    {/if}
</div>
',
      'tpl.msEmail' => '{var $style = [
\'logo\' => \'display:block;margin: auto;\',
\'a\' => \'color:#348eda;\',
\'p\' => \'font-family: Arial;color: #666666;font-size: 12px;\',
\'h\' => \'font-family:Arial;color: #111111;font-weight: 200;line-height: 1.2em;margin: 40px 20px;\',
\'h1\' => \'font-size: 36px;\',
\'h2\' => \'font-size: 28px;\',
\'h3\' => \'font-size: 22px;\',
\'th\' => \'font-family: Arial;text-align: left;color: #111111;\',
\'td\' => \'font-family: Arial;text-align: left;color: #111111;\',
]}

{var $site_url = (\'site_url\' | option) | preg_replace : \'#/$#\' : \'\'}
{var $assets_url = \'assets_url\' | option}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{\'site_name\' | option}</title>
</head>
<body style="margin:0;padding:0;background:#f6f6f6;">
<div style="height:100%;padding-top:20px;background:#f6f6f6;">
    {block \'logo\'}
        <a href="{$site_url}">
            <img style="{$style.logo}"
                 src="{$site_url}{$assets_url}components/minishop2/img/web/ms2_small@2x.png"
                 alt="{$site_url}"
                 width="120" height="90"/>
        </a>
    {/block}
    <!-- body -->
    <table class="body-wrap" style="padding:0 20px 20px 20px;width: 100%;background:#f6f6f6;margin-top:10px;">
        <tr>
            <td></td>
            <td class="container" style="border:1px solid #f0f0f0;background:#ffffff;width:800px;margin:auto;">
                <div class="content">
                    <table style="width:100%;">
                        <tr>
                            <td>
                                <h3 style="{$style.h}{$style.h3}">
                                    {block \'title\'}
                                        miniShop2
                                    {/block}
                                </h3>

                                {block \'products\'}
                                    <table style="width:90%;margin:auto;">
                                        <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th style="{$style.th}">{\'ms2_cart_title\' | lexicon}</th>
                                            <th style="{$style.th}">{\'ms2_cart_count\' | lexicon}</th>
                                            <th style="{$style.th}">{\'ms2_cart_weight\' | lexicon}</th>
                                            <th style="{$style.th}">{\'ms2_cart_cost\' | lexicon}</th>
                                        </tr>
                                        </thead>
                                        {foreach $products as $product}
                                            <tr>
                                                <td style="{$style.th}">
                                                    {if $product.thumb?}
                                                        <img src="{$site_url}{$product.thumb}"
                                                             alt="{$product.pagetitle}"
                                                             title="{$product.pagetitle}"
                                                             width="120" height="90"/>
                                                    {else}
                                                        <img src="{$site_url}{$assets_url}components/minishop2/img/web/ms2_small@2x.png"
                                                             alt="{$product.pagetitle}"
                                                             title="{$product.pagetitle}"
                                                             width="120" height="90"/>
                                                    {/if}
                                                </td>
                                                <td style="{$style.th}">
                                                    {if $product.id?}
                                                        <a href="{$product.id | url : [\'scheme\' => \'full\']}"
                                                           style="{$style.a}">
                                                            {$product.name}
                                                        </a>
                                                    {else}
                                                        {$product.name}
                                                    {/if}
                                                    {if $product.options?}
                                                        <div class="small">
                                                            {$product.options | join : \'; \'}
                                                        </div>
                                                    {/if}
                                                </td>
                                                <td style="{$style.th}">{$product.count} {\'ms2_frontend_count_unit\' | lexicon}</td>
                                                <td style="{$style.th}">{$product.weight} {\'ms2_frontend_weight_unit\' | lexicon}</td>
                                                <td style="{$style.th}">{$product.price} {\'ms2_frontend_currency\' | lexicon}</td>
                                            </tr>
                                        {/foreach}
                                        <tfoot>
                                        <tr>
                                            <th colspan="2"></th>
                                            <th style="{$style.th}">
                                                {$total.cart_count} {\'ms2_frontend_count_unit\' | lexicon}
                                            </th>
                                            <th style="{$style.th}">
                                                {$total.cart_weight} {\'ms2_frontend_weight_unit\' | lexicon}
                                            </th>
                                            <th style="{$style.th}">
                                                {$total.cart_cost} {\'ms2_frontend_currency\' | lexicon}
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <h3 style="{$style.h}{$style.h3}">
                                        {\'ms2_frontend_order_cost\' | lexicon}:
                                        {if $total.delivery_cost}
                                            {$total.cart_cost} {\'ms2_frontend_currency\' | lexicon} + {$total.delivery_cost}
                                            {\'ms2_frontend_currency\' | lexicon} =
                                        {/if}
                                        <strong>{$total.cost}</strong> {\'ms2_frontend_currency\' | lexicon}
                                    </h3>
                                {/block}
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /content -->
            </td>
            <td></td>
        </tr>
    </table>
    <!-- /body -->
    <!-- footer -->
    <table style="clear:both !important;width: 100%;">
        <tr>
            <td></td>
            <td class="container">
                <!-- content -->
                <div class="content">
                    <table style="width:100%;text-align: center;">
                        <tr>
                            <td align="center">
                                <p style="{$style.p}">
                                    {block \'footer\'}
                                    <a href="{$site_url}" style="color: #999999;">
                                        {\'site_name\' | option}
                                    </a>
                                    {/block}
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /content -->
            </td>
            <td></td>
        </tr>
    </table>
    <!-- /footer -->
</div>
</body>
</html>',
      'tpl.msEmail.cancelled.user' => '{extends \'tpl.msEmail\'}

{block \'title\'}
    {\'ms2_email_subject_cancelled_user\' | lexicon : $order}
{/block}',
      'tpl.msEmail.new.manager' => '{extends \'tpl.msEmail\'}

{block \'title\'}
    {\'ms2_email_subject_new_manager\' | lexicon : $order}
{/block}',
      'tpl.msEmail.new.user' => '{extends \'tpl.msEmail\'}

{block \'title\'}
    {\'ms2_email_subject_new_user\' | lexicon : $order}
{/block}

{block \'products\'}
    {parent}
    {if $payment_link?}
        <p style="margin-left:20px;{$style.p}">
            {\'ms2_payment_link\' | lexicon : [\'link\' => $payment_link]}
        </p>
    {/if}
{/block}',
      'tpl.msEmail.paid.manager' => '{extends \'tpl.msEmail\'}

{block \'title\'}
    {\'ms2_email_subject_paid_manager\' | lexicon : $order}
{/block}',
      'tpl.msEmail.paid.user' => '{extends \'tpl.msEmail\'}

{block \'title\'}
    {\'ms2_email_subject_paid_user\' | lexicon : $order}
{/block}',
      'tpl.msEmail.sent.user' => '{extends \'tpl.msEmail\'}

{block \'title\'}
    {\'ms2_email_subject_sent_user\' | lexicon : $order}
{/block}',
      'tpl.msGallery' => '<div id="msGallery">
    {if $files?}
        <div class="fotorama"
             data-nav="thumbs"
             data-thumbheight="45"
             data-allowfullscreen="true"
             data-swipe="true"
             data-autoplay="5000">
            {foreach $files as $file}
                <a href="{$file[\'url\']}" target="_blank">
                    <img src="{$file[\'small\']}" alt="" title="">
                </a>
            {/foreach}
        </div>
    {else}
        <img src="{(\'assets_url\' | option) ~ \'components/minishop2/img/web/ms2_medium.png\'}"
             srcset="{(\'assets_url\' | option) ~ \'components/minishop2/img/web/ms2_medium@2x.png\'} 2x"
             alt="" title=""/>
    {/if}
</div>

',
      'tpl.msGetOrder' => '<div id="msCart">
    <div class="table-responsive">
        <table class="table table-striped">
            <tr class="header">
                <th class="image col-md-2">&nbsp;</th>
                <th class="title col-md-4">{\'ms2_cart_title\' | lexicon}</th>
                <th class="count col-md-2">{\'ms2_cart_count\' | lexicon}</th>
                <th class="weight col-md-1">{\'ms2_cart_weight\' | lexicon}</th>
                <th class="price col-md-1">{\'ms2_cart_cost\' | lexicon}</th>
            </tr>
            {foreach $products as $product}
                <tr>
                    <td class="image">
                        {if $product.thumb?}
                            <img src="{$product.thumb}" alt="{$product.pagetitle}" title="{$product.pagetitle}"/>
                        {else}
                            <img src="{\'assets_url\' | option}components/minishop2/img/web/ms2_small.png"
                                 srcset="{\'assets_url\' | option}components/minishop2/img/web/ms2_small@2x.png 2x"
                                 alt="{$product.pagetitle}" title="{$product.pagetitle}"/>
                        {/if}
                    </td>
                    <td class="title">
                        {if $product.id?}
                            <a href="{$product.id | url}">{$product.name}</a>
                        {else}
                            {$product.name}
                        {/if}
                        {if $product.options?}
                            <div class="small">
                                {$product.options | join : \'; \'}
                            </div>
                        {/if}
                    </td>
                    <td class="count">{$product.count} {\'ms2_frontend_count_unit\' | lexicon}</td>
                    <td class="weight">{$product.weight} {\'ms2_frontend_weight_unit\' | lexicon}</td>
                    <td class="price">{$product.price} {\'ms2_frontend_currency\' | lexicon}</td>
                </tr>
            {/foreach}
            <tr class="footer">
                <th class="total" colspan="2">{\'ms2_cart_total\' | lexicon}:</th>
                <th class="total_count">
                    <span class="ms2_total_count">{$total.cart_count}</span> {\'ms2_frontend_count_unit\' | lexicon}
                </th>
                <th class="total_weight">
                    <span class="ms2_total_weight">{$total.cart_weight}</span> {\'ms2_frontend_weight_unit\' | lexicon}
                </th>
                <th class="total_cost">
                    <span class="ms2_total_cost">{$total.cart_cost}</span> {\'ms2_frontend_currency\' | lexicon}
                </th>
            </tr>
        </table>
    </div>

    <h4>
        {\'ms2_frontend_order_cost\' | lexicon}:
        {if $total.delivery_cost}
            {$total.cart_cost} {\'ms2_frontend_currency\' | lexicon} + {$total.delivery_cost}
            {\'ms2_frontend_currency\' | lexicon} =
        {/if}
        <strong>{$total.cost}</strong> {\'ms2_frontend_currency\' | lexicon}
    </h4>
</div>
',
      'tpl.msMiniCart' => '<div id="msMiniCart" class="{$total_count > 0 ? \'full\' : \'\'}">
    <div class="empty">
        <h5><i class="glyphicon glyphicon-shopping-cart"></i> {\'ms2_minicart\' | lexicon}</h5>
        {\'ms2_minicart_is_empty\' | lexicon}
    </div>
    <div class="not_empty">
        <h5><i class="glyphicon glyphicon-shopping-cart"></i> {\'ms2_minicart\' | lexicon}</h5>
        {\'ms2_minicart_goods\' | lexicon} <strong class="ms2_total_count">{$total_count}</strong> {\'ms2_frontend_count_unit\' | lexicon},
        {\'ms2_minicart_cost\' | lexicon} <strong class="ms2_total_cost">{$total_cost}</strong> {\'ms2_frontend_currency\' | lexicon}
    </div>
</div>',
      'tpl.msOptions' => '{foreach $options as $name => $values}
    <div class="form-group">
        <label class="col-md-2 control-label" for="option_{$name}">{(\'ms2_product_\' ~ $name) | lexicon}:</label>
        <div class="col-md-10">
            <select name="options[{$name}]" class="input-sm form-control" id="option_{$name}">
                {foreach $values as $value}
                    <option value="{$value}">{$value}</option>
                {/foreach}
            </select>
        </div>
    </div>
{/foreach}',
      'tpl.msOrder' => '<form class="form-horizontal ms2_form" id="msOrder" method="post">
    <div class="row">
        <div class="col-md-6">
            <h4>{\'ms2_frontend_credentials\' | lexicon}:</h4>
            {foreach [\'email\',\'receiver\',\'phone\'] as $field}
                <div class="form-group input-parent">
                    <label class="col-md-4 control-label" for="{$field}">
                        <span class="required-star">*</span> {(\'ms2_frontend_\' ~ $field) | lexicon}
                    </label>
                    <div class="col-sm-6">
                        <input type="text" id="{$field}" placeholder="{(\'ms2_frontend_\' ~ $field) | lexicon}"
                               name="{$field}" value="{$form[$field]}"
                               class="form-control{($field in list $errors) ? \' error\' : \'\'}">
                    </div>
                </div>
            {/foreach}

            <div class="form-group input-parent">
                <label class="col-md-4 control-label" for="comment">
                    <span class="required-star">*</span> {\'ms2_frontend_comment\' | lexicon}</label>
                <div class="col-sm-6">
                    <textarea name="comment" id="comment" placeholder="{\'ms2_frontend_comment\' | lexicon}"
                              class="form-control{(\'comment\' in list $errors) ? \' error\' : \'\'}">{$form.comment}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="payments">
            <h4>{\'ms2_frontend_payments\' | lexicon}:</h4>
            <div class="form-group">
                <label class="col-md-4 control-label"><span class="required-star">*</span>
                    {\'ms2_frontend_payment_select\' | lexicon}</label>
                <div class="col-sm-6">
                    {foreach $payments as $payment index=$index}
                        {var $checked = !$order.payment && $index == 0 || $payment.id == $order.payment}
                        <div class="checkbox">
                            <label class="payment input-parent">
                                <input type="radio" name="payment" value="{$payment.id}" id="payment_{$payment.id}"
                                        {$checked ? \'checked\' : \'\'}>
                                {if $payment.logo?}
                                    <img src="{$payment.logo}" alt="{$payment.name}" title="{$payment.name}"/>
                                {else}
                                    {$payment.name}
                                {/if}
                                {if $payment.description?}
                                    <p class="small">
                                        {$payment.description}
                                    </p>
                                {/if}
                            </label>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6" id="deliveries">
            <h4>{\'ms2_frontend_deliveries\' | lexicon}:</h4>
            <div class="form-group">
                <label class="col-md-4 control-label">
                    <span class="required-star">*</span> {\'ms2_frontend_delivery_select\' | lexicon}
                </label>
                <div class="col-sm-6">
                    {foreach $deliveries as $delivery index=$index}
                        {var $checked = !$order.delivery && $index == 0 || $delivery.id == $order.delivery}
                        <div class="checkbox">
                            <label class="delivery input-parent">
                                <input type="radio" name="delivery" value="{$delivery.id}" id="delivery_{$delivery.id}"
                                       data-payments="{$delivery.payments | json_encode}"
                                        {$checked ? \'checked\' : \'\'}>
                                {if $delivery.logo?}
                                    <img src="{$delivery.logo}" alt="{$delivery.name}" title="{$delivery.name}"/>
                                {else}
                                    {$delivery.name}
                                {/if}
                                {if $delivery.description?}
                                    <p class="small">
                                        {$delivery.description}
                                    </p>
                                {/if}
                            </label>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h4>{\'ms2_frontend_address\' | lexicon}:</h4>
            {foreach [\'index\',\'region\',\'city\'] as $field}
                <div class="form-group input-parent">
                    <label class="col-md-4 control-label" for="{$field}">
                        <span class="required-star">*</span> {(\'ms2_frontend_\' ~ $field) | lexicon}
                    </label>
                    <div class="col-sm-6">
                        <input type="text" id="{$field}" placeholder="{(\'ms2_frontend_\' ~ $field) | lexicon}"
                               name="{$field}" value="{$form[$field]}"
                               class="form-control{($field in list $errors) ? \' error\' : \'\'}">
                    </div>
                </div>
            {/foreach}
            <div class="form-group input-parent">
                <label class="col-md-4 control-label" for="street">
                    <span class="required-star">*</span> {\'ms2_frontend_street\' | lexicon}</label>
                <div class="col-md-6 row">
                    {foreach [\'street\',\'building\',\'room\'] as $field}
                        <div class="col-md-4">
                            <input type="text" id="{$field}" placeholder="{(\'ms2_frontend_\' ~ $field) | lexicon}"
                                   name="{$field}" value="{$form[$field]}"
                                   class="form-control{($field in list $errors) ? \' error\' : \'\'}">
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>

    </div>

    <button type="button" name="ms2_action" value="order/clean" class="btn btn-default ms2_link">
        <i class="glyphicon glyphicon-remove"></i> {\'ms2_frontend_order_cancel\' | lexicon}
    </button>

    <hr/>
    <div class="well">
        <div class="col-md-offset-2">
            <h3>{\'ms2_frontend_order_cost\' | lexicon}:
                <span id="ms2_order_cost">{$order.cost ?: 0}</span>
                {\'ms2_frontend_currency\' | lexicon}
            </h3>
            <button type="submit" name="ms2_action" value="order/submit" class="btn btn-default btn-primary ms2_link">
                {\'ms2_frontend_order_submit\' | lexicon}
            </button>
        </div>
    </div>
</form>',
      'tpl.msProductOptions' => '{foreach $options as $option}
    <div class="form-group">
        <label class="col-md-2 control-label">{$option.caption}:</label>
        <div class="col-md-10 form-control-static">
            {if $option.value is array}
                {$option.value | join : \', \'}
            {else}
                {$option.value}
            {/if}
        </div>
    </div>
{/foreach}
',
      'tpl.msProducts.row' => '<div class="row ms2_product">
    <div class="col-md-2">
        {if $thumb?}
            <img src="{$thumb}" alt="{$pagetitle}" title="{$pagetitle}"/>
        {else}
            <img src="{\'assets_url\' | option}components/minishop2/img/web/ms2_small.png"
                 srcset="{\'assets_url\' | option}components/minishop2/img/web/ms2_small@2x.png 2x"
                 alt="{$pagetitle}" title="{$pagetitle}"/>
        {/if}
    </div>
    <div class="col-md-10">
        <form method="post" class="ms2_form">
            <a href="{$id | url}">{$pagetitle}</a>
            <span class="flags">
                {if $new?}
                    <i class="glyphicon glyphicon-flag" title="{\'ms2_frontend_new\' | lexicon}"></i>
                {/if}
                {if $popular?}
                    <i class="glyphicon glyphicon-star" title="{\'ms2_frontend_popular\' | lexicon}"></i>
                {/if}
                {if $favorite?}
                    <i class="glyphicon glyphicon-bookmark" title="{\'ms2_frontend_favorite\' | lexicon}"></i>
                {/if}
            </span>
            <span class="price">
                {$price} {\'ms2_frontend_currency\' | lexicon}
            </span>
            {if $old_price?}
                <span class="old_price">{$old_price} {\'ms2_frontend_currency\' | lexicon}</span>
            {/if}
            <button class="btn btn-default pull-right" type="submit" name="ms2_action" value="cart/add">
                <i class="glyphicon glyphicon-barcode"></i> {\'ms2_frontend_add_to_cart\' | lexicon}
            </button>
            <input type="hidden" name="id" value="{$id}">
            <input type="hidden" name="count" value="1">
            <input type="hidden" name="options" value="[]">
        </form>
        {if $introtext}
            <p>
                <small>{$introtext}</small>
            </p>
        {/if}
    </div>
</div>',
    ),
    'setup-options' => 'minishop2-2.4.12-pl/setup-options.php',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '102b0af7017cd9f89d415f384641e3b2',
      'native_key' => 'minishop2',
      'filename' => 'modNamespace/d1ac2d2d2dd3d08d769b2a86842c678d.vehicle',
      'namespace' => 'minishop2',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2b0edba4f4786e488a9567c001d6c376',
      'native_key' => 'mgr_tree_icon_mscategory',
      'filename' => 'modSystemSetting/518285dd82aee4f27e8dad7fd82d678e.vehicle',
      'namespace' => 'minishop2',
    ),
    2 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5408f8bcf31f8d190156491daad9ed4c',
      'native_key' => 'mgr_tree_icon_msproduct',
      'filename' => 'modSystemSetting/0f1480bb40d990cc03816313b73839fd.vehicle',
      'namespace' => 'minishop2',
    ),
    3 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5d0d7a6f88d6c2a18abe7a567b796288',
      'native_key' => 'ms2_services',
      'filename' => 'modSystemSetting/1d03ebe0d21f9cef99c72684beb2e469.vehicle',
      'namespace' => 'minishop2',
    ),
    4 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b9f54a6f8e2ce79f5f8f1713a25766db',
      'native_key' => 'ms2_plugins',
      'filename' => 'modSystemSetting/5c70f4a765b9913385b84837ccae1491.vehicle',
      'namespace' => 'minishop2',
    ),
    5 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '8ba964e7f01c5f03597022315120bef9',
      'native_key' => 'ms2_category_grid_fields',
      'filename' => 'modSystemSetting/082d4e29a7a0f752b6ab464c6f3fb05e.vehicle',
      'namespace' => 'minishop2',
    ),
    6 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'fedf6c3674226cd19c331c3aebf51e5d',
      'native_key' => 'ms2_category_show_nested_products',
      'filename' => 'modSystemSetting/a8e4cc3465a34a155d688a96a13d9c12.vehicle',
      'namespace' => 'minishop2',
    ),
    7 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'eb42c913f69269d669062e5f2761a59d',
      'native_key' => 'ms2_category_show_comments',
      'filename' => 'modSystemSetting/e3ec064a2529b0c3dd848dff4d8f0828.vehicle',
      'namespace' => 'minishop2',
    ),
    8 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b63fd519c68d2dee3fd441a4773bb2b9',
      'native_key' => 'ms2_category_show_options',
      'filename' => 'modSystemSetting/5b2a7f268fce16dc53e090a17f381d51.vehicle',
      'namespace' => 'minishop2',
    ),
    9 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '85209d7f125df47acfc59b808fbfdeaa',
      'native_key' => 'ms2_category_remember_tabs',
      'filename' => 'modSystemSetting/801841b3ba05f0b6e18af723c4abca9a.vehicle',
      'namespace' => 'minishop2',
    ),
    10 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'c83511a3af32f4a2137470cd60bf0219',
      'native_key' => 'ms2_category_id_as_alias',
      'filename' => 'modSystemSetting/140c47dfb4e68ee25ebd12ae756792d4.vehicle',
      'namespace' => 'minishop2',
    ),
    11 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '630390559d16e4d6b27fea43b53f77cd',
      'native_key' => 'ms2_category_content_default',
      'filename' => 'modSystemSetting/e1931ea0e2e06d22076a1b8807576cd4.vehicle',
      'namespace' => 'minishop2',
    ),
    12 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '8180adbd21fe17319588abaa4532f871',
      'native_key' => 'ms2_template_category_default',
      'filename' => 'modSystemSetting/ff18f7368dbd457885dedd55742d6c43.vehicle',
      'namespace' => 'minishop2',
    ),
    13 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f4377a00591ee09a88b10747b707247b',
      'native_key' => 'ms2_product_extra_fields',
      'filename' => 'modSystemSetting/d5b78fea4a037ee713162e54a357381a.vehicle',
      'namespace' => 'minishop2',
    ),
    14 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6af194be51950376dddf1eba30490735',
      'native_key' => 'ms2_product_show_comments',
      'filename' => 'modSystemSetting/56b94f3520631d7243a835aa9602a939.vehicle',
      'namespace' => 'minishop2',
    ),
    15 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '45eaae624ed78392b8e0c505f5503001',
      'native_key' => 'ms2_template_product_default',
      'filename' => 'modSystemSetting/1a0d697367367bd52bbd6dd6ca4e1170.vehicle',
      'namespace' => 'minishop2',
    ),
    16 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '8bc983a97006564cb645c64672f96f35',
      'native_key' => 'ms2_product_show_in_tree_default',
      'filename' => 'modSystemSetting/9cf213f2fc376b6ff73b1a09def4a598.vehicle',
      'namespace' => 'minishop2',
    ),
    17 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '256322ccda8f76b07592b13e4fb9834b',
      'native_key' => 'ms2_product_source_default',
      'filename' => 'modSystemSetting/905b6834cb1955217c520bd5d6604c57.vehicle',
      'namespace' => 'minishop2',
    ),
    18 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd75eb7e1fb44fd12d69c7474647ec6a4',
      'native_key' => 'ms2_product_thumbnail_size',
      'filename' => 'modSystemSetting/25d986b3dddae7362ccdaaf84e29f072.vehicle',
      'namespace' => 'minishop2',
    ),
    19 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'a43691ce8b6236c6f148b24a6977edf6',
      'native_key' => 'ms2_product_remember_tabs',
      'filename' => 'modSystemSetting/81d98137f039f6a04a04ad550edf1f66.vehicle',
      'namespace' => 'minishop2',
    ),
    20 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5f18a2bb9fb0e8fc2da44d4da18683ee',
      'native_key' => 'ms2_product_id_as_alias',
      'filename' => 'modSystemSetting/5c10d761063e0f57b11b09abe51f2f5e.vehicle',
      'namespace' => 'minishop2',
    ),
    21 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'c8f9cd85e96f512d70a954a8093893e3',
      'native_key' => 'ms2_price_format',
      'filename' => 'modSystemSetting/b6c57d962b47bf1d543173bce8084d9c.vehicle',
      'namespace' => 'minishop2',
    ),
    22 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd26dc905484b5f48a07617e2b3898d5c',
      'native_key' => 'ms2_weight_format',
      'filename' => 'modSystemSetting/d6fc32da043de919cf80f6bbd69d5a51.vehicle',
      'namespace' => 'minishop2',
    ),
    23 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7837e4962046851e00ba95d3245e7e47',
      'native_key' => 'ms2_price_format_no_zeros',
      'filename' => 'modSystemSetting/468f12957a193739cd13689a52619020.vehicle',
      'namespace' => 'minishop2',
    ),
    24 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '057fbbad9fdfdea94242e54d51bc635c',
      'native_key' => 'ms2_weight_format_no_zeros',
      'filename' => 'modSystemSetting/3964757744f0714926f488960414e6ec.vehicle',
      'namespace' => 'minishop2',
    ),
    25 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'ffedd180e96869115e934ae8993af009',
      'native_key' => 'ms2_product_tab_extra',
      'filename' => 'modSystemSetting/6168844a24d7766ac3562c1db027a3a7.vehicle',
      'namespace' => 'minishop2',
    ),
    26 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'c68cc01f934a808c65d55ce9f77a1ab9',
      'native_key' => 'ms2_product_tab_gallery',
      'filename' => 'modSystemSetting/0d4c012a397abadfab93be86c7dd7f2e.vehicle',
      'namespace' => 'minishop2',
    ),
    27 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6108bdf086be670ee7ac774bfda8d69e',
      'native_key' => 'ms2_product_tab_links',
      'filename' => 'modSystemSetting/df73ecbad081edec800afaec12137f3c.vehicle',
      'namespace' => 'minishop2',
    ),
    28 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd5e58be51e802ed22cf551dfbad03ff9',
      'native_key' => 'ms2_product_tab_options',
      'filename' => 'modSystemSetting/87a16edf10f0619d33db664911a3f173.vehicle',
      'namespace' => 'minishop2',
    ),
    29 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '57c1e2d5cde59ec9333e4c2046a3f79f',
      'native_key' => 'ms2_product_tab_categories',
      'filename' => 'modSystemSetting/adc4acbba3be4252e6d46dd4dc8e7648.vehicle',
      'namespace' => 'minishop2',
    ),
    30 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'd62d7d9f081cb2f7bda60398f9a188a0',
      'native_key' => 'ms2_cart_handler_class',
      'filename' => 'modSystemSetting/18a05e870bcc213a8a90f3b6f580c023.vehicle',
      'namespace' => 'minishop2',
    ),
    31 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5e24ec9e62e798bf071f6e4e92110429',
      'native_key' => 'ms2_order_grid_fields',
      'filename' => 'modSystemSetting/a60d51656c3166b82bbe1c03af157b09.vehicle',
      'namespace' => 'minishop2',
    ),
    32 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6317605d7eb3a2dd1c15084752ab2efe',
      'native_key' => 'ms2_order_address_fields',
      'filename' => 'modSystemSetting/9514264bf77d69602976da8873c54194.vehicle',
      'namespace' => 'minishop2',
    ),
    33 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'e233551690477a9bc3fbafcb04b17ec1',
      'native_key' => 'ms2_order_product_fields',
      'filename' => 'modSystemSetting/dd5858610ce74c3cc35a7e78ad30ddca.vehicle',
      'namespace' => 'minishop2',
    ),
    34 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '2d8ee90ce7fcccf0e65df5d4e9f44453',
      'native_key' => 'ms2_order_handler_class',
      'filename' => 'modSystemSetting/cdc19e427984cba9011b696e6b90a0e8.vehicle',
      'namespace' => 'minishop2',
    ),
    35 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '66d08b3f8cd0bc2d93549a56ca321c25',
      'native_key' => 'ms2_order_user_groups',
      'filename' => 'modSystemSetting/e4c6768eda3ef38f8dc12684e2683a30.vehicle',
      'namespace' => 'minishop2',
    ),
    36 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '6ecaf2803a0b68e3e7d2ce0d1cea3147',
      'native_key' => 'ms2_date_format',
      'filename' => 'modSystemSetting/6019299f972d38e4934443f721d8d795.vehicle',
      'namespace' => 'minishop2',
    ),
    37 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '69b3562619db559274b1d47071112083',
      'native_key' => 'ms2_email_manager',
      'filename' => 'modSystemSetting/6972912d1a59fd368d1406c8105f83aa.vehicle',
      'namespace' => 'minishop2',
    ),
    38 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'f89aeba4cd5c9f4bda19e9bbd8e2c629',
      'native_key' => 'ms2_frontend_css',
      'filename' => 'modSystemSetting/1948ba7bc17ee2af00f43962f9e31d65.vehicle',
      'namespace' => 'minishop2',
    ),
    39 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '482bc5f27fa2588873b17be356b7c15e',
      'native_key' => 'ms2_frontend_js',
      'filename' => 'modSystemSetting/b5651ca86322e45b5bb88e38fcaa1134.vehicle',
      'namespace' => 'minishop2',
    ),
    40 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '7bb2bba48732a8947b0f119aae6a4b0b',
      'native_key' => 'ms2_payment_paypal_api_url',
      'filename' => 'modSystemSetting/4b3e759382f7c64cf57c00afa5f96144.vehicle',
      'namespace' => 'minishop2',
    ),
    41 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '98588dbf04598ac17bfea947a774e845',
      'native_key' => 'ms2_payment_paypal_checkout_url',
      'filename' => 'modSystemSetting/fbf17720268739494ee1cecf2cd65d17.vehicle',
      'namespace' => 'minishop2',
    ),
    42 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'b06f7ca74215102e89b52b9f6aafc618',
      'native_key' => 'ms2_payment_paypal_currency',
      'filename' => 'modSystemSetting/2080c48f729a1caf7cf97eff8eca61de.vehicle',
      'namespace' => 'minishop2',
    ),
    43 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5cc354c40d20dd417dd1fb39a95d94ed',
      'native_key' => 'ms2_payment_paypal_user',
      'filename' => 'modSystemSetting/37fcd98f342296511673acbacc0bde8e.vehicle',
      'namespace' => 'minishop2',
    ),
    44 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '76a29c2ef4e08831987f8e4d5086e98f',
      'native_key' => 'ms2_payment_paypal_pwd',
      'filename' => 'modSystemSetting/95d6fd110cc64c0575cdbe4cb909a1a6.vehicle',
      'namespace' => 'minishop2',
    ),
    45 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '5fcee5077aa7851980892832d839e574',
      'native_key' => 'ms2_payment_paypal_signature',
      'filename' => 'modSystemSetting/99f106d5eb942d00e557e0e6b9fec55e.vehicle',
      'namespace' => 'minishop2',
    ),
    46 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => 'ad0ed16099f80bc5644c8447de9114ea',
      'native_key' => 'ms2_payment_paypal_success_id',
      'filename' => 'modSystemSetting/388e28e670ef10b5818c146ae7a18f6f.vehicle',
      'namespace' => 'minishop2',
    ),
    47 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '14d8b0ff9e7c90fdc59cc1c69ba2f415',
      'native_key' => 'ms2_payment_paypal_cancel_id',
      'filename' => 'modSystemSetting/5125b36a25aee28f13eac931542f5734.vehicle',
      'namespace' => 'minishop2',
    ),
    48 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modSystemSetting',
      'guid' => '0c0b8993978e8f1c7e65f29a9dffbdfe',
      'native_key' => 'ms2_payment_paypal_cancel_order',
      'filename' => 'modSystemSetting/6d63c395a6af53bc2e8a7bf0b3c56adb.vehicle',
      'namespace' => 'minishop2',
    ),
    49 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'c71d0e08b58f89588122601cc03c9573',
      'native_key' => 'msOnBeforeAddToCart',
      'filename' => 'modEvent/8d42ac5dde50f6ac3ea7cd8665e9f1ce.vehicle',
      'namespace' => 'minishop2',
    ),
    50 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'cbb0d7aa48a8398d39920fd457926be0',
      'native_key' => 'msOnAddToCart',
      'filename' => 'modEvent/b4f24a5a7a03356233d99d687daee95e.vehicle',
      'namespace' => 'minishop2',
    ),
    51 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'd2fc7e14d128b4dbb3101d90535d058f',
      'native_key' => 'msOnBeforeChangeInCart',
      'filename' => 'modEvent/d23d8b2f5c96de8759b4d43d8680554d.vehicle',
      'namespace' => 'minishop2',
    ),
    52 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'e4e8124caadd4a60476c2d7f3447c989',
      'native_key' => 'msOnChangeInCart',
      'filename' => 'modEvent/d5af2f55b8c7b95a2b1ef990f15a7b66.vehicle',
      'namespace' => 'minishop2',
    ),
    53 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '8de47a38fb06e161a5798c88788c320c',
      'native_key' => 'msOnBeforeRemoveFromCart',
      'filename' => 'modEvent/fba05a107bce32da9143984476148218.vehicle',
      'namespace' => 'minishop2',
    ),
    54 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '4f921b33e6473fc4663b1aaf859d225c',
      'native_key' => 'msOnRemoveFromCart',
      'filename' => 'modEvent/9071af3df75fc9874527b072648c8805.vehicle',
      'namespace' => 'minishop2',
    ),
    55 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '6ed22b68f28dac6a1ef692932b6bc1df',
      'native_key' => 'msOnBeforeEmptyCart',
      'filename' => 'modEvent/4f50c89fce2261e5c5bb2dcac8730948.vehicle',
      'namespace' => 'minishop2',
    ),
    56 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '6b1a53029b6df1c4cf4658da23d75ea1',
      'native_key' => 'msOnEmptyCart',
      'filename' => 'modEvent/47d3be59804a0c6c7ea7a86f231db5ff.vehicle',
      'namespace' => 'minishop2',
    ),
    57 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'a83e90b9f66da81085f67ab5638b51b3',
      'native_key' => 'msOnBeforeAddToOrder',
      'filename' => 'modEvent/cb1fa05f75cef18cfe8517a46fada84f.vehicle',
      'namespace' => 'minishop2',
    ),
    58 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '9c5a4d855cf153a80d6729bf224f8ae7',
      'native_key' => 'msOnAddToOrder',
      'filename' => 'modEvent/9af87c116f595cc5b2f9effac9078185.vehicle',
      'namespace' => 'minishop2',
    ),
    59 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '3997ea9c275d6f1ef3e924f6a1f012e0',
      'native_key' => 'msOnBeforeRemoveFromOrder',
      'filename' => 'modEvent/9c50572223e9635783019c82d81b447e.vehicle',
      'namespace' => 'minishop2',
    ),
    60 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '355411265e8a678965cba490a4c0f6bd',
      'native_key' => 'msOnRemoveFromOrder',
      'filename' => 'modEvent/6ed7d41140840a17e2364d676742c996.vehicle',
      'namespace' => 'minishop2',
    ),
    61 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '0a4d023dcb7b9a2fcc5a3dd63f3ae879',
      'native_key' => 'msOnBeforeEmptyOrder',
      'filename' => 'modEvent/0ebd7a6d9bb0fac787cbf30aedf6f1fa.vehicle',
      'namespace' => 'minishop2',
    ),
    62 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '2a6e95cc287847ea8b113fa7d746e0a9',
      'native_key' => 'msOnEmptyOrder',
      'filename' => 'modEvent/f7ca468d0aa009912a1f8baf4e0ef4aa.vehicle',
      'namespace' => 'minishop2',
    ),
    63 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '32a87f9b2d818d67bec3a8276e008690',
      'native_key' => 'msOnBeforeGetOrderCost',
      'filename' => 'modEvent/dcf8a49c417c0473b0dcaa793d7cf65d.vehicle',
      'namespace' => 'minishop2',
    ),
    64 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '135eec96fe8a1a52b0934d0c5b92bd47',
      'native_key' => 'msOnGetOrderCost',
      'filename' => 'modEvent/70fb484546f36191ebcca72e936cc1fc.vehicle',
      'namespace' => 'minishop2',
    ),
    65 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '2cef75a0a31d6458d75a853a06fc225b',
      'native_key' => 'msOnBeforeChangeOrderStatus',
      'filename' => 'modEvent/b298c56596dde52a7f8a913c1693a698.vehicle',
      'namespace' => 'minishop2',
    ),
    66 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '46de480cc7921f4553081a682a0a307b',
      'native_key' => 'msOnChangeOrderStatus',
      'filename' => 'modEvent/d4dfdbb5b00692ccab6a4b3d2e8f5b24.vehicle',
      'namespace' => 'minishop2',
    ),
    67 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '5064ff8836b4c324cd97af5e24fb577c',
      'native_key' => 'msOnBeforeCreateOrder',
      'filename' => 'modEvent/667e9e9ff1586fb880a87f5ee683a99e.vehicle',
      'namespace' => 'minishop2',
    ),
    68 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '186368596b6dde6a093a4ae7ce0dfece',
      'native_key' => 'msOnCreateOrder',
      'filename' => 'modEvent/4e77ddd01010e6e6ac65a80e903576a6.vehicle',
      'namespace' => 'minishop2',
    ),
    69 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '48177c5b1dd749be91031f426d7a53dd',
      'native_key' => 'msOnBeforeUpdateOrder',
      'filename' => 'modEvent/e03e18d4743896bc5a4899977d21418d.vehicle',
      'namespace' => 'minishop2',
    ),
    70 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'b46bd2847b365387c5bdc97b57e183bc',
      'native_key' => 'msOnUpdateOrder',
      'filename' => 'modEvent/7486b22b63f874bfa2c323030a22cfb8.vehicle',
      'namespace' => 'minishop2',
    ),
    71 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '9c18ffaf2020469bfcfc8faa5f598854',
      'native_key' => 'msOnBeforeRemoveOrder',
      'filename' => 'modEvent/b5af9b3aec019c946729c7ac0ae66874.vehicle',
      'namespace' => 'minishop2',
    ),
    72 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'dbd09e96611449ea0f61e20d94f0efcf',
      'native_key' => 'msOnRemoveOrder',
      'filename' => 'modEvent/e2666f4438a298a06f9b31ca1fc8aeca.vehicle',
      'namespace' => 'minishop2',
    ),
    73 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '7142075e4743d8cf210e5d4e88ce3591',
      'native_key' => 'msOnBeforeCreateOrderProduct',
      'filename' => 'modEvent/07ce2872d059806d6a2f7b69f1c365d5.vehicle',
      'namespace' => 'minishop2',
    ),
    74 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '1aa093a05a9c5d3e0bfcdf63f1bd47db',
      'native_key' => 'msOnCreateOrderProduct',
      'filename' => 'modEvent/ab6e26ca4018743e8c8ee774a677819d.vehicle',
      'namespace' => 'minishop2',
    ),
    75 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'c4a84222bf818ae7fd419bb15a9c2084',
      'native_key' => 'msOnBeforeUpdateOrderProduct',
      'filename' => 'modEvent/19253b5032440034f5383cadc3521c29.vehicle',
      'namespace' => 'minishop2',
    ),
    76 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'b2e231e49956fccc7d89e52736ef1240',
      'native_key' => 'msOnUpdateOrderProduct',
      'filename' => 'modEvent/7f2bdbb049a1949713de3f92b3870bd4.vehicle',
      'namespace' => 'minishop2',
    ),
    77 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '7009352d93ded8107dd4f75a65a55aea',
      'native_key' => 'msOnBeforeRemoveOrderProduct',
      'filename' => 'modEvent/8ffa7eb398b601baa5a47ce01b1af9af.vehicle',
      'namespace' => 'minishop2',
    ),
    78 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '9126d27fa6b17a0af515ee322b43c69d',
      'native_key' => 'msOnRemoveOrderProduct',
      'filename' => 'modEvent/7acdb2ee6e0fa5d99e8246639b5203e7.vehicle',
      'namespace' => 'minishop2',
    ),
    79 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'af1f637922f43a1ae6dd5a14be0a6645',
      'native_key' => 'msOnSubmitOrder',
      'filename' => 'modEvent/768c88e855f01c5084f5e607a32ebb57.vehicle',
      'namespace' => 'minishop2',
    ),
    80 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => '91b2b725794c655ff7fcad70343e3aa0',
      'native_key' => 'msOnManagerCustomCssJs',
      'filename' => 'modEvent/02ad489d3174c9529a17c1d1c165bbb8.vehicle',
      'namespace' => 'minishop2',
    ),
    81 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'f35c402a84c735c8cf7dbd22c3f0ac45',
      'native_key' => 'msOnBeforeValidateOrderValue',
      'filename' => 'modEvent/6e926c2e71815c82bddf6844fcd59064.vehicle',
      'namespace' => 'minishop2',
    ),
    82 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'f10e803cd37cf8d93d27c29cf77de89d',
      'native_key' => 'msOnValidateOrderValue',
      'filename' => 'modEvent/9c874cc4f10a1ddd08fbc930c1f693e6.vehicle',
      'namespace' => 'minishop2',
    ),
    83 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'a9f269d1698024798ae8ec248117653a',
      'native_key' => 'msOnGetProductPrice',
      'filename' => 'modEvent/e549cb07b0f33858c84c73c600ec4525.vehicle',
      'namespace' => 'minishop2',
    ),
    84 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modEvent',
      'guid' => 'a26ddd2342e46bbfa366ea1e096fea9e',
      'native_key' => 'msOnGetProductWeight',
      'filename' => 'modEvent/4cb33e75a93fb7003db86c995932881e.vehicle',
      'namespace' => 'minishop2',
    ),
    85 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modAccessPolicy',
      'guid' => '687d1e39438d2b9a76825db10dbf35ad',
      'native_key' => NULL,
      'filename' => 'modAccessPolicy/5ef6bd1234ae1c4e84e139bb4d5725a2.vehicle',
      'namespace' => 'minishop2',
    ),
    86 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modAccessPolicyTemplate',
      'guid' => '7900bc0bfe00f9e1d05bc5a96bc254a6',
      'native_key' => NULL,
      'filename' => 'modAccessPolicyTemplate/5c4b4d210389f3b25db8bf2187d9f099.vehicle',
      'namespace' => 'minishop2',
    ),
    87 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '260fcbc824508a2e39408a0fbbe36be9',
      'native_key' => 'minishop2',
      'filename' => 'modMenu/f2bf8b2638523a19fc238e302ced49d6.vehicle',
      'namespace' => 'minishop2',
    ),
    88 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => '138ab1da91277cebb7b6a81f41dca432',
      'native_key' => 'ms2_orders',
      'filename' => 'modMenu/ae6ba00c582fcad32f4e34d95d92972a.vehicle',
      'namespace' => 'minishop2',
    ),
    89 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modMenu',
      'guid' => 'ad632c98b613835edd65307b00105441',
      'native_key' => 'ms2_settings',
      'filename' => 'modMenu/eeebf9b949348a93247e184bb1b19da1.vehicle',
      'namespace' => 'minishop2',
    ),
    90 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modCategory',
      'guid' => '149dfac275eef83bc17fed71f4ebe304',
      'native_key' => 1,
      'filename' => 'modCategory/a13e0eec9b4b9d7cd0ba90c887962eb9.vehicle',
      'namespace' => 'minishop2',
    ),
  ),
);