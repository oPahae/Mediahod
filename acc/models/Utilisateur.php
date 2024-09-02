<?php
include_once('Connection.php');

class Utilisateur extends Connection {

    // Ajouter un utilisateur
    public function addUtilisateur($username, $email, $password, $telephone) {
        $pdo = $this->connect();
        $query = "INSERT INTO utilisateurs (username, email, password, telephone) VALUES (:username, :email, :password, :telephone)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password); // Le mot de passe sera hashé avant l'insertion
        $stmt->bindParam(":telephone", $telephone);

        try {
            // Hacher le mot de passe avant de l'enregistrer
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->execute();
            return true; // Retourne vrai si l'insertion est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Supprimer un utilisateur et toutes ses commandes et détails de commandes
    // public function deleteUtilisateurById($id) {
    //     $pdo = $this->connect();
        
    //     try {
    //         // Supprimer les détails de commandes associés à cet utilisateur
    //         $queryDeleteLigneCommande = "DELETE FROM LigneCommande WHERE idCom IN (SELECT idCom FROM Commandes WHERE idUtilisateur = :id)";
    //         $stmtDeleteLigneCommande = $pdo->prepare($queryDeleteLigneCommande);
    //         $stmtDeleteLigneCommande->bindParam(":id", $id);
    //         $stmtDeleteLigneCommande->execute();
            
    //         // Supprimer les commandes associées à cet utilisateur
    //         $queryDeleteCommande = "DELETE FROM Commandes WHERE idUtilisateur = :id";
    //         $stmtDeleteCommande = $pdo->prepare($queryDeleteCommande);
    //         $stmtDeleteCommande->bindParam(":id", $id);
    //         $stmtDeleteCommande->execute();
            
    //         // Supprimer l'utilisateur
    //         $queryDeleteUtilisateur = "DELETE FROM Utilisateurs WHERE id = :id";
    //         $stmtDeleteUtilisateur = $pdo->prepare($queryDeleteUtilisateur);
    //         $stmtDeleteUtilisateur->bindParam(":id", $id);
    //         $stmtDeleteUtilisateur->execute();

    //         return true; // Retourne vrai si la suppression est réussie
    //     } catch (PDOException $e) {
    //         die("Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

    // Modifier un utilisateur
    public function updateUtilisateurById($id, $username, $email, $password = null, $telephone = null) {
        $pdo = $this->connect();
        $query = "UPDATE utilisateurs SET username = :username, email = :email";
        
        // Ajouter les paramètres de mise à jour si le mot de passe ou le téléphone est fourni
        if ($password !== null) {
            $query .= ", password = :password";
        }
        if ($telephone !== null) {
            $query .= ", telephone = :telephone";
        }
        
        $query .= " WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        
        if ($password !== null) {
            // Hacher le mot de passe avant de l'enregistrer
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $hashedPassword);
        }
        
        if ($telephone !== null) {
            $stmt->bindParam(":telephone", $telephone);
        }
        
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            return true; // Retourne vrai si la mise à jour est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Authentifier un utilisateur
    public function authenticateUtilisateur($email, $password) {
        $pdo = $this->connect();
        $query = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        
        try {
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Authentification réussie
                return $user;
            } else {
                // Authentification échouée
                return false;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    public function changePassword($email, $newPassword) {
        // Connexion à la base de données
        $pdo = $this->connect();
    
        // Hashage du nouveau mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
        // Préparation de la requête SQL pour mettre à jour le mot de passe
        $query = "UPDATE utilisateurs SET password = :password WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
    
        try {
            // Exécution de la requête
            $stmt->execute();
            return true; // Mot de passe mis à jour avec succès
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la mise à jour du mot de passe : " . $e->getMessage();
            return false; // Échec de la mise à jour
        }
    }

    public function emailExists($email) {
        $pdo = $this->connect();
        $query = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        
        try {
            $stmt->execute();
            return $stmt->fetchColumn() > 0; // Retourne vrai si l'email existe, sinon faux
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($id, $email = null, $password = null, $username = null, $telephone = null, $profile = null) {
        $pdo = $this->connect();
    
        // Vérifier si le nouvel email existe déjà (si un email est fourni)
        if ($email !== null) {
            $queryCheckEmail = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email AND id != :id";
            $stmtCheckEmail = $pdo->prepare($queryCheckEmail);
            $stmtCheckEmail->bindParam(':email', $email);
            $stmtCheckEmail->bindParam(':id', $id);
            
            try {
                $stmtCheckEmail->execute();
                if ($stmtCheckEmail->fetchColumn() > 0) {
                    $_SESSION['MessageE'] = "L'email est déjà utilisé.";
                    return false; // Retourne faux si l'email est déjà utilisé
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
                return false;
            }
        }
    
        // Préparer les requêtes SQL
        $query = "UPDATE utilisateurs SET";
        $params = [];
        
        // Ajouter les champs à mettre à jour si ils ne sont pas null
        if ($email !== null) {
            $query .= " email = :email,";
            $params[':email'] = $email;
            $_SESSION['user']['email'] = $email; // Mise à jour de la session
        }
        if ($username !== null) {
            $query .= " username = :username,";
            $params[':username'] = $username;
            $_SESSION['user']['username'] = $username; // Mise à jour de la session
        }
        if ($telephone !== null) {
            $query .= " telephone = :telephone,";
            $params[':telephone'] = $telephone;
            $_SESSION['user']['telephone'] = $telephone; // Mise à jour de la session
        }
        if ($password !== null) {
            $query .= " password = :password,";
            $params[':password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        if ($profile !== null && isset($profile['tmp_name']) && $profile['tmp_name'] !== '') {
            // Vérifier que le fichier est une image
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileMimeType = mime_content_type($profile['tmp_name']);
    
            if (in_array($fileMimeType, $allowedMimeTypes)) {
                $filename = uniqid('profile_', true) . '.' . pathinfo($profile['name'], PATHINFO_EXTENSION);
                $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/acc/images/profiles/' . $filename;
                
                if (move_uploaded_file($profile['tmp_name'], $targetPath)) {
                    $query .= " profile = :profile,";
                    $params[':profile'] = '/acc/images/profiles/' . $filename;
                    $_SESSION['user']['profile'] = $params[':profile']; // Mise à jour de la session
                } else {
                    $_SESSION['MessageE'] = "Erreur lors du téléchargement de l'image.";
                    return false;
                }
            } else {
                $_SESSION['MessageE'] = "Le fichier téléchargé n'est pas une image valide.";
                return false;
            }
        }
    
        // Supprimer la virgule finale et ajouter la condition WHERE
        $query = rtrim($query, ',') . " WHERE id = :id";
        $params[':id'] = $id;
    
        $stmt = $pdo->prepare($query);
    
        try {
            // Lier les paramètres et exécuter la requête
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->execute();
            return true; // Retourne vrai si la mise à jour est réussie
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }
    
    
    public function updateWallet($id, $newWalletValue) {
        $pdo = $this->connect();
    
        try {
            // Vérifier si l'utilisateur avec cet ID existe
            $queryCheckId = "SELECT COUNT(*) FROM utilisateurs WHERE id = :id";
            $stmtCheckId = $pdo->prepare($queryCheckId);
            $stmtCheckId->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtCheckId->execute();
    
            // Si l'utilisateur n'existe pas, retourner false
            if ($stmtCheckId->fetchColumn() == 0) {
                return false;
            }
    
            // Si l'utilisateur existe, préparer la requête SQL pour mettre à jour la colonne wallet
            $query = "UPDATE utilisateurs SET wallet = wallet + :wallet WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':wallet', $newWalletValue);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Exécuter la requête
            $stmt->execute();
            return true; // Retourne vrai si la mise à jour est réussie
    
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la mise à jour du wallet : " . $e->getMessage();
            return false; // Retourne faux en cas d'échec
        }
    }
    
    
    public function getUserWalletById($userId) {
        $pdo = $this->connect();
    
        // Préparation de la requête SQL pour récupérer le wallet de l'utilisateur
        $query = "SELECT wallet FROM utilisateurs WHERE id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId);
    
        try {
            // Exécution de la requête
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Vérifier si un wallet a été trouvé
            if ($result) {
                return $result['wallet']; // Retourner le wallet
            } else {
                return null; // Aucun utilisateur trouvé
            }
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération du wallet : " . $e->getMessage();
            return null; // Échec de la récupération
        }
    }
    
    
    
    
}
?>
