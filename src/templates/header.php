
 <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mon Projet Docker</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

<header class="main-header">
    <div class="logo">
        <a href="/index.php">MaBoutique</a>
    </div>

    <div class="search-bar">
        <form action="/catalogue/index.php" method="GET">
            <input type="text" name="search" placeholder="Rechercher un produit...">
            <button type="submit">🔍</button>
        </form>
    </div>

    <nav class="header-actions">
        <a href="/login.php" class="btn-secondary">Connexion</a>
        <a href="/panier.php" class="btn-cart">🛒 Panier (0)</a>
    </nav>
</header>