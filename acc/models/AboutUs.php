<?php
include_once('Connection.php');

class AboutUs extends Connection {
    // Méthode pour mettre à jour le contenu dans la table 'aboutUs'
    public function updateContent($newContent) {
        try {
            // Connexion à la base de données
            $conn = $this->connect();
            
            // Préparation de la requête SQL pour mettre à jour le contenu
            $sql = "UPDATE aboutus SET content = ? WHERE id = 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $newContent, PDO::PARAM_STR);
            
            // Exécution de la requête
            if ($stmt->execute()) {
                return true; // Retourne true en cas de succès
            } else {
                throw new Exception("Erreur lors de la mise à jour : " . $stmt->errorInfo()[2]);
            }
        } catch (Exception $e) {
            // Affiche le message d'erreur et retourne false
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            // Fermeture de la connexion
            $stmt = null;
            $conn = null;
        }
    }

    // Méthode pour récupérer le contenu de la table 'aboutUs'
    public function getContent() {
        try {
            // Connexion à la base de données
            $conn = $this->connect();
            
            // Préparation de la requête SQL pour récupérer le contenu
            $sql = "SELECT content FROM aboutus WHERE id = 1";
            $stmt = $conn->query($sql);
            
            // Vérifie si les données sont trouvées
            if ($stmt->rowCount() > 0) {
                // Retourne les données sous forme de tableau associatif
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['content'];
            } else {
                throw new Exception("Aucune donnée trouvée pour id = 1");
            }
        } catch (Exception $e) {
            // Affiche le message d'erreur
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            // Fermeture de la connexion
            $stmt = null;
            $conn = null;
        }
    }
}
?>
