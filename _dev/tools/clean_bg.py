# Убирает UI-элементы со скрина макета (на апскейле x2): push-pull заливка гладким фоном + зерно.
import cv2, numpy as np, sys, json
src = sys.argv[3] if len(sys.argv) > 3 else '/home/claude/sr/up2.png'
img = cv2.imread(src).astype(np.float32)
H, W = img.shape[:2]
import os
OX, OY, S = float(os.environ.get('OX', 6)), float(os.environ.get('OY', 4)), 2.0
rects = json.load(open(sys.argv[1]))
mask = np.zeros((H, W), np.float32)
for name, r in rects.items():
    x1, y1, x2, y2 = r[:4]
    a = (int((x1-OX)*S), int((y1-OY)*S), int((x2-OX)*S), int((y2-OY)*S))
    rad = int(r[4]*S) if len(r) > 4 else 0
    if rad:
        cv2.rectangle(mask, (a[0]+rad, a[1]), (a[2]-rad, a[3]), 1, -1)
        cv2.rectangle(mask, (a[0], a[1]+rad), (a[2], a[3]-rad), 1, -1)
        for cx, cy in ((a[0]+rad, a[1]+rad), (a[2]-rad, a[1]+rad), (a[0]+rad, a[3]-rad), (a[2]-rad, a[3]-rad)):
            cv2.circle(mask, (cx, cy), rad, 1, -1)
    else:
        cv2.rectangle(mask, a[:2], a[2:], 1, -1)
def pushpull(im, w):
    if min(im.shape[:2]) <= 4:
        s = w.sum()
        val = (im*w[...,None]).sum((0,1))/max(s,1e-6)
        return np.where(w[...,None] > 0, im, val)
    h, ww = im.shape[:2]
    # push: weighted downsample
    imw = cv2.resize(im*w[...,None], ((ww+1)//2, (h+1)//2), interpolation=cv2.INTER_AREA)
    wd = cv2.resize(w, ((ww+1)//2, (h+1)//2), interpolation=cv2.INTER_AREA)
    small = imw/np.maximum(wd, 1e-6)[...,None]
    small = pushpull(small, np.clip(wd*4, 0, 1))
    up = cv2.resize(small, (ww, h), interpolation=cv2.INTER_LINEAR)
    up = cv2.GaussianBlur(up, (5, 5), 1.2)
    return im*w[...,None] + up*(1-w[...,None])
known = 1 - mask
res = pushpull(img, known)
m3 = cv2.GaussianBlur(mask, (7, 7), 2)[...,None]
out = img*(1-m3) + res*m3
rng = np.random.default_rng(1)
out = out + rng.normal(0, 1.4, img.shape).astype(np.float32)*m3
cv2.imwrite(sys.argv[2], np.clip(out, 0, 255).astype(np.uint8))
