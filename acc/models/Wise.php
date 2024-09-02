<?php
include_once('Connection.php');

class Wise extends Connection {

    // Méthode pour mettre à jour les informations dans la table 'wise'
    public function updateWise($currency, $email, $holderName, $bankName, $bankCode, $accountNumber, $address, $city, $zipcode) {
        try {
            // Connexion à la base de données
            $conn = $this->connect();
            
            // Préparation de la requête SQL
            $sql = "UPDATE wise 
                    SET 
                        currency = :currency, 
                        email = :email, 
                        holder_name = :holderName, 
                        bank_name = :bankName, 
                        bank_code = :bankCode, 
                        account_number = :accountNumber, 
                        address = :address, 
                        city = :city, 
                        zipcode = :zipcode 
                    WHERE id = 1";
            
            // Préparation de la requête avec les paramètres
            $stmt = $conn->prepare($sql);
            
            // Liaison des paramètres
            $stmt->bindParam(':currency', $currency);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':holderName', $holderName);
            $stmt->bindParam(':bankName', $bankName);
            $stmt->bindParam(':bankCode', $bankCode);
            $stmt->bindParam(':accountNumber', $accountNumber);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':zipcode', $zipcode);
            
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

    // Méthode pour récupérer et afficher toutes les données de la table 'wise'
    public function getWiseData() {
        try {
            // Connexion à la base de données
            $conn = $this->connect();
            
            // Préparation de la requête SQL pour récupérer les données
            $sql = "SELECT * FROM wise WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            // Récupération des données
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Vérifie si les données sont trouvées
            if ($result) {
                return $result;
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
