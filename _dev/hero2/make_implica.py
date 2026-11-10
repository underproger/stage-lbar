# make_implica.py — фон блока «Micropigmentarea … implică» (lb-implica) из кадра пользователя 1672×941:
#   десктоп implica-bg-v2.webp 2166×1218 (Lanczos ×1.3 + лёгкая резкость) и -1440; мобильный implica-mobile-v2.webp 840×861 —
#   кроп уменьшенного десктопа (масштаб 0.74, сдвиг 2/31 — как у прежнего implica-mobile).
from PIL import Image, ImageFilter
SRC = '/mnt/user-data/uploads/06da823a-image.png'
OUT = '/home/claude/stage-lbar/assets/templates/redesign/img/'
d = Image.open(SRC).convert('RGB').resize((2166, 1218), Image.LANCZOS).filter(ImageFilter.UnsharpMask(radius=1.2, percent=40, threshold=2))
d.save(OUT + 'implica-bg-v2.webp', 'WEBP', quality=86, method=6)
d.resize((1440, 810), Image.LANCZOS).save(OUT + 'implica-bg-v2-1440.webp', 'WEBP', quality=86, method=6)
s = 0.74
d.resize((round(2166 * s), round(1218 * s)), Image.LANCZOS).crop((2, 31, 842, 892)).save(OUT + 'implica-mobile-v2.webp', 'WEBP', quality=86, method=6)
print('ok')
