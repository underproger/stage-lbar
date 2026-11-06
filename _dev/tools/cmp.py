# cmp.py REF SHOT OUTPREFIX [x1 y1 x2 y2] — наложение 50/50 и попеременные полосы
import sys
from PIL import Image, ImageChops
ref = Image.open(sys.argv[1]).convert('RGB'); shot = Image.open(sys.argv[2]).convert('RGB').crop((0, 0, ref.width, ref.height))
box = tuple(map(int, sys.argv[4:8])) if len(sys.argv) > 7 else (0, 0, ref.width, ref.height)
r, s = ref.crop(box), shot.crop(box)
Image.blend(r, s, .5).save(sys.argv[3] + '-blend.png')
d = ImageChops.difference(r, s).point(lambda v: min(255, v*3)); d.save(sys.argv[3] + '-diff.png')
w = r.width; h = r.height
st = Image.new('RGB', (w, h*2)); st.paste(r, (0, 0)); st.paste(s, (0, h)); st.save(sys.argv[3] + '-stack.png')
