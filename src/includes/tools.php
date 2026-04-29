<?php

function getAnnonceRecherche($pdo, $search) {
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE statut = 'en_ligne' AND (titre LIKE ? OR description LIKE ?) ORDER BY created_at DESC");
    $likeSearch = '%' . $search . '%';
    $stmt->execute([$likeSearch, $likeSearch]);
    return $stmt->fetchAll();
}

function addItem($pdo, $vendeur_id, $categorie_id, $titre, $description, $prix, $coordonnees, $ville_nom, $code_postal) {
    // Par défaut, on peut forcer le statut à 'disponible' ou 'actif' si tu n'as pas de valeur par défaut dans la BDD
    $sql = "INSERT INTO articles (vendeur_id, categorie_id, titre, description, prix, statut, coordonnees, ville_nom, code_postal) 
            VALUES (?, ?, ?, ?, ?, 'disponible', ?, ?, ?)";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $vendeur_id, 
        $categorie_id, 
        $titre, 
        $description, 
        $prix, 
        $coordonnees, 
        $ville_nom, 
        $code_postal
    ]);
    
    return $pdo->lastInsertId();
}

function addImage($pdo, $article_id, $nom_image) {
    $stmt = $pdo->prepare("INSERT INTO article_images (article_id, url_image, est_principale, ordre) VALUES (?, ?, ?)");
    return $stmt->execute([$article_id, $nom_image]);
}
