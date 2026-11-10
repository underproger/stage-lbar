# build_logo.py — новый логотип LBar (by Ksenia Kobilianskaia) в SVG (шрифты: npm pack @fontsource/cinzel @fontsource/cormorant-garamond → F):
#   рукописная часть «LBar» + круг — трассировка PNG 354×129 (potrace, ×8);
#   мелкие надписи «— By —» и «KSENIA KOBILIANSKAIA» — набраны шрифтами (контуры, fontTools) по меркам исходника.
import sys, numpy as np, potrace
from PIL import Image, ImageFilter
from fontTools.ttLib import TTFont
from fontTools.pens.svgPathPen import SVGPathPen
from fontTools.pens.transformPen import TransformPen
from fontTools.pens.boundsPen import BoundsPen
SRC = '/mnt/user-data/uploads/8a8d19f3-image.png'
F = '/home/claude/b40/fonts/'
CAPS = sys.argv[1] if len(sys.argv) > 1 else F + 'fontsource-cinzel-5.3.0/files/cinzel-latin-600-normal.woff'
ITAL = sys.argv[3] if len(sys.argv) > 3 else F + 'fontsource-cormorant-garamond-5.3.0/files/cormorant-garamond-latin-600-italic.woff'
OUT = sys.argv[2] if len(sys.argv) > 2 else '/home/claude/b40/logo'
S = 8
def f(v): return ('%.2f' % v).rstrip('0').rstrip('.')

# --- трассировка: без строки подписи (y ≥ 104) и без «— By —» (x 159…230, y 92…103)
im = Image.open(SRC).convert('L')
a = np.array(im).copy()
a[104:, :] = 255
a[92:104, 159:231] = 255
big = Image.fromarray(a).resize((im.width * S, im.height * S), Image.LANCZOS).filter(ImageFilter.GaussianBlur(S * 0.35))
bm = potrace.Bitmap(np.array(big) >= 186)
d = []
for curve in bm.trace(turdsize=6 * S, alphamax=1.0, opticurve=True, opttolerance=0.25):
    d.append('M%s %s' % (f(curve.start_point.x / S), f(curve.start_point.y / S)))
    for seg in curve.segments:
        if seg.is_corner:
            d.append('L%s %sL%s %s' % (f(seg.c.x / S), f(seg.c.y / S), f(seg.end_point.x / S), f(seg.end_point.y / S)))
        else:
            d.append('C%s %s %s %s %s %s' % tuple(f(v / S) for v in (seg.c1.x, seg.c1.y, seg.c2.x, seg.c2.y, seg.end_point.x, seg.end_point.y)))
    d.append('Z')
script = ''.join(d)

# --- текст контурами: подгон по высоте прописных и по ширине строки (трекинг)
def text_path(font_file, text, x0, x1, base, cap_h, track=None):
    ft = TTFont(font_file); gs = ft.getGlyphSet(); cmap = ft.getBestCmap(); upm = ft['head'].unitsPerEm
    capH = getattr(ft['OS/2'], 'sCapHeight', 0) or 0.7 * upm
    sc = cap_h / capH
    names = [cmap[ord(ch)] for ch in text]
    def layout(tr):
        x, pos = 0.0, []
        for n in names:
            pos.append(x); x += gs[n].width * sc + tr
        return pos
    def bounds(pos):
        lo, hi = None, None
        for n, px in zip(names, pos):
            bp = BoundsPen(gs); gs[n].draw(bp)
            if bp.bounds:
                l, r = px + bp.bounds[0] * sc, px + bp.bounds[2] * sc
                lo = l if lo is None else min(lo, l); hi = r if hi is None else max(hi, r)
        return lo, hi
    if track is None:
        lo, hi = bounds(layout(0)); n_gaps = len(names) - 1
        track = ((x1 - x0) - (hi - lo)) / n_gaps
    pos = layout(track); lo, hi = bounds(pos); shift = x0 - lo
    out = []
    for n, px in zip(names, pos):
        sp = SVGPathPen(gs, ntos=lambda v: f(v))
        tp = TransformPen(sp, (sc, 0, 0, -sc, px + shift, base))
        gs[n].draw(tp); out.append(sp.getCommands())
    return ''.join(out)

caps = text_path(CAPS, 'KSENIA KOBILIANSKAIA', 71, 263.6, 118, 8.0)
by = text_path(ITAL, 'By', 175.2, 186.6, 101.2, 7.4, track=0)
lines = 'M160 99.05h8v.7h-8zM193 99.05h34v.7h-34z'
vb = '50 1 216 119'
for name, col in (('', '#816e63'), ('-light', '#d9b49e')):
    open(f'{OUT}{name}.svg', 'w').write(f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="{vb}"><path fill="{col}" fill-rule="evenodd" d="{script}"/><path fill="{col}" d="{caps}{by}{lines}"/></svg>')
print('ok', OUT)
