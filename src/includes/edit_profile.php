<?php
session_start();
require_once __DIR__ . '/db.php';

// Sécurité : Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../connexion');
    exit;
}

$user_id = $_SESSION['user_id'];
$success = false;
$error = null;

// --- PARTIE 1 : TRAITEMENT DE LA MISE À JOUR ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');

    if (!empty($nom) && !empty($prenom)) {
        $stmt = $pdo->prepare("UPDATE users SET nom = ?, prenom = ? WHERE id = ?");
        if ($stmt->execute([$nom, $prenom, $user_id])) {
            $success = true;
        } else {
            $error = "Erreur lors de la mise à jour.";
        }
    } else {
        $error = "Le nom et le prénom sont obligatoires.";
    }
    
}

// --- PARTIE 2 : RÉCUPÉRATION DES INFOS ACTUELLES ---
$stmt = $pdo->prepare("SELECT nom, prenom, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();