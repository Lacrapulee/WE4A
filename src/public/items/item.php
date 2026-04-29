<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/articles_functions.php';
require_once __DIR__ . '/../../includes/item_page_functions.php';

$viewData = buildItemPageViewData($pdo, $_GET['id'] ?? null);
http_response_code($viewData['statusCode']);

$product = $viewData['product'];
$errorMessage = $viewData['errorMessage'];
$similarAds = $viewData['similarAds'];
$imageName = $viewData['imageName'];
$sellerDisplayName = $viewData['sellerDisplayName'];
$priceLabel = $viewData['priceLabel'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($viewData['title']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-[#f5f7fb] text-gray-900 font-sans">
    <?php include __DIR__ . '/../../templates/header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <?php if ($errorMessage): ?>
            <section class="bg-white p-12 rounded-2xl shadow-sm text-center max-w-2xl mx-auto">
                <h1 class="text-2xl font-bold mb-4">Oups !</h1>
                <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($errorMessage); ?></p>
                <a href="/index.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold">Retour à l'accueil</a>
            </section>
        <?php else: ?>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white p-4 rounded-3xl shadow-md border border-gray-100">
                        <img src="/assets/img/<?php echo htmlspecialchars($imageName); ?>" 
                             alt="<?php echo htmlspecialchars($product['titre']); ?>"
                             class="w-full aspect-[4/3] object-cover rounded-2xl bg-gray-50">
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-baseline gap-4 px-2">
                        <h1 class="text-3xl font-extrabold text-gray-900"><?php echo htmlspecialchars($product['titre']); ?></h1>
                        <p class="text-2xl font-black text-blue-600 whitespace-nowrap">
                            <?php echo htmlspecialchars($priceLabel); ?>
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2 px-2">
                        <span class="px-4 py-1.5 bg-gray-200 text-gray-700 rounded-full text-sm font-medium">
                            <?php echo htmlspecialchars($product['ville_nom'] ?? 'Ville inconnue'); ?>
                        </span>
                        <?php if (!empty($product['code_postal'])): ?>
                            <span class="px-4 py-1.5 bg-gray-200 text-gray-700 rounded-full text-sm font-medium"><?php echo htmlspecialchars($product['code_postal']); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="px-2 pt-4">
                        <h2 class="text-xl font-bold mb-3">Description</h2>
                        <p class="text-gray-700 leading-relaxed text-lg">
                            <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                        </p>
                    </div>
                </div>

                <aside class="space-y-6">
                    
                    <section class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Vendeur</p>
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            <?php echo htmlspecialchars($sellerDisplayName); ?>
                        </h2>
                        <div class="space-y-2 text-gray-600 text-sm">
                            <?php if (!empty($product['vendeur_telephone'])): ?>
                                <p class="flex items-center gap-2">📞 <?php echo htmlspecialchars($product['vendeur_telephone']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($product['vendeur_email'])): ?>
                                <p class="flex items-center gap-2 truncate">✉️ <?php echo htmlspecialchars($product['vendeur_email']); ?></p>
                            <?php endif; ?>
                        </div>
                    </section>

                    <section class="bg-white p-6 rounded-3xl shadow-md border border-gray-100 flex flex-col gap-4">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Action rapide</p>
                        <a href="/paiement/index.php?id=<?php echo urlencode($product['id']); ?>" class="w-full bg-gray-900 text-white text-center py-4 rounded-xl font-bold text-lg hover:bg-black transition-all transform hover:scale-[1.02]">
                            Acheter l'article
                        </a>
                        <p class="text-xs text-center text-gray-400 italic">Paiement sécurisé disponible</p>
                    </section>

                    <section class="bg-white p-6 rounded-3xl shadow-md border border-gray-100">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-4">Annonces similaires</p>
                        
                        <?php if (!empty($similarAds)): ?>
                            <div class="grid gap-4">
                                <?php foreach ($similarAds as $similarAd): ?>
                                    <a href="/items/item.php?id=<?php echo $similarAd['id']; ?>" class="group flex gap-4 p-2 rounded-2xl hover:bg-gray-50 transition-colors">
                                        <img src="/assets/img/<?php echo htmlspecialchars($similarAd['image_name']); ?>" 
                                             class="w-20 h-20 object-cover rounded-xl shadow-sm">
                                        <div>
                                            <h3 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-1"><?php echo htmlspecialchars($similarAd['titre']); ?></h3>
                                            <p class="text-red-500 font-bold"><?php echo htmlspecialchars($similarAd['price_label']); ?></p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 italic text-center py-4">Aucune annonce similaire.</p>
                        <?php endif; ?>
                    </section>
                </aside>

            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../../templates/footer.php'; ?>
</body>
</html>