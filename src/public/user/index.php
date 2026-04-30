
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?= htmlspecialchars($nom . ' ' . $prenom) ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/user.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="profile-container">
        <!-- HEADER DU PROFIL -->
        <header class="profile-header">
            <div class="profile-info">
                <h1><?= htmlspecialchars($nom . ' ' . $prenom) ?></h1>
                <p>Membre depuis le <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                <p> Téléphone: <?= htmlspecialchars($telephone) ?></p>
                <p> Adresse postale: <?= htmlspecialchars($adresse_postale ?? 'Non renseignée') ?></p>
                <?php if ($is_owner): ?>
                    <a href="../routeur.php?action=edit_profile" class="btn-edit"> Modifier mon profil</a>
                <?php else: ?>
                    <a href="../contact.php?to=<?= $profile_id ?>" class="btn-edit">✉️ Contacter le vendeur</a>
                <?php endif; ?>
            </div>
        </header>

        <div class="profile-grid">
            <section class="user-items">
                <h2 class="section-title">Annonces</h2>
                <div class="items-grid">
                    <?php foreach ($articles as $article): ?>
                        
                        <div class="item-card">
                            <!-- Ici, il faudrait une jointure pour avoir l'image principale -->
                            <a href="../items?id=<?= $article['id'] ?>"> 
                                <img src="../assets/img/<?= htmlspecialchars($article['image']) ?>" alt="Item">
                            </a>
                            <div class="item-info">
                                <strong><?= htmlspecialchars($article['titre']) ?></strong>
                                    <p><?= $article['prix'] ?> € <span class="status-tag"><?= $article['statut'] ?></span></p>
                                    
                            </div>
                        </div>
                        
                    <?php endforeach; ?>
                </div>
            </section>

            <aside class="user-reviews">
                <h2 class="section-title">Avis clients</h2>
                <?php if (empty($reviews)): ?>
                    <p>Aucun avis pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <strong><?= htmlspecialchars($review['username']) ?></strong>
                            <p>"<?= htmlspecialchars($review['contenu']) ?>"</p>
                            <small>Note: <?= $review['note'] ?>/5</small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </aside>
        </div>
    </div>

    <?php include '../templates/footer.php'; ?>
</body>
</html>