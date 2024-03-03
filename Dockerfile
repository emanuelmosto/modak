FROM php:8.0-fpm

RUN apt-get -y update
RUN apt-get install -y nginx
RUN curl -L -C - --progress-bar -o /usr/local/bin/composer https://getcomposer.org/composer.phar
RUN chmod 755 /usr/local/bin/composer
RUN apt-get install -y git

RUN apt-get install -y zlib1g-dev git unzip zip

# Install php extensions
# exit on errors, exit on unset variables, print every command as it is executed
RUN set install-php-extensions pdo pdo_mysql mysqli bcmath zip pcntl

RUN pecl install redis && docker-php-ext-enable redis
RUN echo "date.timezone=UTC" >> /usr/local/etc/php/conf.d/timezone.ini

RUN apt-get install -y wget nano git

RUN useradd --no-create-home nginx

COPY . /var/www/html

COPY ./docker/php_nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/php_nginx/nginx.conf /etc/nginx/nginx.conf

RUN cd /var/www/html/ && composer install --no-dev -n

RUN mkdir -p /var/www/html/log
RUN chmod -R 777 /var/www/html/log

COPY ./docker/init.sh /var/www/init.sh
RUN chmod +x /var/www/init.sh
