<?php
include_once('Connection.php');

class Categorie extends Connection {

    // Ajouter une catégorie avec une image
    public function addCategorie($nom, $imageFile) {
        $pdo = $this->connect();

        if (isset($imageFile) && $this->isImage($imageFile)) {
            echo "Image is valid.<br>";
            $imagePath = $this->uploadImage($imageFile);
        } else {
            die("Error: The file is not a valid image or no file uploaded.");
        }

        $query = "INSERT INTO categories (nom, image) VALUES (:nom, :image)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":image", $imagePath);

        try {
            $stmt->execute();
            return true; // Retourne vrai si l'insertion est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }


    public function deleteCategorieById($id) {
        $pdo = $this->connect();
        
        try {
            // Mettre la disponibilité de tous les produits à 0 et mettre idSousCategorie à NULL
            $queryUpdateProduit = "UPDATE produits SET disponibilite = 0, idSousCategorie = NULL WHERE idSousCategorie IN (SELECT id FROM souscategories WHERE idCategorie = :id)";
            $stmtUpdateProduit = $pdo->prepare($queryUpdateProduit);
            $stmtUpdateProduit->bindParam(":id", $id);
            $stmtUpdateProduit->execute();
    
            // Supprimer les sous-catégories associées à la catégorie
            $queryDeleteSousCateg = "DELETE FROM souscategories WHERE idCategorie = :id";
            $stmtDeleteSousCateg = $pdo->prepare($queryDeleteSousCateg);
            $stmtDeleteSousCateg->bindParam(":id", $id);
            $stmtDeleteSousCateg->execute();
    
            // Supprimer la catégorie
            $queryDeleteCategorie = "DELETE FROM categories WHERE id = :id";
            $stmtDeleteCategorie = $pdo->prepare($queryDeleteCategorie);
            $stmtDeleteCategorie->bindParam(":id", $id);
            $stmtDeleteCategorie->execute();
    
            return true; // Retourne vrai si la suppression est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    

    public function updateCategorieById($id, $nom, $imageFile = null) {
        $pdo = $this->connect();
    
        try {
            // Commencer la transaction
            $pdo->beginTransaction();
    
            // Préparer la requête pour obtenir l'ancienne image
            $querySelectImage = "SELECT image FROM categories WHERE id = :id";
            $stmtSelectImage = $pdo->prepare($querySelectImage);
            $stmtSelectImage->bindParam(':id', $id);
            $stmtSelectImage->execute();
            $result = $stmtSelectImage->fetch(PDO::FETCH_ASSOC);
    
            // Gérer l'ancienne image
            if ($result) {
                $oldImagePath = $result['image'];
            } else {
                throw new Exception('Category not found.');
            }
    
            // Préparer la requête de mise à jour du nom
            $query = 'UPDATE Categories SET nom = :nom';
            $params = ['nom' => $nom];
    
            // Gestion de l'image
            if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
                // Vérifie le type de fichier et la taille
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imageFile['type'], $allowedTypes)) {
                    throw new Exception('Invalid image type. Only JPG, PNG, and GIF are allowed.');
                }
    
                $maxSize = 10 * 1024 * 1024; // 10MB
                if ($imageFile['size'] > $maxSize) {
                    throw new Exception('Image size exceeds the maximum limit of 2MB.');
                }
    
                // Déplacer le fichier image
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/acc/images/categories/';
                $newImageName = uniqid() . '-' . basename($imageFile['name']); // Renommage pour éviter les conflits
                $newImagePath = $uploadDir . $newImageName;
    
                if (!move_uploaded_file($imageFile['tmp_name'], $newImagePath)) {
                    throw new Exception('Failed to upload the image.');
                }
    
                // Ajouter le chemin de la nouvelle image à la requête de mise à jour
                $query .= ', image = :image';
                $params['image'] = '/acc/images/categories/' . $newImageName; // Chemin relatif
            }
    
            $query .= ' WHERE id = :id';
            $params['id'] = $id;
    
            // Préparer et exécuter la requête
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
    
            // Supprimer l'ancienne image du serveur
            if (isset($oldImagePath) && file_exists($_SERVER['DOCUMENT_ROOT'] . $oldImagePath)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $oldImagePath);
            }
    
            // Valider la transaction
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $pdo->rollBack();
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    
    
    

    // Uploader l'image et retourner le chemin de l'image
    private function uploadImage($file) {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/acc/images/categories/";
        $fileName = uniqid() . '-' . basename($file["name"]);
        $targetFile = $targetDir . $fileName;

        echo "Target File: " . $targetFile . "<br>";

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return "/acc/images/categories/" . $fileName;
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


    public function getAllCategories() {
        $pdo = $this->connect();
        $query = "SELECT id, nom, image FROM categories";
        $stmt = $pdo->prepare($query);
    
        try {
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $categories;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    
// Récupérer une catégorie par son ID
public function getCategoryById($idCategorie) {
    $pdo = $this->connect();
    $query = "
        SELECT id, nom, image
        FROM categories
        WHERE id = :idCategorie
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":idCategorie", $idCategorie);

    try {
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
        return false;
    }
}
}

?>
