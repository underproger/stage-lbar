# Сравнение bbox элементов: макет vs рендер (оба минус чистый фон), 1920x1080
import cv2, numpy as np, sys
ref = cv2.imread('/home/claude/sr/ref1920.png').astype(np.int32)
clean = cv2.resize(cv2.imread('/home/claude/sr/clean.png'), (1920, 1080), interpolation=cv2.INTER_AREA).astype(np.int32)
me = cv2.imread(sys.argv[1]).astype(np.int32)
regions = {
 'logo': (80, 30, 260, 120), 'nav': (300, 50, 1300, 95), 'phone': (1370, 45, 1600, 100), 'cta': (1600, 30, 1880, 112),
 't1': (1000, 225, 1740, 338), 't2': (1000, 350, 1740, 492), 't3': (1095, 492, 1420, 565),
 'line': (1015, 575, 1100, 592), 'sub': (1015, 610, 1480, 652), 'btn1': (1020, 672, 1310, 752), 'btn2': (1315, 672, 1560, 752),
 'btn1txt': (1060, 700, 1215, 724), 'btn2txt': (1345, 700, 1480, 724),
 'card1ic': (190, 860, 280, 925), 'card1num': (170, 930, 300, 970), 'card1txt': (170, 972, 300, 1010), 'card2txt': (380, 930, 530, 1010),
}
def bbox(img, r, thr):
    x1, y1, x2, y2 = r
    d = np.abs(img[y1:y2, x1:x2] - clean[y1:y2, x1:x2]).sum(2) > thr
    ys, xs = np.where(d)
    if len(xs) == 0: return None
    return (x1 + xs.min(), y1 + ys.min(), x1 + xs.max(), y1 + ys.max())
for k, r in regions.items():
    a = bbox(ref, r, 60); b = bbox(me, r, 60)
    if a and b:
        print(f"{k:9s} ref {a}  me {b}  Δ L{b[0]-a[0]:+d} T{b[1]-a[1]:+d} R{b[2]-a[2]:+d} B{b[3]-a[3]:+d}  w {a[2]-a[0]}→{b[2]-b[0]} h {a[3]-a[1]}→{b[3]-b[1]}")
    else: print(k, a, b)
