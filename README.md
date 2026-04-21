Projet WE4A -- Création d'un site internet de revente


Pour l'envoie des fichiers de la page post/index.php :
- sudo chown -R www-data:www-data src/public/assets/img
- sudo chmod -R 775 src/public/assets/img
Dans php/8.*/php.ini changer les lignes : 
- upload_max_filesize = 64M
- post_max_size = 65 
- memory_limit = -1 

PHP My admin : http://localhost:8080