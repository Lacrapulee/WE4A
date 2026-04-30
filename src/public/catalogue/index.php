<?php
session_start();
include '../../includes/db.php';
require_once '../../includes/articles_functions.php';

// On récupère tous les filtres depuis l'URL (GET)
$filters = [
    'search'    => $_GET['search'] ?? '',
    'categorie' => $_GET['categorie'] ?? '',
    'ville'     => $_GET['ville'] ?? '',
    'prix_max'  => $_GET['prix_max'] ?? ''
];

$results = getAnnonceRechercheAvancee($pdo, $filters);
$categories = getCategories($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue - LeCoinCarré</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <?php include '../../templates/header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-8 w-full">
        <!-- BARRE DE RECHERCHE AVANCÉE -->
        <section class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
            <form action="index.php" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Mot-clé -->
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Que cherchez-vous ?</label>
                    <input type="text" name="search" value="<?= htmlspecialchars($filters['search']) ?>" 
                           placeholder="Ex: Vélo, iPhone..." class="w-full border-gray-200 rounded-lg p-2 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Catégorie</label>
                    <select name="categorie" class="w-full border-gray-200 rounded-lg p-2 bg-gray-50 outline-none">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $filters['categorie'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Ville -->
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Ville</label>
                    <input type="text" name="ville" value="<?= htmlspecialchars($filters['ville']) ?>" 
                           placeholder="Ex: Belfort" class="w-full border-gray-200 rounded-lg p-2 bg-gray-50 outline-none">
                </div>

                <!-- Prix Max + Bouton -->
                <div class="flex items-end gap-2">
                    <div class="flex-grow">
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-1">Prix Max (€)</label>
                        <input type="number" name="prix_max" value="<?= htmlspecialchars($filters['prix_max']) ?>" 
                               class="w-full border-gray-200 rounded-lg p-2 bg-gray-50 outline-none">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition-colors">
                        Filtrer
                    </button>
                </div>
            </form>
        </section>

        <!-- AFFICHAGE DES RÉSULTATS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $item): ?>
                    <?php $img = getImageByAnnonceId($pdo, $item['id']) ?: 'default.png'; ?>
                    <a href="/items/item.php?id=<?= $item['id'] ?>" class="group bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-lg transition-all">
                        <img src="/assets/img/<?= htmlspecialchars($img) ?>" class="w-full aspect-video object-cover">
                        <div class="p-4">
                            <h3 class="font-bold truncate"><?= htmlspecialchars($item['titre']) ?></h3>
                            <p class="text-blue-600 font-black mt-1"><?= number_format($item['prix'], 2, ',', ' ') ?> €</p>
                            <div class="flex justify-between items-center mt-3 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                <span><?= htmlspecialchars($item['ville_nom']) ?></span>
                                <span><?= htmlspecialchars($item['categorie_nom']) ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="col-span-full text-center py-20 text-gray-400">Aucun article ne correspond à ces critères.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../../templates/footer.php'; ?>
</body>
</html>