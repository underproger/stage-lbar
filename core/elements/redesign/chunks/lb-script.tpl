{* Скрипты и микроразметка ProfessionalService / LocalBusiness / WebSite (шаг 50 — страницы услуг; шаг 69 — все шаблоны со старым чанком
   script: он больше нигде не стоит). Копия старого script, отличия — aggregateRating и убранный лишний «]]» после JSON WebSite.
   С параметром &reviews — число отзывов из него, оценка — ветка EasyComm, а если оценок нет — 5; aggregateRating есть всегда:
   «Категория» (8) и «Категория NEW» (19) — 135, «Блог - статья» (5) — 25 (курс, шаблон «Обучение» 15, — свой блок в шаблоне: 90).
   Без параметра (остальные шаблоны) — как в старом script: оценка и число — ветка EasyComm страницы (ecThreadRatingMicro /
   ecMessagesCount), нет оценок — нет aggregateRating. У EN-страницы ветка — RO-двойника (lb.roId, у переводов EN своих отзывов нет),
   поэтому число отзывов на EN — как в румынской версии; RO и RU — свои. Параметр &reviews — MODX-плейсхолдер, подставляется до Fenom
   (как &tz в lb-consult; Fenom-переменной $reviews нет); без параметра плейсхолдер остаётся как есть → цифр нет → пусто. *}
{set $reviews = '[[+reviews]]' | ereplace : '~\D+~' : ''}
{set $tid = $_modx->getChunk('lb.roId') | trim}
{set $rate = $_modx->runSnippet('ecThreadRatingMicro', ['thread' => 'resource-' ~ $tid]) | trim}
{if !$rate || $rate == '0'}{set $rate = ''}{/if}
{if $reviews}
{set $cnt = $reviews}
{if !$rate}{set $rate = 5}{/if}
{elseif $rate}
{set $cnt = $_modx->runSnippet('ecMessagesCount', ['thread' => 'resource-' ~ $tid]) | trim}
{/if}
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
		{if $rate}"aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": {$rate},
          "reviewCount": {$cnt}
        },{/if}
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
		{if $rate}"aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": {$rate},
          "reviewCount": {$cnt}
        },{/if}
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
