import sys
import numpy as np
from PIL import Image
def lines(im, x1, y1, x2, y2, th=420):
    reg = im[y1:y2, x1:x2]; d = (reg.sum(2) < th).any(1); r = np.where(d)[0]
    out = []; s = r[0]; p = r[0]
    for v in r[1:]:
        if v > p+2: out.append((s+y1, p+y1)); s = v
        p = v
    out.append((s+y1, p+y1))
    res = []
    for a, b in out:
        reg = im[a:b+1, x1:x2]; xs = np.where((reg.sum(2) < th).any(0))[0]
        res.append((int(xs.min()+x1), int(a), int(xs.max()+x1), int(b)))
    return res
for f in sys.argv[1:]:
    im = np.array(Image.open(f).convert('RGB')).astype(int)
    print(f)
    for name, box in (('c1', (1205, 345, 1800, 500)), ('c2', (1230, 525, 1860, 682)), ('c3', (1215, 705, 1850, 865))):
        print('  ', name, lines(im, *box))
