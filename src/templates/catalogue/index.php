<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue - LeCoinCarré</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/catalogue.css">


</head>
<body class="bg-[#EDFCFD] flex flex-col min-h-screen">
<?php include '../templates/header.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-8 w-full flex-grow">
    <!-- SECTION FILTRES -->
    <section class="bg-white p-6 mb-10">
        <form action="/routeur.php" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <input type="hidden" name="action" value="catalogue">

            <div>
                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Que cherchez-vous ?</label>
                <input type="text" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>"
                       placeholder="Ex: Vélo, iPhone..." class="w-full rounded-lg p-2.5 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Catégorie</label>
                <select name="categorie" class="w-full rounded-lg p-2.5 outline-none">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($filters['categorie']) && $filters['categorie'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Ville</label>
                <input type="text" name="ville" value="<?= htmlspecialchars($filters['ville'] ?? '') ?>"
                       placeholder="Ex: Paris" class="w-full rounded-lg p-2.5 outline-none">
            </div>

            <div class="flex items-end gap-3">
                <div class="flex-grow">
                    <label class="block text-xs font-bold uppercase text-gray-400 mb-2">Prix Max</label>
                    <input type="number" name="prix_max" value="<?= htmlspecialchars($filters['prix_max'] ?? '') ?>"
                           placeholder="€" class="w-full rounded-lg p-2.5 outline-none">
                </div>
                <button type="submit" class="px-6 py-2.5 font-bold transition-all">
                    Filtrer
                </button>
            </div>
        </form>
    </section>

    <!-- GRILLE D'ARTICLES -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        <?php if (!empty($results)): ?>
            <?php foreach ($results as $item): ?>
                <?php $img = getImageByAnnonceId($pdo, $item['id']) ?: 'default.png'; ?>
                <a href="/routeur.php?action=item&id=<?= $item['id'] ?>" class="group">
                    <img src="/assets/img/<?= htmlspecialchars($img) ?>" alt="Produit">
                    <div class="p-4">
                        <h3 class="font-bold truncate"><?= htmlspecialchars($item['titre']) ?></h3>
                        <p class="text-blue-600"><?= number_format($item['prix'], 2, ',', ' ') ?> €</p>

                        <div class="flex justify-between items-center mt-4">
                            <span class="text-gray-400 text-[10px] font-bold uppercase"><?= htmlspecialchars($item['ville_nom']) ?></span>
                            <span class="text-gray-400 text-[10px] font-bold uppercase"><?= htmlspecialchars($item['categorie_nom']) ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-20 text-gray-400">
                <p class="text-lg">Aucun article trouvé.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include '../templates/footer.php'; ?>
</body>
</html>