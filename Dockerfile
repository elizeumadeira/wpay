FROM php:7.2-apache
# FROM 157410751226.dkr.ecr.us-east-1.amazonaws.com/digabackend:latest
# RUN apt-get install -y cron
# Configuration for Apache
    RUN rm -rf /etc/apache2/sites-enabled/000-default.conf
    ADD deploy/config/000-default.conf /etc/apache2/sites-available/
    RUN ln -s /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/
    RUN a2enmod rewrite

# Add root folder
    ADD . /var/www/html/

# Laravel writing rights
    RUN chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache
    RUN chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# Create Laravel folders (mandatory)
    RUN mkdir -p /var/www/html/storage/framework
    RUN mkdir -p /var/www/html/storage/framework/sessions
    RUN mkdir -p /var/www/html/storage/framework/views
    RUN mkdir -p /var/www/html/storage/meta
    RUN mkdir -p /var/www/html/storage/cache
    RUN mkdir -p /var/www/html/public/uploads

# Making Cron
    COPY deploy/cron /etc/cron.d/laravel-schedules
    RUN chmod 0644 /etc/cron.d/laravel-schedules
    # RUN crontab /etc/cron.d/laravel-schedules
    RUN chmod 777 /var/www/html/deploy/run.sh

# Change folder permission
    RUN chmod -R 0777 /var/www/html/storage/
    RUN chmod -R 0777 /var/www/html/public/uploads/
    RUN chown -R www-data:www-data /var/www/html

# Clean Laravel cache and enable apache modules
    RUN cd /var/www/html && composer install
    RUN php /var/www/html/artisan config:cache
    RUN a2enmod rewrite headers
    RUN service apache2 restart

EXPOSE 80 3308

CMD ["/var/www/html/deploy/run.sh"]