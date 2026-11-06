# tmeas.py IMG... — метрики заголовка блока 4: ink-боксы строк и базовые линии
import sys
import numpy as np
from PIL import Image
for f in sys.argv[1:]:
    im = np.array(Image.open(f).convert('RGB')).astype(int)
    def bb(x1, y1, x2, y2, th=330):
        reg = im[y1:y2, x1:x2]; d = reg.sum(2) < th; ys, xs = np.where(d)
        return (xs.min()+x1, ys.min()+y1, xs.max()+x1, ys.max()+y1) if len(xs) else None
    def bbc(x1, y1, x2, y2):
        reg = im[y1:y2, x1:x2]; c = (reg[..., 0]-reg[..., 2] > 35) & (reg.sum(2) < 560); ys, xs = np.where(c)
        return (xs.min()+x1, ys.min()+y1, xs.max()+x1, ys.max()+y1) if len(xs) else None
    # строки: ищем по профилю тёмных пикселей
    reg = im[70:330, 915:1700]; d = (reg.sum(2) < 330) | ((reg[..., 0]-reg[..., 2] > 35) & (reg.sum(2) < 560))
    rows = np.where(d.any(1))[0] + 70
    groups = []; s = rows[0]; p = rows[0]
    for r in rows[1:]:
        if r > p+4: groups.append((s, p)); s = r
        p = r
    groups.append((s, p))
    print(f, 'lines:', groups)
    M = bb(915, groups[0][0], 990, groups[0][1]+1)
    print('  M box', M, ' l1', bb(915, groups[0][0], 1700, groups[0][1]+1))
    if len(groups) > 1: print('  l2', bb(915, groups[1][0], 1700, groups[1][1]+1))
    if len(groups) > 2:
        print('  l3 roman', bb(1250, groups[2][0], 1700, groups[2][1]+1), ' copper', bbc(915, groups[2][0], 1320, groups[2][1]+1))
