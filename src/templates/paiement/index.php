

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

    <main class="max-w-5xl mx-auto px-4 py-8">
        <?php if ($viewData['errorMessage'] && !$product): ?>
            <section class="bg-white p-10 rounded-2xl shadow-sm text-center max-w-2xl mx-auto">
                <h1 class="text-2xl font-bold mb-3">Paiement</h1>
                <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($viewData['errorMessage']); ?></p>
                <a href="/index.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold">Retour aux annonces</a>
            </section>
        <?php elseif ($product): ?>
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <article class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">Article</p>
                    <img src="/assets/img/<?php echo htmlspecialchars($viewData['imageName']); ?>" alt="<?php echo htmlspecialchars($product['titre']); ?>" class="w-full aspect-[4/3] object-cover rounded-2xl mb-4 bg-gray-50">
                    <h2 class="text-2xl font-extrabold mb-2"><?php echo htmlspecialchars($product['titre']); ?></h2>
                    <p class="text-xl font-black text-blue-600 mb-4"><?php echo htmlspecialchars($viewData['priceLabel']); ?></p>
                    <p class="text-gray-600"><?php echo htmlspecialchars($product['ville_nom'] ?? 'Ville inconnue'); ?></p>
                </article>

                <article class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">Paiement et validation</p>

                    <?php if ($viewData['successMessage']): ?>
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl p-4 mb-4">
                            <p class="font-semibold"><?php echo htmlspecialchars($viewData['successMessage']); ?></p>
                            <p class="text-sm mt-1">Reference: <?php echo htmlspecialchars($viewData['orderReference']); ?></p>
                        </div>
                        <a href="/index.php" class="inline-block bg-gray-900 text-white px-6 py-3 rounded-xl font-bold">Retour aux annonces</a>
                    <?php else: ?>
                        <?php if ($viewData['errorMessage']): ?>
                            <p class="mb-4 text-sm text-red-600"><?php echo htmlspecialchars($viewData['errorMessage']); ?></p>
                        <?php endif; ?>

                        <form method="post" class="space-y-4">
                            <input type="hidden" name="article_id" value="<?php echo htmlspecialchars($product['id']); ?>">

                            <div>
                                <label class="block text-sm font-semibold mb-1" for="buyer_name">Nom complet</label>
                                <input id="buyer_name" name="buyer_name" type="text" value="<?php echo htmlspecialchars($viewData['buyerName']); ?>" class="w-full border border-gray-300 rounded-xl px-4 py-3" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1" for="buyer_email">Email</label>
                                <input id="buyer_email" name="buyer_email" type="email" value="<?php echo htmlspecialchars($viewData['buyerEmail']); ?>" class="w-full border border-gray-300 rounded-xl px-4 py-3" required>
                            </div>

                            <button type="submit" name="confirm_payment" value="1" class="w-full bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-black">
                                Valider et payer <?php echo htmlspecialchars($viewData['priceLabel']); ?>
                            </button>
                        </form>
                    <?php endif; ?>
                </article>
            </section>
        <?php endif; ?>
    </main>

</body>
</html>