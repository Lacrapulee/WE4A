<?php
require_once __DIR__ . '/db.php';
session_start();

// 1. Récupérer l'ID du profil à afficher
$profile_id = $_GET['id'] ?? null;
if (!$profile_id) { die("Utilisateur non trouvé."); }

// 2. Chercher les infos du compte
$stmt = $pdo->prepare("SELECT nom, prenom, telephone, email, created_at, adresse_postale FROM users WHERE id = ?");
$stmt->execute([$profile_id]);
$user = $stmt->fetch();

if (!$user) { die("Ce profil n'existe pas."); }

// 3. Vérifier si c'est le propriétaire qui regarde
$is_owner = (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $profile_id);

// 4. Récupérer les articles (À vendre et Vendus)
$stmt = $pdo->prepare("SELECT * FROM articles WHERE vendeur_id = ? ORDER BY created_at DESC");
$stmt->execute([$profile_id]);
$articles = $stmt->fetchAll();

// 5. Récupérer les images principales de chaque article
foreach ($articles as &$article) {
    $stmt = $pdo->prepare("SELECT url_image FROM article_images WHERE article_id = ? AND est_principale = 1 LIMIT 1");
    $stmt->execute([$article['id']]);
    $image = $stmt->fetch();
    $article['image'] = $image ? $image['url_image'] : 'default.png';
}

// 6. Récupérer les commentaires sur ce vendeur
//$stmt = $pdo->prepare("SELECT c.*, u.username FROM commentaires c JOIN users u ON c.auteur_id = u.id WHERE c.cible_id = ?");
//$stmt->execute([$profile_id]);
//$reviews = $stmt->fetchAll();
$reviews = []; // À implémenter plus tard
// 7. Mettre les variables pour la vue et afficher la page
$nom = $user['nom'];
$prenom = $user['prenom'];
$telephone = $user['telephone'];
$email = $user['email'];
$created_at = $user['created_at'];
$adresse_postale = $user['adresse_postale'];

?>
