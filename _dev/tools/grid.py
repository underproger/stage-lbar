# grid.py IN OUT x1 y1 x2 y2 scale step — crop with coordinate grid (coords in source px), labels every 5 steps
import sys
from PIL import Image, ImageDraw, ImageFont
src, out = sys.argv[1], sys.argv[2]
x1, y1, x2, y2 = map(int, sys.argv[3:7]); s = float(sys.argv[7]); step = int(sys.argv[8])
im = Image.open(src).convert('RGB').crop((x1, y1, x2, y2))
im = im.resize((int(im.width*s), int(im.height*s)), Image.LANCZOS).convert('RGBA')
ov = Image.new('RGBA', im.size, (0,0,0,0)); d = ImageDraw.Draw(ov)
f = ImageFont.load_default()
for x in range((x1//step+1)*step, x2, step):
    X = (x-x1)*s; major = x % (step*5) == 0
    d.line([(X,0),(X,im.height)], fill=(255,0,0,150) if major else (0,120,255,60), width=1)
    if major: d.text((X+2,2), str(x), fill=(255,0,0,255), font=f)
for y in range((y1//step+1)*step, y2, step):
    Y = (y-y1)*s; major = y % (step*5) == 0
    d.line([(0,Y),(im.width,Y)], fill=(255,0,0,150) if major else (0,120,255,60), width=1)
    if major: d.text((2,Y+2), str(y), fill=(255,0,0,255), font=f)
Image.alpha_composite(im, ov).convert('RGB').save(out)
