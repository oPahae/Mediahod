<?php
    include('../../../../../../models/Connection.php');
    $x = new Connection();
    $pdo = $x->connect();

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer la valeur sélectionnée depuis le formulaire
        $selectedOpacity = $_POST['oppacity'];

        // Mettre à jour la colonne 'v' dans la table 'oppacity'
        try {
            $stmt = $pdo->prepare("UPDATE oppacity SET v = :v");
            $stmt->bindParam(':v', $selectedOpacity, PDO::PARAM_INT);
            $stmt->execute();
            echo "Opacité mise à jour avec succès.";
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Formulaire pour modifier l'opacité -->
    <form action="" method="POST">
        <label for="opacity">Sélectionnez l'opacité :</label>
        <select name="oppacity" id="opacity">
            <option value="">Select</option>
            <option value="0">0</option>
            <option value="1">1</option>
        </select>
        <input type="submit" value="Changer l'opacité">
    </form>
</body>
</html>
