<?php

session_start(); 

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'connexion':
            require_once __DIR__ . '/../includes/connexion/connexion.php';
            break;
        case 'inscription':
            require_once __DIR__ . '/../includes/inscription/inscription.php';
            break;
        case 'post':  
            require_once __DIR__ . '/../includes/post/post.php';
            header('Location: routeur.php?action=item&id=' . $nouvelArticleId); // Redirige vers la page de l'article nouvellement créé
            break;
        case 'edit_profile':
            require_once __DIR__ . '/../includes/edit_profile/edit_profile.php';
            header('Location: routeur.php?action=user&id=' . $_SESSION['user_id']);
            break;
        case 'paiement':
            // Logique de paiement (à implémenter)
            require_once __DIR__ . '/../includes/paiement/paiement.php';
            header('Location: routeur.php?action=item&id=' . $_POST['article_id']); // Redirige vers la page de l'article après paiement
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($action) {
        case 'user':
            require_once __DIR__ . '/../includes/user/user.php';
            include __DIR__ . '/../templates/user/index.php';
            break;
        case 'catalogue':
            require_once __DIR__ . '/../includes/catalogue/catalogue.php';
            require_once __DIR__ . '/../templates/catalogue/index.php';
            break;
        
        case 'edit_profile':
            require_once __DIR__ . '/../includes/edit_profile/edit_profile.php';
            
            include __DIR__ . '/../templates/header.php';
            include __DIR__ . '/../templates/edit_profile/index.php'; // Affiche la vue
            include __DIR__ . '/../templates/footer.php';
            break;
        // ... dans ton switch ($action) au niveau du GET
        case 'item':
            // 1. Charger la logique (Définit les variables $product, $allImages, etc.)
            require_once __DIR__ . '/../includes/item/item.php';
            
            // 2. Charger les éléments de vue
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../templates/items/index.php'; // Le contenu qu'on vient de créer
            require_once __DIR__ . '/../templates/footer.php';
            break;

        case 'auth':
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../templates/connexion/index.php'; // Le contenu de la page de connexion
            require_once __DIR__ . '/../templates/footer.php';
            break;

        case 'inscription':
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../templates/inscription/index.php'; // Le contenu de la page d'inscription
            require_once __DIR__ . '/../templates/footer.php';
            break;
        
        case 'post':
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../templates/post/index.php'; // Le contenu de la page de publication d'annonce
            require_once __DIR__ . '/../templates/footer.php';
            break;

        case 'paiement':
            require_once __DIR__ . '/../includes/paiement/paiement.php';        
            
            // Logique de paiement (à implémenter)
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../templates/paiement/index.php'; // Le contenu de la page de paiement
            require_once __DIR__ . '/../templates/footer.php';
            break;
        case 'edit_item':
            require_once __DIR__ . '/../includes/item/item.php'; // Récupère les données de l'article
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../templates/edit_item/index.php'; // Le contenu de la page d'édition d'article
            require_once __DIR__ . '/../templates/footer.php';
            break;
    }
}


