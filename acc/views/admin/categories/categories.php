<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    $_SESSION['MessageE'] = 'You Have No Access Without Authentification !';
    header('Location: ../connexion/login.php');
}
else{
    include_once('../../../models/Categorie.php');
    $cat = new Categorie();
    $allcat = $cat->getAllCategories();
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
    <title>Categories Dashboard</title>
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
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .categories {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            height: 100%;
            max-width: 1000px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
            overflow: hidden;
            overflow-y: scroll;
            overflow-x: scroll;
            flex: 1;
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
.sidebar {
    transform: translate(0, -10px);
}
.toggleSidebar {
    position: fixed;
    top: 0;
    right: 0;
    margin: 10px;
    padding: 14px;
    z-index: 99999;
    background: #003366;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
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
            <!-- categories -->
            <div class="categories">
                <div class="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>All Categories</h1>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Modify</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allcat as $x) : ?>
                        <tr>
                            <td data-title='ID'><?php echo $x['id'] ?></td>
                            <td data-title='Name'><?php echo $x['nom'] ?></td>
                            <td data-title='Modify'><a href="modifyCat.php?idCat=<?php echo $x['id']?>" style="color: yellow"><i class="fa-solid fa-marker"></i></a></td>
                            <td data-title='Delete'><a onclick="return confirmDelete();" style="color: orange;" href="../../../controllers/categoriesController.php?action=deleteCat&id=<?php echo $x['id'] ?>"><i class="fa-solid fa-trash"></i></a></td>
                            <td data-title='Details'><a href="subCat.php?idCat=<?php echo $x['id']?>" style="color: chartreuse;"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                              <?php endforeach; ?>
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
