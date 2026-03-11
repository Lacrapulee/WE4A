<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Projet Docker</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f9; }
        .card { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        .status { color: green; font-weight: bold; }
    </style>
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