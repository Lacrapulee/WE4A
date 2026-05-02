<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de <?= htmlspecialchars($nom . ' ' . $prenom) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/user.css">
</head>
<body>
    <?php include __DIR__ . '/../../templates/header.php'; ?>

    <div class="profile-container">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success" style="margin-bottom: 2rem; padding: 1rem; background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; color: #166534; font-weight: 600;">
                ✓ Votre avis a été publié avec succès !
            </div>
        <?php endif; ?>

        <header class="profile-header">
            <div class="profile-info">
                <h1><?= htmlspecialchars($nom . ' ' . $prenom) ?></h1>
                <p>Membre depuis le <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                <p> Téléphone: <?= htmlspecialchars($telephone) ?></p>
                <p> Adresse postale: <?= htmlspecialchars($adresse_postale ?? 'Non renseignée') ?></p>
                <?php if ($is_owner): ?>
                    <a href="../routeur.php?action=edit_profile" class="btn-edit"> Modifier mon profil</a>
                <?php else: ?>
                    <a href="mailto:<?= htmlspecialchars($email) ?>" class="btn-edit">✉️ Contacter le vendeur</a>
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
                            <a href="/routeur.php?action=item&id=<?= $article['id'] ?>"> 
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
                <div class="reviews-header">
                    <h2 class="section-title">Avis clients</h2>
                    <?php if (!$is_owner && isset($_SESSION['user_id'])): ?>
                        <button type="button" onclick="openReviewModal('<?= htmlspecialchars($profile_id, ENT_QUOTES) ?>')" class="btn-add-review" style="border:none; cursor:pointer; background:transparent; padding:0;">
                            + Ajouter un avis
                        </button>
                    <?php endif; ?>
                </div>
                <?php if (empty($reviews)): ?>
                    <p>Aucun avis pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <strong><?= htmlspecialchars($review['auteur_prenom'] . ' ' . $review['auteur_nom']) ?></strong>
                                <span class="review-note">⭐ <?= $review['note'] ?>/5</span>
                            </div>
                            <?php if ($review['article_titre']): ?>
                                <small class="review-item">Pour l'article : <?= htmlspecialchars($review['article_titre']) ?></small>
                            <?php endif; ?>
                            <p class="review-text">"<?= htmlspecialchars($review['commentaire']) ?>"</p>
                            <small class="review-date">Le <?= date('d/m/Y', strtotime($review['date_avis'])) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </aside>
        </div>
    </div>

    <?php
    $reviewModalId = 'reviewModalUser';
    $reviewTitle = 'Donner mon avis';
    $reviewButtonLabel = 'Envoyer l\'avis';
    $reviewTargetId = $profile_id;
    $reviewArticleId = '';
    require __DIR__ . '/../avis/modal.php';
    ?>

    <?php include __DIR__ . '/../../templates/footer.php'; ?>
</body>
</html>