<?php
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
            break;
        case 'item':
            require_once __DIR__ . '/../includes/item.php';
            break;
        case 'edit_profile':
            require_once __DIR__ . '/../includes/edit_profile.php';
            include __DIR__ . '/../public/edit_profile/index.php'; // Affiche la vue
            break;
    }
}

