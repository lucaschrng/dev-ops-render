#!/bin/bash

# Mettre à jour la liste des paquets
sudo apt-get update

# Installer les extensions PHP nécessaires
sudo apt-get install -y php8.1-intl php8.1-xml php8.1-curl php8.1-mbstring php8.1-zip php8.1-dom

# Vérifier les extensions PHP installées
php -m

# Relancer composer install
composer install