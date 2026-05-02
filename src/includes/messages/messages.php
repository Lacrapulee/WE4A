<?php

require_once __DIR__ . '/../messages_functions.php';

// Traiter l'envoi d'un message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /routeur.php?action=connexion');
        exit;
    }

    $conversation_id = $_POST['conversation_id'] ?? '';
    $contenu = trim($_POST['contenu'] ?? '');

    if (empty($conversation_id) || empty($contenu)) {
        $_SESSION['error'] = 'Erreur: message vide ou conversation invalide';
        header('Location: /routeur.php?action=messages&id=' . $conversation_id);
        exit;
    }

    // Vérifier que l'utilisateur fait partie de cette conversation
    $stmt = $pdo->prepare("SELECT * FROM conversations WHERE id = ? AND (acheteur_id = ? OR vendeur_id = ?)");
    $stmt->execute([$conversation_id, $_SESSION['user_id'], $_SESSION['user_id']]);
    $conversation = $stmt->fetch();

    if (!$conversation) {
        $_SESSION['error'] = 'Erreur: accès non autorisé à cette conversation';
        header('Location: /routeur.php?action=messages');
        exit;
    }

    if (sendMessage($pdo, $conversation_id, $_SESSION['user_id'], $contenu)) {
        $_SESSION['success'] = 'Message envoyé';
    } else {
        $_SESSION['error'] = 'Erreur lors de l\'envoi du message';
    }

    header('Location: /routeur.php?action=messages&id=' . $conversation_id);
    exit;
}

// Créer une nouvelle conversation et envoyer le premier message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_vendeur'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /routeur.php?action=connexion');
        exit;
    }

    $article_id = (int)($_POST['article_id'] ?? 0);
    $contenu = trim($_POST['contenu'] ?? '');

    if (!$article_id || empty($contenu)) {
        $_SESSION['error'] = 'Erreur: article ou message invalide';
        header('Location: /routeur.php?action=item&id=' . $article_id);
        exit;
    }

    $stmt = $pdo->prepare("SELECT vendeur_id FROM articles WHERE id = ?");
    $stmt->execute([$article_id]);
    $article = $stmt->fetch();

    if (!$article) {
        $_SESSION['error'] = 'Article non trouvé';
        header('Location: /routeur.php?action=catalogue');
        exit;
    }

    $vendeur_id = $article['vendeur_id'];

    // Ne pas permettre au vendeur de se contacter lui-même
    if ($vendeur_id === $_SESSION['user_id']) {
        $_SESSION['error'] = 'Vous ne pouvez pas contacter votre propre article';
        header('Location: /routeur.php?action=item&id=' . $article_id);
        exit;
    }

    $conversation_id = getOrCreateConversation($pdo, $article_id, $_SESSION['user_id'], $vendeur_id);

    // Envoyer le premier message
    if (sendMessage($pdo, $conversation_id, $_SESSION['user_id'], $contenu)) {
        $_SESSION['success'] = 'Conversation créée et message envoyé';
        header('Location: /routeur.php?action=messages&id=' . $conversation_id);
    } else {
        $_SESSION['error'] = 'Erreur lors de la création de la conversation';
        header('Location: /routeur.php?action=item&id=' . $article_id);
    }
    exit;
}
?>
