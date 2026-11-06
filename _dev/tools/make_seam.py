# Генератор декора «перетекающего фона» (шёлковая лента + медные линии) для стыка блоков.
# make_seam.py OUT.svg "x:dy x:dy …" [толщина-середины] [толщина-краёв]
#   x — px макета 1920, dy — смещение центра ленты от линии стыка (минус — в верхнем блоке, плюс — в нижнем).
# viewBox 1920×760, линия стыка — y = 380 (в CSS декор рисуется половинками в обоих блоках).
import sys, math
out, spec = sys.argv[1], sys.argv[2]
mid_t = float(sys.argv[3]) if len(sys.argv) > 3 else 34
end_t = float(sys.argv[4]) if len(sys.argv) > 4 else 16
pts = [(float(a), 380 + float(b)) for a, b in (p.split(':') for p in spec.split())]

def catmull(points, n=24):
    P = [points[0]] + points + [points[-1]]
    res = []
    for i in range(1, len(P) - 2):
        p0, p1, p2, p3 = P[i-1], P[i], P[i+1], P[i+2]
        for k in range(n):
            t = k / n; t2 = t*t; t3 = t2*t
            res.append(tuple(0.5*((2*p1[j]) + (-p0[j]+p2[j])*t + (2*p0[j]-5*p1[j]+4*p2[j]-p3[j])*t2 + (-p0[j]+3*p1[j]-3*p2[j]+p3[j])*t3) for j in (0, 1)))
    res.append(points[-1]); return res

C = catmull(pts)
x0, x1 = C[0][0], C[-1][0]
def thick(x):
    u = (x - x0) / (x1 - x0)          # 0..1 вдоль ленты
    return end_t + (mid_t - end_t) * math.sin(math.pi * u) ** 1.2
def offset(curve, sgn, extra=0.0):
    o = []
    for i, (x, y) in enumerate(curve):
        a = curve[max(i-1, 0)]; b = curve[min(i+1, len(curve)-1)]
        dx, dy = b[0]-a[0], b[1]-a[1]; L = math.hypot(dx, dy) or 1
        nx, ny = -dy/L, dx/L
        t = thick(x) * sgn + extra * sgn
        o.append((x + nx*t, y + ny*t))
    return o
def poly(p): return 'M' + ' L'.join(f'{x:.1f} {y:.1f}' for x, y in p)
top, bot = offset(C, -1), offset(C, 1)
band = poly(top) + ' L' + ' L'.join(f'{x:.1f} {y:.1f}' for x, y in reversed(bot)) + 'Z'
line1 = poly(offset(C, -1, -4))
line2 = poly(offset(C, 1, -6))
svg = f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 760" preserveAspectRatio="none">
  <!-- сгенерировано _dev/tools/make_seam.py: {spec} -->
  <defs>
    <linearGradient id="band" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#fff" stop-opacity="0"/>
      <stop offset=".22" stop-color="#fff" stop-opacity=".55"/>
      <stop offset=".72" stop-color="#fff" stop-opacity=".45"/>
      <stop offset="1" stop-color="#fff" stop-opacity="0"/>
    </linearGradient>
    <linearGradient id="line" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0" stop-color="#c49a83" stop-opacity="0"/>
      <stop offset=".18" stop-color="#c49a83" stop-opacity=".5"/>
      <stop offset=".82" stop-color="#c49a83" stop-opacity=".45"/>
      <stop offset="1" stop-color="#c49a83" stop-opacity="0"/>
    </linearGradient>
    <filter id="soft" x="-5%" y="-30%" width="110%" height="160%">
      <feGaussianBlur stdDeviation="14"/>
    </filter>
  </defs>
  <path filter="url(#soft)" fill="url(#band)" d="{band}"/>
  <path fill="none" stroke="url(#line)" stroke-width="1.4" d="{line1}"/>
  <path fill="none" stroke="url(#line)" stroke-width="1" stroke-opacity=".6" d="{line2}"/>
</svg>
'''
open(out, 'w').write(svg)
print(out, len(svg), 'bytes')
