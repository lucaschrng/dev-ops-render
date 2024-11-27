FROM dunglas/frankenphp:php8.3.14-alpine

WORKDIR "/app/public"

RUN install-php-extensions \
 pdo \
 pdo_mysql \
 pdo_pgsql \
 gd \
 intl \
 zip \
 opcache

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN chmod +x /usr/local/bin/frankenphp

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_ALLOW_PLUGINS=1

RUN composer require symfony/runtime

RUN composer install --no-dev --optimize-autoloader

ENTRYPOINT ["docker-php-entrypoint"]
CMD ["frankenphp"]