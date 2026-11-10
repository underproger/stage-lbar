-- step62: курс «Curs complet micropigmentare» — английская версия 1182 (/en/complete-micropigmentation-course, шаблон 15 «Обучение»,
-- старый дизайн с новыми шапкой и подвалом, как RO 182); старые чанки шаблона 15 — под EN (alt, сообщения форм, галерея RO-двойника);
-- окно цены курса: подзаголовок и кнопка выводили ключи словаря (опечатки в чанках) — исправлено для всех языков.
-- Сгенерировано _dev/tools/en_course.py (перевод — _dev/en/tr/182.json). Повторный запуск безопасен (EN-строки и TV пересоздаются).
SET NAMES utf8mb4;

DELETE FROM Impulse_Digital_X_site_tmplvar_contentvalues WHERE contentid = 1182;
DELETE FROM Impulse_Digital_X_site_content WHERE id = 1182 AND context_key = 'en';
INSERT INTO Impulse_Digital_X_site_content (`id`, `type`, `contentType`, `pagetitle`, `longtitle`, `description`, `alias`, `link_attributes`, `published`, `pub_date`, `unpub_date`, `parent`, `isfolder`, `introtext`, `content`, `richtext`, `template`, `menuindex`, `searchable`, `cacheable`, `createdby`, `createdon`, `editedby`, `editedon`, `deleted`, `deletedon`, `deletedby`, `publishedon`, `publishedby`, `menutitle`, `donthit`, `privateweb`, `privatemgr`, `content_dispo`, `hidemenu`, `class_key`, `context_key`, `content_type`, `uri`, `uri_override`, `hide_children_in_tree`, `show_in_tree`, `properties`, `alias_visible`) VALUES (1182, 'document', 'text/html', 'Complete micropigmentation course in Bucharest', 'Complete micropigmentation course in Bucharest ᐈ Studio LBar', 'Complete micropigmentation course in Bucharest at Studio LBar ➝ 6 intensive days ✔ Affordable prices ✎ Full PMU course for beginners ☝ A well-designed program', 'complete-micropigmentation-course', '', 1, 0, 0, 0, 0, '', '', 1, 15, 3, 1, 1, 1, UNIX_TIMESTAMP(), 1, UNIX_TIMESTAMP(), 0, 1653660657, 1, UNIX_TIMESTAMP(), 1, 'Course', 0, 0, 0, 0, 0, 'modDocument', 'en', 1, 'complete-micropigmentation-course', 0, 0, 1, '{\"ms2gallery\":{\"media_source\":\"2\"}}', 1);
INSERT INTO Impulse_Digital_X_site_tmplvar_contentvalues (tmplvarid, contentid, value) VALUES
  (22, 1182, '6dbrovi-min.jpg'),
  (35, 1182, 'Complete micropigmentation course'),
  (160, 1182, 'Complete micropigmentation course in Bucharest'),
  (161, 1182, 'LBar School'),
  (162, 1182, 'Take a basic semi-permanent makeup course and become a professional, well-paid PMU artist in just 6 days'),
  (163, 1182, 'Master Trainer with over 10 years of experience and more than 6,000 procedures'),
  (164, 1182, 'Over 400 successful artists have graduated from the course'),
  (165, 1182, 'Our own high-performance permanent makeup methodology'),
  (166, 1182, 'Unlimited online support for students'),
  (167, 1182, '8 <span class=\"gold-word\">reasons</span> to take a permanent makeup course'),
  (168, 1182, 'Steadily growing demand for cosmetic tattoo services worldwide'),
  (169, 1182, 'An intensive 6-day course with hands-on practice on live models'),
  (170, 1182, 'Opportunities for continuous professional and personal growth'),
  (171, 1182, 'Be your own boss and set your own working hours'),
  (172, 1182, 'The freedom to work in any country'),
  (173, 1182, 'No specialized medical training required'),
  (174, 1182, 'A real chance to earn a high income'),
  (175, 1182, 'A small initial investment that pays off quickly'),
  (176, 1182, 'Nice to meet you! Your trainer is <span class=\"gold-word\">Ksenia Kobilianskaia</span>'),
  (177, 1182, 'Over 6,000 procedures performed with a variety of techniques, equipment and pigments'),
  (178, 1182, '400+ satisfied, successful students working all over the world'),
  (179, 1182, 'Founder of the “Lbar” micropigmentation and laser tattoo removal studio in Bucharest'),
  (180, 1182, 'International-level Master Trainer and author of a unique micropigmentation training method'),
  (181, 1182, 'Attends all the conferences and masterclasses held by top PMU specialists'),
  (182, 1182, 'What the <span class=\"gold-word\">LBar</span> semi-permanent makeup school offers:'),
  (183, 1182, 'A unique program based on our own methodology'),
  (184, 1182, 'An extensive program with intensive hands-on practice on latex practice skin and on live models provided by the school'),
  (185, 1182, 'State-of-the-art equipment and materials'),
  (186, 1182, 'The equipment and supplies used during the training are included in the course price'),
  (187, 1182, 'Working through your own fears and doubts'),
  (188, 1182, 'You will overcome the fear of “causing pain”, gain confidence as a PMU artist and create beautiful tattoos on any area of the body'),
  (189, 1182, 'Training and nothing else'),
  (190, 1182, 'Every day, from morning till evening, every minute is devoted to the semi-permanent makeup course, with no distractions'),
  (191, 1182, 'Useful, detailed theory'),
  (192, 1182, 'You will study the theory and the fundamentals without which no tattooing technique can be performed. We guarantee the most detailed theory'),
  (193, 1182, 'From beginner to professional'),
  (194, 1182, 'Even if you have never tried tattooing but want to become an artist, we will help you achieve excellent results'),
  (195, 1182, '2 qualification certificates'),
  (196, 1182, 'Marketing training'),
  (197, 1182, 'that let you work anywhere in the world'),
  (198, 1182, 'to help you successfully promote your services online'),
  (199, 1182, 'Photo gallery: <span class=\"gold-word\">the training process</span>'),
  (200, 1182, 'The <span class=\"gold-word\">micropigmentation <br>course</br></span> program at the LBar school'),
  (201, 1182, '[{\"MIGX_id\":\"1\",\"questions-title\":\"Day 1.\",\"questions-time\":\"\",\"questions-text\":\"<p>Theory module:<\\/p>\\n<ul>\\n<li>1. Detailed information about semi-permanent makeup and contraindications.<\\/li>\\n<li>2. How to monetize tattooing and the income you can expect.<\\/li>\\n<li>3. Overview of the working equipment: machines, needles, different needle types and how they differ.<\\/li>\\n<li>4. Pigments: preferred colors, composition, basic coloring principles, rules for blending shades.<\\/li>\\n<li>5. Organizing and preparing your workstation, the supplies you need, disinfection and hygiene.<\\/li>\\n<li>6. Using anesthetics: types, duration of action, when to apply them.<\\/li>\\n<li>7. Skin structure, pigment insertion depth, possible shades after healing.<\\/li>\\n<li>8. Skin aftercare and epidermis regeneration.<\\/li>\\n<li>9. Key points of a touch-up and why it matters.<\\/li>\\n<li>10. Overview of the main micropigmentation techniques.<\\/li>\\n<\\/ul>\\n<p>Practical module:<\\/p>\\n<ul>\\n<li>1.Practicing shading and stroke techniques.<\\/li>\\n<\\/ul>\"},{\"MIGX_id\":\"2\",\"questions-title\":\"Day 2.\",\"questions-time\":\"\",\"questions-text\":\"<p>Theory module:<\\/p>\\n<ul>\\n<li>1. Color theory: choosing the pigment shade for each area, color exposure and shade brightness.<\\/li>\\n<li>2. Overview of the best-known pigment brands.<\\/li>\\n<li>3. Psychological aspects of the artist\'s work, dealing with fears.<\\/li>\\n<li>4. Description and analysis of common mistakes.<\\/li>\\n<\\/ul>\\n<p>Practical module:<\\/p>\\n<ul>\\n<li>1. Going over the questions students asked during the theory part.<\\/li>\\n<li>2. Practicing the skills on paper.<\\/li>\\n<li>3. The practical part on latex practice skin.<\\/li>\\n<li>4. Learning the brow mapping technique.<\\/li>\\n<li>5. Learning pigmentation and shading methods.<\\/li>\\n<li>6. \\u201cPowder brows\\u201d masterclass by the master trainer.<\\/li>\\n<\\/ul>\"},{\"MIGX_id\":\"3\",\"questions-title\":\"Day 3. Learning the powder brows technique\",\"questions-time\":\"\",\"questions-text\":\"<p>Theory module:<\\/p>\\n<ul>\\n<li>1. Aquarelle lips and the specifics of the technique.<\\/li>\\n<li>2. How the ombr\\u00e9 lips technique is performed.<\\/li>\\n<li>3. Rules for choosing pigment colors.<\\/li>\\n<\\/ul>\\n<p>Practical module:<\\/p>\\n<ul>\\n<li>1. Applying the technique on three live models.<\\/li>\\n<li>2. Analysis of the result.<\\/li>\\n<\\/ul>\"},{\"MIGX_id\":\"4\",\"questions-title\":\"Day 4. Learning aquarelle lip micropigmentation\",\"questions-time\":\"\",\"questions-text\":\"<p>Theory module:<\\/p>\\n<ul>\\n<li>1. Aquarelle lips and the specifics of the technique.<\\/li>\\n<li>2. How the ombr\\u00e9 lips technique is performed.<\\/li>\\n<li>3. Rules for choosing pigment colors.<\\/li>\\n<\\/ul>\\n<p>Practical module:<\\/p>\\n<ul>\\n<li>1. Applying the technique on three live models.<\\/li>\\n<li>2. Analysis of the result.<\\/li>\\n<\\/ul>\"},{\"MIGX_id\":\"5\",\"questions-title\":\"Day 5. Learning eyelid micropigmentation\",\"questions-time\":\"\",\"questions-text\":\"<p>Theory module:<\\/p>\\n<ul>\\n<li>1. Eyelid permanent makeup and the specifics of the technique.<\\/li>\\n<li>2. Theory of how the procedure is performed and how to keep it safe.<\\/li>\\n<\\/ul>\\n<p>Practical module:<\\/p>\\n<ul>\\n<li>1.Applying the technique on three live models: classic upper\\/lower lash line micropigmentation and eyelid permanent makeup with shading.<\\/li>\\n<\\/ul>\"},{\"MIGX_id\":\"6\",\"questions-title\":\"Day 6. Business marketing module\",\"questions-time\":\"\",\"questions-text\":\"<ul>\\n<li>1. Advertising micropigmentation services on popular social networks, creating paid ads on Instagram and Facebook.<\\/li>\\n<li>2. Effective tips on managing and running social media ad accounts.<\\/li>\\n<li>3. Advice on competitive advantages.<\\/li>\\n<li>4. Building a portfolio: tips for quality photos and choosing lighting.<\\/li>\\n<li>5. How to communicate with potential clients and turn them into loyal ones.<\\/li>\\n<li>6. Answers to relevant questions.<\\/li>\\n<li>7. Graduation ceremony: certificates and a celebratory meal.<\\/li>\\n<\\/ul>\"},{\"MIGX_id\":\"7\",\"questions-title\":\"Bonus from the LBar semi-permanent makeup school <svg width=\\\"25\\\" height=\\\"24\\\" viewBox=\\\"0 0 25 24\\\" fill=\\\"none\\\" xmlns=\\\"http:\\/\\/www.w3.org\\/2000\\/svg\\\">                             <path d=\\\"M23 12.0999H1V7.4998C1 7.0998 1.79995 7.19951 2.19995 7.19951H22.7C23.1 7.19951 23 7.0998 23 7.4998V12.0999Z\\\" stroke=\\\"#BF8069\\\" stroke-width=\\\"2\\\" stroke-miterlimit=\\\"10\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\"\\/>                             <path d=\\\"M21.7 22.8999H3.19995C2.79995 22.8999 2 22.0997 2 21.6997V12.1001H22V21.6997C22 22.0997 22.1 22.8999 21.7 22.8999Z\\\" stroke=\\\"#BF8069\\\" stroke-width=\\\"2\\\" stroke-miterlimit=\\\"10\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\"\\/>                             <path d=\\\"M12 6.19971V22.8999\\\" stroke=\\\"#BF8069\\\" stroke-width=\\\"2\\\" stroke-miterlimit=\\\"10\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\"\\/>                             <path d=\\\"M7.5 6.7998C7.5 6.7998 4.5 5.6 4.5 3.5C4.5 1.3 6.2 1 7 1C8.7 1 10.5 1.8999 12.5 6.8999\\\" stroke=\\\"#BF8069\\\" stroke-width=\\\"2\\\" stroke-miterlimit=\\\"10\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\"\\/>                             <path d=\\\"M17.3999 6.7998C17.3999 6.7998 20.3999 5.6 20.3999 3.5C20.3999 1.3 18.6999 1 17.8999 1C16.1999 1 14.3999 1.8999 12.3999 6.8999\\\" stroke=\\\"#BF8069\\\" stroke-width=\\\"2\\\" stroke-miterlimit=\\\"10\\\" stroke-linecap=\\\"round\\\" stroke-linejoin=\\\"round\\\"\\/>                         <\\/svg>\",\"questions-time\":\"\",\"questions-text\":\"<p>Every student who pays in advance gets a free, complete theory module that will be covered during the semi-permanent makeup course. By studying it beforehand, you can go deeper into the theory and spend more time on practice.<\\/p>\"}]'),
  (202, 1182, 'Free <span class=\"gold-word\">webinar with the master trainer</span> of Studio LBar'),
  (203, 1182, 'A free masterclass to help you learn a new profession'),
  (204, 1182, '<p>Sign up for the masterclass and join the webinar to get to know the profession better and decide whether you are ready to work in this field. During the free webinar, the trainer will explain the pros and cons of the profession and the equipment and supplies used in the procedure, and at the end of the online session will answer all your questions.</p>'),
  (205, 1182, 'Webinars held regularly'),
  (206, 1182, 'Watch from anywhere in the world'),
  (207, 1182, 'Unlimited number of participants'),
  (208, 1182, 'See <span class=\"gold-word\">what kinds of tattoos</span> you will <br>be able to do after the course</br>'),
  (209, 1182, 'Prices for the <span class=\"gold-word\">micropigmentation course</span> at the LBar semi-permanent makeup school'),
  (210, 1182, 'The basic course price includes everything you need to complete it. All you have to do is get involved and work hard'),
  (211, 1182, 'Basic'),
  (212, 1182, 'THREE AREAS'),
  (213, 1182, 'group of 2–3 people'),
  (214, 1182, 'up to 10 models each'),
  (215, 1182, '1800 €'),
  (216, 1182, '2900 €'),
  (217, 1182, 'Basic'),
  (218, 1182, 'INDIVIDUAL'),
  (219, 1182, 'Three areas, one-to-one training'),
  (220, 1182, 'up to 12 models '),
  (221, 1182, '3000 €'),
  (223, 1182, 'Basic'),
  (224, 1182, 'POWDER BROWS'),
  (225, 1182, 'up to 4 models each'),
  (226, 1182, 'group of 1 person'),
  (227, 1182, '1500 €'),
  (228, 1182, '2500 €'),
  (229, 1182, 'A gift from us: a <span class=\"gold-word\">semi-permanent eyebrow makeup kit</span>'),
  (230, 1182, 'Premium-quality pigment in your preferred colors'),
  (231, 1182, 'Pigment rings, set of 10'),
  (232, 1182, 'Brow mapping kit'),
  (233, 1182, 'Disposable needles, set of 10'),
  (234, 1182, 'Latex practice skin'),
  (235, 1182, 'Tweezers or a brow trimmer'),
  (236, 1182, 'We don\'t recommend taking the <span class=\"gold-word\">micropigmentation course</span> if you think:'),
  (237, 1182, 'Calculate <span class=\"gold-word\">how much you could earn</span> after training at LBar'),
  (238, 1182, '“I just want a diploma to show off”'),
  (239, 1182, '“I\'m already a PMU artist, I just need more clients”'),
  (240, 1182, '“I know better than you, I just came to see how the course is run”'),
  (241, 1182, 'We will not issue a certificate if we see that you are not ready for a heavy workload, are careless about the course or are not engaged at all.'),
  (242, 1182, 'We don\'t offer a “magic pill” for building a steady flow of clients. But we guarantee that we will do our best to pass on all our experience and knowledge, so that you can use them in your professional work and grow your client base day by day.'),
  (243, 1182, 'We sincerely hope you are an experienced artist who really knows how to do a tattoo well. But our courses are attended by students from all kinds of backgrounds, including beginners. That is why we expect maximum effort, perseverance and a passion for learning from every student, so that we can pass on what matters and teach you everything you need.'),
  (244, 1182, 'Get <span class=\"gold-word\">a free consultation</span> with the LBar school master trainer right now'),
  (245, 1182, 'and you will see that taking the micropigmentation course at our school is the best choice'),
  (249, 1182, 'Installment or interest-free payment plans from 2 months to 2 years'),
  (250, 1182, 'Answers to frequently asked questions'),
  (251, 1182, '[{\"MIGX_id\":\"1\",\"questions-title-bl15\":\"Can I buy supplies from the school after the course?\",\"questions-text-bl15\":\"<p>Yes, basic supplies are available for sale. At the school you can buy a permanent makeup machine, pigments and additional supplies. However, you are under no obligation to buy anything from us. You can buy your starter equipment wherever is convenient for you.<\\/p>\"},{\"MIGX_id\":\"2\",\"questions-title-bl15\":\"Do I need a medical education or training?\",\"questions-text-bl15\":\"<p dir=\\\"ltr\\\"><span>It is not required. A permanent makeup artist can work without a medical background. However, it will be an advantage for your future work.<\\/span><\\/p>\"},{\"MIGX_id\":\"3\",\"questions-title-bl15\":\"What do I need to buy for the eyebrow micropigmentation course?\",\"questions-text-bl15\":\"<p>Nothing. Our school provides everything you need.<\\/p>\"},{\"MIGX_id\":\"4\",\"questions-title-bl15\":\"I\'m already an artist. Can this micropigmentation and microblading course be useful to me?\",\"questions-text-bl15\":\"<p>There is always room to improve your skills and learn modern techniques. We offer training in powder brows, upper\\/lower lash line tattooing and aquarelle lips.<\\/p>\\n<p>\\u00a0<\\/p>\"}]'),
  (252, 1182, 'Basic semi-permanent makeup course – a unique chance to learn a <span class=\"gold-word\">creative profession</span> that pays well'),
  (254, 1182, 'A career as a PMU artist has clear advantages. You can earn several times your current salary while setting your own schedule. We guarantee that we will pass on all our knowledge and skills, which we have built into a unique, proprietary permanent makeup methodology'),
  (256, 1182, 'We assure you'),
  (257, 1182, 'Interesting work'),
  (258, 1182, 'that your investment will pay for itself several times over within the first few months.'),
  (259, 1182, 'with stable earnings and professional growth.'),
  (260, 1182, 'There are many tattoo schools in Bucharest. <br><span class=\"gold-word\">But LBar is the best choice</span></br>'),
  (261, 1182, 'We never promise anything we are not sure of. Our main goal is to give every student the core knowledge that will take them from complete beginner to TOP trainer and let them practice wherever they want.'),
  (262, 1182, '[{\"MIGX_id\":\"1\",\"advantages-title\":\"We don\'t limit your choice. You can train in one, two or three areas. Together we will look at your preferences and suggest the most effective option.\"},{\"MIGX_id\":\"2\",\"advantages-title\":\"We have developed a unique program that balances theory and practice, so we can cover all the information and fully put it into practice in the hands-on sessions.\"},{\"MIGX_id\":\"3\",\"advantages-title\":\"The LBar tattoo school has been running since 2018. Hundreds of our graduates have become successful artists. We can find an individual approach to every student.\"},{\"MIGX_id\":\"4\",\"advantages-title\":\"We provide absolutely everything you need for the training: from a notebook and pen to a well-organized workstation. You will work with professional equipment.\"},{\"MIGX_id\":\"5\",\"advantages-title\":\"Your trainer will always be by your side, supervising your work and gently guiding you if any mistakes are noticed. Our goal is to help you produce flawless work.\"},{\"MIGX_id\":\"6\",\"advantages-title\":\"Practical sessions are done on live models provided by the school. You can also invite your loved ones or friends as models.\"},{\"MIGX_id\":\"7\",\"advantages-title\":\"The training takes place in a friendly, relaxed atmosphere. Nobody will pressure you during the course, but we do expect you to take an active part in the learning process. Work at your best!\"},{\"MIGX_id\":\"8\",\"advantages-title\":\"You will learn how to become a sought-after specialist. We will explain how to work in a highly competitive field and earn more than your competitors.\"}]'),
  (263, 1182, '<p> </p>\r\n<p> </p>'),
  (264, 1182, ' <span class=\"gold-word\">You are one step away from success!</span>'),
  (265, 1182, 'Right after the training, you can start working and making a real profit. Enjoyable work and a decent income will make you even happier.'),
  (266, 1182, '[{\"MIGX_id\":\"4\",\"image\":\"images\\/all\\/obuch1-min (1).jpg\"},{\"MIGX_id\":\"5\",\"image\":\"images\\/all\\/obuch1-min.jpg\"},{\"MIGX_id\":\"6\",\"image\":\"images\\/all\\/obuch2-min.jpg\"},{\"MIGX_id\":\"7\",\"image\":\"images\\/all\\/obuch4-min.jpg\"},{\"MIGX_id\":\"8\",\"image\":\"images\\/all\\/obuch5-min.jpg\"},{\"MIGX_id\":\"9\",\"image\":\"images\\/all\\/obuch6-min.jpg\"},{\"MIGX_id\":\"10\",\"image\":\"images\\/all\\/obuch7-min.jpg\"},{\"MIGX_id\":\"11\",\"image\":\"images\\/all\\/obuch8-min.jpg\"},{\"MIGX_id\":\"12\",\"image\":\"images\\/all\\/obuch9-min.jpg\"}]');

UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = CONCAT(REPLACE(value, ';en:1182', ''), ';en:1182') WHERE tmplvarid = 304 AND contentid IN (182, 295);
INSERT INTO Impulse_Digital_X_site_tmplvar_contentvalues (tmplvarid, contentid, value) SELECT 304, 1182, value FROM Impulse_Digital_X_site_tmplvar_contentvalues WHERE tmplvarid = 304 AND contentid = 182;

-- подвал EN-главной (TV foot-link-l у 1001): + Training (у RO — последний пункт «Training» → curs-complet-micropigmentare)
UPDATE Impulse_Digital_X_site_tmplvar_contentvalues SET value = CONCAT(value, '\n<p><a href="/en/complete-micropigmentation-course">Training</a></p>') WHERE tmplvarid = (SELECT id FROM Impulse_Digital_X_site_tmplvars WHERE name = 'foot-link-l') AND contentid = 1001 AND value NOT LIKE '%/en/complete-micropigmentation-course%';

-- banner-study: фото тренера — alt по-английски; сообщения формы
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(REPLACE(REPLACE(snippet, 'alt=\"Ксения Кобылянская\"', 'alt=\"{if $_modx->config.cultureKey == \'en\'}Ksenia Kobilianskaia{else}Ксения Кобылянская{/if}\"'), '&validationErrorMessage=`Пожалуйста, заполните обязательные поля*`', '&validationErrorMessage=`[[++cultureKey:is=`en`:then=`Please fill in the required fields*`:else=`Пожалуйста, заполните обязательные поля*`]]`'), '&successMessage=`Ваше сообщение было успешно отправлено!`', '&successMessage=`[[++cultureKey:is=`en`:then=`Your message has been sent successfully!`:else=`Ваше сообщение было успешно отправлено!`]]`') WHERE name = 'banner-study' AND snippet NOT LIKE '%Ksenia Kobilianskaia%';

-- bl2-study-trener: то же
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(REPLACE(REPLACE(snippet, 'alt=\"Ксения Кобылянская\"', 'alt=\"{if $_modx->config.cultureKey == \'en\'}Ksenia Kobilianskaia{else}Ксения Кобылянская{/if}\"'), '&validationErrorMessage=`Пожалуйста, заполните обязательные поля*`', '&validationErrorMessage=`[[++cultureKey:is=`en`:then=`Please fill in the required fields*`:else=`Пожалуйста, заполните обязательные поля*`]]`'), '&successMessage=`Ваше сообщение было успешно отправлено!`', '&successMessage=`[[++cultureKey:is=`en`:then=`Your message has been sent successfully!`:else=`Ваше сообщение было успешно отправлено!`]]`') WHERE name = 'bl2-study-trener' AND snippet NOT LIKE '%Ksenia Kobilianskaia%';

-- bl10-study-info: alt картинки
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(snippet, 'alt=\"Вам не нужно проходить обучение, если', 'alt=\"{if $_modx->config.cultureKey == \'en\'}You should not take the course if{else}Вам не нужно проходить обучение, если{/if}') WHERE name = 'bl10-study-info' AND snippet NOT LIKE '%You should not take%';

-- bl11-study-calculator: сообщения формы
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(REPLACE(snippet, '&validationErrorMessage=`Пожалуйста, заполните обязательные поля*`', '&validationErrorMessage=`[[++cultureKey:is=`en`:then=`Please fill in the required fields*`:else=`Пожалуйста, заполните обязательные поля*`]]`'), '&successMessage=`Ваше сообщение было успешно отправлено!`', '&successMessage=`[[++cultureKey:is=`en`:then=`Your message has been sent successfully!`:else=`Ваше сообщение было успешно отправлено!`]]`') WHERE name = 'bl11-study-calculator' AND snippet NOT LIKE '%Please fill in%';

-- bl12-study-form: сообщения формы
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(REPLACE(snippet, '&validationErrorMessage=`Пожалуйста, заполните обязательные поля*`', '&validationErrorMessage=`[[++cultureKey:is=`en`:then=`Please fill in the required fields*`:else=`Пожалуйста, заполните обязательные поля*`]]`'), '&successMessage=`Ваше сообщение было успешно отправлено!`', '&successMessage=`[[++cultureKey:is=`en`:then=`Your message has been sent successfully!`:else=`Ваше сообщение было успешно отправлено!`]]`') WHERE name = 'bl12-study-form' AND snippet NOT LIKE '%Please fill in%';

-- bl18-study-succsess: сообщения формы
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(REPLACE(snippet, '&validationErrorMessage=`Пожалуйста, заполните обязательные поля*`', '&validationErrorMessage=`[[++cultureKey:is=`en`:then=`Please fill in the required fields*`:else=`Пожалуйста, заполните обязательные поля*`]]`'), '&successMessage=`Ваше сообщение было успешно отправлено!`', '&successMessage=`[[++cultureKey:is=`en`:then=`Your message has been sent successfully!`:else=`Ваше сообщение было успешно отправлено!`]]`') WHERE name = 'bl18-study-succsess' AND snippet NOT LIKE '%Please fill in%';

-- bl8-study-price: сообщения форм; подзаголовок окна первого тарифа: опечатка в ключе словаря (выводился сам ключ) — для всех языков
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(REPLACE(REPLACE(snippet, '&validationErrorMessage=`Пожалуйста, заполните обязательные поля*`', '&validationErrorMessage=`[[++cultureKey:is=`en`:then=`Please fill in the required fields*`:else=`Пожалуйста, заполните обязательные поля*`]]`'), '&successMessage=`Ваше сообщение было успешно отправлено!`', '&successMessage=`[[++cultureKey:is=`en`:then=`Your message has been sent successfully!`:else=`Ваше сообщение было успешно отправлено!`]]`'), '{$_modx->lexicon(\'lbar-study-prices-form=subtitle\')}', '{$_modx->lexicon(\'lbar-study-prices-form-subtitle\')}') WHERE name = 'bl8-study-price' AND snippet NOT LIKE '%Please fill in%';

-- bl7-study-portfolio: фото — ресурса lb.roId (у EN — RO-двойник; у RO / RU — сам ресурс, как было)
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(snippet, '[[!ms2Gallery?\n', '{set $roid = $_modx->getChunk(\'lb.roId\') | trim}[[!ms2Gallery?\n                &resources=`{$roid}`\n') WHERE name = 'bl7-study-portfolio' AND snippet NOT LIKE '%lb.roId%';

-- tpl.Form.Study.Modal.BL8: кнопка окна цены курса: ключа lbar.study.prices.btn нет в словаре (выводился сам ключ) — общий ключ кнопки тарифов, для всех языков
UPDATE Impulse_Digital_X_site_htmlsnippets SET snippet = REPLACE(snippet, '{$_modx->lexicon(\"lbar.study.prices.btn\")}', '{$_modx->lexicon(\"lbar-study-prices-btn\")}') WHERE name = 'tpl.Form.Study.Modal.BL8' AND snippet NOT LIKE '%lbar-study-prices-btn%';

