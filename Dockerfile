# Utiliser une image de base compatible avec tous vos services
FROM ubuntu:20.04

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
    mailutils

# Copier les fichiers .env
COPY .env /application/.env

# Charger les variables d'environnement
RUN export $(cat /application/.env | xargs)

# Configuration de MySQL
RUN service mysql start && \
    mysql -e "CREATE USER '${MYSQL_ROOT_USER}'@'%' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}';" && \
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO '${MYSQL_ROOT_USER}'@'%';" && \
    mysql -e "FLUSH PRIVILEGES;" && \
    mysql -e "CREATE DATABASE ${DB_NAME};"

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
