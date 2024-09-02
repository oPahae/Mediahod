<?php
include_once('Connection.php');

class Produit extends Connection {

    public function addProduit($libelle, $prix, $description, $imageFile = null, $logoFile, $stock, $idSousCategorie, $link = null) {
        $pdo = $this->connect();
    
        // Vérifier et uploader le logo
        if ($logoFile && $this->isImage($logoFile)) {
            $logoPath = $this->uploadImage($logoFile, 'produits');
        } else {
            die("Error: The logo file is not a valid image.");
        }
    
        // Vérifier et uploader l'image, si fournie
        $imagePath = null; // Par défaut, pas d'image fournie
        if ($imageFile && isset($imageFile['tmp_name']) && is_uploaded_file($imageFile['tmp_name']) && $this->isImage($imageFile)) {
            $imagePath = $this->uploadImage($imageFile, 'produits');
        }
    
        // Préparer la requête SQL
        $query = "INSERT INTO produits (libelle, prix, description, image, logo, stock, idSousCategorie, link) 
                  VALUES (:libelle, :prix, :description, :image, :logo, :stock, :idSousCategorie, :link)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":libelle", $libelle);
        $stmt->bindParam(":prix", $prix);
        $stmt->bindParam(":description", $description);
    
        // Traiter le cas de l'image NULL
        if ($imagePath === null) {
            $stmt->bindValue(":image", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":image", $imagePath, PDO::PARAM_STR);
        }
    
        $stmt->bindValue(":logo", $logoPath, PDO::PARAM_STR);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":idSousCategorie", $idSousCategorie);
        $stmt->bindValue(":link", $link, PDO::PARAM_STR);
    
        try {
            $stmt->execute();
            return true; // Retourne vrai si l'insertion est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduitById($id) {
        $pdo = $this->connect();
    
        try {
            // Mettre la disponibilité du produit à 0 et supprimer la relation avec la sous-catégorie
            $queryUpdateProduit = "UPDATE produits SET disponibilite = 0, idSousCategorie = NULL WHERE id = :id";
            $stmtUpdateProduit = $pdo->prepare($queryUpdateProduit);
            $stmtUpdateProduit->bindParam(":id", $id);
            $stmtUpdateProduit->execute();
    
            return true; // Retourne vrai si la mise à jour est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    

    public function updateProduit($id, $libelle, $prix, $description, $imageFile = null, $logoFile = null, $stock, $idSousCategorie, $link = null) {
        $pdo = $this->connect();
    
        // Récupérer les anciens chemins des fichiers
        $oldProduit = $this->getProduitById($id);
        $oldImagePath = $oldProduit['image'] ?? null;
        $oldLogoPath = $oldProduit['logo'] ?? null;
    
        // Vérifier et uploader le logo
        if ($logoFile && $logoFile['error'] === UPLOAD_ERR_OK && $this->isImage($logoFile)) {
            $logoPath = $this->uploadImage($logoFile, 'produits');
        } else {
            // On garde l'ancien logo si aucun nouveau logo n'est fourni
            $logoPath = $oldLogoPath;
        }
    
        // Préparer la requête SQL
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK && $this->isImage($imageFile)) {
            $imagePath = $this->uploadImage($imageFile, 'produits');
            $query = "UPDATE produits SET libelle = :libelle, prix = :prix, description = :description, image = :image, logo = :logo, stock = :stock, idSousCategorie = :idSousCategorie, link = :link WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":image", $imagePath);
        } else {
            $imagePath = $oldImagePath;
            $query = "UPDATE produits SET libelle = :libelle, prix = :prix, description = :description, image = :image, logo = :logo, stock = :stock, idSousCategorie = :idSousCategorie, link = :link WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":image", $imagePath);
        }
    
        $stmt->bindParam(":libelle", $libelle);
        $stmt->bindParam(":prix", $prix);
        $stmt->bindParam(":description", $description);
        $stmt->bindValue(":logo", $logoPath, PDO::PARAM_STR);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":idSousCategorie", $idSousCategorie);
        $stmt->bindValue(":link", $link, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id);
    
        try {
            $stmt->execute();
            return true; // Retourne vrai si la mise à jour est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    
    

    // Récupérer tous les produits d'une sous-catégorie spécifique
    public function getProdBySousCat($idSousCategorie) {
        $pdo = $this->connect();
        $query = "
            SELECT p.id, p.libelle, p.prix, p.description, p.image, p.logo, p.stock, p.idSousCategorie, p.link, p.disponibilite , p.date , s.nom AS sousCategorieNom, c.nom AS categorieNom
            FROM produits p
            JOIN souscategories s ON p.idSousCategorie = s.id
            JOIN categories c ON s.idCategorie = c.id
            WHERE p.idSousCategorie = :idSousCategorie
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":idSousCategorie", $idSousCategorie);

        try {
            $stmt->execute();
            $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $produits;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Uploader une image et retourner le chemin
    private function uploadImage($file, $directory) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/acc/images/$directory/";
        $fileName = uniqid() . '-' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;

        echo "Target File: " . $targetFile . "<br>";

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return "/acc/images/$directory/" . $fileName;
        } else {
            die("Error: File upload failed.");
        }
    }

    // Vérifier si le fichier est une image
    private function isImage($file) {
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            die("Error: File is not uploaded correctly.");
        }

        $fileTmpPath = $file['tmp_name'];
        $mimeType = mime_content_type($fileTmpPath);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        echo "File MIME Type: " . $mimeType . "<br>";

        return in_array($mimeType, $allowedTypes) && getimagesize($fileTmpPath) !== false;
    }

    // Supprimer un fichier du serveur
    private function deleteFile($filePath) {
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $filePath;
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function getProduitById($id) {
        $pdo = $this->connect();
        $query = "SELECT p.*, s.nom AS sousCategorieNom, c.nom AS categorieNom
                  FROM produits p
                  LEFT JOIN souscategories s ON p.idSousCategorie = s.id
                  LEFT JOIN categories c ON s.idCategorie = c.id
                  WHERE p.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    

    public function getSousCategoriesWithProducts($idCategorie) {
        $pdo = $this->connect();
        
        // Préparer la requête SQL pour récupérer les sous-catégories avec leurs produits
        $query = "
            SELECT 
                sc.id AS sousCategorieId,
                sc.nom AS sousCategorieNom,
                p.id AS produitId,
                p.libelle AS produitLabel,
                p.prix AS produitPrice,
                p.stock AS produitStock,
                p.description AS produitDescription,
                p.image AS produitImage,
                p.logo AS produitLogo,
                p.date AS produitDate,
                p.link AS produitLink ,
                p.disponibilite AS produitDisp
            FROM souscategories sc
            LEFT JOIN produits p ON sc.id = p.idSousCategorie
            WHERE sc.idCategorie = :idCategorie
            ORDER BY sc.nom, p.libelle
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
        
        try {
            // Exécuter la requête
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Organiser les résultats en sous-catégories avec leurs produits
            $sousCategories = [];
            foreach ($results as $row) {
                $sousCategorieId = $row['sousCategorieId'];
                
                // Initialiser la sous-catégorie si elle n'existe pas encore dans le tableau
                if (!isset($sousCategories[$sousCategorieId])) {
                    $sousCategories[$sousCategorieId] = [
                        'id' => $sousCategorieId,
                        'nom' => $row['sousCategorieNom'],
                        'produits' => []
                    ];
                }
                
                // Ajouter le produit à la sous-catégorie
                if ($row['produitId'] !== null) {
                    $sousCategories[$sousCategorieId]['produits'][] = [
                        'id' => $row['produitId'],
                        'label' => $row['produitLabel'],
                        'price' => $row['produitPrice'],
                        'stock' => $row['produitStock'],
                        'description' => $row['produitDescription'],
                        'image' => $row['produitImage'],
                        'logo' => $row['produitLogo'],
                        'date' => $row['produitDate'],
                        'link' => $row['produitLink'] ,
                        'dispo' => $row['produitDisp']
                    ];
                }
            }
            
            return $sousCategories;
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération des sous-catégories et des produits : " . $e->getMessage();
            return false; // Retourne faux en cas d'échec
        }
    }
    
    
}
?>
