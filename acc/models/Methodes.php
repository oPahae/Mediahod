<?php
require_once 'Connection.php';

class Methodes extends Connection {
    
    // Méthode pour ajouter une nouvelle méthode
    public function addMethod($adresse, $note, $network) {
        $pdo = $this->connect();
        $query = "INSERT INTO methodes (adresse, Note, Network) VALUES (:adresse, :note, :network)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':network', $network);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la méthode : " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour supprimer une méthode par ID
    public function deleteMethod($id) {
        $pdo = $this->connect();
        $query = "DELETE FROM methodes WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la méthode : " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour mettre à jour une méthode par ID
    public function updateMethod($id, $adresse, $note, $network) {
        $pdo = $this->connect();
        $query = "UPDATE methodes SET adresse = :adresse, Note = :note, Network = :network WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':network', $network);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour de la méthode : " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour récupérer toutes les méthodes
    public function getAllMethods() {
        $pdo = $this->connect();
        $query = "SELECT * FROM methodes";
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des méthodes : " . $e->getMessage();
            return [];
        }
    }

    public function getMethodById($id) {
        $pdo = $this->connect();
        $query = "SELECT * FROM methodes WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne un tableau associatif avec les détails de la méthode
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la méthode : " . $e->getMessage();
            return false;
        }
    }
    
}
