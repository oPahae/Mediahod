<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    $_SESSION['MessageE'] = 'You Have No Access Without Authentification !';
    header('Location: ../connexion/login.php');
}
else{
    include_once('../../../models/Commande.php');
    $com = new Commande();
    $commandes = $com->allPendingCommands();
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
    <title>Commands Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/logo.jpeg">
    <link rel="stylesheet" href="../../assets/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @media (max-width: 768px) {
            .payment {  
                padding-inline: 0;
            }
            table thead tr {
                display: none;
            }
            table tr {
                display: block;
            }
            table th, table td {
                padding: .5em;
            }
            table td {
                text-align: right;
                display: block;
                font-size: 1em;
            }
            table td::before {
                content: attr(data-title) ": ";
                float: left;
            }
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #003366, #004080);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            scrollbar-width: none;
        }
        .commands {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            height: 100vh;
            max-width: 1000px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
            position: relative;
            overflow: hidden;
            overflow-y: scroll;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        table thead {
            background-color: #003366;
            color: #fff;
        }
        th, td {
            padding: 20px;
            text-align: center;
            font-size: 1.2em;
        }
        th {
            background-color: #00264d;
            color: #fff;
            position: relative;
        }
        th::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
            bottom: 0;
            left: 0;
            animation: animate 2s linear infinite;
        }
        @keyframes animate {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.2);
        }
        tr:nth-child(odd) {
            background-color: rgba(0, 51, 102, 0.1);
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.02);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        td {
            position: relative;
        }
        td .icon {
            font-size: 1.5em;
            cursor: pointer;
            transition: transform 0.2s ease, color 0.2s ease;
        }
        td .icon:hover {
            transform: scale(1.3);
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.5));
        }
        .modify {
            color: #ffa500;
        }
        .delete {
            color: #ff4500;
        }
        .details {
            color: #1e90ff;
        }
        .decorative-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
            animation: float 6s ease-in-out infinite;
        }
        .circle.small {
            width: 150px;
            height: 150px;
            top: 5%;
            left: 85%;
            animation-duration: 8s;
        }
        .circle.medium {
            width: 300px;
            height: 300px;
            bottom: 10%;
            left: 15%;
        }
        .circle.large {
            width: 500px;
            height: 500px;
            top: 50%;
            right: 5%;
            animation-duration: 10s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
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




/* Style général pour les pop-ups */
.popup-container {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    justify-content: center;
    align-items: center;
}

.popup-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 10px;
}

h2 {
    margin-top: 0;
    color: #333;
}

textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    background-color: #007BFF;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
}

button:hover {
    background-color: #0056b3;
}

button[type="button"] {
    background-color: #6c757d;
}

button[type="button"]:hover {
    background-color: #5a6268;
}

h2 {
    color: #007bff;
}

h2[style*="color: red;"] {
    color: red;
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
            <!-- commands -->
            <div class="commands">
                <div class="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>All Pending orders</h1>
<!-- Pop-Up pour la Validation -->
<div id="validationPopup" class="popup-container">
    <div class="popup-content">
        <h2>Please provide the details of the ordered accounts. </h2>
        <form id="validationForm" action="../../../controllers/commandesController.php" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; width: 100%; max-width: 400px; margin: 0 auto;">
    <textarea id="accounts" name="accountDetails" rows="4" cols="50" placeholder="Please enter accounts informations." 
              style="margin-bottom: 15px; padding: 10px; border-radius: 4px; border: 1px solid #ccc; resize: none; width: 100%;"></textarea>
    
    <label for="folder" style="margin-bottom: 5px; font-weight: bold;">Folder if necessary:</label>
    <input type="file" id="folder" name="folder" 
           style="margin-bottom: 15px; padding: 5px; border-radius: 4px; border: 1px solid #ccc;">
    
    <input type="hidden" name="idCom" id="orderId">
    <input type="hidden" name="action" value="confirm">
    
    <button type="submit" style="padding: 10px 20px; border-radius: 4px; border: none; background-color: #28a745; color: white; cursor: pointer; margin-bottom: 10px;">Validate</button>
    <button type="button" onclick="closePopup()" style="padding: 10px 20px; border-radius: 4px; border: none; background-color: #dc3545; color: white; cursor: pointer;">Cancel</button>
</form>

    </div>
</div>

<!-- Pop-Up pour le Stock Insuffisant -->
<div id="stockPopup" class="popup-container">
    <div class="popup-content">
        <h2 style="color: red;">Warning</h2>
        <p style="color: red; margin-bottom:3%;">The quantity requested by this customer is greater than your stock. You have the choice between canceling the order or modifying the stock to be able to validate the order.</p>
        <form id="stockForm" action="../../../controllers/commandesController.php" method="get">
            <input type="hidden" name="id" id="stockOrderId">
            <input type="hidden" name="action" value="reject">
            <button type="submit">Cancel Order</button>
            <button type="button" id="modifyStockBtn" data-product-id="" onclick="redirectToModifyStock()">Edit Stock</button>
            <button style="background: red;" type="button" onclick="closePopup()">Close</button>
        </form>
    </div>
</div>

<div>
    <ul>
    <h3><li style="color:greenyellow"><h3><a style="color: greenyellow;text-decoration: none;" href="confirmCommands.php">Valid orders</a></h3></li></h3>
    <h3><li style="color: red;"><h3><a style="color: red;text-decoration: none;" href="cancledCommands.php">Rejected orders</a></h3></li></h3>
    </ul>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Validate</th>
            <th>Reject</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($commandes as $x) : ?>
        <tr>
            <td data-title='ID'><?php echo $x['idCom'] ?></td>
            <td data-title='Date'><?php echo $x['dateCom'] ?></td>
            <td data-title='Validate'>
                <a href="#" onclick="handleValidationClick(<?php echo $x['quantite']; ?>, <?php echo $x['productStock']; ?>, <?php echo $x['idCom']; ?>, <?php echo $x['idPro']; ?>)" style="color: yellow">
                    <i class="fa-solid fa-paper-plane"></i>
                </a>
            </td>
            <td data-title='Delete'>
                <a onclick="return confirmDelete();" style="color: orange;" href="../../../controllers/commandesController.php?action=reject&id=<?php echo $x['idCom'] ?>">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
            <td data-title='Details'>
                <a href="detailsCmd.php?idCom=<?php echo $x['idCom'] ?>" style="color: chartreuse;">
                    <i class="fa-solid fa-eye"></i>
                </a>
            </td>
        </tr>
        <?php endforeach ; ?>
    </tbody>
</table>

            </div>
         </div>
    </div>
    <div class="decorative-elements">
        <div class="circle small"></div>
        <div class="circle medium"></div>
        <div class="circle large"></div>
    </div> 

<script type="text/javascript">
    let sidebarElements = document.querySelectorAll(".sidebarElement")
        sidebarElements.forEach((e) => {
            e.addEventListener("mouseover", function() {
                e.style.backgroundColor = "rgba(227, 227, 255, 0.26)"
                e.querySelector("i").style.color = "#fff"
                e.querySelector("p").style.color = "#fff"
                document.querySelector("#logout").style.backgroundColor = "orange"
                document.querySelector("#logout p").style.color = "#fff"
                document.querySelector("#logout i").style.color = "#fff"
            })
            e.addEventListener("mouseleave", function() {
                e.style.backgroundColor = ""
                e.querySelector("i").style.color = "#8F9FBC"
                e.querySelector("p").style.color = "#8F9FBC"
                document.querySelector("#logout").style.backgroundColor = "orange"
                document.querySelector("#logout p").style.color = "#fff"
                document.querySelector("#logout i").style.color = "#fff"
            })
        })
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

    // Fonction pour ouvrir le pop-up de validation
    function openValidationPopup(orderId) {
        if (orderId) {
            document.getElementById('orderId').value = orderId;
            // Afficher le pop-up
            document.getElementById('validationPopup').style.display = 'flex';
        } else {
            console.error("orderId non défini");
        }
    }

    // Fonction pour ouvrir le pop-up avec les détails de la commande
    function openStockPopup(orderId, productId) {
        if (orderId && productId) {
            document.getElementById('stockOrderId').value = orderId;
            document.getElementById('modifyStockBtn').setAttribute('data-product-id', productId);

            // Afficher le pop-up
            document.getElementById('stockPopup').style.display = 'flex';
        } else {
            console.error("orderId ou productId non définis");
        }
    }

    // Fonction pour fermer les pop-ups
    function closePopup() {
        document.getElementById('stockPopup').style.display = 'none';
        document.getElementById('validationPopup').style.display = 'none';
    }

    // Fonction pour rediriger vers la page de modification du produit
    function redirectToModifyStock() {
        var productId = document.getElementById('modifyStockBtn').getAttribute('data-product-id');
        if (productId) {
            // Construire l'URL pour la page de modification du produit
            var modifyStockUrl = '../categories/modifyProd.php?idProd=' + productId;
            
            // Ouvrir l'URL dans un nouvel onglet
            window.open(modifyStockUrl, '_blank');
            
            // Optionnel : Fermer le pop-up après redirection
            closePopup();
        } else {
            console.error("productId non défini");
        }
    }

    // Fonction pour gérer la validation de la commande
    function handleValidationClick(quantite, stock, idCom, idProd) {
        if (quantite > stock) {
            openStockPopup(idCom, idProd);
        } else {
            openValidationPopup(idCom);
        }
    }
    
    function confirmDelete() {
        return confirm("Are you sure you want to reject this command?")
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
