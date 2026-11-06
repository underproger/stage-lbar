# Очистка фона блока 4 (координаты прямоугольников — в системе 1920×1080).
import cv2, numpy as np, json, sys
src, out = sys.argv[1], sys.argv[2]
img = cv2.imread(src).astype(np.float32)
H, W = img.shape[:2]
sx, sy = W/1920, H/1081
mask = np.zeros((H, W), np.float32)
def rect(x1, y1, x2, y2, rad=0):
    a = (int(x1*sx), int(y1*sy), int(x2*sx), int(y2*sy)); r = int(rad*sx)
    if r:
        cv2.rectangle(mask, (a[0]+r, a[1]), (a[2]-r, a[3]), 1, -1)
        cv2.rectangle(mask, (a[0], a[1]+r), (a[2], a[3]-r), 1, -1)
        for cx, cy in ((a[0]+r, a[1]+r), (a[2]-r, a[1]+r), (a[0]+r, a[3]-r), (a[2]-r, a[3]-r)):
            cv2.circle(mask, (cx, cy), r, 1, -1)
    else:
        cv2.rectangle(mask, a[:2], a[2:], 1, -1)
R = json.load(open(sys.argv[3]))
for name, r in R['rects'].items():
    rect(*r)
# дуга: окружность (cx, cy, r) в координатах 1920, от y0 до y1, полоса ±band
if R.get('arcmask'):
    am = cv2.imread(R['arcmask'], 0) > 0
    am = cv2.dilate(am.astype(np.uint8), cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5)))
    mask = np.maximum(mask, am.astype(np.float32))
for (dx, dy, dr) in R['dots']:
    cv2.circle(mask, (int(dx*sx), int(dy*sy)), int(dr*sx), 1, -1)
# логотип на фото: светлые штрихи ярче локального фона → маска + inpaint
x1, y1, x2, y2 = R['logo']
X1, Y1, X2, Y2 = int(x1*sx), int(y1*sy), int(x2*sx), int(y2*sy)
reg = img[Y1:Y2, X1:X2].mean(2)
bgl = cv2.morphologyEx(reg, cv2.MORPH_OPEN, cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (25, 25)))
lm = ((reg - bgl) > R.get('logo_th', 10)).astype(np.uint8)
box = np.zeros_like(lm)
for b in R['logo_boxes']:
    cv2.rectangle(box, (int(b[0]*sx)-X1, int(b[1]*sy)-Y1), (int(b[2]*sx)-X1, int(b[3]*sy)-Y1), 1, -1)
lm = lm & box
lm = cv2.dilate(lm, cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (9, 9)))
logo_mask = np.zeros((H, W), np.uint8); logo_mask[Y1:Y2, X1:X2] = lm
for r in R.get('logo_rects', []):
    a = (int(r[0]*sx), int(r[1]*sy), int(r[2]*sx), int(r[3]*sy)); cv2.rectangle(logo_mask, a[:2], a[2:], 1, -1)
cv2.imwrite(out.replace('.png', '-logomask.png'), logo_mask*255)
base = cv2.inpaint(np.clip(img, 0, 255).astype(np.uint8), logo_mask, 6, cv2.INPAINT_TELEA).astype(np.float32)
def pushpull(im, w):
    if min(im.shape[:2]) <= 4:
        s = w.sum(); val = (im*w[..., None]).sum((0, 1))/max(s, 1e-6)
        return np.where(w[..., None] > 0, im, val)
    h, ww = im.shape[:2]
    imw = cv2.resize(im*w[..., None], ((ww+1)//2, (h+1)//2), interpolation=cv2.INTER_AREA)
    wd = cv2.resize(w, ((ww+1)//2, (h+1)//2), interpolation=cv2.INTER_AREA)
    small = imw/np.maximum(wd, 1e-6)[..., None]
    small = pushpull(small, np.clip(wd*4, 0, 1))
    up = cv2.resize(small, (ww, h), interpolation=cv2.INTER_LINEAR)
    up = cv2.GaussianBlur(up, (5, 5), 1.2)
    return im*w[..., None] + up*(1-w[..., None])
res = pushpull(base, 1-mask)
m3 = cv2.GaussianBlur(mask, (9, 9), 2.5)[..., None]
outim = base*(1-m3) + res*m3
rng = np.random.default_rng(1)
outim = outim + rng.normal(0, 1.3, img.shape).astype(np.float32)*m3
cv2.imwrite(out, np.clip(outim, 0, 255).astype(np.uint8))
cv2.imwrite(out.replace('.png', '-mask.png'), (np.maximum(mask, logo_mask)*255).astype(np.uint8))
