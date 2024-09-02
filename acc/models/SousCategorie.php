<?php
include_once('Connection.php');

class SousCategorie extends Connection {

    // Ajouter une sous-catégorie
    public function addSousCategorie($nom, $idCategorie) {
        $pdo = $this->connect();
        $query = "INSERT INTO souscategories (nom, idCategorie) VALUES (:nom, :idCategorie)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":idCategorie", $idCategorie);

        try {
            $stmt->execute();
            return true; // Retourne vrai si l'insertion est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Supprimer une sous-catégorie (mettre à jour les produits et supprimer la sous-catégorie)
    public function deleteSousCategorieById($id) {
        $pdo = $this->connect();
        
        try {
            // Mettre la disponibilité de tous les produits à 0 et mettre idSousCategorie à NULL
            $queryUpdateProduit = "UPDATE produits SET disponibilite = 0, idSousCategorie = NULL WHERE idSousCategorie = :id";
            $stmtUpdateProduit = $pdo->prepare($queryUpdateProduit);
            $stmtUpdateProduit->bindParam(":id", $id);
            $stmtUpdateProduit->execute();
    
            // Supprimer la sous-catégorie
            $queryDeleteSousCateg = "DELETE FROM souscategories WHERE id = :id";
            $stmtDeleteSousCateg = $pdo->prepare($queryDeleteSousCateg);
            $stmtDeleteSousCateg->bindParam(":id", $id);
            $stmtDeleteSousCateg->execute();
    
            return true; // Retourne vrai si la suppression est réussie
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage()); // Enregistre l'erreur dans le journal des erreurs
            return false;
        }
    }
    
    // Modifier une sous-catégorie
    public function updateSousCategorieById($id, $nom, $idCategorie) {
        $pdo = $this->connect();
        $query = "UPDATE souscategories SET nom = :nom, idCategorie = :idCategorie WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":idCategorie", $idCategorie);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            return true; // Retourne vrai si la mise à jour est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }


    public function getAllSousCategories() {
        $pdo = $this->connect();
        $query = "
            SELECT 
                sc.id, 
                sc.nom AS sousCategorieNom, 
                c.nom AS categorieNom,
                sc.idCategorie
            FROM 
                souscategories sc
            INNER JOIN 
                categories c ON sc.idCategorie = c.id
        ";
        $stmt = $pdo->prepare($query);
    
        try {
            $stmt->execute();
            $sousCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $sousCategories;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    public function getSousCategoriesByCategorieId($idCategorie) {
        $pdo = $this->connect();
        $query = "
            SELECT id, nom
            FROM souscategories
            WHERE idCategorie = :idCategorie
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":idCategorie", $idCategorie);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getSubCategoryById($id) {
        $pdo = $this->connect();
        $query = "
            SELECT 
                sc.id, 
                sc.nom AS sousCategorieNom, 
                c.nom AS categorieNom,
                sc.idCategorie
            FROM 
                souscategories sc
            INNER JOIN 
                categories c ON sc.idCategorie = c.id
            WHERE 
                sc.id = :id
        ";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
    
        try {
            $stmt->execute();
            $subCategory = $stmt->fetch(PDO::FETCH_ASSOC);
            return $subCategory;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    
    }
    
    

?>
