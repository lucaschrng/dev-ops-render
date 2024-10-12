#!/bin/bash
if [ -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
    mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled
elif [ -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled ]; then
    mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini.disabled /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
fi
