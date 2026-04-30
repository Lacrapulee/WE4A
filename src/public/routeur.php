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
            
            break;
    }
}