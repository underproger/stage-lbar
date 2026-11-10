#!/bin/bash
# поднять локальное окружение после рестарта контейнера
grep -q stage-lbar /etc/hosts || echo "127.0.0.1 lbar.ro www.lbar.ro stage-lbar.touchit.vinnica.ua" >> /etc/hosts
mkdir -p /run/mysqld && chown mysql:mysql /run/mysqld
mysqladmin ping >/dev/null 2>&1 || (mysqld_safe --user=mysql >/tmp/mysqld.log 2>&1 &) 
for i in 1 2 3 4 5 6; do mysqladmin ping >/dev/null 2>&1 && break; sleep 1; done
# pid-файл от прошлого запуска мешает старту (apachectl: «already running»), если процесса apache2 нет
pgrep -x apache2 >/dev/null || { rm -f /var/run/apache2/apache2.pid; apachectl start; }
