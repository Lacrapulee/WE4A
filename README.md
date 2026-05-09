# WE4A

Application web de revente développée en PHP/MySQL dans le cadre du projet WE4A.

## Fonctionnalités

- Catalogue d'articles avec affichage des annonces.
- Fiche article avec carousel d'images, contact et articles similaires.
- Connexion, inscription et déconnexion.
- Profils utilisateur avec vue visiteur et vue propriétaire.
- Gestion des favoris.
- Publication, modification et suppression d'annonces.
- Messagerie et avis entre utilisateurs.
- Parcours de paiement et validation de réception.

## Prérequis

- Docker et Docker Compose.
- Un navigateur web.

## Installation

1. Cloner le dépôt.
2. Lancer les services Docker :

```bash
docker compose up -d --build
```

3. Ouvrir l'application dans le navigateur.

## Accès

- Application : http://localhost:8000
- phpMyAdmin : http://localhost:8080

## Base de données

La base est initialisée avec :

- [sql/init.sql](sql/init.sql) pour le schéma.
- [sql/seed.sql](sql/seed.sql) pour les données de démonstration.

Identifiants MySQL utilisés par défaut dans Docker :

- hôte : `db`
- base : `WE4ADB`
- utilisateur : `root`
- mot de passe : `rootpassword`

## Compte administrateur de démonstration

Le seed contient un compte admin prêt à l'emploi :

- email : `admin@admin.fr`
- mot de passe : `admin`

## Arborescence utile

- [src/public](src/public) : point d'entrée public et routeur.
- [src/includes](src/includes) : logique métier PHP.
- [src/templates](src/templates) : vues HTML/PHP.
- [src/public/assets](src/public/assets) : styles et images.

## Routes principales

- `routeur.php?action=catalogue` : page d'accueil du catalogue.
- `routeur.php?action=item&id=...` : page détail d'un article.
- `routeur.php?action=favoris` : page des favoris.
- `routeur.php?action=auth` : connexion.
- `routeur.php?action=inscription` : inscription.
- `routeur.php?action=post` : publier une annonce.

## Configuration des envois de fichiers

Pour l'upload d'images sur la page de publication, il peut être nécessaire d'ajuster les permissions du dossier d'assets :

```bash
sudo chown -R www-data:www-data src/public/assets/img
sudo chmod -R 775 src/public/assets/img
```

Si besoin, augmenter aussi dans le `php.ini` :

- `upload_max_filesize = 64M`
- `post_max_size = 65M`
- `memory_limit = -1`

## Notes de développement

- L'application est servie à partir de `src/public`.
- Les includes PHP contiennent la logique serveur et les accès base de données.
- Les vues utilisent des liens absolus du type `/routeur.php?...` et `/assets/...`.

## Améliorations prévues

- Déplacement de certains scripts JavaScript dans des fichiers dédiés.
- Amélioration du style général.
- Gestion plus stricte des cas métier, par exemple l'achat de son propre article.
- Ajout et finalisation des fonctions super admin.
