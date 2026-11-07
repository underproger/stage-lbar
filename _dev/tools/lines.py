# lines.py IMG x1 y1 x2 y2 [th] [mode] — строки (ink-боксы) в области; mode: dark (по умолчанию) | copper | light
import sys
import numpy as np
from PIL import Image
im = np.array(Image.open(sys.argv[1]).convert('RGB')).astype(int)
x1, y1, x2, y2 = map(int, sys.argv[2:6]); th = int(sys.argv[6]) if len(sys.argv) > 6 else 330
mode = sys.argv[7] if len(sys.argv) > 7 else 'dark'
reg = im[y1:y2, x1:x2]
if mode == 'copper': d = (reg[..., 0]-reg[..., 2] > 30) & (reg.sum(2) < th)
elif mode == 'light': d = reg.sum(2) > th
else: d = reg.sum(2) < th
r = np.where(d.any(1))[0]
if not len(r): print('none'); sys.exit()
out = []; s = r[0]; p = r[0]
for v in r[1:]:
    if v > p+2: out.append((s+y1, p+y1)); s = v
    p = v
out.append((s+y1, p+y1))
for a, b in out:
    xs = np.where(d[a-y1:b-y1+1].any(0))[0]
    print((int(xs.min()+x1), int(a), int(xs.max()+x1), int(b)), 'h', b-a+1, 'w', int(xs.max()-xs.min()+1))
