<?php
    // Inclure le fichier de connexion à la base de données
    include('../../../../../../models/Connection.php');
    
    // Créer une instance de connexion et se connecter à la base de données
    $x = new Connection();
    $pdo = $x->connect();

    try {
        // Préparer et exécuter la requête SQL pour récupérer la valeur de "v"
        $stmt = $pdo->prepare("SELECT v FROM oppacity LIMIT 1");
        $stmt->execute();

        // Récupérer le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si une valeur a été récupérée
        if ($result['v'] == 0) {
            echo "0";
        } else {
            echo "1";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération de la valeur : " . $e->getMessage();
    }
?>
