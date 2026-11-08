# Трассировка букв LBAR (PNG с альфой) в SVG-контуры (potracer)
import numpy as np, potrace
from PIL import Image
a = np.array(Image.open('lbar.png'))
al = a[..., 3] > 127
H, W = al.shape
bm = potrace.Bitmap(al)
plist = bm.trace(turdsize=4, turnpolicy=potrace.POTRACE_TURNPOLICY_MINORITY, alphamax=1.0, opticurve=True, opttolerance=0.2)
def f(p): return f"{p.x:.1f} {p.y:.1f}"
paths = []
for curve in plist:
    d = "M" + f(curve.start_point)
    for seg in curve.segments:
        if seg.is_corner:
            d += " L" + f(seg.c) + " L" + f(seg.end_point)
        else:
            d += " C" + f(seg.c1) + " " + f(seg.c2) + " " + f(seg.end_point)
    d += "Z"
    xs = [curve.start_point.x] + [s.end_point.x for s in curve.segments]
    paths.append((min(xs), max(xs), d))
print(len(paths), [(round(a), round(b)) for a, b, _ in paths])
import json; json.dump([(a, b, d) for a, b, d in paths], open('lbar_paths.json', 'w'))
svg = f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {W} {H}"><path fill="#b26f5f" fill-rule="evenodd" d="{" ".join(d for _,_,d in paths)}"/></svg>'
open('lbar_trace.svg', 'w').write(svg)
print(len(svg))
