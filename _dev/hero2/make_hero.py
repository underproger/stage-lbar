# make_hero.py — новое фото мастера в баннере главной:
#  десктоп: hero-master-v2.webp (570 px) / -2x (1140 px) — вырезка из присланного PNG 1086×1448 (прозрачный фон), без обработки;
#  мобильный: hero-mobile.webp = кроп чистого фона hero-bg-2880 (масштаб 0.79, сдвиг 6/71 — как у прежней картинки) + мастер, низ растворён.
import numpy as np
from PIL import Image
IMG = '/home/claude/stage-lbar/assets/templates/redesign/img/'
src = Image.open('/mnt/user-data/uploads/1f030f57-image.png').convert('RGBA')
for w, name in ((570, 'hero-master-v2.webp'), (1140, 'hero-master-v2-2x.webp')):
    h = round(src.height * w / src.width)
    src.resize((w, h), Image.LANCZOS).save(IMG + name, 'WEBP', quality=86, method=6)
    print(name, w, h)
bg = Image.open(IMG + 'hero-bg-2880.webp').convert('RGB')
s = 0.79
bgs = bg.resize((round(bg.width * s), round(bg.height * s)), Image.LANCZOS)
W, H = 1060, 1107
mob = bgs.crop((6, 71, 6 + W, 71 + H)).convert('RGBA')
mw = 740; mh = round(src.height * mw / src.width)
m = src.resize((mw, mh), Image.LANCZOS)
a = np.array(m).astype(np.float32)
fade0, fade1 = int(mh * 0.80), mh            # низ растворяется, как маска на десктопе
ramp = np.ones(mh, np.float32); ramp[fade0:fade1] = np.linspace(1, 0, fade1 - fade0) ** 1.4
a[:, :, 3] *= ramp[:, None]
m = Image.fromarray(a.astype(np.uint8), 'RGBA')
cx, top = 527, 70
mob.alpha_composite(m, (cx - mw // 2, top))
mob.convert('RGB').save(IMG + 'hero-mobile-v2.webp', 'WEBP', quality=84, method=6)
print('mobile', mw, mh, 'bottom', top + mh)
