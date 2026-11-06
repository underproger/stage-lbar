# маска медной дуги + точек (детекция по отличию от локального фона)
import cv2, numpy as np, sys
img = cv2.imread(sys.argv[1]).astype(np.float32)
H, W = img.shape[:2]; sx, sy = W/1920, H/1081
X1, X2, Y1, Y2 = int(870*sx), int(1080*sx), int(285*sy), int(960*sy)
reg = img[Y1:Y2, X1:X2]
L = reg.mean(2)
bg = cv2.medianBlur(np.clip(L, 0, 255).astype(np.uint8), 31).astype(np.float32)
b, g, r = reg[..., 0], reg[..., 1], reg[..., 2]
dark = (bg - L) > 6
copper = (r - b) > 14
glove = (L < 90) & ((r - b) < 30)
m = (dark & copper & ~glove).astype(np.uint8)
# убрать мелкий шум: оставить компоненты, похожие на линию (площадь > 20)
n, lab, st, _ = cv2.connectedComponentsWithStats(m, 8)
keep = np.zeros_like(m)
for i in range(1, n):
    if st[i, cv2.CC_STAT_AREA] > 25: keep[lab == i] = 1
keep = cv2.dilate(keep, cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (7, 7)))
out = np.zeros((H, W), np.uint8); out[Y1:Y2, X1:X2] = keep
cv2.imwrite(sys.argv[2], out*255)
# центры точек: крупные тёмные пятна
dm = ((bg - L) > 60) & copper & ~glove
n, lab, st, cen = cv2.connectedComponentsWithStats(dm.astype(np.uint8), 8)
for i in range(1, n):
    if st[i, cv2.CC_STAT_AREA] > 150:
        print('dot', round((cen[i][0]+X1)/sx, 1), round((cen[i][1]+Y1)/sy, 1), 'area', st[i, cv2.CC_STAT_AREA], 'wh', st[i, 2]/sx, st[i, 3]/sy)
