
 <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LeCoinCarré</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>

<header class="main-header">
    <div class="logo">
        <a href="/index.php">LeCoinCarré</a>
    </div>

    <div class="search-bar">
        <form action="/catalogue/index.php" method="GET">
            <input type="text" name="search" placeholder="Rechercher un produit...">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <nav class="header-actions">
        <a href="/connexion/index.php" class="btn-secondary">Connexion</a>
        <a href="/inscription/index.php" class="btn-secondary">Inscription</a>
        <a href="/panier.php" class="btn-cart"><i class="fa-solid fa-bag-shopping"></i></a>
    </nav>
</header>