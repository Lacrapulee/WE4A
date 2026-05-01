<?php require_once __DIR__ . '/../../includes/mes_commandes/mes_commandes.php'; ?>

<main style="max-width: 1200px; margin: 0 auto; padding: 20px; font-family: sans-serif;">
    
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Mes commandes</h1>

    <!-- RÉSUMÉ RAPIDE -->
    <div style="display: flex; gap: 20px; margin-bottom: 30px; padding: 15px; background: #eee; border-radius: 8px;">
        <div>
            <strong>Nombre de commandes :</strong> <?= count($commandes) ?>
        </div>
        <div>
            <strong>Total dépensé :</strong> <?= number_format(array_sum(array_column($commandes, 'montant')), 2, ',', ' ') ?> €
        </div>
    </div>

    <!-- GRILLE DE PRODUITS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        
        <?php if (empty($commandes)): ?>
            <p>Vous n'avez aucune commande.</p>
        <?php else: ?>
            <?php foreach ($commandes as $cmd): ?>
                <?php 
                    $isRecu = ($cmd['statut'] === 'recu');
                    $image = $imagesByCommande[$cmd['article_id']] ?? 'default.png';
                ?>
                
                <article style="border: 1px solid #ccc; border-radius: 10px; overflow: hidden; background: #fff;">
                    <!-- IMAGE -->
                    <div style="width: 100%; height: 200px; background: #f9f9f9;">
                        <img src="/assets/img/<?= htmlspecialchars($image) ?>" 
                             style="width: 100%; height: 100%; object-fit: cover;" 
                             alt="Produit">
                    </div>

                    <!-- INFOS -->
                    <div style="padding: 15px;">
                        <span style="font-size: 10px; color: #888;">Réf: <?= htmlspecialchars($cmd['reference']) ?></span>
                        <h2 style="font-size: 18px; margin: 5px 0;"><?= htmlspecialchars($cmd['titre']) ?></h2>
                        <p style="font-weight: bold; font-size: 20px; color: #000;"><?= number_format($cmd['montant'], 2, ',', ' ') ?> €</p>
                        
                        <p style="margin: 10px 0;">
                            <strong>Statut :</strong> 
                            <span style="color: <?= $isRecu ? 'green' : 'orange' ?>;">
                                <?= $isRecu ? 'Livré / Reçu' : 'En attente de réception' ?>
                            </span>
                        </p>

                        <!-- BOUTONS -->
                        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
                            <a href="/routeur.php?action=messages&contact_id=<?= $cmd['vendeur_id'] ?>" 
                               style="display: block; text-align: center; padding: 10px; background: #f0f0f0; color: #333; text-decoration: none; border-radius: 5px; font-size: 14px;">
                                Contacter le vendeur
                            </a>

                            <?php if (!$isRecu): ?>
                                <form action="/routeur.php?action=valider_reception" method="POST">
                                    <input type="hidden" name="vente_id" value="<?= $cmd['id'] ?>">
                                    <button type="submit" style="width: 100%; padding: 12px; background: #000; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                        Confirmer le colis reçu
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="/routeur.php?action=avis&vendeur_id=<?= $cmd['vendeur_id'] ?>&article_id=<?= $cmd['article_id'] ?>" 
                                   style="display: block; text-align: center; padding: 12px; background: #28a745; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold;">
                                    Laisser un avis
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>