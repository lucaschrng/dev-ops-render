FROM dunglas/frankenphp:php8.3.14-alpine

WORKDIR "/app/public"

RUN apk update && apk add --no-cache \
  vim curl wget yarn npm nodejs git \
  build-base locales acl mailutils zip unzip \
  iputils ca-certificates gnupg libzip-dev zlib-dev icu-dev \
  libpng-dev libjpeg-turbo-dev freetype-dev libpq-dev \
  && rm -rf /var/cache/apk/*

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

RUN composer install --no-dev --optimize-autoloader

ENTRYPOINT ["docker-php-entrypoint"]
CMD ["frankenphp"]