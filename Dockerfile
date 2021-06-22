ARG PHP_VERSION=8.0

FROM php:${PHP_VERSION}-apache

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update && \
    apt-get install arp-scan git zlib1g-dev zip unzip libzip-dev libxslt-dev -y && \
    docker-php-ext-install intl && \
    docker-php-ext-install zip && \
    docker-php-ext-install xsl

COPY . /var/www/symfony
WORKDIR /var/www/symfony

RUN sed -ri -e 's!80!8080!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/html!/var/www/symfony/public!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!/var/www/symfony/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "memory_limit=1024M" > /usr/local/etc/php/conf.d/memory-limit.ini

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    php composer.phar install --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative  --no-interaction && \
    php composer.phar clear-cache

RUN mkdir -p /var/www/symfony/var && \
    chown -R www-data.www-data /var/www/symfony/var

VOLUME /var/www/symfony/var
