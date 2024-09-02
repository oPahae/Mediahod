<?php
include_once('Connection.php');

class Admin extends Connection {

    public function authenticate($login, $password) {
        $pdo = $this->connect();
    
        // Préparation de la requête SQL pour récupérer les informations de l'administrateur
        $query = "SELECT login, password FROM admin WHERE id = 1";
        $stmt = $pdo->prepare($query);
    
        try {
            // Exécution de la requête
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Vérifier si le login et le mot de passe sont corrects
            if ($result) {
                // Vérifier le login
                if ($login === $result['login']) {
                    // Vérifier le mot de passe
                    if (password_verify($password, $result['password'])) {
                        return true; // Authentification réussie
                    } else {
                        return false; // Mot de passe incorrect
                    }
                } else {
                    return false; // Login incorrect
                }
            } else {
                return false; // Aucun résultat trouvé
            }
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de l'authentification : " . $e->getMessage();
            return false; // Échec de l'authentification
        }
    }
    

    // Modifier les informations de l'administrateur
    public function updateAdmin($newLogin, $newPassword, $newEmail) {
        $pdo = $this->connect();

        // Hashage du nouveau mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Préparation de la requête SQL pour mettre à jour les informations de l'administrateur
        $query = "UPDATE admin SET login = :newLogin, password = :newPassword, email = :newEmail WHERE id = 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':newLogin', $newLogin);
        $stmt->bindParam(':newPassword', $hashedPassword);
        $stmt->bindParam(':newEmail', $newEmail);

        try {
            // Exécution de la requête
            $stmt->execute();
            return true; // Mise à jour réussie
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la mise à jour des informations : " . $e->getMessage();
            return false; // Échec de la mise à jour
        }
    }

    public function changePassword($newPassword, $newLogin) {
        $pdo = $this->connect();
    
        // Hashage du nouveau mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
        // Préparation de la requête SQL pour mettre à jour le mot de passe et le login
        $query = "UPDATE admin SET password = :newPassword, login = :newLogin WHERE id = 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':newPassword', $hashedPassword);
        $stmt->bindParam(':newLogin', $newLogin);
    
        try {
            // Exécution de la requête
            $stmt->execute();
            return true; // Mise à jour réussie
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors du changement du mot de passe : " . $e->getMessage();
            return false; // Échec du changement
        }
    }
    

    // Récupérer l'email de l'administrateur
    public function getEmail() {
        $pdo = $this->connect();

        // Préparation de la requête SQL pour récupérer l'email de l'administrateur
        $query = "SELECT email FROM admin WHERE id = 1";
        $stmt = $pdo->prepare($query);

        try {
            // Exécution de la requête
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier si un email a été trouvé
            if ($result) {
                return $result['email']; // Retourner l'email
            } else {
                return null; // Aucun administrateur trouvé
            }
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération de l'email : " . $e->getMessage();
            return null; // Échec de la récupération
        }
    }

    public function updateAdminSettings($currentPass, $newUsername = null, $newPassword = null, $newEmail = null) {
        $pdo = $this->connect();
    
        try {
            // Vérifier si le mot de passe actuel est correct
            $query1 = "SELECT password FROM admin WHERE id = 1";
            $stmt = $pdo->prepare($query1);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Vérifier si le mot de passe actuel est correct
            if (password_verify($currentPass, $result['password'])) {
                // Mettre à jour le nom d'utilisateur si fourni
                if (!empty($newUsername)) {
                    $query2 = "UPDATE Admin SET login = :newUsername WHERE id = 1";
                    $stmt = $pdo->prepare($query2);
                    $stmt->bindParam(':newUsername', $newUsername);
                    $stmt->execute();
                }
    
                // Mettre à jour le mot de passe si fourni
                if (!empty($newPassword)) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // Hash le nouveau mot de passe
                    $query3 = "UPDATE admin SET password = :newPassword WHERE id = 1";
                    $stmt = $pdo->prepare($query3);
                    $stmt->bindParam(':newPassword', $hashedPassword);
                    $stmt->execute();
                }
    
                // Mettre à jour l'email si fourni
                if (!empty($newEmail)) {
                    $query4 = "UPDATE admin SET email = :newEmail WHERE id = 1";
                    $stmt = $pdo->prepare($query4);
                    $stmt->bindParam(':newEmail', $newEmail);
                    $stmt->execute();
                }
    
                return true; // Retourne vrai si toutes les mises à jour sont réussies
            } else {
                return false; // Mot de passe actuel incorrect
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getAdminInfo() {
        $pdo = $this->connect();
    
        try {
            // Préparer la requête SQL pour obtenir les informations de l'administrateur
            $query = "SELECT login, email FROM admin WHERE id = 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
    
            // Récupérer les résultats
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result; // Retourner les informations de l'administrateur
            } else {
                return false; // Aucun résultat trouvé
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    
    
    
}



?>
