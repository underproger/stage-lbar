# Подмена внешних файлов intl-tel-input на локальные копии (в песочнице внешние запросы закрыты).
import os
ITI = '/home/claude/iti/node_modules/intl-tel-input/build/'
MAP = {'intlTelInput.min.js': ('js/intlTelInput.min.js', 'application/javascript'),
       'intlTelInput.css': ('css/intlTelInput.css', 'text/css'),
       'flags.png': ('img/flags.png', 'image/png'), 'flags@2x.png': ('img/flags@2x.png', 'image/png'),
       'utils.js': ('js/utils.js', 'application/javascript')}
async def route(r):
    url = r.request.url; host = url.split('/')[2]
    if host.endswith('touchit.vinnica.ua') or host.endswith('lbar.ro'):
        return await r.continue_()
    if 'intl-tel-input' in url:
        name = url.split('?')[0].rsplit('/', 1)[-1]
        if name in MAP:
            path, ct = MAP[name]
            return await r.fulfill(path=ITI + path, content_type=ct)
    await r.abort()
