-- ==========================================================
-- FICHIER DE SEEDING : seed.sql
-- Base de données : WE4ADB
-- ==========================================================

-- 0. CONFIGURATION DE LA SESSION
SET NAMES utf8mb4 COLLATE utf8mb4_general_ci;
USE WE4ADB;

-- Décocher si vous voulez supprimer les anciennes données
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

-- 1. CRÉATION DES UTILISATEURS
INSERT INTO `users` (`id`, `email`, `password`, `nom`, `prenom`, `telephone`) VALUES
('u1-uuid-placeholder', 'jean.dupont@gmail.com', 'hash123', 'Dupont', 'Jean', '0611223344'),
('u2-uuid-placeholder', 'marie.curie@utbm.fr', 'hash123', 'Curie', 'Marie', '0655443322'),
('u3-uuid-placeholder', 'lucas.bertrand@orange.fr', 'hash123', 'Bertrand', 'Lucas', '0788990011'),
('u4-uuid-placeholder', 'sophie.fonfec@yahoo.fr', 'hash123', 'Fonfec', 'Sophie', '0600112233'),
('u5-uuid-placeholder', 'admin.boutique@utbm.fr', 'hash123', 'Admin', 'Boutique', '0384001122');

-- Variables pour les IDs utilisateurs (forcées en general_ci)
SET @u1 = 'u1-uuid-placeholder' COLLATE utf8mb4_general_ci;
SET @u2 = 'u2-uuid-placeholder' COLLATE utf8mb4_general_ci;
SET @u3 = 'u3-uuid-placeholder' COLLATE utf8mb4_general_ci;
SET @u4 = 'u4-uuid-placeholder' COLLATE utf8mb4_general_ci;
SET @u5 = 'u5-uuid-placeholder' COLLATE utf8mb4_general_ci;

-- 2. CRÉATION DES CATÉGORIES
INSERT INTO `categories` (`id`, `nom`, `description`) VALUES 
(1, 'Informatique', 'PC, Consoles, Accessoires'),
(2, 'Vehicules', 'Voitures, Velos, Trottinettes'),
(3, 'Immobilier', 'Ventes et Locations'),
(4, 'Maison', 'Meubles et Deco'),
(5, 'Loisirs', 'Sport, Musique, Jeux');

-- 3. INSERTION DES ARTICLES
INSERT INTO `articles` (`vendeur_id`, `categorie_id`, `titre`, `description`, `prix`, `statut`, `coordonnees`, `ville_nom`, `code_postal`) VALUES
-- Informatique (Jean @u1)
(@u1, 1, 'MacBook Pro 14', 'M2, 16Go RAM, comme neuf.', 1800.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(@u1, 1, 'iPhone 15', 'Noir, 128Go, debloque.', 850.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(@u1, 1, 'Clavier Corsair K70', 'Switch Red, RGB.', 110.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(@u1, 1, 'Souris MX Master 3S', 'Ideal productivite.', 75.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(@u1, 1, 'Casque Bose QC45', 'Reduction de bruit active.', 190.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
(@u1, 1, 'ecran Dell 27 4K', 'Dalle IPS ultra precise.', 350.00, 'en_ligne', POINT(47.64, 6.85), 'Belfort', '90000'),
-- Vehicules (Marie @u2)
(@u2, 2, 'Peugeot 208', '1.2 PureTech, 50k km.', 11500.00, 'en_ligne', POINT(47.51, 6.79), 'Montbeliard', '25200'),
(@u2, 2, 'VTT Specialized', 'Tout suspendu, Taille M.', 1200.00, 'en_ligne', POINT(47.51, 6.79), 'Montbeliard', '25200'),
-- Maison (Lucas @u3)
(@u3, 4, 'Canape d angle convertible', 'Gris fonce, 4 places.', 450.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
(@u3, 4, 'Table a manger Chene', 'Avec 6 chaises assorties.', 320.00, 'en_ligne', POINT(47.58, 6.81), 'Sevenans', '90400'),
-- Loisirs (Sophie @u4)
(@u4, 5, 'Guitare Fender Stratocaster', 'Made in Mexico, Sunburst.', 650.00, 'en_ligne', POINT(47.58, 6.79), 'Hericourt', '70400'),
(@u4, 5, 'Halteres 20kg', 'Lot de 2, fonte.', 40.00, 'en_ligne', POINT(47.58, 6.79), 'Hericourt', '70400'),
-- Immobilier (Admin @u5)
(@u5, 3, 'Studio Centre Belfort', 'Proche gare, 25m2.', 55000.00, 'en_ligne', POINT(47.63, 6.86), 'Belfort', '90000'),
(@u5, 3, 'T3 Montbeliard', 'Vue sur le chateau, parking.', 125000.00, 'en_ligne', POINT(47.51, 6.79), 'Montbeliard', '25200');

-- 4. IMAGES
INSERT INTO `article_images` (`article_id`, `url_image`, `est_principale`)
SELECT `id`, 'default.png', 1 FROM `articles`;

-- 5. AVIS (Correction Illegal Mix of Collations)
INSERT INTO `avis` (`article_id`, `expediteur_id`, `destinataire_id`, `note`, `commentaire`, `date_avis`) VALUES
-- Avis sur Jean (@u1)
((SELECT id FROM articles WHERE vendeur_id = @u1 LIMIT 1 OFFSET 0), @u2, @u1, 5, 'Excellent vendeur ! MacBook comme neuf.', NOW() - INTERVAL 15 DAY),
((SELECT id FROM articles WHERE vendeur_id = @u1 LIMIT 1 OFFSET 1), @u3, @u1, 5, 'Très professionnel et réactif.', NOW() - INTERVAL 10 DAY),
((SELECT id FROM articles WHERE vendeur_id = @u1 LIMIT 1 OFFSET 4), @u3, @u1, 5, 'Casque Bose parfait, Jean est top.', NOW() - INTERVAL 4 DAY),
((SELECT id FROM articles WHERE vendeur_id = @u1 LIMIT 1 OFFSET 5), @u4, @u1, 3, 'Ecran OK, mais câble manquant.', NOW() - INTERVAL 12 DAY),

-- Avis sur Marie (@u2)
((SELECT id FROM articles WHERE vendeur_id = @u2 LIMIT 1 OFFSET 0), @u5, @u2, 5, 'La Peugeot est parfaite.', NOW() - INTERVAL 15 DAY),
((SELECT id FROM articles WHERE vendeur_id = @u2 LIMIT 1 OFFSET 1), @u3, @u2, 4, 'VTT en bon état, merci.', NOW() - INTERVAL 7 DAY),

-- Avis sur Lucas (@u3)
((SELECT id FROM articles WHERE vendeur_id = @u3 LIMIT 1 OFFSET 0), @u2, @u3, 5, 'Canapé magnifique, livraison facile.', NOW() - INTERVAL 2 DAY),
((SELECT id FROM articles WHERE vendeur_id = @u3 LIMIT 1 OFFSET 1), @u4, @u3, 2, 'Table avec rayures non mentionnées.', NOW() - INTERVAL 20 DAY),

-- Avis "Profil" (Transactions sans article spécifique)
(NULL, @u1, @u3, 5, 'Acheteur très poli et ponctuel.', NOW() - INTERVAL 5 DAY),
(NULL, @u5, @u4, 4, 'Sophie est une acheteuse réactive.', NOW() - INTERVAL 9 DAY);

-- 6. FAVORIS
INSERT INTO `favoris` (`user_id`, `article_id`) VALUES
(@u1, (SELECT id FROM articles WHERE titre = 'Peugeot 208' COLLATE utf8mb4_general_ci LIMIT 1)),
(@u2, (SELECT id FROM articles WHERE titre = 'MacBook Pro 14' COLLATE utf8mb4_general_ci LIMIT 1)),
(@u3, (SELECT id FROM articles WHERE titre = 'MacBook Pro 14' COLLATE utf8mb4_general_ci LIMIT 1)),
(@u4, (SELECT id FROM articles WHERE titre = 'iPhone 15' COLLATE utf8mb4_general_ci LIMIT 1));

COMMIT;