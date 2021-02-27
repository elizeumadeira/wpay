#!/bin/bash
#service apache2 restart
php /var/www/html/artisan register:container
service cron restart
/usr/sbin/apache2ctl -D FOREGROUND