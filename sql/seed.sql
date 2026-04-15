-- Utilisation de la base
USE WE4ADB;

-- a decocher si on veut supprimer les anciennes donnees
-- SET FOREIGN_KEY_CHECKS = 0;
-- DELETE FROM `article_attributs_valeurs`;
-- DELETE FROM `article_images`;
-- DELETE FROM `messages`;
-- DELETE FROM `conversations`;
-- DELETE FROM `favoris`;
-- DELETE FROM `avis`;
-- DELETE FROM `promotions`;
-- DELETE FROM `articles`;
-- DELETE FROM `categories`;
-- DELETE FROM `users`;
-- SET FOREIGN_KEY_CHECKS = 1;

-- 1. CRÉATION DES UTILISATEURS (5 profils différents)
INSERT INTO `users` (`id`, `email`, `password`, `nom`, `prenom`, `telephone`) VALUES
(UUID(), 'jean.dupont@gmail.com', 'hash123', 'Dupont', 'Jean', '0611223344'),
(UUID(), 'marie.curie@utbm.fr', 'hash123', 'Curie', 'Marie', '0655443322'),
(UUID(), 'lucas.bertrand@orange.fr', 'hash123', 'Bertrand', 'Lucas', '0788990011'),
(UUID(), 'sophie.fonfec@yahoo.fr', 'hash123', 'Fonfec', 'Sophie', '0600112233'),
(UUID(), 'admin.boutique@utbm.fr', 'hash123', 'Admin', 'Boutique', '0384001122');

-- Récupération des IDs dans des variables pour les lier aux articles
SET @u1 = (SELECT id FROM users WHERE email = 'jean.dupont@gmail.com');
SET @u2 = (SELECT id FROM users WHERE email = 'marie.curie@utbm.fr');
SET @u3 = (SELECT id FROM users WHERE email = 'lucas.bertrand@orange.fr');
SET @u4 = (SELECT id FROM users WHERE email = 'sophie.fonfec@yahoo.fr');
SET @u5 = (SELECT id FROM users WHERE email = 'admin.boutique@utbm.fr');

-- 2. CRÉATION DES CATÉGORIES
INSERT INTO `categories` (`id`, `nom`, `description`) VALUES 
(1, 'Informatique', 'PC, Consoles, Accessoires'),
(2, 'Véhicules', 'Voitures, Vélos, Trottinettes'),
(3, 'Immobilier', 'Ventes et Locations'),
(4, 'Maison', 'Meubles et Déco'),
(5, 'Loisirs', 'Sport, Musique, Jeux');

-- 3. INSERTION DES 50 ARTICLES
INSERT INTO `articles` (`id`, `vendeur_id`, `categorie_id`, `titre`, `description`, `prix`, `statut`, `coordonnees`, `ville_nom`, `code_postal`) VALUES
-- Informatique (Vendeur Jean @u1)
(UUID(), @u1, 1, 'MacBook Pro 14', 'M2, 16Go RAM, comme neuf.', 1800.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'iPhone 15', 'Noir, 128Go, débloqué.', 850.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'Clavier Corsair K70', 'Switch Red, RGB.', 110.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'Souris MX Master 3S', 'Idéal productivité.', 75.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'Casque Bose QC45', 'Réduction de bruit active.', 190.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'Écran Dell 27 4K', 'Dalle IPS ultra précise.', 350.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'iPad Air 5', 'Puce M1, Bleu.', 550.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'Nintendo Switch OLED', 'Avec Mario Kart 8.', 290.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'PS5 Standard', 'Avec 2 manettes.', 420.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u1, 1, 'Carte Graphique RTX 3070', 'Marque ASUS, jamais miné.', 380.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),

-- Véhicules (Vendeur Marie @u2)
(UUID(), @u2, 2, 'Peugeot 208', '1.2 PureTech, 50k km.', 11500.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'VTT Specialized', 'Tout suspendu, Taille M.', 1200.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Trottinette Dualtron', 'Très puissante.', 900.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Casque Shark Carbon', 'Neuf, jamais porté.', 250.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Renault Zoe', 'Batterie incluse, 400km autonomie.', 14000.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Gants Cuir Furygan', 'Taille L, protection D3O.', 60.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Remorque Bagagère', 'Bon état général.', 300.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Vespa 125', 'Révision faite, look rétro.', 2800.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Porte-Vélos Thule', 'Pour 3 vélos, sur attelage.', 220.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u2, 2, 'Pneus Neige (x4)', 'Michelin Alpin, 205/55 R16.', 200.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),

-- Maison (Vendeur Lucas @u3)
(UUID(), @u3, 4, 'Canapé d angle convertible', 'Gris foncé, 4 places.', 450.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Table à manger Chêne', 'Avec 6 chaises assorties.', 320.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Aspirateur Dyson V11', 'Complet avec accessoires.', 300.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Machine à laver LG', '9kg, silencieuse.', 280.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Robot Pâtissier KitchenAid', 'Rouge Empire, peu servi.', 400.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Bureau assis-debout', 'Électrique, blanc.', 250.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Lit 160x200', 'Sommier + matelas Emma.', 500.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Lot de Luminaires', 'Style industriel.', 80.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Réfrigérateur Samsung', 'Froid ventilé, gris.', 350.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u3, 4, 'Miroir doré ancien', 'Grande taille.', 120.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),

-- Loisirs (Vendeur Sophie @u4)
(UUID(), @u4, 5, 'Guitare Fender Stratocaster', 'Made in Mexico, Sunburst.', 650.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Haltères 20kg', 'Lot de 2, fonte.', 40.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Livre Harry Potter', 'Collection complète, reliée.', 100.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Piano numérique Yamaha', 'Toucher lourd, 88 touches.', 450.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Raquette de Tennis Wilson', 'Modèle Roger Federer.', 110.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Jeu de société Catan', 'Neuf, sous blister.', 30.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Appareil Photo Canon EOS R6', 'Boitier nu, peu de clics.', 1800.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Objectif 50mm f1.8', 'Parfait état.', 150.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Lot de Vinyls Rock', '30 albums classiques.', 200.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),
(UUID(), @u4, 5, 'Tapis de course', 'Pliable, écran tactile.', 500.00, 'en_ligne', POINT(47.58, 6.79), 'Héricourt', '70400'),

-- Immobilier (Vendeur Admin/Pro @u5)
(UUID(), @u5, 3, 'Studio Centre Belfort', 'Proche gare, 25m2.', 55000.00, 'en_ligne', POINT(47.63, 6.86), 'Belfort', '90000'),
(UUID(), @u5, 3, 'T3 Montbéliard', 'Vue sur le château, parking.', 125000.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u5, 3, 'Maison de ville', 'Belfort Nord, jardin 200m2.', 210000.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u5, 3, 'Terrain à bâtir', 'Sevenans, viabilisé.', 85000.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(UUID(), @u5, 3, 'Colocation Étudiante', '3 chambres disponibles, Belfort.', 350.00, 'en_ligne', POINT(47.63, 6.86), 'Belfort', '90000'),
(UUID(), @u5, 3, 'Garage fermé', 'Quartier Jean Jaurès.', 12000.00, 'en_ligne', POINT(47.63, 6.86), 'Belfort', '90000'),
(UUID(), @u5, 3, 'Loft industriel', 'Montbéliard, 110m2.', 195000.00, 'en_ligne', POINT(47.51, 6.79), 'Montbéliard', '25200'),
(UUID(), @u5, 3, 'Appartement T2', 'Neuf, livraison 2025.', 135000.00, 'en_ligne', POINT(47.63, 6.86), 'Belfort', '90000'),
(UUID(), @u5, 3, 'Immeuble de rapport', '3 studios loués, Belfort.', 160000.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(UUID(), @u5, 3, 'Local commercial', 'Rue piétonne, 40m2.', 800.00, 'en_ligne', POINT(47.63, 6.86), 'Belfort', '90000');

-- 4. IMAGES PAR DÉFAUT
INSERT INTO `article_images` (`article_id`, `url_image`, `est_principale`)
SELECT id, 'default.png', 1 FROM articles;