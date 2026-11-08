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
	/* мега-меню (десктоп): Esc закрывает панель и возвращает фокус на «Servicii»; снова открывается при уходе мыши / фокуса */
	/* выбор языка (десктоп): hover / фокус открывают через CSS, клик — для тача и клавиатуры; закрытие — клик снаружи и Esc */
	var lang = document.querySelector('.lb-header .lb-lang');
	var langBtn = lang && lang.querySelector('.lb-lang__btn');
	if (langBtn) {
		var setLang = function (open) {
			lang.classList.toggle('is-open', open);
			langBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
		};
		langBtn.addEventListener('click', function () { setLang(!lang.classList.contains('is-open')); });
		document.addEventListener('click', function (e) { if (!lang.contains(e.target)) setLang(false); });
		lang.addEventListener('keydown', function (e) {
			if (e.key !== 'Escape') return;
			setLang(false);
			langBtn.focus();
			lang.classList.add('is-shut');
		});
		lang.addEventListener('mouseleave', function () { lang.classList.remove('is-shut'); });
		lang.addEventListener('focusout', function (e) { if (!lang.contains(e.relatedTarget)) { lang.classList.remove('is-shut'); setLang(false); } });
	}
	document.querySelectorAll('.lb-nav__item--mega').forEach(function (it) {
		var link = it.querySelector('.lb-nav__link');
		it.addEventListener('keydown', function (e) {
			if (e.key !== 'Escape' || !isDesktop()) return;
			it.classList.add('is-shut');
			if (link) link.focus();
		});
		it.addEventListener('mouseleave', function () { it.classList.remove('is-shut'); });
		it.addEventListener('focusout', function (e) {
			if (!it.contains(e.relatedTarget)) it.classList.remove('is-shut');
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
	// все блоки редизайна (id="lb-…") и кнопки «Записаться» (js-lb-book) — где бы они ни стояли
	var anchorSel = '.lb-header a[href^="#"], [id^="lb-"] a[href^="#"], a.js-lb-book';
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

	/* ---------- Блок «Отзывы»: бесконечная карусель карточек ----------
	   Лента — оригинальные карточки + по копии набора слева и справа (копии — aria-hidden, без Tab, только для «бесконечности»).
	   Десктоп: по центру экрана — промежуток между 2-й и 3-й видимой карточкой (как в макете); мобильный — текущая карточка по центру.
	   Если все карточки помещаются в ширину — ряд по центру без стрелок и точек. Свайп/перетаскивание, стрелки, точки, ←/→,
	   автопрокрутка (пауза при наведении/фокусе, вне экрана; останавливается после первого действия пользователя). */
	var reviews = document.querySelector('.lb-reviews');
	var rvCar = reviews && reviews.querySelector('.lb-reviews__carousel');
	var rvPage = reviews && reviews.classList.contains('lb-reviews--page');
	// страница «Отзывы»: сетка без карусели — первые 12 карточек (на телефоне 6), дальше кнопкой столько же
	if (rvCar && rvPage) (function () {
		var cards = [].slice.call(rvCar.querySelectorAll('.lb-rcard'));
		var btn = reviews.querySelector('.lb-reviews__morebtn');
		var STEP = isDesktop() ? 12 : 6;
		cards.forEach(function (c, i) { if (i >= STEP) c.classList.add('is-more'); });
		var sync = function () { if (btn) btn.classList.toggle('is-hidden', !rvCar.querySelector('.lb-rcard.is-more')); };
		sync();
		if (btn) btn.addEventListener('click', function () {
			var next = [].slice.call(rvCar.querySelectorAll('.lb-rcard.is-more'), 0, STEP);
			next.forEach(function (c) { c.classList.remove('is-more'); });
			if (next.length && !reduce && window.gsap) {
				window.gsap.from(next, { y: 40, opacity: 0, duration: 1, stagger: 0.04, ease: 'expo.out', clearProps: 'transform,opacity' });
			}
			sync();
			if (window.ScrollTrigger) window.ScrollTrigger.refresh();
		});
	})();
	if (rvCar && !rvPage) (function () {
		var track = rvCar.querySelector('.lb-reviews__track');
		var viewport = rvCar.querySelector('.lb-reviews__viewport');
		var dotsWrap = rvCar.querySelector('.lb-reviews__dots');
		var originals = [].slice.call(track.children);
		var N = originals.length;
		if (!N) return;
		var st = { p: 0, pitch: 0, anchor: 0, loop: false, x: 0 };
		var dots = [];
		var clones = false;
		var auto = null, autoStopped = reduce, hovered = false, inView = false;

		var makeClones = function () {
			return originals.map(function (c) {
				var k = c.cloneNode(true);
				k.removeAttribute('id');
				k.setAttribute('aria-hidden', 'true');
				k.classList.add('is-clone');
				// копия видна и кликается мышью/пальцем, но не попадает в порядок Tab и в дерево доступности
				[].forEach.call(k.querySelectorAll('button, a'), function (b) { b.setAttribute('tabindex', '-1'); });
				return k;
			});
		};
		var setClones = function (on) {
			if (on === clones) return;
			if (on) {
				makeClones().forEach(function (k) { track.insertBefore(k, originals[0]); });
				makeClones().forEach(function (k) { track.appendChild(k); });
			} else {
				[].slice.call(track.querySelectorAll('.is-clone')).forEach(function (k) { k.parentNode.removeChild(k); });
			}
			clones = on;
		};
		var setX = function (x, anim) {
			track.classList.toggle('is-anim', !!anim);
			st.x = x;
			track.style.transform = 'translate3d(' + x.toFixed(2) + 'px,0,0)';
		};
		var curX = function () {
			var m = getComputedStyle(track).transform;
			if (!m || m === 'none') return st.x;
			var v = m.match(/matrix(3d)?\(([^)]+)\)/);
			if (!v) return st.x;
			var a = v[2].split(',');
			return parseFloat(v[1] ? a[12] : a[4]);
		};
		var posFor = function (p) { return st.anchor - (N + p) * st.pitch; };
		var norm = function (p) { return ((p % N) + N) % N; };
		var setActive = function () {
			var a = norm(st.p);
			dots.forEach(function (d, i) {
				d.classList.toggle('is-active', i === a);
				if (i === a) d.setAttribute('aria-current', 'true'); else d.removeAttribute('aria-current');
			});
		};
		var renderDots = function () {
			if (dots.length === N || !dotsWrap) return;
			dotsWrap.innerHTML = '';
			dots = originals.map(function (c, i) {
				var b = document.createElement('button');
				b.type = 'button';
				b.className = 'lb-reviews__dot';
				b.setAttribute('aria-label', (rvCar.getAttribute('data-dot') || '') + ' ' + (i + 1));
				b.addEventListener('click', function () {
					stopAuto();
					var d = i - norm(st.p);
					if (d > N / 2) d -= N;
					if (d < -N / 2) d += N;
					go(st.p + d);
				});
				dotsWrap.appendChild(b);
				return b;
			});
		};
		var measure = function () {
			var cs = getComputedStyle(track);
			var gap = parseFloat(cs.columnGap) || parseFloat(cs.gap) || 0;
			var w = originals[0].offsetWidth;
			var vw = viewport.clientWidth;
			st.pitch = w + gap;
			st.anchor = isDesktop() ? vw / 2 - 2 * st.pitch + gap / 2 : (vw - w) / 2;
			return N * st.pitch - gap <= vw;
		};
		var update = function () {
			var fits = measure();
			st.loop = N > 1 && !fits;
			rvCar.classList.toggle('is-static', !st.loop);
			setClones(st.loop);
			if (st.loop) {
				st.p = norm(st.p);
				setX(posFor(st.p), false);
			} else {
				track.classList.remove('is-anim');
				track.style.transform = '';
			}
			renderDots();
			setActive();
		};
		var go = function (target) {
			if (!st.loop) return;
			// индекс уходит дальше одной копии — мгновенно переносим ленту на равноценную позицию
			if (target > N) {
				setX(curX() + N * st.pitch, false);
				target -= N;
				void track.offsetWidth;
			} else if (target < -1) {
				setX(curX() - N * st.pitch, false);
				target += N;
				void track.offsetWidth;
			}
			st.p = target;
			setX(posFor(target), true);
			setActive();
		};
		track.addEventListener('transitionend', function (e) {
			if (e.target !== track || e.propertyName !== 'transform') return;
			if (st.p >= N || st.p < 0) {
				st.p = norm(st.p);
				setX(posFor(st.p), false);
			}
		});

		// стрелки и клавиатура
		var prev = rvCar.querySelector('.lb-reviews__arrow--prev');
		var next = rvCar.querySelector('.lb-reviews__arrow--next');
		if (prev) prev.addEventListener('click', function () { stopAuto(); go(st.p - 1); });
		if (next) next.addEventListener('click', function () { stopAuto(); go(st.p + 1); });
		rvCar.addEventListener('keydown', function (e) {
			if (!st.loop || (e.key !== 'ArrowLeft' && e.key !== 'ArrowRight')) return;
			if (e.target.closest && e.target.closest('input, textarea')) return;
			e.preventDefault();
			stopAuto();
			go(st.p + (e.key === 'ArrowRight' ? 1 : -1));
		});

		// перетаскивание / свайп
		var drag = null, suppressClick = false;
		viewport.addEventListener('pointerdown', function (e) {
			if (!st.loop || (e.pointerType === 'mouse' && e.button !== 0)) return;
			drag = { id: e.pointerId, x0: e.clientX, y0: e.clientY, sx: curX(), moved: false };
		});
		window.addEventListener('pointermove', function (e) {
			if (!drag || e.pointerId !== drag.id) return;
			var dx = e.clientX - drag.x0;
			if (!drag.moved) {
				if (Math.abs(dx) < 6) return;
				if (Math.abs(e.clientY - drag.y0) > Math.abs(dx)) { drag = null; return; }
				drag.moved = true;
				stopAuto();
				viewport.classList.add('is-drag');
			}
			setX(drag.sx + dx, false);
		});
		var endDrag = function (e) {
			if (!drag || (e && e.pointerId !== drag.id)) return;
			var d = drag;
			drag = null;
			viewport.classList.remove('is-drag');
			if (!d.moved) return;
			suppressClick = true;
			setTimeout(function () { suppressClick = false; }, 0);
			var dx = (e ? e.clientX : d.x0) - d.x0;
			var from = Math.round((st.anchor - d.sx) / st.pitch) - N;
			var steps = Math.round(-dx / st.pitch);
			if (!steps && Math.abs(dx) > 40) steps = dx < 0 ? 1 : -1;
			st.p = from;
			go(from + steps);
		};
		window.addEventListener('pointerup', endDrag);
		window.addEventListener('pointercancel', endDrag);
		viewport.addEventListener('click', function (e) {
			if (suppressClick) { e.preventDefault(); e.stopPropagation(); }
		}, true);
		viewport.addEventListener('dragstart', function (e) { e.preventDefault(); });

		// автопрокрутка
		var tick = function () { if (st.loop && !hovered && inView && !document.hidden && !drag) go(st.p + 1); };
		var startAuto = function () { if (!autoStopped && !auto) auto = setInterval(tick, 6000); };
		var stopAuto = function () { autoStopped = true; if (auto) { clearInterval(auto); auto = null; } };
		rvCar.addEventListener('mouseenter', function () { hovered = true; });
		rvCar.addEventListener('mouseleave', function () { hovered = false; });
		rvCar.addEventListener('focusin', function () { hovered = true; });
		rvCar.addEventListener('focusout', function () { hovered = false; });
		if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (en) { inView = en[0].isIntersecting; if (inView) startAuto(); }, { threshold: 0.35 }).observe(rvCar);
		}

		var rvTimer;
		window.addEventListener('resize', function () {
			clearTimeout(rvTimer);
			rvTimer = setTimeout(update, 120);
		});
		if (document.fonts && document.fonts.ready) document.fonts.ready.then(update);
		update();
	})();

	/* ---------- Блок «Отзывы»: окна (полный отзыв, форма отзыва) ---------- */
	if (reviews) (function () {
		var rmodal = document.getElementById('lb-rmodal');
		var rform = document.getElementById('lb-rform');
		var opener = null;
		var open = function (dlg, from) {
			if (!dlg) return;
			opener = from || null;
			if (typeof dlg.showModal === 'function') dlg.showModal(); else dlg.setAttribute('open', '');
			doc.classList.add('is-lb-modal');
		};
		var close = function (dlg) {
			if (!dlg || !dlg.hasAttribute('open')) return;
			if (typeof dlg.close === 'function') dlg.close(); else { dlg.removeAttribute('open'); onClose(); }
		};
		var onClose = function () {
			doc.classList.remove('is-lb-modal');
			if (opener && opener.focus) opener.focus();
			opener = null;
		};
		[rmodal, rform].forEach(function (dlg) {
			if (!dlg) return;
			dlg.addEventListener('close', onClose);
			dlg.addEventListener('click', function (e) {
				// клик по подложке (вне окна) или по крестику
				if (e.target === dlg || (e.target.closest && e.target.closest('.lb-rmodal__close'))) close(dlg);
			});
		});
		// полный отзыв: шапка карточки, весь текст, ответ студии
		reviews.addEventListener('click', function (e) {
			var card = e.target.closest && e.target.closest('.lb-rcard');
			if (!card || !rmodal) return;
			if (!e.target.closest('.lb-rcard__more, .lb-rcard__text')) return;
			var body = rmodal.querySelector('.lb-rmodal__body');
			var head = card.querySelector('.lb-rcard__head').cloneNode(true);
			var name = head.querySelector('.lb-rcard__name');
			if (name) name.id = 'lb-rmodal-name';
			var text = document.createElement('div');
			text.className = 'lb-rmodal__text';
			text.innerHTML = card.querySelector('.lb-rcard__text').innerHTML;
			body.innerHTML = '';
			body.appendChild(head);
			body.appendChild(text);
			var reply = card.querySelector('.lb-rcard__reply');
			if (reply) {
				var r = reply.cloneNode(true);
				r.hidden = false;
				body.appendChild(r);
			}
			open(rmodal, card.querySelector('.lb-rcard__more'));
		});
		reviews.querySelectorAll('.js-lb-review-form').forEach(function (b) {
			b.addEventListener('click', function () { open(rform, b); });
		});
	})();

	/* ---------- Галерея: «Смотреть все работы» раскрывает остальные фото ---------- */
	document.querySelectorAll('.lb-portfolio').forEach(function (sec) {
		var grid = sec.querySelector('.lb-gallery');
		var btn = sec.querySelector('.lb-portfolio__more');
		var foot = sec.querySelector('.lb-portfolio__foot');
		if (!grid || !btn) return;
		var more = grid.querySelectorAll('.lb-gallery__item--more');
		// фото не больше 8 — кнопка не нужна; ссылка на портфолио (страницы услуг) остаётся
		if (!more.length) { btn.classList.add('is-hidden'); if (foot && !foot.querySelector('.lb-portfolio__all')) foot.classList.add('is-hidden'); return; }
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

	/* ---------- Галерея внутренней страницы портфолио: «Показать ещё» — по 16 фото ---------- */
	document.querySelectorAll('.lb-pgallery').forEach(function (sec) {
		var grid = sec.querySelector('.lb-gallery');
		var btn = sec.querySelector('.lb-pgallery__more');
		var foot = sec.querySelector('.lb-pgallery__foot');
		if (!btn) return;
		var hidden = function () { return grid ? grid.querySelectorAll('.lb-gallery__item--more') : []; };
		var sync = function () {
			if (hidden().length) return;
			btn.classList.add('is-hidden');
			if (foot && !foot.querySelector('a.lb-btn')) foot.classList.add('is-hidden');
		};
		sync();
		btn.addEventListener('click', function () {
			var next = [].slice.call(hidden(), 0, 16);
			next.forEach(function (el) { el.classList.remove('lb-gallery__item--more'); });
			if (next.length && !reduce && window.gsap) {
				window.gsap.from(next, { y: 40, opacity: 0, duration: 1, stagger: 0.035, ease: 'expo.out', clearProps: 'transform,opacity' });
			}
			sync();
			if (window.ScrollTrigger) window.ScrollTrigger.refresh();
		});
	});

	/* ---------- Блок FAQ: аккордеон ----------
	   Открыт один вопрос: клик по другому закрывает предыдущий. Высота — CSS (grid-template-rows), здесь — классы и aria.
	   После раскрытия пересчитываем ScrollTrigger (меняется высота страницы); на мобильном открытый вопрос докручиваем в экран. */
	var faq = document.querySelector('.lb-faq');
	if (faq) {
		var fItems = [].slice.call(faq.querySelectorAll('.lb-faq__item'));
		var fRefresh;
		var setItem = function (li, open) {
			li.classList.toggle('is-open', open);
			var b = li.querySelector('.lb-faq__q');
			if (b) b.setAttribute('aria-expanded', open ? 'true' : 'false');
		};
		// на мобильном список изначально свёрнут (первый ответ длинный — так вопросы видны сразу).
		// Сворачиваем без анимации: иначе ScrollTrigger блоков ниже (SEO, «Статьи», «Контакты») посчитает позиции
		// по ещё не свернувшемуся списку, и анимации появления сработают на ~высоту ответа позже (контент остаётся скрытым).
		if (window.matchMedia('(max-width: 1024px)').matches) {
			faq.classList.add('is-instant');
			fItems.forEach(function (li) { setItem(li, false); });
			void faq.offsetHeight;
			faq.classList.remove('is-instant');
		}
		fItems.forEach(function (li) {
			var b = li.querySelector('.lb-faq__q');
			if (!b) return;
			b.addEventListener('click', function () {
				var open = !li.classList.contains('is-open');
				fItems.forEach(function (o) { if (o !== li) setItem(o, false); });
				setItem(li, open);
				clearTimeout(fRefresh);
				fRefresh = setTimeout(function () {
					if (window.ScrollTrigger) window.ScrollTrigger.refresh();
					if (open) {
						var hdr = document.querySelector('.lb-header');
						var top = li.getBoundingClientRect().top - (hdr ? hdr.offsetHeight : 0) - 16;
						if (top < 0) window.scrollBy({ top: top, behavior: reduce ? 'auto' : 'smooth' });
					}
				}, 720);
			});
		});
	}

	/* ---------- SEO-блок: кружки таймлайна и линии при прокрутке ----------
	   В HTML текста ничего не меняем (даже классы): отмечаем только обёртки — .is-anim/.is-in на секции
	   и data-seen (сколько h3 уже показано) на .lb-seo__body; кружки выбирает CSS через h3:nth-of-type. */
	var seo = document.querySelector('.lb-seo');
	var seoBody = seo && seo.querySelector('.lb-seo__body');
	// пустые абзацы из редактора (<p>&nbsp;</p>) не рисуем пустыми карточками — прячем (в HTML текст не меняется)
	if (seoBody) [].forEach.call(seoBody.querySelectorAll('p'), function (p) {
		if (!p.textContent.trim() && !p.querySelector('img, iframe, video')) p.classList.add('is-empty');
	});
	if (seo && seoBody && !reduce && window.requestAnimationFrame) {
		var seoHead = seo.querySelector('.lb-seo__head');
		var seoH3 = [].filter.call(seoBody.children, function (el) { return el.tagName === 'H3'; });
		var seen = 0, seoTick = false;
		seo.classList.add('is-anim');
		// показано всё, что уже выше 88% высоты экрана (и при быстрой прокрутке / переходе по якорю ничего не остаётся скрытым)
		var seoCheck = function () {
			seoTick = false;
			var lim = window.innerHeight * 0.88;
			if (seoHead && seoHead.getBoundingClientRect().top < lim) seo.classList.add('is-in');
			var n = seen;
			while (n < seoH3.length && seoH3[n].getBoundingClientRect().top < lim) n++;
			if (n > seen) {
				seen = n;
				seoBody.setAttribute('data-seen', String(seen));
			}
			if (seen >= seoH3.length && seo.classList.contains('is-in')) {
				window.removeEventListener('scroll', seoOnScroll);
				window.removeEventListener('resize', seoOnScroll);
			}
		};
		var seoOnScroll = function () {
			if (!seoTick) { seoTick = true; window.requestAnimationFrame(seoCheck); }
		};
		window.addEventListener('scroll', seoOnScroll, { passive: true });
		window.addEventListener('resize', seoOnScroll);
		seoCheck();
	}

	/* ---------- Появление блоков при прокрутке ---------- */
	var initReveal = function () {
		if (reduce || typeof window.gsap === 'undefined' || !window.ScrollTrigger) return;
		var gsap = window.gsap;
		gsap.registerPlugin(window.ScrollTrigger);
		// на страницах услуг части блоков нет (преимуществ и цитаты в «О процедуре», иконок в «implică» и т. п.) — пустые цели не ошибка
		gsap.config({ nullTargetWarn: false });
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
		if (reviews) {
			var rq = function (s) { return reviews.querySelectorAll(s); };
			var rtl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: reviews, start: 'top 68%' } });
			var radd = function (sel, from, at) { var els = typeof sel === 'string' ? rq(sel) : sel; if (els.length) rtl.from(els, from, at); };
			radd('.lb-reviews__bg', { opacity: 0, duration: 1.8, ease: 'power2.out' }, 0);
			radd('.lb-reviews__lin', { yPercent: 105, duration: 1.5, stagger: 0.12 }, 0.1);
			radd('.lb-reviews__sub', { y: 24, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.4);
			radd('.lb-reviews__pill', { y: 24, scale: 0.96, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0.5);
			radd('.lb-reviews__star', { scale: 0, rotation: -40, duration: 0.9, stagger: 0.08, ease: 'back.out(2.4)', clearProps: 'transform' }, 0.8);
			// видимые карточки — по очереди слева направо, остальные — сразу
			var vis = [].filter.call(rq('.lb-rcard'), function (c) {
				var r = c.getBoundingClientRect();
				return r.right > 0 && r.left < window.innerWidth;
			});
			radd(vis, { y: 80, opacity: 0, duration: 1.5, stagger: 0.09, clearProps: 'transform' }, 0.55);
			radd('.lb-reviews__nav, .lb-reviews__btns > *', { y: 26, opacity: 0, duration: 1.2, stagger: 0.08, clearProps: 'transform' }, 0.95);
			var num = reviews.querySelector('.lb-reviews__num');
			var val = num && parseFloat(num.textContent);
			if (val) {
				var o = { v: 0 };
				rtl.to(o, { v: val, duration: 1.4, ease: 'power3.out', onUpdate: function () { num.textContent = o.v.toFixed(1); }, onComplete: function () { num.textContent = val.toFixed(1); } }, 0.6);
			}
		}
		if (faq) {
			var fq = function (s) { return faq.querySelectorAll(s); };
			var ftl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: faq, start: 'top 70%' } });
			var fadd = function (sel, from, at, to) {
				var els = fq(sel);
				if (!els.length) return;
				if (to) ftl.fromTo(els, from, to, at); else ftl.from(els, from, at);
			};
			fadd('.lb-faq__bg', { opacity: 0, scale: 1.04, duration: 2, ease: 'power3.out', clearProps: 'transform' }, 0);
			fadd('.lb-faq__lin', { yPercent: 105, duration: 1.5, stagger: 0.12 }, 0.15);
			fadd('.lb-faq__flourish', { clipPath: 'inset(0% 100% 0% 0%)' }, 0.7, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.6, ease: 'power2.inOut', clearProps: 'clipPath' });
			fadd('.lb-faq__text', { y: 30, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0.55);
			fadd('.lb-faq__ctas > *', { y: 26, opacity: 0, duration: 1.2, stagger: 0.09, clearProps: 'transform' }, 0.75);
			fadd('.lb-faq__item', { y: 60, opacity: 0, duration: 1.4, stagger: 0.1, clearProps: 'transform' }, 0.3);
			fadd('.lb-faq__num', { yPercent: 60, opacity: 0, duration: 1.1, stagger: 0.1, clearProps: 'transform' }, 0.6);
		}
		// «Статьи» и «Контакты»: одинаковая схема — заголовок, затем карточки / строки по очереди
		var revealBlock = function (sec, start, steps) {
			if (!sec) return;
			var tl = gsap.timeline({ defaults: { ease: 'expo.out' }, scrollTrigger: { trigger: sec, start: start } });
			steps.forEach(function (st) {
				var els = sec.querySelectorAll(st[0]);
				if (!els.length) return;
				if (st[3]) tl.fromTo(els, st[1], st[3], st[2]); else tl.from(els, st[1], st[2]);
			});
		};
		revealBlock(document.querySelector('.lb-blog'), 'top 70%', [
			['.lb-blog__bg', { opacity: 0, duration: 1.8, ease: 'power2.out' }, 0],
			['.lb-blog__lin', { yPercent: 105, duration: 1.5, stagger: 0.12 }, 0.1],
			['.lb-blog__flourish', { clipPath: 'inset(0% 50% 0% 50%)' }, 0.55, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.5, ease: 'power2.inOut', clearProps: 'clipPath' }],
			['.lb-blog__card', { y: 90, opacity: 0, duration: 1.5, stagger: 0.12, clearProps: 'transform' }, 0.35],
			['.lb-blog__num', { scale: 0, rotation: -30, duration: 1, stagger: 0.12, ease: 'back.out(2)', clearProps: 'transform' }, 0.9],
			['.lb-blog__cta > *', { y: 26, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.9]
		]);
		revealBlock(document.querySelector('.lb-contact'), 'top 70%', [
			['.lb-contact__bg', { opacity: 0, duration: 1.8, ease: 'power2.out' }, 0],
			['.lb-contact__title', { y: 50, opacity: 0, duration: 1.4, clearProps: 'transform' }, 0.1],
			['.lb-contact__line', { clipPath: 'inset(0% 100% 0% 0%)' }, 0.5, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.4, ease: 'power2.inOut', clearProps: 'clipPath' }],
			['.lb-contact__sub', { y: 30, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0.25],
			['.lb-contact__map', { y: 60, scale: 0.97, opacity: 0, duration: 1.6, clearProps: 'transform' }, 0.35],
			['.lb-contact__card', { y: 60, opacity: 0, duration: 1.6, clearProps: 'transform' }, 0.3],
			['.lb-contact__row', { x: 40, opacity: 0, duration: 1.2, stagger: 0.07, clearProps: 'transform' }, 0.5],
			['.lb-contact__sep svg', { scale: 0, rotation: -90, duration: 1, ease: 'back.out(2)', clearProps: 'transform' }, 0.8],
			['.lb-contact__tile', { y: 24, opacity: 0, duration: 1.1, stagger: 0.08, clearProps: 'transform' }, 0.9],
			['.lb-contact__btn', { y: 24, opacity: 0, duration: 1.1, clearProps: 'transform' }, 1.1]
		]);
		// портфолио (общая страница и галереи), курсы
		revealBlock(document.querySelector('.lb-pfhub'), 'top 75%', [
			['.lb-pfhub__eyebrow', { x: -30, opacity: 0, duration: 1.2, stagger: 0.3, clearProps: 'transform' }, 0],
			['.lb-pfcard', { y: 70, opacity: 0, duration: 1.4, stagger: 0.1, clearProps: 'transform' }, 0.15]
		]);
		revealBlock(document.querySelector('.lb-pgallery'), 'top 80%', [
			['.lb-pgallery__intro', { y: 40, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0],
			['.lb-gallery__item:not(.lb-gallery__item--more)', { y: 50, opacity: 0, scale: 0.97, duration: 1.2, stagger: 0.04, clearProps: 'transform,opacity' }, 0.2]
		]);
		revealBlock(document.querySelector('.lb-prices'), 'top 75%', [
			['.lb-prices__intro', { y: 40, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0],
			['.lb-prices__group', { y: 70, opacity: 0, duration: 1.4, stagger: 0.12, clearProps: 'transform' }, 0.15]
		]);
		revealBlock(document.querySelector('.lb-courses'), 'top 75%', [
			['.lb-courses__eyebrow', { x: -30, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0],
			['.lb-course', { y: 70, opacity: 0, duration: 1.5, stagger: 0.12, clearProps: 'transform' }, 0.15],
			['.lb-course__li', { x: 30, opacity: 0, duration: 1.1, stagger: 0.08, clearProps: 'transform' }, 0.6]
		]);
		// подвал: в блоке «Заказать звонок» (.lb-footer__call) анимируется только кнопка — окно (position: fixed) лежит рядом с ней:
		// прозрачность / transform на самом блоке прятали бы окно, открытое до прокрутки к подвалу (кнопки «Записаться» без формы на странице)
		revealBlock(document.querySelector('.lb-footer'), 'top 80%', [
			['.lb-footer__logo', { y: 40, opacity: 0, duration: 1.4, clearProps: 'transform' }, 0],
			['.lb-footer__copy', { y: 24, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.15],
			['.lb-footer__soc', { y: 20, scale: 0.8, opacity: 0, duration: 1, stagger: 0.06, ease: 'back.out(2)', clearProps: 'transform' }, 0.3],
			['.lb-footer__col p', { y: 18, opacity: 0, duration: 1, stagger: 0.04, clearProps: 'transform' }, 0.2],
			['.lb-footer__contacts > :not(.lb-footer__call)', { y: 22, opacity: 0, duration: 1.1, stagger: 0.07, clearProps: 'transform' }, 0.3],
			['.lb-footer__call > .btn-mobal', { y: 22, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.8]
		]);
	};
	initReveal();

	/* ---------- Баннер статьи: просмотры с разрядами (9 300) — HitsPage отдаёт число без пробелов ---------- */
	Array.prototype.forEach.call(document.querySelectorAll('.lb-shero__sv--num'), function (el) {
		var t = el.textContent.trim();
		if (/^\d{4,}$/.test(t)) el.textContent = t.replace(/\B(?=(\d{3})+(?!\d))/g, '\u00a0');
	});

	/* ---------- Баннер страниц услуг (lb-shero): интро ---------- */
	var shero = document.querySelector('.lb-shero');
	if (shero && !reduce && typeof window.gsap !== 'undefined') {
		var sq = function (s) { return shero.querySelectorAll(s); };
		var stl = window.gsap.timeline({ defaults: { ease: 'expo.out' } });
		var sAdd = function (sel, vars, pos) { var els = sq(sel); if (els.length) stl.from(els, vars, pos); };
		sAdd('.lb-shero__frame', { xPercent: 6, opacity: 0, duration: 1.8, ease: 'power3.out', clearProps: 'transform' }, 0);
		sAdd('.lb-shero__photo', { opacity: 0, duration: 1.4, ease: 'power2.out' }, 0.1);
		sAdd('.lb-shero__photo img', { scale: 1.12, duration: 2.4, ease: 'power3.out', clearProps: 'transform' }, 0.1);
		/* шапка — как на главной: ссылки меню по отдельности (transform на .lb-nav ломает позицию мега-панели) */
		stl.from(isDesktop() ? '.lb-header__logo, .lb-nav__list > li > .lb-nav__link, .lb-lang, .lb-header__right' : '.lb-header__logo, .lb-header__right', { y: -24, opacity: 0, duration: 1.2, stagger: isDesktop() ? 0.035 : 0.08, clearProps: 'transform' }, 0.3);
		sAdd('.lb-shero__eyebrow', { x: -30, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.4);
		sAdd('.lb-shero__t1, .lb-shero__t2', { yPercent: 40, opacity: 0, duration: 1.5, stagger: 0.12, clearProps: 'transform' }, 0.5);
		sAdd('.lb-shero__sub', { y: 20, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.8);
		sAdd('.lb-shero__feat, .lb-shero__li, .lb-shero__desc', { y: 20, opacity: 0, duration: 1.1, stagger: 0.08, clearProps: 'transform' }, 0.95);
		sAdd('.lb-shero__btns > *', { y: 24, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 1.1);
		sAdd('.lb-shero__cat', { y: 20, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.85);
		sAdd('.lb-shero__stats', { y: 30, opacity: 0, duration: 1.3, clearProps: 'transform' }, 0.95);
		sAdd('.lb-shero__stat', { x: 24, opacity: 0, duration: 1.1, stagger: 0.08, clearProps: 'transform' }, 1.05);
		sAdd('.lb-shero__badge', { y: 40, opacity: 0, duration: 1.3, stagger: 0.12, clearProps: 'transform' }, 1.0);
		sAdd('.lb-crumbs__item', { x: -16, opacity: 0, duration: 1, stagger: 0.06, clearProps: 'transform' }, 1.25);
	}

	/* ---------- 404 и «Спасибо» (lb-msg): интро ---------- */
	var msg = document.querySelector('.lb-msg');
	if (msg && !reduce && typeof window.gsap !== 'undefined') {
		var mtl = window.gsap.timeline({ defaults: { ease: 'expo.out' } });
		var mAdd = function (sel, vars, pos, to) { var els = msg.querySelectorAll(sel); if (!els.length) return; if (to) mtl.fromTo(els, vars, to, pos); else mtl.from(els, vars, pos); };
		mAdd('.lb-msg__bg', { opacity: 0, scale: 1.05, duration: 2.2, ease: 'power3.out', clearProps: 'transform' }, 0);
		mtl.from(isDesktop() ? '.lb-header__logo, .lb-nav__list > li > .lb-nav__link, .lb-lang, .lb-header__right' : '.lb-header__logo, .lb-header__right', { y: -24, opacity: 0, duration: 1.2, stagger: isDesktop() ? 0.035 : 0.08, clearProps: 'transform' }, 0.3);
		mAdd('.lb-msg__digit, .lb-msg__seal', { yPercent: 30, opacity: 0, duration: 1.6, stagger: 0.12, clearProps: 'transform' }, 0.35);
		/* овалы и галочка «прорисовываются» (pathLength=1) */
		mAdd('.lb-msg__ring', { strokeDashoffset: 1, strokeDasharray: 1 }, 0.7, { strokeDashoffset: 0, strokeDasharray: 1, duration: 1.8, stagger: 0.15, ease: 'power2.inOut', clearProps: 'strokeDashoffset,strokeDasharray' });
		mAdd('.lb-msg__check', { strokeDashoffset: 1, strokeDasharray: 1 }, 1.0, { strokeDashoffset: 0, strokeDasharray: 1, duration: 1.1, ease: 'power2.inOut', clearProps: 'strokeDashoffset,strokeDasharray' });
		mAdd('.lb-msg__spark', { scale: 0, rotation: -90, transformOrigin: '50% 50%', duration: 1, stagger: 0.15, ease: 'back.out(2)', clearProps: 'transform' }, 1.2);
		mAdd('.lb-msg__eyebrow', { y: 20, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.6);
		mAdd('.lb-msg__title, .lb-msg__big', { yPercent: 30, opacity: 0, duration: 1.5, clearProps: 'transform' }, 0.7);
		mAdd('.lb-msg__flourish', { clipPath: 'inset(0% 50% 0% 50%)' }, 1.0, { clipPath: 'inset(0% 0% 0% 0%)', duration: 1.4, ease: 'power2.inOut', clearProps: 'clipPath' });
		mAdd('.lb-msg__text', { y: 20, opacity: 0, duration: 1.2, clearProps: 'transform' }, 0.95);
		mAdd('.lb-msg__btns > *', { y: 24, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 1.1);
	}

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
		.from(q('.lb-hero__master'), { y: 50, opacity: 0, duration: 1.8, ease: 'power3.out', clearProps: 'transform' }, 0.25)
		.from(q('.lb-hero__letters'), { y: 80, opacity: 0, duration: 2.2, ease: 'power3.out', clearProps: 'transform' }, 0.6)
		.from(q('.lb-hero__vline'), { clipPath: 'inset(0% 0% 100% 0%)', duration: 1.8, ease: 'power2.inOut', clearProps: 'clipPath' }, 0.55)
		.from(q('.lb-hero__arches'), { clipPath: 'inset(100% 0% 0% 0%)', duration: 2, ease: 'power2.inOut', clearProps: 'clipPath' }, 0.8)
		/* пункты меню анимируются по ссылкам, не целиком .lb-nav: transform на .lb-nav / li становится containing block
		   для мега-панели — при наведении во время интро она уезжала влево */
		.from(isDesktop() ? '.lb-header__logo, .lb-nav__list > li > .lb-nav__link, .lb-lang, .lb-header__right' : '.lb-header__logo, .lb-header__right', { y: -24, opacity: 0, duration: 1.2, stagger: isDesktop() ? 0.035 : 0.08, clearProps: 'transform' }, 0.35)
		.from(q('.lb-hero__t1, .lb-hero__t2, .lb-hero__t3'), { yPercent: 55, opacity: 0, duration: 1.6, stagger: 0.14 }, 0.5)
		.from(q('.lb-hero__line'), { scaleX: 0, duration: 1.2 }, 1.05)
		.from(q('.lb-hero__sub'), { y: 20, opacity: 0, duration: 1.2 }, 1.1)
		.from(q('.lb-hero__btns > *'), { y: 24, opacity: 0, duration: 1.2, stagger: 0.1, clearProps: 'transform' }, 1.2)
		.from(q('.lb-card'), { y: 60, opacity: 0, duration: 1.4, stagger: 0.12, clearProps: 'transform' }, 1.0)
		.from(q('.lb-hero__deco'), { opacity: 0, duration: 1.6, ease: 'power2.out' }, 1.4);

	if (isDesktop()) {
		// лёгкий параллакс за курсором: мастер и карточки (фон, линии и искры на них не двигаем — они совпадают с фоном)
		var master = hero.querySelector('.lb-hero__master');
		var qx = gsap.quickTo(master, 'x', { duration: 1.8, ease: 'power3.out' });
		var qy = gsap.quickTo(master, 'y', { duration: 1.8, ease: 'power3.out' });
		var cards = hero.querySelector('.lb-hero__cards');
		var cx = cards && gsap.quickTo(cards, 'x', { duration: 1.4, ease: 'power3.out' });
		var cy = cards && gsap.quickTo(cards, 'y', { duration: 1.4, ease: 'power3.out' });
		hero.addEventListener('mousemove', function (e) {
			var r = hero.getBoundingClientRect();
			var dx = (e.clientX - r.left) / r.width - 0.5;
			var dy = (e.clientY - r.top) / r.height - 0.5;
			qx(dx * 10); qy(dy * 6);
			if (cards) { cx(dx * 16); cy(dy * 12); }
		});
		hero.addEventListener('mouseleave', function () {
			qx(0); qy(0);
			if (cards) { cx(0); cy(0); }
		});
	}

	// фон уезжает медленнее при прокрутке
	if (window.ScrollTrigger) {
		gsap.to(hero.querySelector('.lb-hero__scene'), {
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
