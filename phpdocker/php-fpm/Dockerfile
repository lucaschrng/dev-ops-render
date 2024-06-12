FROM phpdockerio/php:8.1-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.1-bcmath \ 
        php8.1-bz2 \ 
        php8.1-raphf \
        php8.1-http \
        php8.1-gd \
        php8.1-gmagick \ 
        php8.1-gmp \ 
        php8.1-http \ 
        php8.1-imap \ 
        php8.1-inotify \ 
        php8.1-intl \ 
        php8.1-mailparse \ 
        php8.1-mcrypt \ 
        php8.1-memcache \ 
        php8.1-memcached \ 
        php8.1-msgpack \ 
        php8.1-mysql \ 
        php8.1-redis \ 
        php8.1-soap \ 
        php8.1-solr \ 
        php8.1-ssh2 \ 
        php8.1-uuid \ 
        php8.1-xdebug \ 
        php8.1-xmlrpc \ 
        php8.1-xsl \ 
        php8.1-yaml \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
