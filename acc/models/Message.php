<?php
include_once('Connection.php');

class Message extends Connection {

    // Ajouter un nouveau message avec une image
    public function addMessage($contenu, $email, $image = null ,$username , $whatsapp) {
        $pdo = $this->connect();

        // Préparer le chemin pour l'image si elle est fournie
        $imagePath = null;
        if ($image !== null && isset($image['tmp_name']) && $image['tmp_name'] !== '') {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileMimeType = mime_content_type($image['tmp_name']);

            if (in_array($fileMimeType, $allowedMimeTypes)) {
                $filename = uniqid('message_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
                $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/acc/images/messages/' . $filename;

                if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                    $imagePath = '/acc/images/messages/' . $filename;
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                    return false;
                }
            } else {
                echo "Le fichier téléchargé n'est pas une image valide.";
                return false;
            }
        }

        // Préparation de la requête SQL pour insérer un nouveau message
        $query = "INSERT INTO message (contenu, email, image ,username,whatsapp) VALUES (:contenu, :email, :image,:username,:whatsapp)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':whatsapp', $whatsapp);


        try {
            // Exécution de la requête
            $stmt->execute();
            return true; // Message ajouté avec succès
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de l'ajout du message : " . $e->getMessage();
            return false; // Échec de l'ajout
        }
    }

    // Récupérer tous les messages
    public function getAllMessages() {
        $pdo = $this->connect();

        // Préparation de la requête SQL pour récupérer tous les messages
        $query = "SELECT * FROM message";
        $stmt = $pdo->query($query);

        try {
            // Exécution de la requête et récupération des résultats
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération des messages : " . $e->getMessage();
            return false; // Échec de la récupération
        }
    }

    // Supprimer un message spécifique par son ID
    public function deleteMessageById($id) {
        $pdo = $this->connect();

        // Préparer la requête pour récupérer le chemin de l'image avant de supprimer le message
        $queryGetImage = "SELECT image FROM message WHERE id = :id";
        $stmtGetImage = $pdo->prepare($queryGetImage);
        $stmtGetImage->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            $stmtGetImage->execute();
            $result = $stmtGetImage->fetch(PDO::FETCH_ASSOC);
            
            // Supprimer le message
            $queryDelete = "DELETE FROM message WHERE id = :id";
            $stmtDelete = $pdo->prepare($queryDelete);
            $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtDelete->execute();
            
            // Supprimer l'image associée si elle existe
            if ($result['image']) {
                $imagePath = $_SERVER['DOCUMENT_ROOT'] . $result['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            return true; // Message supprimé avec succès
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la suppression du message : " . $e->getMessage();
            return false; // Échec de la suppression
        }
    }

    public function getMessageById($id) {
        $pdo = $this->connect();
    
        // Préparer la requête SQL pour récupérer un message spécifique par son ID
        $query = "SELECT * FROM message WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        try {
            // Exécuter la requête
            $stmt->execute();
            
            // Récupérer le résultat
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Retourner les informations du message ou false si aucun message n'est trouvé
            return $result ?: false;
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération du message : " . $e->getMessage();
            return false;
        }
    }
    
}
?>
