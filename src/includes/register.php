<?php

require_once __DIR__ . '/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Récupération
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

$nom = isset($_POST['nom']) ? $_POST['nom'] : null;
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : null;
$telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
$date_naissance = isset($_POST['date_naissance']) ? $_POST['date_naissance'] : null;
$adresse = isset($_POST['adresse_postale']) ? $_POST['adresse_postale'] : null;

if (empty($email) || empty($password) || empty($confirm)) {
    die("Champs obligatoires manquants");
}

if ($password !== $confirm) {
    die("Les mots de passe ne correspondent pas");
}

try {
    // Vérifier si email existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->fetch()) {
        die("Email déjà utilisé");
    }

    // UUID génération
    $id = bin2hex(random_bytes(16)); // simple unique (32 chars)

    // Hash mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertion
    $stmt = $pdo->prepare("
        INSERT INTO users 
        (id, email, password, nom, prenom, telephone, date_naissance, adresse_postale)
        VALUES 
        (:id, :email, :password, :nom, :prenom, :telephone, :date_naissance, :adresse)
    ");

    $stmt->execute([
        'id' => $id,
        'email' => $email,
        'password' => $hashedPassword,
        'nom' => $nom,
        'prenom' => $prenom,
        'telephone' => $telephone,
        'date_naissance' => $date_naissance ?: null,
        'adresse' => $adresse
    ]);

    // Connexion auto
    $_SESSION['user_id'] = $id;
    $_SESSION['email'] = $email;

    header("Location: /index.php");
    exit;

} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}