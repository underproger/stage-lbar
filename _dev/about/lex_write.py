# Переписывает блок «страница «О нас»» в лексиконах ro / ru / en из ab.py (ключи lbar.rd.ab.*). Запуск: python3 _dev/about/lex_write.py
import os, re, sys
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from ab import T
ROOT = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
esc = lambda s: s.replace('\\', '\\\\').replace('"', '\\"').replace('$', '\\$')
for i, l in enumerate(('ro', 'ru', 'en')):
    p = f'{ROOT}/core/components/babel/lexicon/{l}/translate.inc.php'
    s = open(p, encoding='utf-8').read()
    s = re.sub(r"\n// страница «О нас» \(шаг 47\)\n(?:\$_lang\['lbar\.rd\.ab\.[^\n]*\n)*", '\n', s)
    s = re.sub(r"\$_lang\['lbar\.rd\.ab\.[^\n]*\n", '', s)
    add = '// страница «О нас» (шаг 47)\n' + ''.join(f'$_lang[\'lbar.rd.ab.{k}\'] = "{esc(v[i])}";\n' for k, v in T.items())
    open(p, 'w', encoding='utf-8').write(s.rstrip('\n') + '\n\n' + add)
print(len(T), 'keys')
