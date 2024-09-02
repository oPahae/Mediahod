<?php
include_once('Connection.php');
class Commande extends Connection {

   // Ajouter une commande
   public function addCommande($quantite, $montant, $idPro, $idUser) {
    $pdo = $this->connect();

    // Préparation de la requête SQL pour ajouter une commande
    $query = "INSERT INTO commandes (quantite, montant, idPro, idUtilisateur) VALUES (:quantite, :montant, :idPro, :idUser)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':quantite', $quantite);
    $stmt->bindParam(':montant', $montant);
    $stmt->bindParam(':idPro', $idPro);
    $stmt->bindParam(':idUser', $idUser);

    try {
        // Exécution de la requête
        $stmt->execute();
        return true; // Ajout réussi
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de l'ajout de la commande : " . $e->getMessage();
        return false; // Échec de l'ajout
    }
}

// Supprimer une commande
public function deleteCommande($idCom) {
    $pdo = $this->connect();

    // Préparation de la requête SQL pour supprimer une commande
    $query = "DELETE FROM commandes WHERE idCom = :idCom";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idCom', $idCom);

    try {
        // Exécution de la requête
        $stmt->execute();
        return true; // Suppression réussie
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de la suppression de la commande : " . $e->getMessage();
        return false; // Échec de la suppression
    }
}
   

    // Obtenir les détails d'une commande par ID
    public function getCommandeById($id) {
        $pdo = $this->connect();
        $query = "SELECT * FROM commandes WHERE idCom = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne les détails de la commande
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Obtenir toutes les commandes pour un utilisateur spécifique
    public function getCommandesByUtilisateur($idUtilisateur) {
        $pdo = $this->connect();
        $query = "SELECT * FROM commandes WHERE idUtilisateur = :idUtilisateur";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":idUtilisateur", $idUtilisateur);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne toutes les commandes pour cet utilisateur
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Calculer le nombre total de commandes
    public function getTotalCommandes() {
        $pdo = $this->connect();
        $query = "SELECT COUNT(*) AS total FROM commandes";
        $stmt = $pdo->query($query);

        try {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Calculer le nombre de commandes valides
    public function getTotalCommandesValides() {
        $pdo = $this->connect();
        $query = "SELECT COUNT(*) AS total FROM commandes WHERE etat = 'V'";
        $stmt = $pdo->query($query);

        try {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Calculer le nombre de commandes annulées
    public function getTotalCommandesAnnulees() {
        $pdo = $this->connect();
        $query = "SELECT COUNT(*) AS total FROM commandes WHERE etat = 'A'";
        $stmt = $pdo->query($query);

        try {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }


    public function allPendingCommands() {
        $pdo = $this->connect();
    
        // Préparation de la requête SQL pour récupérer toutes les commandes en attente avec les détails du produit
        $query = "
            SELECT 
                commandes.*,
                produits.stock AS productStock
            FROM commandes
            JOIN produits ON commandes.idPro = produits.id
            WHERE commandes.etat = 'P'
        ";
        $stmt = $pdo->prepare($query);
    
        try {
            // Exécution de la requête
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner les résultats
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération des commandes en attente : " . $e->getMessage();
            return false; // Échec de la récupération
        }
    }
    

    // Récupérer toutes les commandes validées
    public function allValideCommands() {
        $pdo = $this->connect();

        // Préparation de la requête SQL pour récupérer toutes les commandes validées
        $query = " SELECT 
                commandes.*,
                produits.stock AS productStock
            FROM commandes
            JOIN produits ON commandes.idPro = produits.id
            WHERE commandes.etat = 'V'
            ORDER BY dateCom DESC
            ";
        $stmt = $pdo->prepare($query);

        try {
            // Exécution de la requête
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner les résultats
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération des commandes validées : " . $e->getMessage();
            return false; // Échec de la récupération
        }
    }

    // Récupérer toutes les commandes annulées
    public function allAnnCommands() {
        $pdo = $this->connect();

        // Préparation de la requête SQL pour récupérer toutes les commandes annulées
        $query = "SELECT * FROM commandes WHERE etat = 'A'";
        $stmt = $pdo->prepare($query);

        try {
            // Exécution de la requête
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner les résultats
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération des commandes annulées : " . $e->getMessage();
            return false; // Échec de la récupération
        }
    }

    // Récupérer toutes les commandes
    public function allCommands() {
        $pdo = $this->connect();

        // Préparation de la requête SQL pour récupérer toutes les commandes
        $query = "SELECT * FROM commandes";
        $stmt = $pdo->prepare($query);

        try {
            // Exécution de la requête
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner les résultats
        } catch (PDOException $e) {
            // Gestion des erreurs
            echo "Erreur lors de la récupération de toutes les commandes : " . $e->getMessage();
            return false; // Échec de la récupération
        }
    }

   //les commandes par utilisateur
   public function getAllCommandsWithProductDetailsByUserId($userId) {
    $pdo = $this->connect();
    
    // Préparation de la requête SQL pour récupérer toutes les commandes d'un utilisateur
    // avec les détails du produit
    $query = "
        SELECT 
            commandes.idCom,
            commandes.dateCom,
            commandes.quantite,
            commandes.montant,
            commandes.idUtilisateur,
            commandes.idPro,
            commandes.etat,
            produits.libelle AS productName,
            produits.prix AS productPrice
        FROM commandes
        JOIN produits ON commandes.idPro = produits.id
        WHERE commandes.idUtilisateur = :userId
        ORDER BY dateCom DESC
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userId', $userId);

    try {
        // Exécution de la requête
        $stmt->execute();
        // Récupération des résultats
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result; // Retourne les commandes avec les détails du produit
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
        return false; // Échec de la récupération
    }
}


public function getCommandWithProductDetailsById($idCom) {
    $pdo = $this->connect();
    
    // Préparation de la requête SQL pour récupérer une commande spécifique par son ID
    // avec les détails du produit associé
    $query = "
        SELECT 
            commandes.idCom,
            commandes.dateCom,
            commandes.quantite,
            commandes.montant,
            commandes.idUtilisateur,
            commandes.idPro,
            commandes.etat,
            produits.libelle AS productName,
            produits.prix AS productPrice ,
            produits.stock AS productStock
        FROM commandes
        JOIN produits ON commandes.idPro = produits.id
        WHERE commandes.idCom = :idCom
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idCom', $idCom, PDO::PARAM_INT);

    try {
        // Exécution de la requête
        $stmt->execute();
        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result; // Retourne les détails de la commande avec les détails du produit
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de la récupération de la commande : " . $e->getMessage();
        return false; // Échec de la récupération
    }
}


//
public function getUserContactByCommandId($idCom) {
    $pdo = $this->connect();
    
    // Préparation de la requête SQL pour récupérer l'email et le téléphone de l'utilisateur
    // en utilisant l'ID de la commande
    $query = "
        SELECT
            utilisateurs.id, 
            utilisateurs.username,
            utilisateurs.email,
            utilisateurs.telephone,
            utilisateurs.wallet
        FROM commandes
        JOIN utilisateurs ON commandes.idUtilisateur = utilisateurs.id
        WHERE commandes.idCom = :idCom
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idCom', $idCom, PDO::PARAM_INT);

    try {
        // Exécution de la requête
        $stmt->execute();
        // Récupération du résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result; // Retourne l'email et le téléphone de l'utilisateur
    } catch (PDOException $e) {
        // Gestion des erreurs
        echo "Erreur lors de la récupération des informations de contact : " . $e->getMessage();
        return false; // Échec de la récupération
    }
}


public function rejectCommande($idCom) {
    // Récupérer les détails de la commande et les informations du produit
    $detailsCommand = $this->getCommandWithProductDetailsById($idCom);
    
    // Vérifier si les détails de la commande ont été récupérés correctement
    if ($detailsCommand === false) {
        echo "Erreur: Impossible de récupérer les détails de la commande.";
        return false;
    }
    
    // Récupérer les informations de contact de l'utilisateur
    $detailsUser = $this->getUserContactByCommandId($idCom);
    
    // Vérifier si les informations de l'utilisateur ont été récupérées correctement
    if ($detailsUser === false) {
        echo "Erreur: Impossible de récupérer les informations de l'utilisateur.";
        return false;
    }
    
    // Modifier l'état de la commande à 'A' (Annulée)
    $pdo = $this->connect();
    $query = "UPDATE commandes SET etat = 'A' WHERE idCom = :idCom";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':idCom', $idCom, PDO::PARAM_INT);
    
    try {
        // Exécuter la requête pour mettre à jour l'état de la commande
        $stmt->execute();
        echo "La commande a été annulée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour de l'état de la commande : " . $e->getMessage();
        return false;
    }
    include_once('../envoyerEmail.php');
    // Envoyer l'email d'annulation à l'utilisateur
    send_email_annulation($detailsCommand, $detailsUser);
    
    return true; // Opération réussie
}



  
    

    // Calculer le chiffre d'affaires par année
    public function getChiffreAffairesParAnnee($annee) {
        $pdo = $this->connect();
        $query = "SELECT SUM(montant) AS chiffreAffaires FROM commandes WHERE etat = 'V' AND YEAR(dateCom) = :annee";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":annee", $annee);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['chiffreAffaires'] ?? 0; // Retourne 0 si aucun résultat
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }

    // Calculer le chiffre d'affaires par mois
    public function getChiffreAffairesParMois($mois, $annee) {
        $pdo = $this->connect();
        $query = "SELECT SUM(montant) AS chiffreAffaires FROM commandes WHERE etat = 'valide' AND MONTH(dateCom) = :mois AND YEAR(dateCom) = :annee";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":mois", $mois);
        $stmt->bindParam(":annee", $annee);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['chiffreAffaires'] ?? 0; // Retourne 0 si aucun résultat
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
            return false;
        }
    }


    public function validerCommand($idCom, $accountInfo , $file = null) {
        // Connexion à la base de données
        $pdo = $this->connect();
        
        try {
            // Démarrage de la transaction
            $pdo->beginTransaction();
            
            // Étape 1 : Récupérer les informations de la commande
            $detailsCommand = $this->getCommandWithProductDetailsById($idCom);
            if (!$detailsCommand) {
                throw new Exception("Erreur lors de la récupération des informations de commande.");
            }
    
            // Étape 2 : Récupérer les informations de l'utilisateur
            $detailsUser = $this->getUserContactByCommandId($idCom);
            if (!$detailsUser) {
                throw new Exception("Erreur lors de la récupération des informations de l'utilisateur.");
            }
    
            // Étape 3 : Mettre à jour l'état de la commande à 'V'
            $queryUpdateEtat = "
                UPDATE commandes
                SET etat = 'V'
                WHERE idCom = :idCom
            ";
            $stmtUpdateEtat = $pdo->prepare($queryUpdateEtat);
            $stmtUpdateEtat->bindParam(':idCom', $idCom, PDO::PARAM_INT);
            if (!$stmtUpdateEtat->execute()) {
                throw new Exception("Erreur lors de la mise à jour de l'état de la commande.");
            }
    
            // Étape 4 : Diminuer le stock du produit
            $queryUpdateStock = "
                UPDATE produits
                SET stock = stock - :quantite
                WHERE id = :idPro
            ";
            $stmtUpdateStock = $pdo->prepare($queryUpdateStock);
            $stmtUpdateStock->bindParam(':quantite', $detailsCommand['quantite'], PDO::PARAM_INT);
            $stmtUpdateStock->bindParam(':idPro', $detailsCommand['idPro'], PDO::PARAM_INT);
            if (!$stmtUpdateStock->execute()) {
                throw new Exception("Erreur lors de la mise à jour du stock du produit.");
            }
    
            // Étape 5 : Diminuer le wallet de l'utilisateur
            $queryUpdateWallet = "
                UPDATE utilisateurs
                SET wallet = wallet - :montant
                WHERE id = :idUtilisateur
            ";
            $stmtUpdateWallet = $pdo->prepare($queryUpdateWallet);
            $stmtUpdateWallet->bindParam(':montant', $detailsCommand['montant'], PDO::PARAM_INT);
            $stmtUpdateWallet->bindParam(':idUtilisateur', $detailsCommand['idUtilisateur'], PDO::PARAM_INT);
            if (!$stmtUpdateWallet->execute()) {
                throw new Exception("Erreur lors de la mise à jour du wallet de l'utilisateur.");
            }
    
          // Étape 6 : Récupérer à nouveau les informations de l'utilisateur après la mise à jour du wallet
$queryGetUpdatedUser = "
SELECT u.*, c.montant 
FROM utilisateurs u 
JOIN commandes c ON u.id = c.idUtilisateur 
WHERE c.idCom = :idCom
";
$stmtGetUpdatedUser = $pdo->prepare($queryGetUpdatedUser);
$stmtGetUpdatedUser->bindParam(':idCom', $idCom, PDO::PARAM_INT);
$stmtGetUpdatedUser->execute();
$detailsUserUpdated = $stmtGetUpdatedUser->fetch(PDO::FETCH_ASSOC);

if (!$detailsUserUpdated) {
throw new Exception("Erreur lors de la récupération des informations mises à jour de l'utilisateur.");
}

    
            // Étape 7 : Envoyer l'email de validation
            include_once('../envoyerEmail.php');
            send_email_validation($detailsCommand, $detailsUserUpdated, $accountInfo , $file);
    
            // Tout s'est bien passé, on commit la transaction
            $pdo->commit();
            return true;
    
        } catch (Exception $e) {
            // En cas d'erreur, on annule toutes les opérations
            $pdo->rollBack();
            return false;
        }
    }
    






    // public function validerCommande($idCom) {
    //     $pdo = $this->connect();
        
    //     // Commencer une transaction
    //     $pdo->beginTransaction();
        
    //     try {
    //         // Modifier l'état de la commande
    //         $queryUpdateCommande = "UPDATE Commandes SET etat = 'V' WHERE idCom = :idCom";
    //         $stmtUpdateCommande = $pdo->prepare($queryUpdateCommande);
    //         $stmtUpdateCommande->bindParam(":idCom", $idCom);
    //         $stmtUpdateCommande->execute();
            
    //         // Réduire le stock pour chaque produit dans la commande
    //         $queryGetLigneCommande = "SELECT idProduit, quantite FROM LigneCommande WHERE idCom = :idCom";
    //         $stmtGetLigneCommande = $pdo->prepare($queryGetLigneCommande);
    //         $stmtGetLigneCommande->bindParam(":idCom", $idCom);
    //         $stmtGetLigneCommande->execute();
    //         $ligneCommandes = $stmtGetLigneCommande->fetchAll(PDO::FETCH_ASSOC);
    
    //         foreach ($ligneCommandes as $ligne) {
    //             $idProduit = $ligne['idProduit'];
    //             $quantite = $ligne['quantite'];
                
    //             // Mettre à jour le stock
    //             $queryUpdateStock = "UPDATE Produits SET stock = stock - :quantite WHERE id = :idProduit";
    //             $stmtUpdateStock = $pdo->prepare($queryUpdateStock);
    //             $stmtUpdateStock->bindParam(":quantite", $quantite);
    //             $stmtUpdateStock->bindParam(":idProduit", $idProduit);
    //             $stmtUpdateStock->execute();
    //         }
            
    //         // Récupérer les informations de la commande
    //         $queryGetCommande = "SELECT dateCom FROM Commandes WHERE idCom = :idCom";
    //         $stmtGetCommande = $pdo->prepare($queryGetCommande);
    //         $stmtGetCommande->bindParam(":idCom", $idCom);
    //         $stmtGetCommande->execute();
    //         $commande = $stmtGetCommande->fetch(PDO::FETCH_ASSOC);
            
    //         // Récupérer les informations de l'utilisateur
    //         $queryGetUtilisateur = "SELECT u.username, c.idUtilisateur FROM Commandes c JOIN Utilisateurs u ON c.idUtilisateur = u.id WHERE c.idCom = :idCom";
    //         $stmtGetUtilisateur = $pdo->prepare($queryGetUtilisateur);
    //         $stmtGetUtilisateur->bindParam(":idCom", $idCom);
    //         $stmtGetUtilisateur->execute();
    //         $utilisateur = $stmtGetUtilisateur->fetch(PDO::FETCH_ASSOC);
    
    //         // Envoyer l'email de validation
    //         //send_mail_validation($idCom, $utilisateur['username'], $commande['dateCom']);
            
    //         // Commit transaction
    //         $pdo->commit();
            
    //         return true;
    //     } catch (Exception $e) {
    //         // Rollback transaction en cas d'erreur
    //         $pdo->rollBack();
    //         die("Error: " . $e->getMessage());
    //         return false;
    //     }
    // }
    
    // public function annullerCommande($idCom) {
    //     $pdo = $this->connect();
        
    //     // Commencer une transaction
    //     $pdo->beginTransaction();
        
    //     try {
    //         // Modifier l'état de la commande
    //         $queryUpdateCommande = "UPDATE Commandes SET etat = 'annule' WHERE idCom = :idCom";
    //         $stmtUpdateCommande = $pdo->prepare($queryUpdateCommande);
    //         $stmtUpdateCommande->bindParam(":idCom", $idCom);
    //         $stmtUpdateCommande->execute();
            
    //         // Récupérer les informations de la commande
    //         $queryGetCommande = "SELECT dateCom FROM Commandes WHERE idCom = :idCom";
    //         $stmtGetCommande = $pdo->prepare($queryGetCommande);
    //         $stmtGetCommande->bindParam(":idCom", $idCom);
    //         $stmtGetCommande->execute();
    //         $commande = $stmtGetCommande->fetch(PDO::FETCH_ASSOC);
            
    //         // Récupérer les informations de l'utilisateur
    //         $queryGetUtilisateur = "SELECT u.username, c.idUtilisateur FROM Commandes c JOIN Utilisateurs u ON c.idUtilisateur = u.id WHERE c.idCom = :idCom";
    //         $stmtGetUtilisateur = $pdo->prepare($queryGetUtilisateur);
    //         $stmtGetUtilisateur->bindParam(":idCom", $idCom);
    //         $stmtGetUtilisateur->execute();
    //         $utilisateur = $stmtGetUtilisateur->fetch(PDO::FETCH_ASSOC);
    
    //         // Envoyer l'email d'annulation
    //         //send_mail_annulation($idCom, $utilisateur['username'], $commande['dateCom']);
            
    //         // Commit transaction
    //         $pdo->commit();
            
    //         return true;
    //     } catch (Exception $e) {
    //         // Rollback transaction en cas d'erreur
    //         $pdo->rollBack();
    //         die("Error: " . $e->getMessage());
    //         return false;
    //     }
    // }
    
}
?>
