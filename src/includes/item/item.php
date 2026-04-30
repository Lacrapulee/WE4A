<?php
// includes/item.php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../articles_functions.php';

// 1. Récupération des données
$productId = $_GET['id'] ?? null;
$product = getAnnonceById($pdo, $productId);

// 2. Traitement des erreurs et données liées
if (!$product) {
    $errorMessage = "Cet article n'existe pas ou n'est plus disponible.";
} else {
    $errorMessage = null;
    
    // Récupération des images
    $allImages = getAllImagesByAnnonceId($pdo, $product['id']);
    if (empty($allImages)) {
        $allImages = ['default.png'];
    }
    
    // Récupération des annonces similaires
    $similarAds = getAnnoncesSimilaires($pdo, $product['categorie_id'], $product['id']);
}

