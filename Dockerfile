# Utiliser une image de base compatible avec tous vos services
FROM ubuntu:20.04

# Définir le frontend Debian pour éviter les invites interactives
ENV DEBIAN_FRONTEND=noninteractive

# Installation des dépendances générales
RUN apt-get update && apt-get install -y \
    nginx \
    php-fpm \
    php-mysql \
    mysql-server \
    redis-server \
    memcached \
    nodejs \
    npm \
    yarn \
    wget \
    unzip \
    supervisor \
    curl \
    mailutils \
    postfix

# Copier les fichiers .env
COPY .env /application/.env
COPY .env.local /application/.env.local

# Charger les variables d'environnement
ENV APP_PATH=/home/wwwroot/sf5-p4
ENV DB_NAME=db-sf5-p4
ENV MYSQL_ROOT_USER=root
ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=db-sf5-p4
ENV MYSQL_PASSWORD=root

# Configuration de MySQL
RUN service mysql start && \
    mysql -e "CREATE USER '${MYSQL_ROOT_USER}'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}';" && \
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO '${MYSQL_ROOT_USER}'@'%';" && \
    mysql -e "FLUSH PRIVILEGES;" && \
    mysql -e "CREATE DATABASE \`${DB_NAME}\`;"

# Copier les configurations spécifiques de PHP, Nginx, MySQL, etc.
COPY phpdocker/php-fpm/php-ini-overrides.ini /etc/php/8.1/fpm/conf.d/99-overrides.ini
COPY phpdocker/nginx/nginx.conf /etc/nginx/sites-available/default
COPY phpdocker/data/db /var/lib/mysql

# Copier le code de l'application
COPY . /application
WORKDIR /application

# Configuration de supervisord pour gérer tous les services
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exposer les ports nécessaires
EXPOSE 80 3306 6379 2011 2012 2013

# Commande pour démarrer supervisord et donc tous les services
CMD ["/usr/bin/supervisord"]
