import cv2, numpy as np
a = cv2.imread('bg_clean.png'); H, W = a.shape[:2]
g = cv2.cvtColor(a, cv2.COLOR_BGR2GRAY).astype(np.float32)
dark = cv2.GaussianBlur(g, (0, 0), 6) - g
m = np.zeros((H, W), np.uint8)
# вертикальная линия и кружок
m[200:800, 802:811] = 255
cv2.circle(m, (806, 220), 20, 255, -1)
# дуги: ноги и окружности (центры/радиусы — подгонка по пикселям)
arcs = [(1641.5, 573.4, 146.8), (1643.2, 574.3, 118.9), (1645.8, 574.4, 91.2)]
for cx, cy, r in arcs:
    cv2.ellipse(m, (int(round(cx * 4)), int(round(cy * 4))), (int(round(r * 4)), int(round(r * 4))), 0, 180, 360, 255, 4 * 5, cv2.LINE_AA, 2)
    lx = int(round(cx - r))
    m[int(cy) - 2:945, lx - 3:lx + 4] = 255
# искры и свечения
for (x, y, rad) in ((799.8, 443.4, 16), (805.8, 470.4, 18), (1526.2, 555.8, 20), (1525.5, 585.0, 14)):
    cv2.circle(m, (int(round(x)), int(round(y))), rad, 255, -1)
# оставляем только там, где реально есть отличие от фона (+ запас), чтобы не трогать лишнего
br = g - cv2.GaussianBlur(g, (0, 0), 10)
sig = ((dark > 1.0) | (br > 2.0)).astype(np.uint8) * 255
sig = cv2.dilate(sig, np.ones((5, 5), np.uint8))
mask = cv2.bitwise_and(m, sig)
mask = cv2.dilate(mask, np.ones((3, 3), np.uint8))
# искры и кружок целиком
cv2.circle(mask, (806, 220), 20, 255, -1)
for (x, y, rad) in ((799.8, 443.4, 16), (805.8, 470.4, 18), (1526.2, 555.8, 20), (1525.5, 585.0, 14)):
    cv2.circle(mask, (int(round(x)), int(round(y))), rad, 255, -1)
cv2.imwrite('mask.png', mask)
out = cv2.inpaint(a, mask, 6, cv2.INPAINT_TELEA)
cv2.imwrite('bg_nodeco.png', out)
print('mask px', int((mask > 0).sum()))
