<?php 
    require_once '../includes/db.php';
    require_once '../includes/articles_functions.php'; // On charge nos fonctions
    
    // On appelle la fonction pour récupérer les données
    $articles = getAnnoncesEnLigne($pdo);

    include '../templates/header.php'; 
?>

<main>
    <h2>Toutes les annonces</h2>
    
    <?php if (empty($articles)): ?>
        <p>Aucune annonce pour le moment.</p>
    <?php else: ?>
        <div class="annonces-grid">
            <?php foreach ($articles as $article): ?>
                <div class="annonce-card">
                    <h3><?= htmlspecialchars($article['titre']) ?></h3>
                    <p>Prix : <strong><?= $article['prix'] ?> €</strong></p>
                    <p>Ville : <?= htmlspecialchars($article['ville_nom']) ?></p>
                    <a href="annonce.php?id=<?= $article['id'] ?>">Voir le détail</a>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include '../templates/footer.php'; ?>