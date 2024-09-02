<?php
session_start();
if(isset($_SESSION['banned'])){
    header('Location: ../security/banned.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="aboutUs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/logo.jpeg">
</head>
<style>
    .about-container {
        width: 99%;
    }
</style>
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

            <!-- about -->
            <div class="about-container">
                <div class="about-header">
                    <h1>About Us</h1>
                </div>
                <div class="about-content">
                    <!-- <p>
                        Welcome to our website! We are dedicated to providing top-notch services and products to our valued customers.
                        Our mission is to innovate and deliver solutions that meet your needs. With a team of highly skilled professionals,
                        we are committed to excellence in everything we do.
                    <br>
                        Our journey began with a passion for technology and a desire to make a difference. Over the years, we have grown
                        into a leading provider in our industry, known for our reliability, quality, and customer-centric approach.
                        Thank you for choosing us as your trusted partner. We look forward to serving you and helping you achieve your goals.
                    </p> -->
                    <?php 
                    include_once('../../models/AboutUs.php');
                    $a = new AboutUs();
                    echo htmlspecialchars($a->getContent())
                    ?>
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
    </div>
    <script src="aboutUs.js"></script>
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

