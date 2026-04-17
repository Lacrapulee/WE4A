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
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getImageByAnnonceId($pdo, $id) {
    $stmt = $pdo->prepare("SELECT url_image FROM article_images WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}