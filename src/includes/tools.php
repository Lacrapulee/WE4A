<?php


function addItem($pdo, $vendeur_id, $categorie_id, $titre, $description, $prix, $coordonnees, $ville_nom, $code_postal) {
    // On sépare la chaîne "47.639,6.853" en deux variables
    list($lat, $long) = explode(',', $coordonnees);

    // On prépare la requête avec la fonction ST_PointFromText
    // Note : On utilise POINT($long $lat) sans virgule entre les deux à l'intérieur du point
    $sql = "INSERT INTO articles (vendeur_id, categorie_id, titre, description, prix, statut, coordonnees, ville_nom, code_postal) 
            VALUES (?, ?, ?, ?, ?, 'en_ligne', ST_PointFromText(?), ?, ?)";
            
    $point = "POINT($long $lat)"; // Format WKT : Longitude Latitude

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $vendeur_id, 
        $categorie_id, 
        $titre, 
        $description, 
        $prix, 
        $point, // On envoie le point formaté
        $ville_nom, 
        $code_postal
    ]);
    
    return $pdo->lastInsertId();
}

function addImage($pdo, $article_id, $nom_image) {
    $stmt = $pdo->prepare("INSERT INTO article_images (article_id, url_image, est_principale, ordre) VALUES (?, ?, ?)");
    return $stmt->execute([$article_id, $nom_image]);
}

function getCoordinates($adresse, $ville, $cp) {
    $query = urlencode($adresse . " " . $cp . " " . $ville);
    $url = "https://api-adresse.data.gouv.fr/search/?q=$query&limit=1";
    
    $response = @file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        if (!empty($data['features'])) {
            // L'API renvoie [Longitude, Latitude]
            $coords = $data['features'][0]['geometry']['coordinates'];
            return $coords[1] . ',' . $coords[0]; // On stocke "Lat,Long"
        }
    }
    return null; // Retourne null si rien n'est trouvé
}
