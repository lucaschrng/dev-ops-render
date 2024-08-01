#!/bin/bash

# Remplacer les variables d'environnement dans le fichier SQL
envsubst < /docker-entrypoint-initdb.d/init.sql.template > /docker-entrypoint-initdb.d/init.sql

# Démarrer le service MySQL et exécuter le script SQL
service mysql start
mysql < /docker-entrypoint-initdb.d/init.sql