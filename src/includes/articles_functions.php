<?php

/**
 * Récupère la liste des annonces en ligne
 */
function getAnnoncesEnLigne($pdo) {
    $stmt = $pdo->query("SELECT * FROM articles WHERE statut = 'en_ligne' ORDER BY created_at DESC");
    return $stmt->fetchAll();
}

/**
 * Récupère une annonce précise par son ID
 */
function getAnnonceById($pdo, $id) {
    $stmt = $pdo->prepare(
        "SELECT a.*, c.nom AS categorie_nom, u.nom AS vendeur_nom, u.prenom AS vendeur_prenom, u.email AS vendeur_email, u.telephone AS vendeur_telephone
         FROM articles a
         LEFT JOIN categories c ON c.id = a.categorie_id
         LEFT JOIN users u ON u.id = a.vendeur_id
         WHERE a.id = ?"
    );
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getImageByAnnonceId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT url_image FROM article_images WHERE article_id = ? ORDER BY est_principale DESC, ordre ASC, id ASC LIMIT 1");
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

function getImagesByAnnonceIds($pdo, $articleIds) {
    if (empty($articleIds)) {
        return [];
    }

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

    $rows = $stmt->fetchAll();
    $images = [];

    foreach ($rows as $row) {
        $images[$row['article_id']] = $row['url_image'];
    }

    return $images;
}

function getAnnoncesSimilaires($pdo, $categorieId, $articleId, $limit = 3) {
    $limit = (int) $limit;
    $stmt = $pdo->prepare(
        "SELECT id, titre, prix
         FROM articles
         WHERE statut = 'en_ligne' AND categorie_id = ? AND id <> ?
         ORDER BY created_at DESC
         LIMIT {$limit}"
    );
    $stmt->bindValue(1, $categorieId, PDO::PARAM_INT);
    $stmt->bindValue(2, $articleId, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchAll();
}