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

# Create appuser and ensure permissions
RUN adduser -D appuser \
    && mkdir -p /data/caddy /config/caddy \
    && chown -R appuser:appuser /data/caddy /config/caddy

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files
COPY . .

# Ensure FrankenPHP binary is executable
RUN chmod +x /usr/local/bin/frankenphp \
    && chown appuser:appuser /usr/local/bin/frankenphp

# Set environment variables for Composer and Caddy
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_ALLOW_PLUGINS=1
ENV XDG_DATA_HOME=/app/data
ENV SERVER_NAME=dev-ops-render.onrender.com
ENV APP_ENV=prod
ENV APP_DEBUG=0

RUN mkdir -p /app/data && chown -R appuser:appuser /app/data

# Install Symfony Runtime and project dependencies
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Switch to non-root user
USER appuser

# Expose necessary ports
EXPOSE 8080 80 443

# Start the FrankenPHP server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]