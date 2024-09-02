<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    $_SESSION['MessageE'] = 'You Have No Access Without Authentification !';
    header('Location: ../connexion/login.php');
}
elseif(!isset($_GET['idCom'])){
    $_SESSION['MessageE'] = 'Something Went Wrong!';
    header('Location: commands');  
}
else{
    include_once('../../../models/Commande.php');
    $com = new Commande();
    $detailsCom = $com->getCommandWithProductDetailsById($_GET['idCom']);
    $userInfo = $com->getUserContactByCommandId($_GET['idCom']);
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
    <title>Command Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/logo.jpeg">
    <link rel="stylesheet" href="../../assets/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @media screen and (max-width: 768px) {
            td:nth-child(2), td:nth-child(3), th:nth-child(2), th:nth-child(3) {
                display: none;
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
        .detailsCmd {
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


.back {
        width: 100%; /* Largeur à 100% de la cellule <td> */
        box-sizing: border-box; /* Inclut le padding dans la largeur totale */
        background-color: #3498db; /* Bleu ciel */
        color: white; /* Texte en blanc */
        border: none; /* Pas de bordure */
        padding: 10px 20px; /* Espacement interne */
        font-size: 16px; /* Taille du texte */
        border-radius: 5px; /* Bordures arrondies */
        cursor: pointer; /* Curseur en forme de main */
        transition: background-color 0.3s ease, transform 0.3s ease; /* Transition pour l'effet hover */
    }

    .back:hover {
        background-color: #2980b9; /* Bleu plus foncé au survol */
        transform: scale(1.05); /* Légère augmentation de la taille au survol */
    }

    .back:active {
        background-color: #1c5d8c; /* Bleu encore plus foncé quand cliqué */
        transform: scale(0.98); /* Légère réduction de la taille quand cliqué */
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
            <!-- detailsCmd -->
            <div class="detailsCmd">
                <div class="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Command Details</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Label</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $detailsCom['idCom'] ?></td>
                            <td><?php echo $detailsCom['productName'] ?></td>
                            <td><?php echo $detailsCom['quantite'] ?></td>
                            <td>$<?php echo $detailsCom['productPrice'] ?></td>
                            <td>$<?php echo $detailsCom['montant'] ?></td>
                        </tr>
                        <tr>
                            <td style="background-color: #3498db;">
                                <button class="back"  onclick="history.back()">back</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            <!-- user Info -->
            <!-- <div class="detailsCmd"> -->
                <h1>User Info</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>UserName</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Wallet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $userInfo['id'] ?></td>
                            <td><?php echo $userInfo['username'] ?></td>
                            <td><?php echo $userInfo['email'] ?></td>
                            <td><?php echo $userInfo['telephone'] ?></td>
                            <td>$<?php echo $userInfo['wallet'] ?></td>
                        </tr>
                        <!-- <tr>
                            <td style="background-color: #3498db;">
                                <button class="back"  onclick="history.back()">back</button>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
                </div>
                <!-- </div> -->
         </div>
    </div>
    <div class="decorative-elements">
        <div class="circle small"></div>
        <div class="circle medium"></div>
        <div class="circle large"></div>
    </div> 

    <script>
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
</script>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this product?");
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
