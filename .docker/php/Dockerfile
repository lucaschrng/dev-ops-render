FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget zip unzip yarn npm nodejs iputils-ping ca-certificates \
    gnupg gnupg1 gnupg2 libzip-dev zlib1g-dev libicu-dev g++ libpng-dev libjpeg-dev libfreetype6-dev

RUN docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip

COPY php.ini /etc/php/8.1/php.ini
COPY php-fpm-pool.conf /etc/php/8.1/pool.d/www.conf

#RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
# INSTALL COMPOSER
#RUN curl -s https://getcomposer.org/installer | php
#RUN alias composer='php composer.phar'

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN wget https://toolbelt.heroku.com/install-ubuntu.sh -O - | bash
#    mv /root/.heroku/bin/heroku /usr/local/bin/heroku

RUN #dpkg -s apt-transport-https && dpkg -s heroku-toolbelt

# Need to install excimer extension for running SENTRY
RUN pecl install excimer

wsl


RUN groupadd dev -g 999
RUN useradd dev -g dev -d /home/dev -m

RUN rm -rf /var/lib/apt/lists/*
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

WORKDIR /home/wwwroot/sf5-p2

EXPOSE 9000
CMD ["php-fpm"]
