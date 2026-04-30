<?php
include '../includes/db.php';
require_once '../includes/articles_functions.php';

// On récupère tous les filtres depuis l'URL (GET)
$filters = [
    'search'    => $_GET['search'] ?? '',
    'categorie' => $_GET['categorie'] ?? '',
    'ville'     => $_GET['ville'] ?? '',
    'prix_max'  => $_GET['prix_max'] ?? ''
];

$results = getAnnonceRechercheAvancee($pdo, $filters);
$categories = getCategories($pdo);
