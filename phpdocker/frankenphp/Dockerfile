FROM dunglas/frankenphp:php8.3.14-alpine

WORKDIR "/app"

# Install necessary dependencies
RUN apk add --no-cache \
    bash \
    vim \
    curl \
    wget \
    yarn \
    npm \
    nodejs \
    git \
    build-base \
    icu-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zlib-dev \
    libpq \
    libpq-dev \
    ca-certificates \
    zip \
    unzip \
    tzdata \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        gd \
        intl \
        zip \
        opcache \
    && rm -rf /var/cache/apk/*

# RUN adduser -D appuser

# RUN install-php-extensions \
#   pdo pdo_mysql pdo_pgsql gd intl zip opcache

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . .

# Ensure FrankenPHP binary is executable
RUN chmod +x /usr/local/bin/frankenphp

# Set environment variables for Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_ALLOW_PLUGINS=1

# Install Symfony Runtime and project dependencies
RUN composer require symfony/runtime \
    && composer install --no-dev --no-script --optimize-autoloader

# Set entrypoint and default command
ENTRYPOINT ["docker-php-entrypoint"]
CMD ["frankenphp"]