<?php
session_start();
include '../../includes/tools.php';
include '../../includes/db.php';

$searchQuery = $_GET['search'] ?? '';
$results = [];

if ($searchQuery !== '') {
    $results = getAnnonceRecherche($pdo, $searchQuery);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include '../../templates/header.php'; ?>
    
    <main class="catalogue-container">
        <section class="search-section">
            <h1>Catalogue</h1>
        </section>

        <section class="results-section">
            <?php if ($searchQuery !== ''): ?>
                <?php if (!empty($results)): ?>
                    <div class="results-list">
                        <?php foreach ($results as $item): ?>
                            <div class="result-item">
                                <h3><?php echo htmlspecialchars($item['titre']); ?></h3>
                                <p><?php echo htmlspecialchars($item['description']); ?></p>
                                <p class="price"><?php echo htmlspecialchars($item['prix']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-results">Aucun résultat pour "<?php echo htmlspecialchars($searchQuery); ?>"</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="info-message">Utilisez la barre de recherche pour trouver des articles</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include '../../templates/footer.php'; ?>
</body>
</html>