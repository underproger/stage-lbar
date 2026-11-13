// node tbt.js URL [cpu] [runs] — длинные задачи главного потока (TBT-подобная сумма dur-50 после FCP), десктоп 1350x940
const puppeteer = require('/home/claude/build/node_modules/puppeteer-core');
(async () => {
  const url = process.argv[2], cpu = +(process.argv[3] || 4), runs = +(process.argv[4] || 3);
  const res = [];
  for (let r = 0; r < runs; r++) {
    const b = await puppeteer.launch({ executablePath: '/usr/bin/google-chrome', headless: 'new',
      args: ['--no-sandbox', '--ignore-certificate-errors', '--no-proxy-server', '--window-size=1350,940'] });
    const p = await b.newPage();
    if (process.env.BLOCK) { await p.setRequestInterception(true); p.on('request', q => { if (new RegExp(process.env.BLOCK).test(q.url())) q.abort(); else q.continue(); }); }
    await p.setViewport({ width: 1350, height: 940 });
    const c = await p.target().createCDPSession();
    await c.send('Network.setCacheDisabled', { cacheDisabled: true });
    await c.send('Emulation.setCPUThrottlingRate', { rate: cpu });
    await p.tracing.start({ categories: ['devtools.timeline', 'disabled-by-default-devtools.timeline', 'blink.user_timing', 'loading'] });
    await p.goto(url, { waitUntil: 'load' });
    await new Promise(z => setTimeout(z, 6000));
    const buf = await p.tracing.stop();
    await b.close();
    const ev = JSON.parse(Buffer.from(buf).toString("utf8")).traceEvents;
    const tn = {}; ev.forEach(e => { if (e.name === 'thread_name') tn[e.pid + ':' + e.tid] = e.args.name; });
    const cnt = {}; ev.forEach(e => { const k = e.pid + ':' + e.tid; if (tn[k] === 'CrRendererMain') cnt[k] = (cnt[k] || 0) + 1; });
    const main = Object.keys(cnt).sort((a, b) => cnt[b] - cnt[a])[0];
    const mt = ev.filter(e => e.pid + ':' + e.tid === main && e.ph === 'X');
    const fcpE = ev.find(e => e.name === 'firstContentfulPaint');
    const fcp = fcpE ? fcpE.ts : 0;
    const t0 = (ev.find(e => e.name === 'navigationStart') || { ts: mt[0].ts }).ts;
    const tasks = mt.filter(e => e.name === 'RunTask' && e.dur > 50000);
    let tbt = 0, list = [];
    tasks.forEach(t => {
      if (t.ts + t.dur < fcp) return;
      const st = Math.max(t.ts, fcp);
      const d = (t.ts + t.dur - st) / 1000;
      if (d > 50) tbt += d - 50;
      // что внутри
      const s = t.ts, en = t.ts + t.dur, agg = {};
      mt.forEach(e => { if (e !== t && e.ts >= s && e.ts < en && ['Layout', 'UpdateLayoutTree', 'EvaluateScript', 'FunctionCall', 'ParseHTML', 'Paint', 'TimerFire', 'EventDispatch', 'FireAnimationFrame'].includes(e.name)) {
        let k = e.name; if (k === 'EvaluateScript' || k === 'FunctionCall') { const d2 = (e.args && e.args.data) || {}; k += ':' + String(d2.url || d2.functionName || '').split('/').pop().slice(0, 30); }
        agg[k] = (agg[k] || 0) + e.dur / 1000; } });
      const top = Object.entries(agg).sort((a, b) => b[1] - a[1]).slice(0, 5).map(([k, v]) => k + ' ' + Math.round(v)).join(', ');
      list.push(`@${Math.round((t.ts - t0) / 1000)} ${Math.round(t.dur / 1000)}ms [${top}]`);
    });
    const tot = {}; mt.forEach(e => { if (['Layout', 'UpdateLayoutTree'].includes(e.name)) tot.style = (tot.style || 0) + e.dur / 1000; if (['EvaluateScript', 'FunctionCall', 'TimerFire', 'FireAnimationFrame', 'EventDispatch'].includes(e.name)) tot.js = (tot.js || 0); });
    res.push(Math.round(tbt));
    console.log(`run ${r}: FCP ${Math.round((fcp - t0) / 1000)} TBT~${Math.round(tbt)} style+layout ${Math.round(tot.style)}`); list.forEach(x => console.log('   ', x));
  }
  console.log('TBT runs', res.join(' '));
})();
