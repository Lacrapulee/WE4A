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
    <title><?php echo $product ? htmlspecialchars($product['titre']) : 'Article introuvable'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-[#f5f7fb] text-gray-900 flex flex-col min-h-screen">
<!-- templates/item_view.php -->
<main class="flex-grow max-w-7xl mx-auto px-4 py-8 w-full">
    <?php if ($errorMessage): ?>
        <div class="bg-white p-12 rounded-3xl shadow-sm text-center max-w-2xl mx-auto mt-10">
            <h1 class="text-2xl font-bold mb-4">Oups !</h1>
            <p class="text-gray-600 mb-6"><?= $errorMessage ?></p>
            <a href="routeur.php?action=catalogue" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Retour au catalogue</a>
        </div>
    <?php else: ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- COLONNE GAUCHE (Image + Description) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARROUSEL -->
                <div class="bg-white p-4 rounded-3xl shadow-md border border-gray-100">
                    <div class="relative group overflow-hidden rounded-2xl aspect-[4/3] bg-gray-50">
                        <div id="carousel-track" class="flex transition-transform duration-500 ease-out h-full">
                            <?php foreach ($allImages as $img): ?>
                                <img src="/assets/img/<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover flex-shrink-0">
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($allImages) > 1): ?>
                            <button onclick="moveCarousel(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">❮</button>
                            <button onclick="moveCarousel(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 p-2 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">❯</button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- INFOS -->
                <div class="flex justify-between items-baseline px-2">
                    <h1 class="text-3xl font-extrabold"><?= htmlspecialchars($product['titre']) ?></h1>
                    <p class="text-2xl font-black text-blue-600"><?= number_format($product['prix'], 2, ',', ' ') ?> €</p>
                </div>

                <div class="px-2 pt-4">
                    <h2 class="text-xl font-bold mb-3">Description</h2>
                    <p class="text-gray-700 leading-relaxed text-lg"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>
            </div>

            <!-- COLONNE DROITE (Vendeur + Similaires) -->
            <aside class="space-y-6">
                <section class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Vendeur</p>
                    <a href="routeur.php?action=user&id=<?= $product['vendeur_id'] ?>" class="text-xl font-bold hover:text-blue-600 transition-colors">
                        <?= htmlspecialchars($product['vendeur_prenom'] . ' ' . $product['vendeur_nom']) ?>
                    </a>
                </section>

                <a href="#" class="block w-full bg-gray-900 text-white text-center py-4 rounded-2xl font-bold text-lg">Acheter l'article</a>
                
                <!-- SIMILAIRES -->
                <section class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-4">Annonces similaires</p>
                    <?php foreach ($similarAds as $ad): ?>
                        <a href="routeur.php?action=item&id=<?= $ad['id'] ?>" class="flex gap-4 mb-4 group">
                            <img src="/assets/img/<?= getImageByAnnonceId($pdo, $ad['id']) ?: 'default.png' ?>" class="w-16 h-16 object-cover rounded-xl">
                            <div>
                                <h4 class="font-bold text-sm group-hover:text-blue-600"><?= htmlspecialchars($ad['titre']) ?></h4>
                                <p class="text-blue-600 font-bold text-sm"><?= number_format($ad['prix'], 2, ',', ' ') ?> €</p>
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
        currentIndex = (currentIndex + dir + total) % total;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
</script>
</body>
</html>