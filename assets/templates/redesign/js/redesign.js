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
	document.querySelectorAll('.lb-header a[href^="#"], .lb-hero a[href^="#"]').forEach(function (a) {
		a.addEventListener('click', function (e) {
			var id = a.getAttribute('href').slice(1);
			var target = id && document.getElementById(id);
			if (target) {
				e.preventDefault();
				scrollToEl(target);
				return;
			}
			// формы записи нет на странице — открываем попап «Заказать звонок» из футера
			if (a.classList.contains('js-lb-book')) {
				var modalBtn = document.querySelector('.footer .btn-mobal, footer .btn-mobal, .btn-mobal');
				if (modalBtn) {
					e.preventDefault();
					modalBtn.click();
				}
			}
		});
	});

	/* ---------- «Читать далее» (текст свёрнут до 3 строк) ---------- */
	document.querySelectorAll('.lb-about__textwrap').forEach(function (wrap) {
		var text = wrap.querySelector('.lb-about__text');
		var btn = wrap.querySelector('.lb-about__more');
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
