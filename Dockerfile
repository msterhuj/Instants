FROM php:8.0.3-apache-buster

LABEL MAINTAINER="gabin.lanore@gmail.com"

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

COPY . .

RUN mv config/000-default.conf /etc/apache2/sites-available/
RUN mv config/instants.ini /usr/local/etc/php/conf.d/
RUN rm -rvf config/ html/
RUN a2enmod rewrite
RUN chown www-data:www-data -R /var/www

VOLUME /var/www
VOLUME /var/log/apache2

EXPOSE 80