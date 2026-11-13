// node scroll.js URL width height jsfile|- shotprefix — прокрутить страницу вниз, собрать скрытые (opacity<.99) элементы
const puppeteer = require('/home/claude/build/node_modules/puppeteer-core');
const fs = require('fs');
(async () => {
  const [url, w, h, js, shot] = process.argv.slice(2);
  const b = await puppeteer.launch({ executablePath: '/usr/bin/google-chrome', headless: 'new', args: ['--no-sandbox', '--ignore-certificate-errors', '--no-proxy-server'] });
  const p = await b.newPage(); await p.setViewport({ width: +w, height: +h, isMobile: +w < 800, hasTouch: +w < 800 });
  if (js !== '-') { const body = fs.readFileSync(js, 'utf8'); await p.setRequestInterception(true); p.on('request', q => { if (q.url().includes('redesign.min.js')) q.respond({ status: 200, contentType: 'application/javascript', body }); else q.continue(); }); }
  await p.goto(url, { waitUntil: 'load' }); await new Promise(z => setTimeout(z, 3500));
  const H = await p.evaluate(() => document.documentElement.scrollHeight);
  for (let y = 0; y < H; y += Math.round(+h * 0.6)) { await p.evaluate(y => window.scrollTo(0, y), y); await new Promise(z => setTimeout(z, 700)); }
  await new Promise(z => setTimeout(z, 3500));
  const hidden = await p.evaluate(() => {
    const out = [];
    document.querySelectorAll('.wrapper *').forEach(el => {
      const cs = getComputedStyle(el); const r = el.getBoundingClientRect();
      if (r.width < 2 || r.height < 2) return;
      if (+cs.opacity < 0.99 && cs.visibility !== 'hidden' && !el.closest('.form-modal-overlay, .lb-rmodal, [aria-hidden="true"], .lb-mmenu, .lb-mega')) {
        let s = el.tagName.toLowerCase() + (el.className && typeof el.className === 'string' ? '.' + el.className.trim().split(/\s+/)[0] : '');
        out.push(s + ' ' + cs.opacity);
      }
    });
    return out;
  });
  if (shot) await p.screenshot({ path: shot, fullPage: true });
  console.log('hidden:', hidden.length, [...new Set(hidden)].slice(0, 40).join(' | '));
  await b.close();
})();
