<?php

session_start(); 

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'connexion':
            require_once __DIR__ . '/../includes/login.php';
            break;
        case 'inscription':
            require_once __DIR__ . '/../includes/register.php';
            break;
        case 'post':
            require_once __DIR__ . '/../includes/post.php';
        case 'edit_profile':
            require_once __DIR__ . '/../includes/edit_profile.php';
            header('Location: routeur.php?action=user&id=' . $_SESSION['user_id']);
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    switch ($action) {
        case 'user':
            require_once __DIR__ . '/../includes/user.php';
            include __DIR__ . '/../public/user/index.php';
            break;
        case 'catalogue':
            require_once __DIR__ . '/../includes/catalogue.php';
            require_once __DIR__ . '/catalogue/index.php';
            break;
        
        case 'edit_profile':
            require_once __DIR__ . '/../includes/edit_profile.php';
            
            include '../templates/header.php';
            include __DIR__ . '/../public/edit_profile/index.php'; // Affiche la vue
            include '../templates/footer.php';
            break;
        // ... dans ton switch ($action) au niveau du GET
        case 'item':
            // 1. Charger la logique (Définit les variables $product, $allImages, etc.)
            require_once __DIR__ . '/../includes/item.php';
            
            // 2. Charger les éléments de vue
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/items/index.php'; // Le contenu qu'on vient de créer
            require_once __DIR__ . '/../templates/footer.php';
            break;

        case 'auth':
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../public/connexion/index.php'; // Le contenu de la page de connexion
            require_once __DIR__ . '/../templates/footer.php';
            break;

        case 'inscription':
            require_once __DIR__ . '/../templates/header.php'; // Ton header Tailwind
            require_once __DIR__ . '/../public/inscription/index.php'; // Le contenu de la page d'inscription
            require_once __DIR__ . '/../templates/footer.php';
            break;
    }
}


