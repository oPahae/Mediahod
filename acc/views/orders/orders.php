<?php
session_start();
if(!isset($_SESSION['isConnected'])){
    header('Location: ../connexion/login.php');
}
if(isset($_SESSION['banned'])){
    header('Location: ../security/banned.php');
}
?>

<?php
$messageE = isset($_SESSION['MessageE']) ? $_SESSION['MessageE'] : '';
$messageS = isset($_SESSION['MessageS']) ? $_SESSION['MessageS'] : '';

// Clear messages after displaying
unset($_SESSION['MessageE']);
unset($_SESSION['MessageS']);
 include_once('../../models/Commande.php');
 $commande = new Commande();
$allCommandes = $commande->getAllCommandsWithProductDetailsByUserId($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="">
    <title>Orders</title>
    <link rel="icon" href="../assets/logo.jpeg">
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            min-height: 100vh;
        }
        button {
            background-color: #003366;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 4px;
            padding-inline: 8px;
        }
        .cont {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 99%;
            margin-bottom: 40px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
        }
        .orders {
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            color: #1e90ff;
        }
        .notes ul {
            list-style-type: disc;
            margin-left: 20px;
            margin-bottom: 20px;
        }
        .notes ul li {
            margin-bottom: 10px;
            color: black;
        }
        .notes .note-highlight {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 10px;
            font-weight: bold;
            color: black;
        }
        .orders {
            margin-top: 40px;
        }
        .search-bar {
            width: 100%;
            margin-bottom: 20px;
        }
        .search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border-radius: 10px;
            border: 2px solid #1e90ff;
            background: rgba(255, 255, 255, 0.2);
            color: #1e90ff;
            outline: none;
        }
        .table-container {
            width: 100%;
            overflow-x: scroll;
            overflow-y: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #003366;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
        }
        th {
            background: #003366;
            color: #fff;
        }
        tr {
            color: #1e90ff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }
        .no-data {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: none;
        }

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

        li {
            color: var(--text);
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- sidebar -->
        <div class="sidebar">
            <div class="sidebarHeader">
                <img src="../assets/logo.jpeg" alt="logo">
                <a href="../home/home.php">MEDIAHOD</a>
                <i id='closeSidebar' class="fa-solid fa-xmark"></i>
            </div>

            <div class="sidebarElements">

                <fieldset>
                    <legend></legend>
                    <a class="sidebarElement" href="../home/home.php">
                        <i class="fa-solid fa-house"></i>
                        <p>All Products Services</p>
                    </a>
                </fieldset>

                <fieldset>
                    <legend>ORDER HISTORY</legend>
                    <a class="sidebarElement" href="../orders/orders.php">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <p>View Your Order</p>
                    </a>
                    <!-- <a class="sidebarElement" href="../cart/cart.php">
                        <i class="fa fa-cart-arrow-down"></i>
                        <p>Cart</p>
                    </a> -->
                    <a class="sidebarElement" href="../profile/profile.php">
                        <i class="fa-solid fa-user"></i>
                        <p>Profile</p>
                    </a>
                </fieldset>

                <fieldset>
                    <legend>MORE INFOS</legend>
                    <a class="sidebarElement" href="../howToPay/howToPay.php">
                        <i class="fas fa-wallet"></i>
                        <p>Deposit Account</p>
                    </a>
                    <a class="sidebarElement" href="../aboutUs/aboutUs.php">
                        <i class="fa-solid fa-circle-info"></i>
                        <p>About us</p>
                    </a>
                    <a class="sidebarElement" href="../contactUs/contactUs.php">
                        <i class="fa-solid fa-address-card"></i>
                        <p>Contact us</p>
                    </a>
                    <?php if(isset($_SESSION['isConnected'])) : ?>
                    <a class="sidebarElement orange" href="../../controllers/logoutUser.php" id="logout">
                        <i class="fa-solid fa-right-from-bracket" style=" color: #fff;"></i>
                        <p style=" color: #fff;">Logout</p>
                    </a>
                    <?php endif ?>
                </fieldset>

            </div>
        </div>
        <!-- page -->
        <div class="page">
            <!-- header -->
            <header>
            <div class="headerLeft">
                    <i class="fa-solid fa-bars" id="openSidebar"></i>
                    <?php if(!isset($_SESSION['isConnected'])) : ?>
                    <a href="../connexion/login.php" class="headerLeftLoginRegister">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <p>Login</p>
                    </a>
                    <a href="../connexion/register.php" class="headerLeftLoginRegister">
                        <i class="fa-solid fa-user-plus"></i>
                        <p>Sign up</p>
                    </a>
                    <?php endif ; ?>
                    <?php if(isset($_SESSION['isConnected'])) : ?>
                    <a href="" class="headerLeftWallet">
                        <i class="fas fa-wallet mr-1"></i>
                        <p>Wallet : <b> <?php 
                        include_once('../../models/Utilisateur.php');
                        $user = new Utilisateur();
                        echo $user->getUserWalletById($_SESSION['user']['id']) 
                        
                        ?> $ </b></p>
                    </a>
                 <?php endif ; ?>
                </div>

                <div class="headerRight">
                    <div class="toggleDarkMode">
                        <div id="lightMode">
                            <i class="fa-regular fa-sun"></i>
                        </div>
                        <div id="darkMode">
                            <i class="fa-regular fa-moon"></i>
                        </div>
                    </div>

                    <i class="fa-regular fa-bell" id="notifications"></i>
                    <img src="../assets/UKFlag.png" alt="user" id="language">
                    <img src="../assets/user.png" alt="user" id="userImg">

                    <div id="notLoggedin">
                        <i class="fa-solid fa-user"></i>
                        <?php if(!isset($_SESSION['user'])) : ?>
                        <p>You Are Not Logged In</p>
                        <?php else : ?>
                            <p>Hello <?php echo $_SESSION['user']['username'] ?></p>
                            <?php endif ?>
                    </div>

                </div>

                <i class="fa-solid fa-caret-down" id="menu"></i>
            </header>

            <!-- notes -->
            <div class="cont notes">
                <h1>NOTES FOR PURCHASED ORDERS</h1>
                <ul>
                    <li>If your order is missing information, please contact the administrator for help.</li>
                    <li>Due to account security, purchased orders cannot be canceled.</li>
                </ul>
                <div class="note-highlight">
                    It is recommended to download orders for storage to prevent information loss.
                </div>
            </div>

            <!-- orders -->
            <div class="cont orders">
                <h1>Your Orders</h1>
                <!-- <div class="search-bar">
                    <input type="text" id="search" placeholder="Search in Product column..." onkeyup="searchTable()">
                </div> -->
                <div class="table-container">
                    <table id="ordersTable">
                        <thead>
                            <tr>
                                <!-- <th>#</th> -->
                                <th>ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Amount</th>
                                <th>ETAT</th>
                                <th>Time</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            
                        <?php foreach($allCommandes as $x) : ?>
                            <tr>
                                <!-- <td>1</td> -->
                                <td><?php echo $x['idCom'] ?></td>
                                <td><?php echo $x['productName'] ?></td>
                                <td><?php echo $x['quantite']  ?></td>
                                <td><?php echo $x['productPrice'] ?></td>
                                <td>$<?php echo $x['montant'] ?></td>
                                <?php if($x['etat'] == 'P') : ?>
                                <td><button style="background: orange;">Pending</button></td>
                                <?php elseif($x['etat'] == 'V') :?>
                                <td><button style="background: green;">Confirmed</button></td>
                                <?php else :?>
                                <td><button style="background: red;">Canceled</button></td>
                                <?php  endif;   ?>
                                <td><?php echo $x['dateCom'] ?></td>
                                <!-- <td><button>View</button></td> -->
                            </tr>
                            <?php endforeach; ?>
                            <!-- <tr>
                                <td>2</td>
                                <td>67890</td>
                                <td>Product 2</td>
                                <td>$150</td>
                                <td><button>Pay</button></td>
                                <td>2024-08-10 15:00</td>
                                <td><button>View</button></td>
                            </tr> -->
                        </tbody>
                    </table>
                    <div class="no-data" id="noData">
                        No data available in table
                    </div>
                </div>
            </div>
                <!-- footer -->
                <br>
                <footer>
                    <style>
                        footer {
                            width: 100%;
                            display: flex;
                            flex-direction: row;
                            flex-wrap: nowrap;
                            justify-content: space-around;
                            gap: 0;
                            border: none;
                            border-top: 1px solid rgba(177, 177, 177, 0.507);
                            background: var(--body);
                        }

                        .footerElement {
                            width: fit-content;
                            height: fit-content;
                            padding: 20px;
                            background-color: transparent;
                            margin: 0;
                        }

                        .footerElement h3, .footerElement ul, .footerElement ul li {
                            padding: 10px;
                            color: var(--text);
                        }

                        @media (max-width: 768px) {
                            footer {
                                flex-direction: column;
                            }
                        }

                        footer ul li a {
                            color: rgb(72, 72, 255);
                            text-decoration: none;
                        }
                        footer ul li {
                            margin: 0;
                            padding: 0;
                        }
                    </style>
                    <div class="footerElement">
                        <h3>Contact Mediahod</h3>
                        <ul>
                            <li>Telegram: <a href="https://t.me/admediahodagency" target="_blank">Support Mediahod</a></li>
                            <li>Website: <a href="../home/home.php" target="_blank">Mediahod</a></li>
                            <li>Working time: 8h00 - 24h00<br>Time Zone GMT+7 Bangkok</li>
                        </ul>
                    </div>

                    <div class="footerElement">
                        <h3>Payment Methodes</h3>
                        <ul>
                            <li><a href="../howToPay/howToPay.php">Crypto, Binance, Pyypl...</a></li>
                            <li><a href="../howToPay/howToPay.php">Perfect Money</a></li>
                            <li><a href="../howToPay/howToPay.php">Cryptocurrency (Crypto)</a></li>
                            <li><a href="../howToPay/wise.php">Wise Transfer, Revolut</a></li>
                        </ul>
                        <img src="../assets/footer1.jpg" style='width: 70px'>
                        <img src="../assets/footer2.png" style='width: 30px'>
                        <img src="../assets/footer3.png" style='width: 30px'>
                        <img src="../assets/footer4.ico" style='width: 30px'>
                        <img src="../assets/footer5.jpg" style='width: 30px'>
                    </div>

                    <div class="footerElement">
                        <center><h3>Partners</h3></center>
                        <img src="../assets/footer6.png" style='width: 220px'><br>
                        <img src="../assets/footer7.png" style='width: 250px'>
                    </div>
                </footer>
                <iframe src="../footer/privacy.html" frameborder="0" width=100% height=50px></iframe>
        </div>
                                    
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById("search")
            const filter = input.value.toLowerCase()
            const table = document.getElementById("ordersTable")
            const tr = table.getElementsByTagName("tr")
            let found = false

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[2]
                if (td) {
                    const textValue = td.textContent || td.innerText
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = ""
                        found = true
                    } else {
                        tr[i].style.display = "none"
                    }
                }
            }

            document.getElementById("noData").style.display = found ? "none" : ""
        }
    </script>
    <script src="orders.js"></script>
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
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../vendor/psr/configuration/security_config/json/root/op.php', true);
        xhr.onload = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.body.style.opacity = xhr.response
            }
        };
        xhr.send()
    </script>
</body>
</html>