{* Скрипты и микроразметка страниц услуг (шаг 50) — копия старого чанка script (он сам не меняется: стоит на остальных шаблонах).
   Отличия: число отзывов в aggregateRating (ProfessionalService / LocalBusiness) — параметр &reviews из шаблона («Категория» 8 и
   «Категория NEW» 19 передают 135), а не ecMessagesCount (отзывы easyComm этой страницы); оценка — ecThreadRatingMicro, а если у страницы
   своих оценок нет (EN-версии) — 5, поэтому aggregateRating есть на каждой странице услуги; убран лишний «]]» после JSON WebSite
   (в старом чанке из-за него JSON невалиден). *}
{set $rate = $_modx->runSnippet('ecThreadRatingMicro') | trim}
{if !$rate || $rate == '0'}{set $rate = 5}{/if}
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
		"aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": {$rate},
          "reviewCount": {$reviews ?: 135}
        },
		"openingHoursSpecification": [
			{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": [
				"Monday",
				"Tuesday",
				"Wednesday",
				"Thursday",
				"Friday"
				],
				"opens": "09:00",
				"closes": "20:00"
			},
			{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": [
				"Saturday"
				],
				"opens": "09:00",
				"closes": "18:00"
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
		"aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": {$rate},
          "reviewCount": {$reviews ?: 135}
        },
		"openingHoursSpecification": [
			{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": [
				"Monday",
				"Tuesday",
				"Wednesday",
				"Thursday",
				"Friday"
				],
				"opens": "09:00",
				"closes": "20:00"
			},
			{
			"@type": "OpeningHoursSpecification",
			"dayOfWeek": [
				"Saturday"
				],
				"opens": "09:00",
				"closes": "18:00"
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
