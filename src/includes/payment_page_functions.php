<?php

require_once __DIR__ . '/sales_functions.php';

function buildPaymentPageViewData($pdo, $articleId, $requestMethod, $postData) {
    $viewData = [
        'statusCode' => 200,
        'title' => 'Paiement',
        'errorMessage' => null,
        'successMessage' => null,
        'orderReference' => null,
        'product' => null,
        'imageName' => 'default.png',
        'priceLabel' => null,
        'buyerName' => '',
        'buyerEmail' => '',
    ];

    if (!$articleId) {
        $viewData['statusCode'] = 400;
        $viewData['errorMessage'] = 'Aucun article selectionne pour le paiement.';
        return $viewData;
    }

    $product = getAnnonceById($pdo, $articleId);
    if (!$product || ($product['statut'] ?? '') !== 'en_ligne') {
        $viewData['statusCode'] = 404;
        $viewData['errorMessage'] = 'Article indisponible.';
        return $viewData;
    }

    $viewData['product'] = $product;
    $viewData['title'] = 'Paiement - ' . $product['titre'];
    $viewData['imageName'] = getImageByAnnonceId($pdo, $product['id']) ?: 'default.png';
    $viewData['priceLabel'] = number_format((float) $product['prix'], 2, ',', ' ') . ' EUR';

    if ($requestMethod !== 'POST' || !isset($postData['confirm_payment'])) {
        return $viewData;
    }

    $buyerName = trim((string) ($postData['buyer_name'] ?? ''));
    $buyerEmail = trim((string) ($postData['buyer_email'] ?? ''));

    $viewData['buyerName'] = $buyerName;
    $viewData['buyerEmail'] = $buyerEmail;

    if ($buyerName === '' || $buyerEmail === '') {
        $viewData['statusCode'] = 422;
        $viewData['errorMessage'] = 'Merci de remplir ton nom et ton email pour valider le paiement.';
        return $viewData;
    }

    if (!filter_var($buyerEmail, FILTER_VALIDATE_EMAIL)) {
        $viewData['statusCode'] = 422;
        $viewData['errorMessage'] = 'Adresse email invalide.';
        return $viewData;
    }

    $saleResult = processDirectSale($pdo, $product, $buyerName, $buyerEmail);
    if (!$saleResult['ok']) {
        $viewData['statusCode'] = 409;
        $viewData['errorMessage'] = $saleResult['error'];
        return $viewData;
    }

    $viewData['orderReference'] = $saleResult['reference'];
    $viewData['successMessage'] = 'Paiement valide. Ta commande est confirmee.';

    return $viewData;
}