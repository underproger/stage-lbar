/* LBAR — редизайн: шапка, мобильное меню, баннер. Без зависимостей от jQuery; GSAP — опционально. */
(function () {
	'use strict';

	var doc = document.documentElement;
	var header = document.querySelector('.lb-header');
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var isDesktop = function () { return window.matchMedia('(min-width: 1025px)').matches; };

	/* ---------- Шапка: состояние после прокрутки ---------- */
	if (header) {
		var onScroll = function () {
			header.classList.toggle('is-scrolled', window.pageYOffset > 20);
		};
		onScroll();
		window.addEventListener('scroll', onScroll, { passive: true });
	}

	/* ---------- Мобильное меню ---------- */
	var burger = document.querySelector('.lb-header__burger');
	if (burger) {
		var setMenu = function (open) {
			doc.classList.toggle('is-menu-open', open);
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
		};
		burger.addEventListener('click', function () {
			setMenu(!doc.classList.contains('is-menu-open'));
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') setMenu(false);
		});
		window.addEventListener('resize', function () {
			if (isDesktop()) setMenu(false);
		});
		document.querySelectorAll('.lb-mnav a').forEach(function (a) {
			a.addEventListener('click', function () { setMenu(false); });
		});
	}
	document.querySelectorAll('.lb-nav__toggle').forEach(function (btn) {
		btn.addEventListener('click', function (e) {
			e.preventDefault();
			var li = btn.parentNode;
			var open = !li.classList.contains('is-open');
			li.classList.toggle('is-open', open);
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	});

	/* ---------- Плавный скролл к якорям на этой странице ---------- */
	var scrollToEl = function (el) {
		var offset = header ? header.offsetHeight : 0;
		var y = el.getBoundingClientRect().top + window.pageYOffset - offset - 10;
		window.scrollTo({ top: y, behavior: reduce ? 'auto' : 'smooth' });
	};
	// Слушаем на фазе перехвата: старый custom.js («Jacor») вешает на все a[href^="#"] свой jQuery-скролл без учёта
	// фиксированной шапки — для ссылок новых блоков он не должен срабатывать (stopPropagation до цели).
	var anchorSel = '.lb-header a[href^="#"], .lb-hero a[href^="#"], .lb-about a[href^="#"], .lb-implica a[href^="#"], .lb-price a[href^="#"]';
	document.addEventListener('click', function (e) {
		var a = e.target.closest && e.target.closest(anchorSel);
		if (!a) return;
		var id = a.getAttribute('href').slice(1);
		var target = id && document.getElementById(id);
		// событие дальше не идёт — мобильное меню закрываем здесь
		if (burger && a.closest('.lb-mnav')) {
			doc.classList.remove('is-menu-open');
			burger.setAttribute('aria-expanded', 'false');
		}
		if (target) {
			e.preventDefault();
			e.stopPropagation();
			scrollToEl(target);
			return;
		}
		// формы записи нет на странице — открываем попап «Заказать звонок» из футера
		if (a.classList.contains('js-lb-book')) {
			var modalBtn = document.querySelector('.footer .btn-mobal, footer .btn-mobal, .btn-mobal');
			if (modalBtn) {
				e.preventDefault();
				e.stopPropagation();
				modalBtn.click();
			}
		}
	}, true);

	/* ---------- «Читать далее» (текст свёрнут до 3 строк): блоки «О микропигментации» и «Цены» ---------- */
	var initClamp = function (wrapSel, textSel, btnSel) {
		document.querySelectorAll(wrapSel).forEach(function (wrap) {
			var text = wrap.querySelector(textSel);
			var btn = wrap.querySelector(btnSel);
			if (!text || !btn) return;
			var check = function () {
				if (wrap.classList.contains('is-open')) return;
				var clamped = parseFloat(getComputedStyle(text).maxHeight) || 0;
				wrap.classList.toggle('is-short', text.scrollHeight <= clamped + 2);
			};
			check();
			window.addEventListener('resize', check);
			if (document.fonts && document.fonts.ready) document.fonts.ready.then(check);
			btn.addEventListener('click', function () {
				var open = !wrap.classList.contains('is-open');
				if (open) {
					text.style.maxHeight = text.scrollHeight + 'px';
					wrap.classList.add('is-open');
				} else {
					text.style.maxHeight = '';
					wrap.classList.remove('is-open');
					var top = wrap.getBoundingClientRect().top;
					if (top < 0) window.scrollBy({ top: top - 120, behavior: reduce ? 'auto' : 'smooth' });
				}
				btn.setAttribute('aria-expanded', open ? 'true' : 'false');
				if (window.ScrollTrigger) setTimeout(function () { window.ScrollTrigger.refresh(); }, 850);
			});
		});
	};
	initClamp('.lb-about__textwrap', '.lb-about__text', '.lb-about__more');
	initClamp('.lb-price__textwrap', '.lb-price__text', '.lb-price__more');

	/* ---------- Блок «implică»: точки на дуге ----------
	   Дуга — окружность (586, 603), r = 435 в координатах макета 1920. Точку ставим на дугу
	   по фактической высоте карточки (у RU-текстов карточки выше, чем в макете). */
	var implica = document.querySelector('.lb-implica');
	if (implica) {
		var ARC = { cx: 586, cy: 603, r: 435 };
		var placeDots = function () {
			var k = implica.offsetWidth / 1920;
			implica.classList.toggle('is-tall', isDesktop() && implica.offsetHeight > 1080 * k + 4);
			if (!isDesktop()) return;
			var col = implica.querySelector('.lb-implica__col');
			// offset* — без учёта transform (карточки в этот момент могут анимироваться)
			implica.querySelectorAll('.lb-implica__item').forEach(function (item) {
				var dot = item.querySelector('.lb-implica__dot');
				if (!dot) return;
				var left = col.offsetLeft + item.offsetLeft;
				var y = (col.offsetTop + item.offsetTop + dot.offsetTop + dot.offsetHeight / 2) / k;
				var dy = Math.max(-ARC.r, Math.min(ARC.r, y - ARC.cy));
				var x = ARC.cx + Math.sqrt(ARC.r * ARC.r - dy * dy);
				item.style.setProperty('--dot-x', (x * k - left) + 'px');
			});
		};
		placeDots();
		window.addEventListener('resize', placeDots);
		window.addEventListener('load', placeDots);
		if (document.fonts && document.fonts.ready) document.fonts.ready.then(placeDots);
	}

	/* ---------- Блоки с формой («Консультация», «Запись на процедуру»): поле телефона (intlTelInput) ----------
	   Библиотека считает отступ текста от кода страны один раз — при смене ширины экрана (размеры в vw) пересчитываем. */
	var formBlocks = [].slice.call(document.querySelectorAll('.lb-consult, .lb-book'));
	var tels = formBlocks.map(function (sec) { return sec.querySelector('input[name="phone"]'); }).filter(Boolean);
	if (tels.length) {
		var itiTimer;
		window.addEventListener('resize', function () {
			clearTimeout(itiTimer);
			itiTimer = setTimeout(function () {
				tels.forEach(function (tel) {
					var iti = window.intlTelInputGlobals && window.intlTelInputGlobals.getInstance(tel);
					var data = iti && iti.getSelectedCountryData();
					if (data && data.iso2) iti.setCountry(data.iso2);
				});
			}, 150);
		});
	}

	/* ---------- Галерея: «Смотреть все работы» раскрывает остальные фото ---------- */
	document.querySelectorAll('.lb-portfolio').forEach(function (sec) {
		var grid = sec.querySelector('.lb-gallery');
		var btn = sec.querySelector('.lb-portfolio__more');
		var foot = sec.querySelector('.lb-portfolio__foot');
		if (!grid || !btn) return;
		var more = grid.querySelectorAll('.lb-gallery__item--more');
		if (!more.length) { if (foot) foot.classList.add('is-hidden'); return; }
		btn.addEventListener('click', function () {
			var open = !grid.classList.contains('is-open');
			var shown = [].filter.call(grid.children, function (el) { return getComputedStyle(el).display === 'none'; });
			grid.classList.toggle('is-open', open);
			sec.classList.toggle('is-open', open);
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			if (open && !reduce && window.gsap) {
				window.gsap.from(shown, { y: 40, opacity: 0, duration: 1, stagger: 0.035, ease: 'expo.out', clearProps: 'transform,opacity' });
			}
			if (!open) {
				var top = grid.getBoundingClientRect().top;
				if (top < 0) window.scrollBy({ top: top - 140, behavior: reduce ? 'auto' : 'smooth' });
			}
			if (window.ScrollTrigger) window.ScrollTrigger.refresh();
		});
	});

	/* ---------- Появление блоков при прокрутке ---------- */
	var initReveal = function () {
		if (reduce || typeof window.gsap === 'undefined' || !window.ScrollTrigger) return;
		var gsap = window.gsap;
		gsap.registerPlugin(window.ScrollTrigger);
		var about = document.querySelector('.lb-about');
		if (about) {
			var tl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: about, start: 'top 72%' } });
			tl.from(about.querySelector('.lb-about__bg'), { opacity: 0, y: 40, duration: 1.6, ease: 'power3.out', clearProps: 'transform' }, 0)
				.from(about.querySelectorAll('.lb-about__eyebrow, .lb-about__t1, .lb-about__t2, .lb-about__textwrap'), { y: 40, opacity: 0, duration: 1.3, stagger: 0.1, clearProps: 'transform' }, 0.15)
				.from(about.querySelectorAll('.lb-about__item'), { x: -30, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 0.5)
				.from(about.querySelectorAll('.lb-about__quote, .lb-about__cta'), { y: 30, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 0.8);
		}
		var price = document.querySelector('.lb-price');
		if (price) {
			var pq = function (s) { return price.querySelectorAll(s); };
			var pdesk = isDesktop();
			var ptl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: price, start: 'top 70%' } });
			ptl.from(pq('.lb-price__lin'), { yPercent: 105, duration: 1.5, stagger: 0.12 }, 0)
				.from(pq('.lb-price__cta'), { y: 26, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.5);
			// вводного текста может не быть (пустой TV table-bl7, напр. в RU)
			if (pq('.lb-price__textwrap').length) ptl.from(pq('.lb-price__textwrap'), { x: pdesk ? 40 : 0, y: pdesk ? 0 : 24, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0.15);
			ptl.from(pq('.lb-price__card'), { y: 70, opacity: 0, duration: 1.6, clearProps: 'transform' }, 0.3)
				.from(pq('.lb-ptable__row'), { x: pdesk ? 60 : 0, y: pdesk ? 0 : 20, opacity: 0, duration: 1.2, stagger: 0.08, clearProps: 'transform' }, 0.55)
				.from(pq('.lb-ptable__ic svg'), { scale: 0.4, opacity: 0, duration: 1, stagger: 0.08, ease: 'back.out(2)', clearProps: 'transform' }, 0.75);
			// цены «набегают» от нуля (в HTML — итоговые значения)
			pq('.lb-ptable__price').forEach(function (cell, n) {
				var txt = cell.textContent;
				var m = txt.match(/^(\D*)(\d[\d\s\u202f\u00a0]*\d|\d)(.*)$/);
				if (!m) return;
				var val = parseInt(m[2].replace(/\D/g, ''), 10);
				if (!val) return;
				var fmt = function (v) { return m[1] + String(Math.round(v)).replace(/\B(?=(\d{3})+(?!\d))/g, '\u00a0') + m[3]; };
				var o = { v: 0 };
				ptl.to(o, { v: val, duration: 1.4, ease: 'power3.out', onStart: function () { cell.textContent = fmt(0); }, onUpdate: function () { cell.textContent = fmt(o.v); }, onComplete: function () { cell.textContent = txt; } }, 0.7 + n * 0.08);
			});
		}
		// блоки с формой: «Консультация» (.lb-consult) и «Запись на процедуру» (.lb-book) — одинаковая анимация
		formBlocks.forEach(function (sec) {
			var b = sec.classList.contains('lb-book') ? 'lb-book' : 'lb-consult';
			var ctl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: sec, start: 'top 72%' } });
			var add = function (sel, from, at, to) {
				var els = sec.querySelectorAll(sel);
				if (!els.length) return;
				if (to) ctl.fromTo(els, from, to, at); else ctl.from(els, from, at);
			};
			add('.' + b + '__bg', { opacity: 0, scale: 1.04, duration: 2, ease: 'power3.out', clearProps: 'transform' }, 0);
			add('.' + b + '__eyebrow', { x: -30, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.15);
			add('.' + b + '__lin', { yPercent: 105, duration: 1.5, stagger: 0.12 }, 0.2);
			add('.' + b + '__flourish', { clipPath: 'inset(0% 100% 0% 0%)' }, 0.75, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.6, ease: 'power2.inOut', clearProps: 'clipPath' });
			add('.' + b + '__text', { y: 30, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0.6);
			add('.' + b + '__card', { y: 70, opacity: 0, duration: 1.6, clearProps: 'transform' }, 0.3);
			add('.lb-cform__field, .lb-cform__btn, .lb-cform__policy', { y: 26, opacity: 0, duration: 1.2, stagger: 0.09, clearProps: 'transform' }, 0.6);
		});
		if (implica) {
			var iq = function (s) { return implica.querySelectorAll(s); };
			var arc = implica.querySelector('.lb-implica__arcline');
			var desk = isDesktop();
			var itl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: implica, start: 'top 70%' } });
			itl.from(implica.querySelector('.lb-implica__bg'), { opacity: 0, duration: 1.6, ease: 'power2.out' }, 0)
				.from(implica.querySelector('.lb-implica__bg img'), { scale: 1.06, duration: 2.4, ease: 'power3.out', clearProps: 'transform' }, 0)
				.from(iq('.lb-implica__eyebrow'), { x: -30, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.2)
				.from(iq('.lb-implica__lin'), { yPercent: 105, duration: 1.5, stagger: 0.12 }, 0.25)
				.from(iq('.lb-implica__item'), { x: desk ? 120 : 0, y: desk ? 0 : 30, opacity: 0, duration: 1.4, stagger: 0.16, clearProps: 'transform' }, 0.55)
				.from(iq('.lb-implica__ic svg'), { scale: 0.4, rotation: -25, opacity: 0, duration: 1.2, stagger: 0.16, ease: 'back.out(2)', clearProps: 'transform' }, 0.85)
				.from(iq('.lb-implica__btns > *'), { y: 26, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 1.05);
			if (desk && arc && arc.getTotalLength) {
				var len = arc.getTotalLength();
				gsap.set(arc, { strokeDasharray: len, strokeDashoffset: len });
				itl.to(arc, { strokeDashoffset: 0, duration: 2, ease: 'power2.inOut' }, 0.3)
					.from(iq('.lb-implica__dot'), { scale: 0, duration: 0.9, stagger: 0.32, ease: 'back.out(3)', clearProps: 'transform' }, 0.75);
			}
		}

		var master = document.querySelector('.lb-master');
		if (master) {
			var mq = function (s) { return master.querySelectorAll(s); };
			var mdesk = isDesktop();
			var mtl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: master, start: 'top 70%' } });
			mtl.from(master.querySelector('.lb-master__photo'), { y: mdesk ? 60 : 30, opacity: 0, duration: 1.8, ease: 'power3.out', clearProps: 'transform' }, 0)
				.from(mq('.lb-master__title'), { y: 40, opacity: 0, duration: 1.4, clearProps: 'transform' }, 0.2)
				.from(mq('.lb-master__item'), { y: 30, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 0.45)
				.from(mq('.lb-master__ic svg'), { scale: 0.4, rotation: -20, opacity: 0, duration: 1.1, stagger: 0.1, ease: 'back.out(2)', clearProps: 'transform' }, 0.65)
				.from(mq('.lb-master__btn'), { y: 26, opacity: 0, duration: 1.2, clearProps: 'transform' }, 1);
			var marc = master.querySelector('.lb-master__arc');
			var msheen = master.querySelector('.lb-master__sheen');
			if (mdesk && marc && marc.getTotalLength) {
				[marc, msheen].forEach(function (path, k) {
					if (!path) return;
					var l = path.getTotalLength();
					gsap.set(path, { strokeDasharray: l, strokeDashoffset: l });
					mtl.to(path, { strokeDashoffset: 0, duration: k ? 1.6 : 2.2, ease: 'power2.inOut' }, k ? 0.9 : 0.1);
				});
			}
			// фото чуть смещается при прокрутке (глубина)
			if (mdesk) {
				gsap.to(master.querySelector('.lb-master__photo img'), { yPercent: -4, ease: 'none', scrollTrigger: { trigger: master, start: 'top bottom', end: 'bottom top', scrub: true } });
			}
		}

		var portfolio = document.querySelector('.lb-portfolio');
		if (portfolio) {
			var pq = function (s) { return portfolio.querySelectorAll(s); };
			var ptl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: portfolio, start: 'top 72%' } });
			ptl.from(pq('.lb-portfolio__lin'), { yPercent: 105, duration: 1.5, stagger: 0.12 }, 0)
				.from(pq('.lb-portfolio__sub'), { y: 26, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.3)
				.from(pq('.lb-gallery__item:not(.lb-gallery__item--more)'), { y: 60, opacity: 0, scale: 0.96, duration: 1.3, stagger: 0.06, clearProps: 'transform,opacity' }, 0.25)
				.from(pq('.lb-portfolio__foot'), { y: 26, opacity: 0, duration: 1.1, clearProps: 'transform' }, 0.8);
			var parcs = pq('.lb-portfolio__arc');
			if (isDesktop()) {
				[].forEach.call(parcs, function (path, k) {
					if (!path.getTotalLength) return;
					var l = path.getTotalLength();
					gsap.set(path, { strokeDasharray: l, strokeDashoffset: l });
					ptl.to(path, { strokeDashoffset: 0, duration: 2, ease: 'power2.inOut' }, 0.1 + k * 0.3);
				});
			}
		}
	};
	initReveal();

	/* ---------- Анимации баннера (GSAP) ---------- */
	var hero = document.querySelector('.lb-hero');
	if (!hero || reduce || typeof window.gsap === 'undefined') {
		doc.classList.add('lb-anim-done');
		return;
	}
	var gsap = window.gsap;
	if (window.ScrollTrigger) gsap.registerPlugin(window.ScrollTrigger);

	var q = function (s) { return hero.querySelectorAll(s); };
	var bg = hero.querySelector('.lb-hero__bg');

	var tl = gsap.timeline({ defaults: { ease: 'expo.out' }, onComplete: function () { doc.classList.add('lb-anim-done'); } });
	tl.from(bg, { scale: 1.06, opacity: 0, duration: 2.2, ease: 'power3.out', clearProps: 'transform' }, 0)
		.from(isDesktop() ? '.lb-header__logo, .lb-nav, .lb-lang, .lb-header__right' : '.lb-header__logo, .lb-header__right', { y: -24, opacity: 0, duration: 1.2, stagger: 0.08, clearProps: 'transform' }, 0.35)
		.from(q('.lb-hero__t1, .lb-hero__t2, .lb-hero__t3'), { yPercent: 55, opacity: 0, duration: 1.6, stagger: 0.14 }, 0.5)
		.from(q('.lb-hero__line'), { scaleX: 0, duration: 1.2 }, 1.05)
		.from(q('.lb-hero__sub'), { y: 20, opacity: 0, duration: 1.2 }, 1.1)
		.from(q('.lb-hero__btns > *'), { y: 24, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 1.2)
		.from(q('.lb-card'), { y: 60, opacity: 0, duration: 1.4, stagger: 0.12, clearProps: 'transform' }, 1.0)
		.from(q('.lb-hero__deco'), { opacity: 0, duration: 1.6, ease: 'power2.out' }, 1.4);

	if (isDesktop()) {
		// лёгкий параллакс за курсором (фон не двигаем — он совпадает с макетом 1:1)
		var deco = hero.querySelector('.lb-hero__deco');
		var qx = gsap.quickTo(deco, 'x', { duration: 1.6, ease: 'power3.out' });
		var qy = gsap.quickTo(deco, 'y', { duration: 1.6, ease: 'power3.out' });
		var cards = hero.querySelector('.lb-hero__cards');
		var cx = cards && gsap.quickTo(cards, 'x', { duration: 1.4, ease: 'power3.out' });
		var cy = cards && gsap.quickTo(cards, 'y', { duration: 1.4, ease: 'power3.out' });
		hero.addEventListener('mousemove', function (e) {
			var r = hero.getBoundingClientRect();
			var dx = (e.clientX - r.left) / r.width - 0.5;
			var dy = (e.clientY - r.top) / r.height - 0.5;
			qx(dx * -18); qy(dy * -12);
			if (cards) { cx(dx * 16); cy(dy * 12); }
		});
		hero.addEventListener('mouseleave', function () {
			qx(0); qy(0);
			if (cards) { cx(0); cy(0); }
		});
	}

	// фон уезжает медленнее при прокрутке
	if (window.ScrollTrigger) {
		gsap.to(hero.querySelector('.lb-hero__bg img'), {
			yPercent: 12,
			ease: 'none',
			scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
		});
		gsap.to(hero.querySelector('.lb-hero__content'), {
			yPercent: -6,
			ease: 'none',
			scrollTrigger: { trigger: hero, start: 'top top', end: 'bottom top', scrub: true }
		});
	}
})();
