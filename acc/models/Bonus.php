<?php
include_once('Connection.php');

class Bonus extends Connection {

    // Méthode pour mettre à jour la description dans la table 'Bonus'
    public function updateBonus($description) {
        try {
            // Connexion à la base de données
            $conn = $this->connect();
            
            // Préparation de la requête SQL
            $sql = "UPDATE bonus 
                    SET 
                        description = :description 
                    WHERE id = 1";
            
            // Préparation de la requête avec les paramètres
            $stmt = $conn->prepare($sql);
            
            // Liaison des paramètres
            $stmt->bindParam(':description', $description);
            
            // Exécution de la requête
            if ($stmt->execute()) {
                return true; // Retourne true en cas de succès
            } else {
                throw new Exception("Erreur lors de la mise à jour.");
            }
            
        } catch (Exception $e) {
            // Affiche le message d'erreur et retourne false
            echo $e->getMessage();
            return false;
        }
    }

    // Méthode pour récupérer la description de la table 'Bonus'
    public function getBonus() {
        try {
            // Connexion à la base de données
            $conn = $this->connect();
            
            // Préparation de la requête SQL pour récupérer la description
            $sql = "SELECT description FROM bonus WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            // Récupération des données
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Vérifie si la description est trouvée
            if ($result) {
                return $result['description'];
            } else {
                throw new Exception("Aucune donnée trouvée pour id = 1");
            }
        } catch (Exception $e) {
            // Affiche le message d'erreur et retourne false
            echo $e->getMessage();
            return false;
        }
    }
}
