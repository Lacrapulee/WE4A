<?php

function getAnnonceRecherche($pdo, $search) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE statut = 'en_ligne' AND (titre LIKE ? OR description LIKE ?) ORDER BY created_at DESC");
    $likeSearch = '%' . $search . '%';
    $stmt->execute([$likeSearch, $likeSearch]);
    return $stmt->fetchAll();
}

function addItem($pdo, $titre, $description, $prix, $categorie_id, $user_id) {
    $stmt = $pdo->prepare("INSERT INTO articles (titre, description, prix, categorie_id, user_id) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$titre, $description, $prix, $categorie_id, $user_id]);
}