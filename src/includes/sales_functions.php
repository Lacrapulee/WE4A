<?php

function processDirectSale($pdo, $article, $buyerName, $buyerEmail) {
    $result = [
        'ok' => false,
        'reference' => null,
        'error' => null,
    ];

    $articleId = (string) ($article['id'] ?? '');
    $sellerId = (string) ($article['vendeur_id'] ?? '');
    $amount = (float) ($article['prix'] ?? 0);

    if ($articleId === '' || $sellerId === '') {
        $result['error'] = 'Article invalide pour la vente.';
        return $result;
    }

    $reference = 'CMD-' . strtoupper(bin2hex(random_bytes(4)));

    try {
        $pdo->beginTransaction();

        $update = $pdo->prepare("UPDATE articles SET statut = 'vendu' WHERE id = ? AND statut = 'en_ligne'");
        $update->execute([$articleId]);

        if ($update->rowCount() !== 1) {
            $pdo->rollBack();
            $result['error'] = 'Cet article vient d\'etre vendu.';
            return $result;
        }

        $insert = $pdo->prepare(
            "INSERT INTO ventes (reference, article_id, vendeur_id, acheteur_nom, acheteur_email, montant, statut_paiement)
             VALUES (?, ?, ?, ?, ?, ?, 'valide')"
        );
        $insert->execute([$reference, $articleId, $sellerId, $buyerName, $buyerEmail, $amount]);

        $pdo->commit();

        $result['ok'] = true;
        $result['reference'] = $reference;
        return $result;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        $result['error'] = 'Erreur technique pendant la validation du paiement.';
        return $result;
    }
}