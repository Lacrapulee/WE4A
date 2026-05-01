<?php

/**
 * Récupère la liste des annonces en ligne (Utilisé par catalogue.php par défaut)
 */
function getAnnoncesEnLigne($pdo) {
    $stmt = $pdo->query("SELECT * FROM articles WHERE statut = 'en_ligne' ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Recherche des annonces par mot-clé (Utilisé par la barre de recherche)
 */
function getAnnonceRecherche($pdo, $search) {
    $stmt = $pdo->prepare(
        "SELECT * FROM articles 
         WHERE statut = 'en_ligne' 
         AND (titre LIKE ? OR description LIKE ?) 
         ORDER BY created_at DESC"
    );
    $searchTerm = "%" . $search . "%";
    $stmt->execute([$searchTerm, $searchTerm]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère les images pour une liste d'IDs (Optimisation)
 */
function getImagesByAnnonceIds($pdo, $articleIds) {
    if (empty($articleIds)) return [];

    $articleIds = array_values(array_unique($articleIds));
    $placeholders = implode(',', array_fill(0, count($articleIds), '?'));

    $stmt = $pdo->prepare(
        "SELECT ai.article_id, ai.url_image
         FROM article_images ai
         INNER JOIN (
            SELECT article_id, MIN(id) AS min_id
            FROM article_images
            WHERE article_id IN ($placeholders)
            GROUP BY article_id
         ) first_image ON first_image.article_id = ai.article_id AND first_image.min_id = ai.id"
    );
    $stmt->execute($articleIds);

    $images = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $images[$row['article_id']] = $row['url_image'];
    }
    return $images;
}




/**
 * Recherche avancée d'annonces
 */
function getAnnonceRechercheAvancee($pdo, $filters = []) {
    $sql = "SELECT a.*, c.nom as categorie_nom 
            FROM articles a
            LEFT JOIN categories c ON a.categorie_id = c.id
            WHERE a.statut = 'en_ligne'";
    
    $params = [];
    if (!empty($filters['search'])) {
        $sql .= " AND (a.titre LIKE :search OR a.description LIKE :search)";
        $params['search'] = '%' . $filters['search'] . '%';
    }
    if (!empty($filters['categorie'])) {
        $sql .= " AND a.categorie_id = :cat";
        $params['cat'] = $filters['categorie'];
    }
    if (!empty($filters['ville'])) {
        $sql .= " AND a.ville_nom LIKE :ville";
        $params['ville'] = '%' . $filters['ville'] . '%';
    }
    if (!empty($filters['prix_max'])) {
        $sql .= " AND a.prix <= :prix_max";
        $params['prix_max'] = $filters['prix_max'];
    }

    $sql .= " ORDER BY a.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère une annonce précise par son ID
 */
function getAnnonceById($pdo, $id) {
    $stmt = $pdo->prepare(
        "SELECT a.*, u.id AS vendeur_id, c.nom AS categorie_nom, u.nom AS vendeur_nom, u.prenom AS vendeur_prenom, u.email AS vendeur_email, u.telephone AS vendeur_telephone
         FROM articles a
         LEFT JOIN categories c ON c.id = a.categorie_id
         LEFT JOIN users u ON u.id = a.vendeur_id
         WHERE a.id = ?"
    );
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère TOUTES les images d'un article (pour le carrousel)
 */
function getAllImagesByAnnonceId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT url_image FROM article_images WHERE article_id = ? ORDER BY ordre ASC");
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Récupère l'image principale uniquement (pour le catalogue)
 */
function getImageByAnnonceId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT url_image FROM article_images WHERE article_id = ? ORDER BY ordre ASC LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

/**
 * Récupère les catégories pour les filtres
 */
function getCategories($pdo) {
    return $pdo->query("SELECT id, nom FROM categories ORDER BY nom ASC")->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Annonces similaires
 */
function getAnnoncesSimilaires($pdo, $categorieId, $articleId, $limit = 3) {
    $stmt = $pdo->prepare(
        "SELECT id, titre, prix FROM articles 
         WHERE statut = 'en_ligne' AND categorie_id = ? AND id <> ? 
         ORDER BY created_at DESC LIMIT " . (int)$limit
    );
    $stmt->execute([$categorieId, $articleId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

