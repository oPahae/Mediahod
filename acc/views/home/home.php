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


<?php
include_once('../../models/Categorie.php');
$categorie = new Categorie();
$categories = $categorie->getAllCategories();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="">
    <title>MEDIAHOD</title>
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/logo.jpeg">

    <style>
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

a {
    text-decoration: none;
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
            <!-- main -->
            <main>
                <!-- dash -->
                <div class="dash">
                    <div class="banner">
                        <p>Mediahod <br> Platform That Provides High Quality Social Media Accounts</p>
                        <div class="notLoggedinBanner">
                        <?php if(!isset($_SESSION['user'])) : ?>
                        <p>Hi ! You Are Not Logged in</p>
                        <?php else : ?>
                            <p>Hello <?php echo $_SESSION['user']['username'] ?></p>
                            <?php endif ;?>
                        </div>
                    </div>
                </div>
                <!-- services -->
                <div class="services">
                    <div class="service">
                        <img src="../assets/logo.jpeg" alt="logo">
                        <p>Instant Delivery <br> Active account, full of information</p>
                    </div>
                    <div class="service">
                        <img src="../assets/logo.jpeg" alt="logo">
                        <p>24/7 Support <br> Solve problems quickly</p>
                    </div>
                    <div class="service">
                        <img src="../assets/logo.jpeg" alt="logo">
                        <p>100% Secure <br> Account is safe and secure</p>
                    </div>
                </div>
                <!-- tape -->
                <div class="tape">
                    <marquee>If the product you want to buy is not available, please contact the administrator to request it.</marquee>
                </div>
                <!-- products -->
                <p class="productsTitle">PRODUCTS AND SERVICES</p>

                <div class="products">
                    <?php  foreach($categories as $cat) : ?> 
                    <div class="product">
                        <img src="<?php echo $cat['image'] ?>" alt="<?php echo $cat['nom'] ?>">
                        <a href="../buy/buy.php?idCat=<?php echo $cat['id'] ?>">   
                        <p><?php echo $cat['nom'] ?></p>
                        </a>
                    </div>
                
                        <?php endforeach; ?>
                    <!-- <div class="product">
                        <img src="../assets/animated/suitcase.gif" alt="account">
                        <p>Business Manager</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/flag.gif" alt="account">
                        <p>Facebook Pages</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/google.gif" alt="account">
                        <p>Google Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/instagram.gif" alt="account">
                        <p>Instagram Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/twitter.gif" alt="account">
                        <p>Twitter Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/discord.gif" alt="account">
                        <p>Discord Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/amazon.gif" alt="account">
                        <p>Amazon Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/telegram.gif" alt="account">
                        <p>Telegram Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/netflix.gif" alt="account">
                        <p>Netflix Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/reddit.gif" alt="account">
                        <p>Reddit Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/snapchat.gif" alt="account">
                        <p>Snapchat Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/youtube.gif" alt="account">
                        <p>Youtube Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/apple.gif" alt="account">
                        <p>ID Apple Accounts</p>
                    </div>
                    <div class="product">
                        <img src="../assets/animated/spotify.gif" alt="account">
                        <p>Spotify Accounts</p>
                    </div> -->
                    

                </div>

                <!-- tutorials -->
                <p class="tutorialsTitle">Posts & Tutorial</p>

                <div class="tutorials">
                        
                </div>

                <!-- footer -->
                <br>
                <footer>
                    <style>
                        footer {
                            width: 105%;
                            display: flex;
                            flex-direction: row;
                            flex-wrap: nowrap;
                            justify-content: space-around;
                            gap: 0;
                            border: none;
                            border-top: 1px solid rgba(177, 177, 177, 0.507);
                            background: var(--footer);
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
                <iframe src="../footer/privacy.html" frameborder="0" width=105% height=50px></iframe>
            </main>
        </div>

    </div>

    <script src="home.js"></script>

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
</body>
</html>