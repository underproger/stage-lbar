    <meta charset="[[++modx_charset]]" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <base href="[[!++site_url]]" />
    [[Canonical]]
    <title>[[*longtitle:default=`[[*pagetitle]]`]]</title>
    <meta name="robots" content="{$_modx->resource.robot}" />
    [[*description:notempty=`<meta name="description" content="[[*description]]">`]]
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="autor" content="[[++autor]]">
	<meta name="copyright" content="Copyright (c) [[+phx:input=`now`:strtotime:date=`%Y`]] by [[++site_name]]" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="64x64" href="favicon.png">

    <meta name="it-rating" content="it-rat-1320b27f41502b183e5f4961dd00e5c0" />
    [[BabelLinks?
        &showCurrent=`1`
        &tpl=`babelLinkHeadAlternate`
    ]]
    
    <link rel="stylesheet" href="/assets/templates/css/reset.css"/>
	<!-- <link rel="preload" as="style" href="/assets/templates/css/reset.css"/> -->
	
	<link rel="stylesheet" href="/assets/templates/css/template.css?ver=1.0.2"/>
	<link rel="preload" as="style" href="/assets/templates/css/template.css?ver=1.0.2"/>
	
	<link rel="stylesheet" href="/assets/templates/css/blog.css?ver=17.02.2403"/>
	<!-- <link rel="preload" as="style" href="/assets/templates/css/blog.css"/> -->
	
	<link rel="stylesheet" href="/assets/templates/css/fonts.css"/>
	<!-- <link rel="preload" as="style" href="/assets/templates/css/fonts.css"/> -->
	
	<link rel="stylesheet" href="/assets/templates/css/media.css"/>
	<!-- <link rel="preload" as="style" href="/assets/templates/css/media.css"/> -->
    
    <link rel="stylesheet" href="/assets/templates/css/slimmenu.css"/>
	<!-- <link rel="preload" as="style" href="/assets/templates/css/slimmenu.css"/> -->
	
	<!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
	
	<meta name="facebook-domain-verification" content="hai8duv278xd103dco38h7q0v6e7ft" />
	
	{$_modx->lexicon->load('babel:translate')}
	
<!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    <meta charset="[[++modx_charset]]" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <base href="[[!++site_url]]" />
    <title>[[+st_title_blog_list]]</title>
    <meta name="robots" content="{$_modx->resource.robot}" />
    <meta name="description" content="[[*description:default=`[[+st_description_blog_list]]`]]">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="autor" content="[[++autor]]">
	<meta name="copyright" content="Copyright (c) [[+phx:input=`now`:strtotime:date=`%Y`]] by [[++site_name]]" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="it-rating" content="it-rat-1320b27f41502b183e5f4961dd00e5c0" />
    [[BabelLinks?
        &showCurrent=`1`
        &tpl=`babelLinkHeadAlternate`
    ]]
    
    <link rel="stylesheet" href="/assets/templates/css/reset.css" />
    <link rel="stylesheet" href="/assets/templates/css/template.css?ver=19.08.2315" />
    <link rel="stylesheet" href="/assets/templates/css/blog.css?ver=17.02.2403" />
    <link rel="stylesheet" href="/assets/templates/css/fonts.css" />
    <link rel="stylesheet" href="/assets/templates/css/media.css" />
    <link rel="stylesheet" href="/assets/templates/css/slimmenu.css" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <meta name="facebook-domain-verification" content="hai8duv278xd103dco38h7q0v6e7ft" />
    
    {$_modx->lexicon->load('babel:translate')}
    
<!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" />
<style>
    .iti { width:100%; }
    .iti--separate-dial-code .iti__selected-flag {
        color:black;
        background:none;
        font-size:16px;
    }
    .consultation-form .iti__selected-flag {
    
    color:white;
    }
    .iti--container {
        z-index:9999;
        
    }
</style>

<script>
console.log('1');
var inputs = document.querySelectorAll("[name='phone']");
inputs.forEach((block) => {
    let iti = intlTelInput(block, {
        separateDialCode : true,
        initialCountry: "auto",
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.3/build/js/utils.js",
        geoIpLookup: function(success, failure) {
        $.get("https://extreme-ip-lookup.com/json", function() {}, "jsonp").always(function(resp) {
          var countryCode = (resp && resp.countryCode) ? resp.countryCode : "ro";
          success(countryCode);
        });
        },
    });

    let width = $(block).parents('form').width();
   // $(block).prev().find('.iti__country-list').css('width', width);
    $(block).prop('placeholder', '{$_modx->lexicon("lbar.form.input.phone")}');
})

$(document).on('submit', '.ajax_form', function() {
    var phone = this.querySelector('[name="phone"]');
    var iti = window.intlTelInputGlobals.getInstance(phone);
    phone.value = iti.getNumber();
    
});

</script>
{disableSource}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script src="/assets/templates/js/jquery-3.2.0.min.js"></script>
<script src="/assets/templates/js/jquery-migrate-3.0.0.min.js"></script>
<script>var $ = jQuery;</script>
<script src="/assets/templates/js/main.js"></script>
<script src="/assets/templates/js/custom.js"></script>
<script src="/assets/soc-share/soc-share.js"></script>
<!--<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3aTlJzCMv6opFNcZtoI-gzymZOc9nSNA&language=uk&region=UA&callback=initMap"></script>-->
[[$inttelinput]]
<script>
$(document).on('af_complete', function(event, response) {
    var form = response.form;
    if (response.success) { //Если форма заполнена и нет ошибок
        if (form.attr('id') == 'form-bl4') {
            window.location.href = "[[++cultureKey:is=`ro`:then=`[[~40]]`:else=`[[~269]]`]]"
        }
        if (form.attr('id') == 'form-bl8') {
            window.location.href = "[[++cultureKey:is=`ro`:then=`[[~40]]`:else=`[[~269]]`]]"
        }
        if (form.attr('id') == 'form-study-banner') {
            window.location.href = "[[++cultureKey:is=`ro`:then=`[[~40]]`:else=`[[~269]]`]]"
        }
        if (form.attr('id') == 'form-study-bl2') {
            window.location.href = "[[++cultureKey:is=`ro`:then=`[[~40]]`:else=`[[~269]]`]]"
        }
        if (form.attr('id') == 'form-study-bl18') {
            window.location.href = "[[++cultureKey:is=`ro`:then=`[[~40]]`:else=`[[~269]]`]]"
        }
    }
    // Отменяем вывод стандартного сообщения
    response.message='';
});
{/disableSource}
</script>

<script type="application/ld+json">
	{
        "@context": "https://schema.org",
        "@type": "ProfessionalService",
        "image": "https://lbar.ro/images/design/logo-schema.jpg",
        "@id": "[[!++site_url]]",
        "name": "[[++site_name]]",
        "logo": "https://lbar.ro/images/design/logo.png",
        "description": "Micropigmentare Bucuresti, tatuaj în salonul Lbar",
        "email": "[[++e-mail]]",
        "priceRange": "[[*seo-price-range:empty=`0`]]",
        "address": {
                "@type": "PostalAddress",
                "streetAddress": "București, Sector 1, Strada Polonă 92",
                "addressLocality": "București",
                "addressRegion": "Bucuresti",
                "postalCode": "010496",
                "addressCountry": "RO"
				},
        "geo": {
			"@type": "GeoCoordinates",
			"latitude": 44.4523683,
			"longitude": 26.1017169
		},
		"url": "[[!++site_url]]",
		"telephone": "[[++phone-1]]",
		[[ecThreadRatingMicro:isnot=`0`:then=`"aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": [[ecThreadRatingMicro]],
          "reviewCount": [[ecMessagesCount]]
        },`:else=``]]
		"openingHoursSpecification": [
			{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": [
				"Monday",
				"Tuesday",
				"Wednesday",
				"Thursday",
				"Friday",
				"Saturday",
				"Sunday"
				],
				"opens": "09:00",
				"closes": "20:00"
			}
		]
	}
</script>
<script type="application/ld+json">
	{
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "image": "https://lbar.ro/images/design/logo-schema.jpg",
        "@id": "[[!++site_url]]#localbusiness",
        "name": "[[++site_name]]",
        "logo": "https://lbar.ro/images/design/logo.png",
        "description": "Micropigmentare Bucuresti, tatuaj în salonul Lbar",
        "email": "[[++e-mail]]",
        "priceRange": "[[*seo-price-range:empty=`0`]]",
        "address": {
                "@type": "PostalAddress",
                "streetAddress": "București, Sector 1, Strada Polonă 92",
                "addressLocality": "București",
                "addressRegion": "Bucuresti",
                "postalCode": "010496",
                "addressCountry": "RO"
				},
        "geo": {
			"@type": "GeoCoordinates",
			"latitude": 44.4523683,
			"longitude": 26.1017169
		},
		"url": "[[!++site_url]]",
		"telephone": "[[++phone-1]]",
		[[ecThreadRatingMicro:isnot=`0`:then=`"aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": [[ecThreadRatingMicro]],
          "reviewCount": [[ecMessagesCount]]
        },`:else=``]]
		"openingHoursSpecification": [
			{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": [
				"Monday",
				"Tuesday",
				"Wednesday",
				"Thursday",
				"Friday",
				"Saturday",
				"Sunday"
				],
				"opens": "09:00",
				"closes": "20:00"
			}
		]
	}
</script>

<script type="application/ld+json">
   {
      "@context": "http://schema.org",
      "@type": "WebSite",
      "name": "[[++site_name]]",
      "url": "[[!++site_url]]"
      }
</script>
<form action="" method="post" class="ajax_form af_example">

    <div class="form-group">
        <label class="control-label" for="af_name">[[%af_label_name]]</label>
        <div class="controls">
            <input type="text" id="af_name" name="name" value="[[+fi.name]]" placeholder="" class="form-control"/>
            <span class="error_name">[[+fi.error.name]]</span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="af_email">[[%af_label_email]]</label>
        <div class="controls">
            <input type="email" id="af_email" name="email" value="[[+fi.email]]" placeholder="" class="form-control"/>
            <span class="error_email">[[+fi.error.email]]</span>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="af_message">[[%af_label_message]]</label>
        <div class="controls">
            <textarea id="af_message" name="message" class="form-control" rows="5">[[+fi.message]]</textarea>
            <span class="error_message">[[+fi.error.message]]</span>
        </div>
    </div>

    <div class="form-group">
        <div class="controls">
            <button type="reset" class="btn btn-default">[[%af_reset]]</button>
            <button type="submit" class="btn btn-primary">[[%af_submit]]</button>
        </div>
    </div>

    [[+fi.success:is=`1`:then=`
    <div class="alert alert-success">[[+fi.successMessage]]</div>
    `]]
    [[+fi.validation_error:is=`1`:then=`
    <div class="alert alert-danger">[[+fi.validation_error_message]]</div>
    `]]
</form>
<h2>[[%ec_fe_message_add]]</h2>
<form class="form well ec-form" method="post" role="form" id="ec-form-[[+fid]]" data-fid="[[+fid]]" action="">
    <input type="hidden" name="thread" value="[[+thread]]">

    <div class="form-group ec-antispam">
        <label for="ec-[[+antispam_field]]-[[+fid]]" class="control-label">[[%ec_fe_message_antismap]]</label>
        <input type="text" name="[[+antispam_field]]" class="form-control" id="ec-[[+antispam_field]]-[[+fid]]" value="" />
    </div>

    <div class="form-group">
        <label for="ec-user_name-[[+fid]]" class="control-label">[[%ec_fe_message_user_name]]</label>
        <input type="text" name="user_name" class="form-control" id="ec-user_name-[[+fid]]" value="[[+user_name]]" />
        <span class="ec-error help-block" id="ec-user_name-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-user_email-[[+fid]]" class="control-label">[[%ec_fe_message_user_email]]</label>
        <input type="text" name="user_email" class="form-control" id="ec-user_email-[[+fid]]" value="[[+user_email]]" />
        <span class="ec-error help-block" id="ec-user_email-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-user_contacts-[[+fid]]" class="control-label">[[%ec_fe_message_user_contacts]]</label>
        <input type="text" name="user_contacts" class="form-control" id="ec-user_contacts-[[+fid]]" value="[[+user_contacts]]" />
        <span class="ec-error help-block" id="ec-user_contacts-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-subject-[[+fid]]" class="control-label">[[%ec_fe_message_subject]]</label>
        <input type="text" name="subject" class="form-control" id="ec-subject-[[+fid]]" value="[[+subject]]" />
        <span class="ec-error help-block" id="ec-subject-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-rating-[[+fid]]" class="control-label">[[%ec_fe_message_rating]]</label>
        <input type="hidden" name="rating" id="ec-rating-[[+fid]]" value="[[+rating]]" />
        <div class="ec-rating ec-clearfix" data-storage-id="ec-rating-[[+fid]]">
            <div class="ec-rating-stars">
                <span data-rating="1" data-description="[[%ec_fe_message_rating_1]]"></span>
                <span data-rating="2" data-description="[[%ec_fe_message_rating_2]]"></span>
                <span data-rating="3" data-description="[[%ec_fe_message_rating_3]]"></span>
                <span data-rating="4" data-description="[[%ec_fe_message_rating_4]]"></span>
                <span data-rating="5" data-description="[[%ec_fe_message_rating_5]]"></span>
            </div>
            <div class="ec-rating-description">[[%ec_fe_message_rating_0]]</div>
        </div>
        <span class="ec-error help-block" id="ec-rating-error-[[+fid]]"></span>
    </div>

    <div class="form-group">
        <label for="ec-text-[[+fid]]" class="control-label">[[%ec_fe_message_text]]</label>
        <textarea type="text" name="text" class="form-control" rows="5" id="ec-text-[[+fid]]">[[+text]]</textarea>
        <span class="ec-error help-block" id="ec-text-error-[[+fid]]"></span>
    </div>

    [[+recaptcha]]

    <div class="form-actions">
        <input type="submit" class="btn btn-primary" name="send" value="[[%ec_fe_send]]" />
    </div>
</form>
<div id="ec-form-success-[[+fid]]"></div>
<form class="form well ec-form clearfix" method="post" id="ec-form-[[+fid]]" data-fid="[[+fid]]" action="">
    <input type="hidden" name="thread" value="[[+thread]]">
    <div class="col-l-f">
        <div class="form-group ec-antispam">
            <label for="ec-[[+antispam_field]]-[[+fid]]" class="control-label">[[%ec_fe_message_antismap]]</label>
            <input type="text" name="[[+antispam_field]]" class="form-control" id="ec-[[+antispam_field]]-[[+fid]]" value="" />
        </div>
    
        <div class="form-group">
            <input type="text" name="user_name" class="form-control" placeholder="[[%ec_fe_message_user_name]]*" id="ec-user_name-[[+fid]]" value="[[+user_name]]" />
            <span class="ec-error help-block" id="ec-user_name-error-[[+fid]]"></span>
        </div>
        <div class="form-group">
            <textarea name="text" class="form-control" rows="5" placeholder="[[%ec_fe_message_text]]*" id="ec-text-[[+fid]]">[[+text]]</textarea>
            <span class="ec-error help-block" id="ec-text-error-[[+fid]]"></span>
        </div>
    </div>
    <div class="col-r-f">
        <div class="form-group">
            <input type="text" name="user_email" class="form-control" placeholder="[[%ec_fe_message_user_email]]" id="ec-user_email-[[+fid]]" value="[[+user_email]]" />
            <span class="ec-error help-block" id="ec-user_email-error-[[+fid]]"></span>
        </div>
    
        [[+recaptcha]]
        
        <div class="wrap-col-rat">
            <div class="col-rat-l">
                <div class="form-group">
                    <label for="ec-rating-[[+fid]]" class="control-label">{$_modx->lexicon("lbar.reviews.rating.label")}:</label>
                    <input type="hidden" name="rating" id="ec-rating-[[+fid]]" value="[[+rating]]" />
                    <div class="ec-rating ec-clearfix" data-storage-id="ec-rating-[[+fid]]">
                        <div class="ec-rating-stars">
                            <span data-rating="1" data-description="[[%ec_fe_message_rating_1]]"></span>
                            <span data-rating="2" data-description="[[%ec_fe_message_rating_2]]"></span>
                            <span data-rating="3" data-description="[[%ec_fe_message_rating_3]]"></span>
                            <span data-rating="4" data-description="[[%ec_fe_message_rating_4]]"></span>
                            <span data-rating="5" data-description="[[%ec_fe_message_rating_5]]"></span>
                        </div>
                    </div>
                    <span class="ec-error help-block" id="ec-rating-error-[[+fid]]"></span>
                </div>
            </div>
            <div class="col-rat-r">
                <div class="form-actions">
                    <input type="submit" class="btn-send" name="send" value="[[%ec_fe_send]]" />
                </div>
            </div>
        </div>
    </div>
</form>
<div id="ec-form-success-[[+fid]]"></div>
<form class="form well ec-form clearfix" method="post" role="form" id="ec-form-[[+fid]]" data-fid="[[+fid]]" action="">
    <input type="hidden" name="thread" value="[[+thread]]">
    <div class="col-l-f">
        <div class="form-group ec-antispam">
            <label for="ec-[[+antispam_field]]-[[+fid]]" class="control-label">[[%ec_fe_message_antismap]]</label>
            <input type="text" name="[[+antispam_field]]" class="form-control" id="ec-[[+antispam_field]]-[[+fid]]" value="" />
        </div>
    
        <div class="form-group">
            <input type="text" name="user_name" class="form-control" placeholder="[[%ec_fe_message_user_name]]*" id="ec-user_name-[[+fid]]" value="[[+user_name]]" />
            <span class="ec-error help-block" id="ec-user_name-error-[[+fid]]"></span>
        </div>
        <div class="form-group">
            <input type="text" name="user_email" class="form-control" placeholder="[[%ec_fe_message_user_email]]" id="ec-user_email-[[+fid]]" value="[[+user_email]]" />
            <span class="ec-error help-block" id="ec-user_email-error-[[+fid]]"></span>
        </div>
       
    </div>
    <div class="col-r-f">
        
     <div class="form-group">
            <textarea name="text" class="form-control" rows="5" placeholder="[[%ec_fe_message_text]]*" id="ec-text-[[+fid]]">[[+text]]</textarea>
            <span class="ec-error help-block" id="ec-text-error-[[+fid]]"></span>
        </div>
        [[+recaptcha]]
        
        <div class="wrap-col-rat">
            <div class="col-rat-l">
                <div class="form-group">
                    <label for="ec-rating-[[+fid]]" class="control-label">{$_modx->lexicon("lbar.reviews.rating.label")}:</label>
                    <input type="hidden" name="rating" id="ec-rating-[[+fid]]" value="[[+rating]]" />
                    <div class="ec-rating ec-clearfix" data-storage-id="ec-rating-[[+fid]]">
                        <div class="ec-rating-stars">
                            <span data-rating="1" data-description="[[%ec_fe_message_rating_1]]"></span>
                            <span data-rating="2" data-description="[[%ec_fe_message_rating_2]]"></span>
                            <span data-rating="3" data-description="[[%ec_fe_message_rating_3]]"></span>
                            <span data-rating="4" data-description="[[%ec_fe_message_rating_4]]"></span>
                            <span data-rating="5" data-description="[[%ec_fe_message_rating_5]]"></span>
                        </div>
                    </div>
                    <span class="ec-error help-block" id="ec-rating-error-[[+fid]]"></span>
                </div>
            </div>
            <div class="col-rat-r">
                <div class="form-actions">
                    <input type="submit" class="btn-send" name="send" value="[[%ec_fe_send]]" />
                </div>
            </div>
        </div>
    </div>
</form>
<div id="ec-form-success-[[+fid]]"></div>
На сайте [[++site_url]] было оставлено новое сообщение:
<br />
<br />
Автор: <span style="font-weight: bold">[[+user_name]]</span>
<br/>
Электронная почта: <span style="font-weight: bold">[[+user_email]]</span>
<br/>
Контактная информация: <span style="font-weight: bold">[[+user_contacts]]</span>
<br/>
<br/>
Тема сообщения: <span style="font-weight: bold">[[+subject]]</span>
<br/>
Оценка: <span style="font-weight: bold">[[+rating]]</span>
<br/>
Текст сообщения:
<br/>
<br/>
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+text]]</div>
<br /><br />
Сообщение было оставлено на странице <a target="_blank" href="[[~[[+resource_id]]?scheme=`full`]]">[[+resource_pagetitle]]</a>
<br />
<br />
<a target="_blank" href="[[++site_url]]manager/?a=resource/update&id=[[+resource_id]]">Опубликовать или ответить на сообщение &gt;</a>
На сайте [[++site_url]] был добавлен новый комментарий:
<p>Автор: <span style="font-weight: bold">[[+user_name]]</span></p>
<p>Электронная почта: <span style="font-weight: bold">[[+user_email]]</span></p>
<p>Текст комментария:</p>
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+text]]</div>
<p>Оценка: <span style="font-weight: bold">[[+rating]]</span></p>
<p>Комментарий был оставлен на странице <a target="_blank" href="[[~[[+resource_id]]?scheme=`full`]]">[[+resource_pagetitle]]</a></p>
<p>Перейдите в админку чтобы опубликовать или ответить на сообщение</p>
Здравствуйте, [[+user_name]]!
<br />
Вы оставили сообщение на сайте [[++site_url]]:
<br />
<br />
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+text]]</div>
<br /><br />
Ваше сообщение будет опубликовано после проверки администратором.
<br />
<br />
С уважением, [[++site_name]].
Здравствуйте, [[+user_name]]!
<p>Вы оставили комментарий на сайте [[++site_url]]</p>
<p>Текст комментария:</p>
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+text]]</div>
<p>Ваше сообщение будет опубликовано после проверки администратором.</p>
<p>С уважением, [[++site_name]].</p>
<div class="form-group">
    <div class="ec-captcha" id="ec-captcha-[[+fid]]"></div>
    <span class="ec-error help-block" id="ec-captcha-error-[[+fid]]"></span>
</div>
<div class="alert alert-success" role="alert">
    [[%ec_fe_send_success]]
</div>
<div class="alert alert-success" role="alert">
    [[%ec_fe_send_success]]
</div>
Здравствуйте, [[+user_name]]!
<br />
Вы оставляли сообщение на сайте [[++site_url]]:
<br />
<br />
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+text]]</div>
<br /><br />
[[+no_reply_and_published]][[+reply_and_published]][[+reply_and_not_published]]
<br />
<br />
С уважением, [[++site_name]].

<!--ec_no_reply_and_published
Ваше сообщение было опубликовано. Вы можете его просмотреть <a href="[[~[[+resource_id]]? &scheme=`full`]]#message-[[+id]]">здесь</a>.
-->
<!--ec_reply_and_published
[[+reply_author]]<br />
<br />
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+reply_text]]</div>
<br />
Ваше сообщение с ответом на него опубликовано <a href="[[~[[+resource_id]]? &scheme=`full`]]#message-[[+id]]">здесь</a>.
-->
<!--ec_reply_and_not_published
[[+reply_author]]<br />
<br />
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+reply_text]]</div>
-->

<!--ec_reply_author <span style="font-weight:bold;">[[+reply_author]]</span> ответил на ваше сообщение:-->
<!--ec_!reply_author На ваше сообщение дан ответ:-->
Здравствуйте, [[+user_name]]!
<p>Вы оставляли комментарий на сайте [[++site_url]]:</p>
<p>Текст комментария:</p>
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+text]]</div>
<p>[[+no_reply_and_published]][[+reply_and_published]][[+reply_and_not_published]]</p>
<p>С уважением, [[++site_name]].</p>
<!--ec_no_reply_and_published
<p>Ваше сообщение было опубликовано. Вы можете его просмотреть <a href="[[~[[+resource_id]]? &scheme=`full`]]#message-[[+id]]">здесь</a>.</p>
-->
<!--ec_reply_and_published
<p>[[+reply_author]]</p>
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+reply_text]]</div>
<p>Ваше сообщение с ответом на него опубликовано <a href="[[~[[+resource_id]]? &scheme=`full`]]#message-[[+id]]">здесь</a>.</p>
-->
<!--ec_reply_and_not_published
<p>[[+reply_author]]</p>
<div style="white-space:pre;background: #f0f0f0;padding: 10px;border: solid 1px #eee;">[[+reply_text]]</div>
-->

<!--ec_reply_author <span style="font-weight:bold;">[[+reply_author]]</span> ответил на ваше сообщение:-->
<!--ec_!reply_author На ваше сообщение дан ответ:-->
<div id="ec-[[+thread_name]]-message-[[+id]]" class="ec-message box">
    <div class="message-l">
        <div>[[+user_name]]</div>
    </div>
    <div class="message-r">
        <span style="display:none;">[[+rating]]</span>
        <div class="ec-stars">
            <span class="rating-[[+rating]]"></span>
        </div>
    </div>
    <div class="clearfix"></div>
    <p>[[+text]]</p>
    [[+reply_text]]
</div>

<!--ec_reply_text <div class="ec-message__reply">[[+reply_author]]<p>[[+reply_text]]</p></div>-->
<!--ec_reply_author <p><strong>[[+reply_author]]</strong></p>-->
<div id="ec-[[+thread_name]]-message-[[+id]]" class="ec-message box">
    <div class="message-l">
        <div>[[+user_name]]</div>
    </div>
    <div class="message-r">
        <div class="ec-stars">
            <span class="rating-[[+rating]]"></span>
        </div>
    </div>
    <div class="clearfix"></div>
    <p>[[+text]]</p>
    [[+reply_text]]
</div>

<!--ec_reply_text <div class="ec-message__reply">[[+reply_author]]<p>[[+reply_text]]</p></div>-->
<!--ec_reply_author <p><strong>[[+reply_author]]</strong></p>-->
<div class="ec-stars" title="[[+rating_wilson]]">
    <span style="width: [[+rating_wilson_percent]]%"></span>
</div>
<div class="ec-stars" title="[[+rating_wilson]]">
    <span style="width: [[+rating_wilson_percent]]%"></span>
</div>
[[+rating_wilson]]
<form method="post" id="form-bl4" class="wrap-form consultation-f">
    <div class="controls">
        <input type="text" class="ic-person input" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.trainer.input.name")}">
    </div>
    <div class="controls">
        <input type="tel" class="ic-tel input input-replace-placeholder" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    </div>
    <div class="controls">
        <input type="hidden" name="title" value="">
        <input type="hidden" name="link" value="[[*uri]]">
        <input type="hidden" name="workemail" value="">
        <div class="wrap clearfix">
            <div class="col">
                <button type="submit" class="btn-send btn">[[*link-form-bl4:default=`[[pdoField? &id=`1` &field=`link-form-bl4`]]`]]</button>
            </div>
            <span class="consultation-form__info">{$_modx->lexicon("lbar.form.trainer.policy")}</span>
        </div>
    </div>
</form>
<form method="post" id="form-bl8" class="form wrap-form">
    <div class="controls">
        <input type="text" class="ic-person" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    </div>
    <div class="controls">
        <input type="tel" class="ic-tel" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    </div>
    <div class="controls">
        <input type="hidden" name="title" value="">
        <input type="hidden" name="link" value="[[*uri]]">
        <input type="hidden" name="workemail" value="">
        <div class="wrap clearfix">
            <div class="col">
                <div class="text">{$_modx->lexicon("lbar.form.policy")}</div>
            </div>
            <div class="col">
                <button type="submit" class="btn-send">[[*link-form-bl8:default=`[[pdoField? &id=`[[++site_start]]` &field=`link-form-bl8`]]`]]</button>
            </div>
        </div>
    </div>
</form>
<form method="post" id="form-bl4" class="form">
    <div class="controls">
        <input type="text" class="ic-person" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    </div>
    <div class="controls">
        <input type="tel" class="ic-tel" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    </div>
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="btn-modal-send btn-send">{$_modx->lexicon("lbar.popup.form.button.submit")}</button>
</form>
<form method="post" id="form-study-bl12" class="salary-form">
    <input class="input" type="text" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    <input class="input" type="text" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="btn salary-btn">{$_modx->lexicon("lbar.calculator.form.btn")}</button>
</form>

<form method="post" id="form-study-bl12" class="consultation-f">
    <p class="consultation-form__title">{$_modx->lexicon("lbar-study-consultation-form-title")}</p>
    <span class="consultation-form__subtitle">{$_modx->lexicon("lbar-study-consultation-form-subtitle")}</span>
    <input class="input" type="text" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    <input class="input" type="text" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="btn consultation-form__btn">{$_modx->lexicon("lbar.form.trainer.button.submit")}</button>
    <span class="consultation-form__info">{$_modx->lexicon("lbar.form.trainer.policy")}</span>
</form>

<form method="post" id="form-study-banner">
    <input class="input" type="text" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    <input class="input input-replace-placeholder" type="text" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="popup-btn btn">{$_modx->lexicon('lbar-study-banner-form-btn')}</button>
    <span class="popup-info">{$_modx->lexicon("lbar.form.trainer.policy")}</span>
</form>

<form method="post" id="form-study-bl18">
    <input class="input" type="text" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    <input class="input" type="text" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="popup-btn btn">{$_modx->lexicon("lbar-study-success-form-btn")}</button>
    <span class="popup-info">{$_modx->lexicon("lbar.form.trainer.policy")}</span>
</form>

<form method="post" id="form-study-bl2">
    <input class="input" type="text" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    <input class="input" type="text" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="popup-btn btn">{$_modx->lexicon("lbar.form.trainer.button.submit")}</button>
    <span class="popup-info">{$_modx->lexicon("lbar.form.trainer.policy")}</span>
</form>

<form method="post" id="form-study-bl8">
    <input class="input" type="text" name="name" value="" placeholder="{$_modx->lexicon("lbar.form.input.name")}">
    <input class="input" type="text" name="phone" value="" placeholder="{$_modx->lexicon("lbar.form.input.phone")}">
    <input type="hidden" name="title" value="">
    <input type="hidden" name="link" value="[[*uri]]">
    <input type="hidden" name="workemail" value="">
    <button type="submit" class="popup-btn btn">{$_modx->lexicon("lbar-study-prices-btn")}</button>
    <span class="popup-info">{$_modx->lexicon("lbar.form.trainer.policy")}</span>
</form>

