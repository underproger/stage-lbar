import sys; sys.path.insert(0,'/home/claude/tools')
from fontmetrics import ink
F='/home/claude/ftest/'
mont=F+'montserrat-latin-wght-normal.woff2'; monti=F+'montserrat-latin-wght-italic.woff2'
pfd=F+'playfair-display-latin-wght-normal.woff2'; pfdi=F+'playfair-display-latin-wght-italic.woff2'
def calc(label, path, text, axes, target, ls_em=0.0):
    m=ink(path,text,axes); n=len(text)-1
    fs=target/(m['ink']+ls_em*n)
    print(f"{label:22s} fs≈{fs:6.2f}  cap={m['cap']*fs:5.1f} xh={m['xh']*fs:5.1f}")
calc('h1 PFD500 ls-.02', pfd, 'Machiaj permanent —', {'wght':500}, 757, -0.02)
calc('h2 PFDi400 ls-.015', pfdi, 'frumusete accentuata cu eleganta', {'wght':400}, 950, -0.015)
calc('p Mont400', mont, 'Micropigmentarea este solutia ideala pentru un look ingrijit,', {'wght':400}, 811)
calc('label Mont600', mont, 'Aspect natural si armonios', {'wght':600}, 395)
calc('label Mont700', mont, 'Aspect natural si armonios', {'wght':700}, 395)
calc('quote Monti400', monti, 'La Studio Lbar, fiecare procedura este realizata', {'wght':400}, 617)
for ls in (0.18,0.2,0.22,0.25):
    calc(f'eyebrow Mont500 ls{ls}', mont, 'DESPRE MICROPIGMENTARE', {'wght':500}, 394, ls)
for ls in (0.18,0.2,0.22):
    calc(f'cta Mont600 ls{ls}', mont, 'PROGRAMEAZA O CONSULTATIE', {'wght':600}, 447, ls)
