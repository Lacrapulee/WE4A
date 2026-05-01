<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? htmlspecialchars($product['titre']) : 'Article introuvable'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/item.css">
</head>
<body class="page-body">

<main class="main-container">
    <?php if ($errorMessage): ?>
        <div class="error-box">
            <h1 class="text-2xl font-bold mb-4">Oups !</h1>
            <p class="text-gray-600 mb-6"><?= $errorMessage ?></p>
            <a href="routeur.php?action=catalogue" class="btn-back">Retour au catalogue</a>
        </div>
    <?php else: ?>
        
        <div class="product-grid">
            <!-- COLONNE GAUCHE (Image + Description) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARROUSEL -->
                <div class="carousel-card">
                    <div class="carousel-viewport">
                        <div id="carousel-track" class="carousel-track">
                            <?php foreach ($allImages as $img): ?>
                                <img src="/assets/img/<?= htmlspecialchars($img) ?>" class="carousel-slide">
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($allImages) > 1): ?>
                            <button onclick="moveCarousel(-1)" class="carousel-nav left-4">❮</button>
                            <button onclick="moveCarousel(1)" class="carousel-nav right-4">❯</button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- TITRE & PRIX -->
                <div class="flex justify-between items-baseline px-2">
                    <h1 class="text-3xl font-extrabold"><?= htmlspecialchars($product['titre']) ?></h1>
                    <p class="product-price"><?= number_format($product['prix'], 2, ',', ' ') ?> €</p>
                </div>

                <!-- INFORMATIONS -->
                <div class="content-section">
                    <div class="info-block">
                        <h2>Description</h2>
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    </div>

                    <div class="info-block">
                        <h2>Localisation</h2>
                        <p><?= htmlspecialchars($product['ville_nom'] . ' (' . $product['code_postal'] . ')') ?></p>
                    </div>

                    <div class="info-block">
                        <h2>Catégorie</h2>
                        <p><?= htmlspecialchars($product['categorie_nom']) ?></p>
                    </div>

                    <div class="info-block">
                        <h2>Publié le</h2>
                        <p><?= date('d/m/Y', strtotime($product['created_at'])) ?></p>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE (Vendeur + Similaires) -->
            <aside class="space-y-6">
                <section class="aside-card">
                    <p class="meta-label">Vendeur</p>
                    <a href="routeur.php?action=user&id=<?= $product['vendeur_id'] ?>" class="vendeur-link">
                        <?= htmlspecialchars($product['vendeur_prenom'] . ' ' . $product['vendeur_nom']) ?>
                    </a>
                </section>

                <!-- BOUTON D'ACHAT / MODIFICATION -->
                <?php if ($_SESSION['admin'] ?? false): ?>
                    <a href="routeur.php?action=paiement&id=<?= $product['id'] ?>" class="btn-buy">Acheter l'article</a>
                    <a href="routeur.php?action=edit_item&id=<?= $product['id'] ?>" class="btn-buy">Modifier l'article</a>
                <?php elseif (!$isOwner && $product['statut'] === 'en_ligne'): ?>
                    <a href="routeur.php?action=paiement&id=<?= $product['id'] ?>" class="btn-buy">Acheter l'article</a>
                <?php elseif ($isOwner): ?>
                    <a href="routeur.php?action=edit_item&id=<?= $product['id'] ?>" class="btn-buy">Modifier l'article</a>
                <?php endif; ?>
            
                

                <!-- SIMILAIRES -->
                <section class="aside-card">
                    <p class="meta-label">Annonces similaires</p>
                    <?php foreach ($similarAds as $ad): ?>
                        <a href="routeur.php?action=item&id=<?= $ad['id'] ?>" class="similar-item group">
                            <img src="/assets/img/<?= getImageByAnnonceId($pdo, $ad['id']) ?: 'default.png' ?>" alt="Thumbnail">
                            <div>
                                <h4 class="group-hover:text-blue-600"><?= htmlspecialchars($ad['titre']) ?></h4>
                                <p><?= number_format($ad['prix'], 2, ',', ' ') ?> €</p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </section>
            </aside>
        </div>
    <?php endif; ?>
</main>

<script>
    let currentIndex = 0;
    const track = document.getElementById('carousel-track');
    const total = <?= count($allImages ?? []) ?>;
    function moveCarousel(dir) {
        if (total <= 1) return;
        currentIndex = (currentIndex + dir + total) % total;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
</script>
</body>
</html>