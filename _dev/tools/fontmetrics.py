from fontTools.ttLib import TTFont
from fontTools.varLib.instancer import instantiateVariableFont
import sys
def ink(path, text, axes):
    f = TTFont(path); f = instantiateVariableFont(f, axes)
    upm = f['head'].unitsPerEm; cmap = f.getBestCmap(); gs = f.getGlyphSet(); hm = f['hmtx']
    from fontTools.pens.boundsPen import BoundsPen
    x = 0; xmin = None; xmax = None
    for ch in text:
        g = cmap.get(ord(ch));
        if g is None: x += upm*0.3; continue
        bp = BoundsPen(gs); gs[g].draw(bp)
        if bp.bounds:
            a, b, c, d = bp.bounds
            xmin = x + a if xmin is None else min(xmin, x + a); xmax = x + c if xmax is None else max(xmax, x + c)
        x += hm[g][0]
    os2 = f['OS/2']
    return dict(upm=upm, adv=x/upm, ink=(xmax-xmin)/upm, cap=os2.sCapHeight/upm, xh=os2.sxHeight/upm, asc=f['hhea'].ascent/upm, desc=f['hhea'].descent/upm)
F = '/home/claude/ftest/'
nsd = F+'noto-serif-display-latin-standard-normal.woff2'
nsdx = F+'noto-serif-display-latin-ext-standard-normal.woff2'
dm = F+'dm-sans-latin-standard-normal.woff2'
if __name__ == "__main__":
    for label, path, text, axes, target in [
      ('h1 l1', nsd, 'Micropigmentare', {'wght':350,'wdth':75}, 665),
      ('h1 l2', nsd, 'premium', {'wght':300,'wdth':75}, 688),
      ('h1 l3 (Bucuresti approx)', nsd, 'in Bucuresti', {'wght':300,'wdth':75}, 281),
      ('logo', nsd, 'LBAR', {'wght':200,'wdth':62.5}, 148),
      ('nav Servicii', dm, 'Servicii', {'wght':400,'opsz':14}, 66),
      ('nav Portofoliu', dm, 'Portofoliu', {'wght':400,'opsz':14}, 90),
      ('nav Contact', dm, 'Contact', {'wght':400,'opsz':14}, 76),
      ('sub', dm, 'Rezultate naturale. Elegant care raman.', {'wght':400,'opsz':14}, 395),
      ('phone', dm, '+40 720 203 105', {'wght':400,'opsz':14}, 146),
    ]:
        m = ink(path, text, axes); fs = target/m['ink']
        print(f"{label:28s} font-size≈{fs:6.1f}px  cap={m['cap']*fs:5.1f} xh={m['xh']*fs:5.1f}  (cap/em {m['cap']:.3f} xh/em {m['xh']:.3f})")
