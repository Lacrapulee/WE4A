# Utilisation de l'image PHP avec Apache
FROM php:8.2-apache

# Installation de l'extension PDO MySQL pour communiquer avec la base de données
RUN docker-php-ext-install pdo pdo_mysql

# On active le module rewrite d'Apache (utile pour les URLs propres)
RUN a2enmod rewrite

# On change la racine du serveur vers le dossier /public pour plus de sécurité
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Dossier de travail dans le conteneur
WORKDIR /var/www/html