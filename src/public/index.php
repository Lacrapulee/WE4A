<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Projet Docker</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>


<body>
    <div class="card">
        <h1>🚀 Succès !</h1>
        <p>Ton serveur <strong>PHP + Apache</strong> fonctionne sous Docker.</p>
        <p class="status">Version de PHP : <?php echo phpversion(); ?></p>
        <p>Dossier actuel : <code><?php echo __DIR__; ?></code></p>
    </div>
</body>
</html>