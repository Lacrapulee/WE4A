<?php

function getAnnonceRecherche($pdo, $search) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE statut = 'en_ligne' AND (titre LIKE ? OR description LIKE ?) ORDER BY created_at DESC");
    $likeSearch = '%' . $search . '%';
    $stmt->execute([$likeSearch, $likeSearch]);
    return $stmt->fetchAll();
}