{* Микроразметка CreativeWorkSeries страниц услуг (шаг 50) — вместо старого script-creativeworkseries-scheme (он не меняется):
   число оценок (ratingCount) — параметр &reviews из шаблона (135), а не ecMessagesCount; оценка — ecThreadRatingMicro, если у страницы
   своих оценок нет (EN-версии) — 5 (как в lb-script). &reviews — MODX-плейсхолдер (подставляется до Fenom), без него — 135. *}
{set $reviews = '[[+reviews]]' | ereplace : '~\D+~' : ''}
{set $rate = $_modx->runSnippet('ecThreadRatingMicro') | trim}
{if !$rate || $rate == '0'}{set $rate = 5}{/if}
<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "CreativeWorkSeries",
    "name": "[[*pagetitle]]",
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{$rate}",
        "bestRating": "5",
        "ratingCount": "{$reviews ?: 135}"
    }
}
</script>
