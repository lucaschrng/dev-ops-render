FROM dunglas/frankenphp:php8.3.14

WORKDIR "/app/public"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    vim curl wget yarn npm nodejs apt-utils git \
    build-essential locales acl mailutils wget zip unzip yarn npm nodejs iputils-ping ca-certificates \
    gnupg gnupg1 gnupg2 libzip-dev zlib1g-dev libicu-dev g++ libpng-dev libjpeg-dev libfreetype6-dev \
    libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

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

RUN useradd -m appuser

USER appuser

RUN composer install --no-dev --optimize-autoloader

USER root

ENTRYPOINT ["docker-php-entrypoint"]
CMD ["frankenphp"]
