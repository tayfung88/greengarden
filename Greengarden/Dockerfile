# Utilisez une image de base
FROM php:7.4-apache

# Copiez le code source dans le conteneur
COPY . /var/www/html

# Exposez le port 80 pour le serveur web
EXPOSE 80

# Commande pour démarrer le serveur Apache
CMD ["apache2-foreground"]
