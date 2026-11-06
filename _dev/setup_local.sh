#!/bin/bash
# Локальное окружение stage-lbar в облачной сессии Claude (Ubuntu 24.04, root).
# Запуск из корня репо:
#   bash _dev/setup_local.sh <дамп> <патч> <патч> …   — файлы импортируются по порядку, например:
#   bash _dev/setup_local.sh mysql_impua_testlbar_….tar.gz stage-lbar-urls.sql stage-lbar-01-header-banner.sql \
#        stage-lbar-02-about.sql stage-lbar-03-services.sql stage-lbar-04-implica.sql
#   (или lbar-full-stage-2026-11-06.sql.gz = дамп + urls + 01, затем 02, 03, 04)
#   Форматы: .sql, .sql.gz, .tar.gz; строка «enable the sandbox mode» вырезается при импорте.
# После перезапуска контейнера (MariaDB/Apache упали, /etc/hosts сброшен): bash _dev/tools/up.sh
set -e
REPO=$(cd "$(dirname "$0")/.." && pwd)
cd "$REPO"

echo "== пакеты"
apt-get update -qq
DEBIAN_FRONTEND=noninteractive apt-get install -y -qq mariadb-server apache2 libapache2-mod-php8.3 \
  php8.3-mysql php8.3-gd php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-intl locales >/tmp/apt.log 2>&1
locale-gen ru_RU.UTF-8 ro_RO.UTF-8 >/dev/null
pip install --break-system-packages -q opencv-contrib-python-headless fonttools brotli bs4 requests 2>/dev/null || true
mkdir -p /home/claude/build && (cd /home/claude/build && [ -d node_modules/sass ] || (npm init -y >/dev/null && npm i -s sass gsap >/dev/null 2>&1))
mkdir -p /home/claude/sr && [ -s /home/claude/sr/EDSR_x2.pb ] || curl -sSL -o /home/claude/sr/EDSR_x2.pb https://raw.githubusercontent.com/Saafke/EDSR_Tensorflow/master/models/EDSR_x2.pb

echo "== MariaDB (как на хостинге: без strict mode)"
printf "[mysqld]\nsql_mode=NO_ENGINE_SUBSTITUTION\n" > /etc/mysql/mariadb.conf.d/99-local.cnf
mkdir -p /run/mysqld && chown mysql:mysql /run/mysqld
mysqladmin ping >/dev/null 2>&1 || (mysqld_safe --user=mysql >/tmp/mysqld.log 2>&1 &)
for i in $(seq 1 20); do mysqladmin ping >/dev/null 2>&1 && break; sleep 1; done
mysql -e "CREATE DATABASE IF NOT EXISTS lbar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; CREATE USER IF NOT EXISTS 'lbar'@'localhost' IDENTIFIED BY 'lbar'; GRANT ALL ON lbar.* TO 'lbar'@'localhost'; FLUSH PRIVILEGES;"
for f in "$@"; do
  echo "   импорт $f"
  case "$f" in
    *.tar.gz|*.tgz) tar xzOf "$f" ;;
    *.gz) zcat "$f" ;;
    *) cat "$f" ;;
  esac | sed '/enable the sandbox mode/d' | mysql lbar
done

echo "== PHP: MODX 2.8.1 падает на PHP 8 без get_magic_quotes_gpc — полифилл только локально"
mkdir -p /etc/php-local
cat > /etc/php-local/polyfill.php <<'PHP'
<?php
if (!function_exists('get_magic_quotes_gpc')) { function get_magic_quotes_gpc() { return false; } }
if (!function_exists('get_magic_quotes_runtime')) { function get_magic_quotes_runtime() { return false; } }
PHP
printf "auto_prepend_file=/etc/php-local/polyfill.php\nerror_reporting=E_ALL & ~E_DEPRECATED & ~E_STRICT\ndisplay_errors=Off\nmemory_limit=512M\n" > /etc/php/8.3/apache2/conf.d/99-local.ini
cp /etc/php/8.3/apache2/conf.d/99-local.ini /etc/php/8.3/cli/conf.d/99-local.ini

echo "== файлы сайта: пути как на проде (/home/impua/lbar.ro/www → репо), локальные конфиги"
mkdir -p /home/impua/lbar.ro && ln -sfn "$REPO" /home/impua/lbar.ro/www
mkdir -p core/config core/export core/packages   # в git их нет (конфиги и кэш — в .gitignore)
cp _dev/local-config/config.core.php ./config.core.php
cp _dev/local-config/config.core.php ./connectors/config.core.php
cp _dev/local-config/config.core.php ./impulsemanager/config.core.php
cp _dev/local-config/config.inc.php ./core/config/config.inc.php
mkdir -p core/cache
chown -R www-data:www-data core/cache core/export core/packages core/components core/elements assets core/config/config.inc.php
chmod -R a+rX "$REPO"
git config --global --add safe.directory "$REPO"

echo "== Apache + SSL, домены стейджа и прода → 127.0.0.1"
grep -q stage-lbar /etc/hosts || echo "127.0.0.1 lbar.ro www.lbar.ro stage-lbar.touchit.vinnica.ua" >> /etc/hosts
a2enmod rewrite ssl headers expires deflate >/dev/null
[ -f /etc/ssl/certs/ssl-cert-snakeoil.pem ] || make-ssl-cert generate-default-snakeoil
cat > /etc/apache2/sites-available/lbar.conf <<'CONF'
<Directory /home/impua/lbar.ro/www>
    Options FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
<VirtualHost *:80>
    ServerName stage-lbar.touchit.vinnica.ua
    ServerAlias lbar.ro www.lbar.ro localhost
    DocumentRoot /home/impua/lbar.ro/www
    ErrorLog /var/log/apache2/lbar-error.log
</VirtualHost>
<VirtualHost *:443>
    ServerName stage-lbar.touchit.vinnica.ua
    ServerAlias lbar.ro www.lbar.ro localhost
    DocumentRoot /home/impua/lbar.ro/www
    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/ssl-cert-snakeoil.pem
    SSLCertificateKeyFile /etc/ssl/private/ssl-cert-snakeoil.key
    ErrorLog /var/log/apache2/lbar-error.log
</VirtualHost>
CONF
echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf
a2enconf servername >/dev/null; a2dissite 000-default >/dev/null 2>&1 || true; a2ensite lbar >/dev/null
apachectl configtest && (apachectl restart || apachectl start)
sleep 1
for u in / /ru/; do curl -sk --noproxy '*' -o /dev/null -w "https://stage-lbar.touchit.vinnica.ua$u → %{http_code}\n" https://stage-lbar.touchit.vinnica.ua$u; done
echo "Готово. Скриншоты: python3 _dev/tools/shot2.py https://stage-lbar.touchit.vinnica.ua/ out.png 1920 1080"
