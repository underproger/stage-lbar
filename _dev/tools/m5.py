import sys
import numpy as np
from PIL import Image
for f in sys.argv[1:]:
    im = np.array(Image.open(f).convert('RGB')).astype(int)
    def lines(x1, y1, x2, y2, th, copper=False):
        reg = im[y1:y2, x1:x2]
        d = ((reg[..., 0]-reg[..., 2] > 35) & (reg.sum(2) < 600)) if copper else (reg.sum(2) < th)
        r = np.where(d.any(1))[0]
        if not len(r): return []
        out = []; s = r[0]; p = r[0]
        for v in r[1:]:
            if v > p+2: out.append((s+y1, p+y1)); s = v
            p = v
        out.append((s+y1, p+y1))
        res = []
        for a, b in out:
            xs = np.where(d[a-y1:b-y1+1].any(0))[0]; res.append((int(xs.min()+x1), int(a), int(xs.max()+x1), int(b)))
        return res
    print(f)
    print('  eyebrow', lines(130, 80, 700, 125, 520))
    print('  title  ', lines(130, 160, 720, 345, 330))
    print('  italic ', lines(110, 350, 720, 465, 0, True))
    print('  sub    ', lines(130, 540, 720, 690, 450))
    print('  +40    ', lines(1003, 360, 1080, 405, 200))
    print('  ph2    ', lines(1160, 360, 1600, 405, 420))
    print('  ph1    ', lines(1030, 245, 1500, 285, 420))
