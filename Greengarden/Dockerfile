#utilisons une image PHP apache
FROM php:apache

#copy de toute l'appl dans le répertoire du travail du conteneur
COPY . /var/www/html

#copy de l'env prod en le renommant en env
COPY .env.prod /var/www/html/.env

# installons les dépendances de PDO pour MySQL
RUN docker-php-ext-install pdo pdo_mysql
