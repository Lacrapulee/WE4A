
<?php
//Include the header 
include '../../templates/header.php';

// Get product ID from query string
$productId = $_GET['id'] ?? null;
if (!$productId) {
    echo "Erreur: ID du produit manquant.";
    exit;
}

require_once '../../includes/db.php';
require_once "../../includes/articles_functions.php";

$product = getAnnonceById($pdo,$productId);

$nom_image = getImageByAnnonceId($pdo, $productId);
$dossier = "../assets/img/";

if (!$product) {
    echo "Erreur: Produit non trouvé.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['titre']); ?></title>
    <style>
        .product-menu { padding: 20px; max-width: 600px; margin: 20px auto; }
        .product-menu h1 { color: #333; }
        .product-info { background: #f5f5f5; padding: 15px; border-radius: 5px; }
        .product-info p { margin: 10px 0; }
        .price { font-size: 1.5em; color: #007bff; font-weight: bold; }
    </style>
</head>
<body>
    <div class="product-menu">
        <h1><?php echo htmlspecialchars($product['titre']); ?></h1>
        <div class="product-info">
            <img src="<?php echo $dossier . $nom_image; ?>" alt="Mon Image"> 
            <p><strong>ID:</strong> <?php echo htmlspecialchars($product['id']); ?></p>
            <p><strong>Prix:</strong> <span class="price"><?php echo htmlspecialchars($product['prix']); ?>€</span></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
        </div>
    </div>
</body>
</html>