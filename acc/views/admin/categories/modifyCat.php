<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    $_SESSION['MessageE'] = 'You Have No Access Without Authentification !';
    header('Location: ../connexion/login.php');
}
elseif(!isset($_GET['idCat'])){
    $_SESSION['MessageE'] = 'Something Went Wrong !';
    header('Location: categories.php');
}
else{
    include_once('../../../models/Categorie.php');
    $c = new Categorie();
    $cat = $c->getCategoryById($_GET['idCat']);

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
    <title>Modifier Produit</title>
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
        .page {
            justify-content: center;
            align-items: center;
        }
        body {
            background: linear-gradient(135deg, #003366, #004080);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .modifyCat {
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
            <!-- modifyCat -->
            <div class="modifyCat">
                <div class="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Modify Category</h1>
                <form id="product-form" action="../../../controllers/categoriesController.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="idCat" value="<?php echo $cat['id'] ?>">
                    
                    <label for="label">Category Name</label>
                    <input type="text" id="label" name="label" value="<?php echo $cat['nom']?>" disabled>
        
                    <label for="imageCat">Category Image</label>
                    <input type="file" id="imageCat" name="imageCat" disabled>
                    
                    <div class="button-group">
                        <button type="button" id="edit-button">Edit</button>
                        <button type="button" id="cancel-button" style="display: none;">Cancel</button>
                        <button type="submit" id="confirm-button" style="display: none;" name="action" value="modifyCat">Confirm</button>
                    </div>
                </form>
                <div id="success-message">Category Modified Successfully!</div>
            </div>
        </div>
    </div>

    <script>
        const editButton = document.getElementById('edit-button');
        const cancelButton = document.getElementById('cancel-button');
        const confirmButton = document.getElementById('confirm-button');
        const formElements = document.querySelectorAll('#product-form input, #product-form textarea, #product-form select');
        const successMessage = document.getElementById('success-message');

        editButton.addEventListener('click', () => {
            formElements.forEach(element => element.disabled = false);
            editButton.style.display = 'none';
            cancelButton.style.display = 'inline-block';
            confirmButton.style.display = 'inline-block';
        });

        cancelButton.addEventListener('click', () => {
            formElements.forEach(element => {
                element.disabled = true;
                // Reset input values if needed
                if (element.type === 'text') {
                    element.value = "<?php echo addslashes($cat['nom']); ?>" 
                }
            });
            editButton.style.display = 'inline-block';
            cancelButton.style.display = 'none';
            confirmButton.style.display = 'none';
        });

        document.getElementById('product-form').addEventListener('submit', (e) => {
          // No need to prevent default form submission here
     // e.preventDefault(); // Remove this line if the form should be submitted normally
    formElements.forEach(element => element.disabled = false);
    editButton.style.display = 'inline-block';
    cancelButton.style.display = 'none';
    confirmButton.style.display = 'none';
});


        let sidebarElements = document.querySelectorAll(".sidebarElement");
        sidebarElements.forEach((e) => {
            e.addEventListener("mouseover", function() {
                e.style.backgroundColor = "rgba(227, 227, 255, 0.26)";
                e.querySelector("i").style.color = "#fff";
                e.querySelector("p").style.color = "#fff";
                document.querySelector("#logout").style.backgroundColor = "orange";
                document.querySelector("#logout p").style.color = "#fff";
                document.querySelector("#logout i").style.color = "#fff";
            });
            e.addEventListener("mouseleave", function() {
                e.style.backgroundColor = "";
                e.querySelector("i").style.color = "#8F9FBC";
                e.querySelector("p").style.color = "#8F9FBC";
                document.querySelector("#logout").style.backgroundColor = "orange";
                document.querySelector("#logout p").style.color = "#fff";
                document.querySelector("#logout i").style.color = "#fff";
            });
        });
    </script>



<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($messageE)): ?>
            showNotification('error', '<?php echo addslashes($messageE); ?>');
        <?php endif; ?>
        <?php if (!empty($messageS)): ?>
            showNotification('success', '<?php echo addslashes($messageS); ?>');
        <?php endif; ?>
    });

    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <span>${message}</span>
            <button class="close-btn">&times;</button>
        `;
        document.body.appendChild(notification);

        document.querySelector('.notification .close-btn').addEventListener('click', function() {
            this.parentElement.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        });

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 500);
        }, 5000);
    }
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

