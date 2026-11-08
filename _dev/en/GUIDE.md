# RO → EN translation guide — lbar.ro (LBar Studio, permanent makeup studio in Bucharest)

The site gets a third language, English, at /en/. You translate the Romanian (RO) page texts into natural,
polished, sales-friendly English for an international audience in Bucharest (expats, tourists, English speakers).
Quality bar: a native-English copywriter for a premium beauty studio. Not word-for-word; faithful in meaning,
no invented facts, no dropped facts.

## Files
- Input: `/home/claude/b39/tr/in/<RO_ID>.json` — one RO page:
  - `fields`: resource fields (`pagetitle`, `longtitle` = meta title, `menutitle` = menu label, `description` = meta description,
    `introtext`, `content`)
  - `tvs`: template variables, name → string (plain text or HTML)
  - `migx`: name → list of rows (dicts of strings): FAQ (`questions-title`, `questions-text`) and price tables (`col-1`..`col-4`)
  - `ro_uri`, `en_slug`, `template`, `words` — context only
- Output: `/home/claude/b39/tr/out/<RO_ID>.json` — **the same JSON structure** (`ro_id`, `fields`, `tvs`, `migx`),
  every key present in the input present in the output, every value translated. MIGX lists: same number of rows, same keys
  per row, same order. Write valid UTF-8 JSON (`ensure_ascii=False`), e.g. with a small Python script.
  Don't copy `words`/`ro_uri`/`en_slug`/`template`.
- Notes: `/home/claude/b39/tr/out/<RO_ID>.notes.txt` — only if something needs a human decision (one line each); otherwise no file.

## Hard rules
1. **HTML stays identical in structure**: same tags in the same order and nesting, same attributes and attribute values
   (`href`, `src`, `id`, `class`, `width`, `style` …) — translate only the text nodes plus `alt`/`title` attribute text.
   Never add or remove tags; never change a heading level (`<h2>` stays `<h2>` etc.); keep `<br/>`/`<br />` where they are
   (they are deliberate line breaks in short titles — keep them at a sensible spot of the English phrase);
   keep `&nbsp;`/entities as they are or as plain characters. Keep `\r\n` line breaks roughly where they were (not critical).
2. **Never touch** URLs/hrefs/src, MODX tags (`[[...]]`, `{...}` Fenom), placeholders, numbers in prices (`1100 RON`, `200 LEI` →
   keep the amount and the currency word as is: `1100 RON`, `200 LEI`), phone numbers, e-mails, the address `Strada Polonă 92`.
3. Names: `Ksenia Kobilianskaia`, `Aliona Șubcinskaia` (keep exactly as written in the source of that string; Alena/Aliona as given),
   brand `LBar` / `Lbar` / `LBar Studio` / `Studio LBar` — keep the brand as written (`Lbar Studio` may become `LBar Studio`).
   `București` → `Bucharest`; `Sector 1` stays.
4. American English spelling (color, center, anesthetic, favorite). Address the reader as "you" (Romanian formal Dvs. → plain "you").
5. Headings and titles: Title Case is NOT required — use sentence case like the source (capitalize the first word and proper nouns).
   Keep ALL-CAPS strings in caps (buttons such as `FĂ O PROGRAMARE` → `BOOK AN APPOINTMENT`).
6. SEO: keep the key phrases natural and present: "permanent makeup", "micropigmentation", the technique name, "Bucharest".
   - `longtitle` (meta title): ≤ 65 characters if possible, keep "Bucharest" when the source has București/Bucuresti.
   - `description` (meta description): 120–160 characters, keep emoji/symbols (⚡ ⭐ ✔ etc.) where the source has them.
   - `pagetitle` / `menutitle`: short, natural; `menutitle` is a menu label (1–4 words).
   - `title-banner` is the page H1 on service pages — keep it a clear keyword heading ("Powder brows in Bucharest" style).
7. Keep the meaning of every sentence; you may merge/split sentences inside the same paragraph for natural English,
   but don't move content between HTML elements.
8. Obvious leftovers from the old Ukrainian site: meta descriptions saying a master works "la Kiev" → use "in Bucharest"
   (the masters work at the Bucharest studio). Historical/biographical text about Kyiv/Ukraine (e.g. "studio founded in Kyiv") is
   factual — translate it as is. Put a one-line note in the notes file when you apply this.
9. Romanian typos/missing diacritics in the source (e.g. "sprancene", "Retus") — just translate the meaning.
10. Don't leave any Romanian words in the output except proper names and the street address.

## Glossary (use consistently)
| Romanian | English |
|---|---|
| micropigmentare | micropigmentation (also fine: permanent makeup, when it reads better) |
| machiaj permanent / machiaj semipermanent | permanent makeup / semi-permanent makeup |
| tatuaj cosmetic, tatuaj (in the PMU sense) | cosmetic tattoo / cosmetic tattooing (permanent makeup) |
| dermopigmentist, maestru, master | PMU artist / artist (in titles like "TOP-Master" keep "TOP Master") |
| TOP-Master / TOP-Trainer | TOP Master / TOP Trainer |
| micropigmentare sprâncene | eyebrow micropigmentation (brow permanent makeup) |
| sprâncene pudrate / efect pudrat / powder | powder brows / powder effect |
| fir cu fir (sprâncene) | hair-stroke (technique) / hair-stroke brows |
| microblading | microblading |
| tatuaj sprâncene 3D/6D | 3D/6D eyebrow tattoo |
| micropigmentare ochi / eyeliner / săgeți | eyeliner micropigmentation / eyeliner / winged eyeliner |
| micropigmentare pleoape / contur ochi | lash line enhancement (eyelid micropigmentation) / eye contour |
| umbrire | shading |
| micropigmentare buze / contur buze cu umplere parțială | lip micropigmentation (lip blush) / lip contour with partial fill |
| aquarelle / ombre / efect pudrat (buze) | aquarelle / ombré / powder effect |
| corecție, retuș, retus | touch-up |
| reîmprospătare (până la 1 an) | refresh (within 1 year) |
| îndepărtare tatuaj / remover | tattoo removal / remover |
| tatuaj aluniță | beauty mark tattoo |
| extensii de gene fir cu fir | classic eyelash extensions |
| epilare definitivă cu laser | laser hair removal |
| manichiură / pedichiură / ojă semi / gel | manicure / pedicure / gel polish / gel |
| consultație (gratuită) | (free) consultation |
| programare | appointment / booking |
| ședință / procedură | session / procedure (treatment) |
| pigmenți hipoalergenici | hypoallergenic pigments |
| anestezic / cremă anestezică | anesthetic / numbing cream |
| vindecare / crustă | healing / scabs |
| discipoli / cursanți | students |
| salon / studio | studio (salon is fine where it reads better) |
| recenzii | reviews |
| portofoliu | portfolio |

## Fixed translations of strings repeated across pages (use exactly)
| Romanian | English |
|---|---|
| 1 oră | 1 hour |
| 1 oră 30 min. / 1 oră 30 min | 1 hour 30 min. / 1 hour 30 min |
| 2 ore | 2 hours |
| Retus / Retuș | Touch-up |
| Corecție după un alt master | Correction of another artist's work |
| 100% din prețul primei ședințe | 100% of the first session price |
| 80% din prețul inițial | 80% of the original price |
| Reimprospatare pana la 1 an / Reimprospatare până la 1 an | Refresh within 1 year |
| Răspunsuri la întrebări frecvente | Answers to frequently asked questions |
| Materiale și consumabile <br/>profesionale | Professional materials <br/>and supplies |
| Folosim exclusiv pigmenți hipoalergenici testați și echipamente profesionale | We use only tested hypoallergenic pigments and professional equipment |
| Efect maxim <br/>rezistent | Maximum <br/>long-lasting effect |
| Sprâncene superbe și naturale cu durata efectului până la 1,5-2 ani, fără a fi necesar aplicarea machiajului zilnic | Gorgeous, natural-looking brows that last up to 1.5–2 years, with no need for daily makeup |
| Micropigmentare sprancene / sprâncene | Eyebrow micropigmentation |
| Micropigmentare sprancene pudrat | Powder brows micropigmentation |
| Micropigmentare Sprancene Fir cu Fir | Hair-stroke eyebrow micropigmentation |
| Microblading sprancene | Microblading brows |
| Tatuaj sprancene 3D/6D | 3D/6D eyebrow tattoo |
| Micropigmentare ochi | Eye micropigmentation |
| Micropigmentare Ochi Eyeliner | Eyeliner micropigmentation |
| Micropigmentare ochi (pleoape) / Micropigmentare pleoape | Lash line enhancement |
| Tatuaj contur ochi cu umbrire | Eye contour tattoo with shading |
| Micropigmentare buze | Lip micropigmentation |
| Micropigmentare buze aquarelle | Aquarelle lip micropigmentation |
| Micropigmentare buze efect pudrat | Powder-effect lip micropigmentation |
| Micropigmentare buze ombre | Ombré lip micropigmentation |
| Tatuaj buze 3D/6D | 3D/6D lip tattoo |
| Tatuaj contur buze cu umplere parțială | Lip contour tattoo with partial fill |
| Manichiura semipermanenta (mani semi) | Gel polish manicure |
| Manichiură clasică cu lac de gel | Classic manicure with gel polish |
| Mani semi cu protectie | Gel polish manicure with strengthening base |
| Indepartare oja semi | Gel polish removal |
| Stemping o unghii | Stamping (one nail) |
| Gel pe unghia naturala | Gel on the natural nail |
| Fragmente de antrenament | Training moments |
| Contact | Contact |
| Vă lipsesc sprâncenele | Missing your brows |
| Doriți o schimbare de look | Want a new look |
| Lista de prețuri: micropigmentare în București | Price list: micropigmentation in Bucharest |
| Recenzii tatuaje cosmetice de la clientele noastre | Cosmetic tattoo reviews from our clients |
| Galerie foto – machiaj permanent după procedură | Photo gallery – permanent makeup after the procedure |
| Faceți click pe poză pentru a o extinde și a o vizualiza în mărime naturală | Click a photo to enlarge it and see it in full size |
| Calitate / Siguranță / Frumusețe | Quality / Safety / Beauty |
| Micropigmentarea în salonul nostru din București, implică: | Micropigmentation at our Bucharest studio means: |
| Solicitați o programare pentru o ședință chiar acum | Book your session right now |
| FĂ O PROGRAMARE | BOOK AN APPOINTMENT |
| SOLICITĂ O CONSULTAȚIE | GET A CONSULTATION |
| Micropigmentarea – cea mai bună modalitate de a vă transforma | Micropigmentation – the best way to transform your look |
| Solicitați o consultație gratuită | Get a free consultation |
| Articolele noastre | Our articles |
| Micropigmentare Bucuresti Studio Lbar (home H1, TV title-banner of page 1) | Permanent makeup Bucharest LBar Studio |
| Rezultate naturale. Eleganță care rămâne. | Natural results. Elegance that lasts. |
| Servicii Lbar Studio | LBar Studio services |

## Checking your work
Before finishing, run a quick self-check in Python over each output file: JSON loads; key sets equal to the input; MIGX row
counts/keys equal; for every HTML string the sequence of tag names (regex `</?([a-zA-Z0-9]+)`) equals the input's; all `href="…"` and
`src="…"` values equal the input's; no Romanian diacritics (`ăâîșțşţĂÂÎȘȚ`) left except in `Strada Polonă 92`, `Aliona Șubcinskaia`
and other proper names. Fix anything that fails.
