<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/articles_functions.php';

$productId = $_GET['id'] ?? null;
$product = getAnnonceById($pdo, $productId);

if (!$product) {
    $errorMessage = "Cet article n'existe pas ou n'est plus disponible.";
} else {
    $errorMessage = null;
    $allImages = getAllImagesByAnnonceId($pdo, $product['id']);
    if (empty($allImages)) $allImages = ['default.png'];
    $similarAds = getAnnoncesSimilaires($pdo, $product['categorie_id'], $product['id']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product ? htmlspecialchars($product['titre']) : 'Article introuvable'; ?> - LeCoinCarré</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/item.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
</head>
<body class="bg-[#EDFCFD] text-gray-900 flex flex-col min-h-screen">



<main class="flex-grow max-w-7xl mx-auto px-4 py-8 w-full">
    <?php if ($errorMessage): ?>
        <div class="bg-white p-12 rounded-3xl shadow-sm text-center max-w-2xl mx-auto mt-10 border border-gray-100">
            <h1 class="text-2xl font-bold mb-4">Oups !</h1>
            <p class="text-gray-600 mb-6"><?= $errorMessage ?></p>
            <a href="routeur.php?action=catalogue" class="bg-[#005F83] text-white px-6 py-3 rounded-xl font-bold transition-all hover:bg-[#004a66]">Retour au catalogue</a>
        </div>
    <?php else: ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- COLONNE GAUCHE (Image + Description) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- CARROUSEL -->
                <div class="product-card-container p-4">
                    <div class="carousel-wrapper rounded-2xl group relative overflow-hidden bg-gray-50 aspect-[4/3]">
                        <div id="carousel-track" class="flex transition-transform duration-500 ease-out h-full">
                            <?php foreach ($allImages as $img): ?>
                                <img src="/assets/img/<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover flex-shrink-0">
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($allImages) > 1): ?>
                            <button onclick="moveCarousel(-1)" class="carousel-btn absolute left-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">❮</button>
                            <button onclick="moveCarousel(1)" class="carousel-btn absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity">❯</button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- INFOS -->
                <div class="flex justify-between items-baseline px-2">
                    <h1 class="product-title text-3xl font-extrabold"><?= htmlspecialchars($product['titre']) ?></h1>
                    <p class="product-price text-2xl font-black"><?= number_format($product['prix'], 2, ',', ' ') ?> €</p>
                </div>

                <div class="px-2 pt-4">
                    <p class="section-label">Description</p>
                    <p class="text-gray-700 leading-relaxed text-lg"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>
            </div>

            <!-- COLONNE DROITE (Vendeur + Similaires) -->
            <aside class="space-y-6">
                <!-- Vendeur -->
                <section class="aside-section">
                    <p class="section-label">Vendeur</p>
                    <a href="routeur.php?action=user&id=<?= $product['vendeur_id'] ?>" class="text-xl font-bold hover:text-[#005F83] transition-colors flex items-center gap-2">
                        <span class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-sm">👤</span>
                        <?= htmlspecialchars($product['vendeur_prenom'] . ' ' . $product['vendeur_nom']) ?>
                    </a>
                </section>

                <!-- Bouton Action -->
                <a href="#" class="btn-buy">Acheter l'article</a>

                <!-- SIMILAIRES -->
                <section class="aside-section">
                    <p class="section-label mb-4">Annonces similaires</p>
                    <div class="space-y-2">
                        <?php foreach ($similarAds as $ad): ?>
                            <a href="routeur.php?action=item&id=<?= $ad['id'] ?>" class="similar-ad-card">
                                <img src="/assets/img/<?= getImageByAnnonceId($pdo, $ad['id']) ?: 'default.png' ?>" class="similar-thumbnail">
                                <div class="overflow-hidden">
                                    <h4 class="font-bold text-sm text-gray-900 truncate"><?= htmlspecialchars($ad['titre']) ?></h4>
                                    <p class="text-[#005F83] font-bold text-sm"><?= number_format($ad['prix'], 2, ',', ' ') ?> €</p>
                                </div>
                            </a>
                        <?php endforeach; ?>

                        <?php if(empty($similarAds)): ?>
                            <p class="text-gray-400 text-sm italic">Aucune annonce similaire.</p>
                        <?php endif; ?>
                    </div>
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