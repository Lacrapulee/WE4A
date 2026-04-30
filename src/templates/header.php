
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
        <a href="/">
            <img src="../assets/img/logo.png" alt="Accueil">
        </a>
    </div>

    </div class="nav-links">
        <a href="/routeur.php?action=post">Vendre</a>
    </div>

    <div class="search-bar">
        <form action="/routeur.php?action=catalogue" method="GET">
            <input type="hidden" name="action" value="catalogue">
            <input type="text" name="search" placeholder="Rechercher un produit...">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <nav class="header-actions">
        <a href="/routeur.php?action=auth" class="btn-secondary">Connexion</a>
        <a href="/routeur.php?action=inscription" class="btn-secondary">Inscription</a>
        <a href="/routeur.php?action=user&id=<?= $_SESSION['user_id'] ?? '' ?>" method="GET" class="btn-cart"><i class="fa-solid fa-user"></i></a>
    </nav>
</header>