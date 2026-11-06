import sys, io, glob, os
import numpy as np
from PIL import Image, ImageDraw, ImageFont
from fontTools.ttLib import TTFont
from fontTools.varLib.instancer import instantiateVariableFont
ref = np.array(Image.open('/home/claude/b4/ref1920.png').convert('L')).astype(float)
def refcrop(x1, y1, x2, y2):
    reg = ref[y1:y2, x1:x2]; d = reg < 120
    ys, xs = np.where(d); return 255 - reg[ys.min():ys.max()+1, xs.min():xs.max()+1]
TARGETS = {
  'l1': ('Micropigmentarea', refcrop(920, 85, 1700, 160)),
  'l2': ('în salonul nostru din', refcrop(920, 160, 1700, 228)),
  'impl': ('implică:', refcrop(1310, 228, 1700, 305)),
}
def ttf(path, axes=None):
    f = TTFont(path)
    if axes and 'fvar' in f: f = instantiateVariableFont(f, axes)
    f.flavor = None; b = io.BytesIO(); f.save(b); b.seek(0); return b
def render(fontbytes, text, size=200):
    fontbytes.seek(0); fnt = ImageFont.truetype(fontbytes, size)
    im = Image.new('L', (size*len(text), size*2), 0); d = ImageDraw.Draw(im); d.text((size//2, size//2), text, font=fnt, fill=255)
    a = np.array(im).astype(float); ys, xs = np.where(a > 128); return a[ys.min():ys.max()+1, xs.min():xs.max()+1], fnt
def score(fb, key):
    text, tgt = TARGETS[key]
    r, fnt = render(fb, text)
    # aspect ratio of ink box vs target
    ar_r = r.shape[1]/r.shape[0]; ar_t = tgt.shape[1]/tgt.shape[0]
    rr = np.array(Image.fromarray(r.astype(np.uint8)).resize((tgt.shape[1], tgt.shape[0]), Image.LANCZOS)).astype(float)
    a = rr > 110; b = tgt > 110
    iou = (a & b).sum()/max((a | b).sum(), 1)
    return ar_r/ar_t, iou
C = {}
N = '/home/claude/fonttest/node_modules/'
R = '/home/claude/stage-lbar/assets/templates/redesign/fonts/'
def pick(pkg, pat):
    g = sorted(glob.glob(N + pkg + '/files/' + pat)); return g[0] if g else None
cands = [
 ('Playfair 400', R+'playfair-display-latin-wght-normal.woff2', {'wght': 400}),
 ('Playfair 500', R+'playfair-display-latin-wght-normal.woff2', {'wght': 500}),
 ('NSD 400 wd100', R+'noto-serif-display-latin-standard-normal.woff2', {'wght': 400, 'wdth': 100}),
 ('NSD 400 wd87', R+'noto-serif-display-latin-standard-normal.woff2', {'wght': 400, 'wdth': 87.5}),
 ('DM Serif Display', pick('@fontsource/dm-serif-display', '*latin-400-normal.woff2'), None),
 ('Gilda Display', pick('@fontsource/gilda-display', '*latin-400-normal.woff2'), None),
 ('Prata', pick('@fontsource/prata', '*latin-400-normal.woff2'), None),
 ('Bodoni Moda 500', pick('@fontsource-variable/bodoni-moda', '*latin-wght-normal.woff2'), {'wght': 500}),
 ('Libre Caslon Display', pick('@fontsource/libre-caslon-display', '*latin-400-normal.woff2'), None),
 ('Abhaya Libre 500', pick('@fontsource/abhaya-libre', '*latin-500-normal.woff2'), None),
 ('Frank Ruhl 500', pick('@fontsource-variable/frank-ruhl-libre', '*latin-wght-normal.woff2'), {'wght': 500}),
 ('Libre Baskerville', pick('@fontsource/libre-baskerville', '*latin-400-normal.woff2'), None),
 ('Cormorant 600', pick('@fontsource-variable/cormorant', '*latin-wght-normal.woff2'), {'wght': 600}),
 ('Lora 500', pick('@fontsource-variable/lora', '*latin-wght-normal.woff2'), {'wght': 500}),
 ('DM Serif Text', pick('@fontsource/dm-serif-text', '*latin-400-normal.woff2'), None),
 ('Source Serif 500', pick('@fontsource-variable/source-serif-4', '*latin-wght-normal.woff2'), {'wght': 500}),
 ('Fraunces 500', pick('@fontsource-variable/fraunces', '*latin-full-normal.woff2') or pick('@fontsource-variable/fraunces', '*latin-wght-normal.woff2'), {'wght': 500}),
 ('Young Serif', pick('@fontsource/young-serif', '*latin-400-normal.woff2'), None),
]
for name, path, axes in cands:
    if not path: print('skip', name); continue
    try:
        fb = ttf(path, axes)
        res = [score(fb, k) for k in ('l1', 'l2')]
        print(f"{name:22s} " + '  '.join(f"{k}: ar {a:.3f} iou {i:.3f}" for k, (a, i) in zip(('l1', 'l2'), res)))
    except Exception as e:
        print(name, 'ERR', e)
