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

RUN mkdir -p /app/data && chown -R appuser:appuser /app/data

# Install Symfony Runtime and project dependencies
RUN composer install --no-dev --no-scripts --optimize-autoloader

# Set up Caddyfile
RUN echo ':80 { \n \
    root * /app/public \n \
    php_fastcgi unix//var/run/php/php8.3-fpm.sock \n \
    file_server \n \
}' > /etc/caddy/Caddyfile

# Switch to non-root user
USER appuser

# Expose necessary ports
EXPOSE 80 443

# Set entrypoint and default command
ENTRYPOINT ["/usr/local/bin/frankenphp"]
CMD ["run", "--config", "/etc/caddy/Caddyfile"]