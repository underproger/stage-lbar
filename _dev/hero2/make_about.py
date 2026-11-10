# make_about.py — фон блока «О микропигментации» (lb-about) из присланного пользователем кадра 1672×941 (новое фото в рамке, без печати):
#   десктоп about-bg-v2.webp 2166×1218 (Lanczos ×1.3 + лёгкая резкость), about-bg-v2-1440.webp; мобильный about-mobile-v2.webp —
#   кроп десктопа (40, 50, 840×1090), как у прежнего about-mobile. Геометрия рамки та же — фото услуг (TV img_bl1_about) ложится в неё, как раньше.
from PIL import Image, ImageFilter
SRC = '/mnt/user-data/uploads/22a10e15-image.png'
OUT = '/home/claude/stage-lbar/assets/templates/redesign/img/'
d = Image.open(SRC).convert('RGB').resize((2166, 1218), Image.LANCZOS).filter(ImageFilter.UnsharpMask(radius=1.2, percent=40, threshold=2))
d.save(OUT + 'about-bg-v2.webp', 'WEBP', quality=86, method=6)
d.resize((1440, 810), Image.LANCZOS).save(OUT + 'about-bg-v2-1440.webp', 'WEBP', quality=86, method=6)
d.crop((40, 50, 880, 1140)).save(OUT + 'about-mobile-v2.webp', 'WEBP', quality=86, method=6)
print('ok')
