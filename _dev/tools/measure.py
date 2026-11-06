import cv2, numpy as np, json
a = cv2.imread('/home/claude/sr/up2.png').astype(np.int32)
b = cv2.imread('/home/claude/sr/clean.png').astype(np.int32)
d = np.abs(a-b).sum(2)
K = 1920/2166
rects = json.load(open('/home/claude/sr/rects.json'))
OX, OY, S = 6, 4, 2
for name, r in rects.items():
    x1, y1, x2, y2 = [int((v-o)*S) for v, o in zip(r[:4], (OX, OY, OX, OY))]
    sub = (d[y1:y2, x1:x2] > 40).astype(np.uint8)
    # merge horizontally close parts into words: dilate
    k = np.ones((3, 9), np.uint8)
    dil = cv2.dilate(sub, k)
    n, lab, st, _ = cv2.connectedComponentsWithStats(dil)
    parts = []
    for i in range(1, n):
        x, y, w, h, area = st[i]
        if area < 30: continue
        parts.append([round((x1+x)*K), round((y1+y)*K), round(w*K), round(h*K)])
    parts.sort(key=lambda p: (p[1]//20, p[0]))
    print(name, 'x,y,w,h @1920:', parts[:12])
