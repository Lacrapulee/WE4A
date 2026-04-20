<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['ma_super_image'])) {
    
    $dossierCible = "../assets/img/";
    $infosFichier = pathinfo($_FILES["ma_super_image"]["name"]);
    $extension = strtolower($infosFichier['extension']);
    
    // 1. Sécurité Extensions
    $autorise = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (in_array($extension, $autorise)) {
        // 2. Sécurité : Vérification du vrai type d'image
        if (getimagesize($_FILES["ma_super_image"]["tmp_name"])) {
            
            // 3. Nouveau nom unique
            $nomSecurise = bin2hex(random_bytes(8)) . "." . $extension;
            $cheminFinal = $dossierCible . $nomSecurise;

            if (move_uploaded_file($_FILES["ma_super_image"]["tmp_name"], $cheminFinal)) {
                
                // C'est ICI que tu appelles ta fonction DB
                // include_once 'includes/db_functions.php';
                // ajouterImageDansDb($nomSecurise);
                
                echo "Succès ! Image enregistrée sous : " . $nomSecurise;
            }
        }
    } else {
        echo "Format non autorisé.";
    }
}
?>

<form action="/post/index.php" method="post" enctype="multipart/form-data">
    <input type="file" name="ma_super_image">
    <button type="submit">Envoyer</button>
</form>