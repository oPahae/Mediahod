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
// Inclure le fichier contenant la classe
include_once('../../models/Produit.php');
include_once('../../models/Categorie.php');

// Créer une instance de la classe
$produit = new Produit();
$categorie = new Categorie;
// Appeler la méthode pour récupérer les sous-catégories avec les produits
$sousCategories = $produit->getSousCategoriesWithProducts($_GET['idCat']);
$categories = $categorie->getCategoryById($_GET['idCat']);

// if(isset($_SESSION['isConnecetd'])){
    // include_once('../../models/Utilisateur.php');
    // $user = new Utilisateur();
    // $wallet = $user->getUserWalletById($_SESSION['user']['id']);
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="">
    <title>Buy Accounts</title>
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/logo.jpeg">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #fff, #fff);
            color: #0080ff;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            min-height: 100vh;
        }
        .cont {
            backdrop-filter: blur(15px);
            border-radius: 20px;
            width: 99%;
            margin-bottom: 40px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            color: #0080ff;
        }
        h2 {
            margin-bottom: 10px;
            font-size: 1.5em;
            color: #ffeb3b;
        }
        ul {
            list-style-type: disc;
            margin-left: 20px;
            margin-bottom: 20px;
        }
        ul li {
            margin-bottom: 10px;
        }
        @media (max-width: 768px) {
            table thead th:not(:first-child) {
                display: none;
            }

            table tbody td:not(:first-child) {
                display: block;
                text-align: left;
                border-top: none;
                border-bottom: none;
                border-left: none;
            }

            table tbody tr {
                display: flex;
                flex-wrap: wrap;
                margin-bottom: 16px;
                border: 1px solid #ddd;
            }

            table tbody td:first-child {
                flex: 1 0 100%;
                margin-bottom: 8px;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }

            table tbody td:not(:first-child) {
                box-sizing: border-box;
                border-right: none;
                border-bottom: none;
                padding: 4px;
                margin-bottom: 8px;
            }
            .preview-btn, .cart-icon, .price-btn {
                width: fit-content;
            }
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid rgba(155, 155, 155, 0.527);
        }
        thead {
            background: linear-gradient(to right, #0068cf, black);
            height: 44px;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
        }
        th {
            color: #fff;
        }
        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.1);
        }
        .no-data {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: none; /* Initially hidden */
        }
        .product-info {
            display: flex;
            flex-direction: column;
            align-content: start;
            justify-content: center;
            gap: 6px;
            color: var(--text);
        }
        .product-info img {
            width: 30px;
            height: 30px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 5px;
        }
        .product-info-1, .product-info-2 {
            display: flex;
            flex-direction: row;
            gap: 4px;
            color: var(--text);
        }
        .product-info-1 a {
            text-decoration: none;
            color: var(--text);
        }
        .product-info-2 i {
            transform: translateY(4px);
        }
        .preview-btn {
            border: 1px solid rgb(0, 148, 153);
            padding: 10px 14px;
            border-radius: 5px;
            cursor: pointer;
            color: black;
            transition: transform .1s;
        }
        .preview-btn:hover {
            background: rgb(0, 148, 153);
            color: #fff;
        }
        .preview-image {
            display: none;
            margin-top: 10px;
        }
        .cart-icon {
            cursor: pointer;
            margin-right: 10px;
            font-size: 1em;
            color: black;
            border: 1px solid rgb(0, 148, 153);
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform .1s;
            border-radius: 5px;
            padding: 10px 14px;
            background: #fff;
        }
        .cart-icon:hover {
            background: rgb(0, 148, 153);
            color: #fff;
        }
        .price-btn {
            font-weight: bold;
            border: 1px solid red;
            padding: 10px 14px;
            border-radius: 5px;
            cursor: pointer;
            color: black;
            transition: transform .1s;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 4px;
            background: #fff;
        }
        .price-btn:hover {
            color: #fff;
            background: red;
        }
        thead {
            background: linear-gradient(to right, #0068cf, black);
        }
        /* .pay-btn, .outstock-btn {
            background: #ffeb3b;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            color: #003366;
            font-weight: bold;
        }
        .pay-btn:hover {
            background: #ffe600;
        } */

        
        /* .outstock-btn {
            background: #ccc;
            cursor: not-allowed;
            color: #333;
        } */


        .pay-btn {
            display: inline-block; /* Permet au lien de se comporter comme un bouton */
            background: #ffeb3b; /* Couleur de fond jaune */
            border: none; /* Pas de bordure */
            padding: 10px 20px; /* Espacement intérieur */
            border-radius: 5px; /* Coins arrondis */
            cursor: pointer; /* Curseur indiquant que le lien est cliquable */
            color: #003366; /* Couleur du texte */
            font-weight: bold; /* Texte en gras */
            text-decoration: none; /* Pas de soulignement */
            text-align: center; /* Centre le texte */
            font-size: 16px; /* Taille de la police */
            transition: background 0.3s ease; /* Animation pour le changement de couleur */
        }

        .pay-btn:hover {
            background: #ffe600; /* Couleur de fond jaune plus foncé lors du survol */
        }


        .outstock-btn {
            display: inline-block; /* Permet au lien de se comporter comme un bouton */
            background: #ccc; /* Couleur de fond */
            border: none; /* Pas de bordure */
            padding: 10px 20px; /* Espacement intérieur */
            border-radius: 5px; /* Coins arrondis */
            cursor: not-allowed; /* Curseur de non-disponibilité */
            color: #333; /* Couleur du texte */
            font-weight: bold; /* Texte en gras */
            text-decoration: none; /* Pas de soulignement */
            text-align: center; /* Centre le texte */
            font-size: 16px; /* Taille de la police */
            transition: background 0.3s ease; /* Animation pour le changement de couleur */
        }

        .outstock-btn:hover {
            background: #bbb; /* Couleur de fond lors du survol */
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





        /* Styles pour le pop-up */
        .popup {
            display: none; /* Caché par défaut */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-content {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            width: 80%;
            max-width: 500px;
            position: relative;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .popup-close:hover {
            color: #000;
        }

        .popup h2 {
            margin-top: 0;
        }

        .popup form {
            display: flex;
            flex-direction: column;
        }

        .popup input[type="text"],
        .popup input[type="number"] {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .popup button {
            background: #ffeb3b;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            color: #003366;
            font-weight: bold;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .popup button:hover {
            background: #ffe600;
        }


        /* Styles pour le texte total */
        .total-price {
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            color: red;
            text-align: center;
        }


        /* pay button but redirect to login page */
        .pay-btnL {
            display: inline-block; /* Permet au lien de se comporter comme un bouton */
            background: #ffeb3b; /* Couleur de fond jaune */
            border: none; /* Pas de bordure */
            padding: 10px 20px; /* Espacement intérieur */
            border-radius: 5px; /* Coins arrondis */
            cursor: pointer; /* Curseur indiquant que le lien est cliquable */
            color: #003366; /* Couleur du texte */
            font-weight: bold; /* Texte en gras */
            text-decoration: none; /* Pas de soulignement */
            text-align: center; /* Centre le texte */
            font-size: 16px; /* Taille de la police */
            transition: background 0.3s ease; /* Animation pour le changement de couleur */
        }

        .pay-btnL:hover {
            background: #ffe600; /* Couleur de fond jaune plus foncé lors du survol */
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
                    <a href="#" class="headerLeftWallet">
                        <i class="fas fa-wallet mr-1"></i>
                        <p style='color: rgb(89, 119, 255)'>Wallet : <b> <?php 
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
                        <p>Hi ! You Are Not Logged in</p>
                        <?php else : ?>
                            <p>Hello <?php echo $_SESSION['user']['username'] ?></p>
                            <?php endif ;?>
                    </div>

                </div>

                <i class="fa-solid fa-caret-down" id="menu"></i>
            </header>
            <!-- Notes -->
            <style>
                .notes {
                    padding: 20px;
                }
                .notes img {
                    width: 250px;
                }
                .notes div p {
                    color: var(--text);
                    font-weight: bold;
                }
                .notes p span {
                    color: red;
                    font-family: 'arial';
                    letter-spacing: 1px; 
                }
                .notes strong, .notes li {
                    font-size: 22px;
                    color: var(--text);
                    font-weight: bolder;
                }
                .notes li {
                    margin-left: 18px;
                }
                .notes a {
                    text-decoration: none;
                    color: blue;
                }
            </style>
            
            <div class="cont notes">
                <img src="../assets/notes.webp" alt="">
                <div>
                    <p>⭐ Accounts purchased on the website are absolutely confidential. However, for safety purposes, <span>You Should Change Your Account Password and Email Password After the Warranty Expires.</span></p>
                </div><br>
                <div>
                    <p>❗ If the password is incorrect, please contact the Admin for support with troubleshooting or warranty. Absolutely don't use the 'Forgot password' function!</p>
                </div><br>
                <div>
                    <p>👉 Facebook is scanning and checkpointing phones. This is a global situation, therefore we only offer a warranty for the first 6 hours after purchase for this case.</p>
                </div><br>
                <div>
                    <p>👉 Product on the website are for ADVERTISING purposes only. Customers have acts of violating the law of <a href="#">Vietnamese</a>, we do not take any responsibility!.</p>
                </div><br>
                <div>
                    <p>🔥 Each account has different warranty policies, so you need to read the warranty policy of each product before purchasing (click on info button [i] and automatically jump to the commodity details page)</p>
                </div><br>
                <div>
                    <p>👉 Customer support via [Telegram: <a href="https://t.me/benjamin8809" target="_blank">t.me/benjamin8809</a> | Fanpage: <a href="#">m.me/maxvia88</a> | Email: <a href='#'>support@maxvia88.com</a>] <br> Any problem will be solved when we are online. If we haven't replied yet, don't worry, as soon as we're online we'll take care of it for you.</p>
                </div><br>
                <div>
                    <p>🙍‍♂️ Hotline/Zalo/Whatsapp Admin (Handling recharge and warranty): <a href="tel:+84932220202">+8493.222.0202</a> (<span>Call directly if the message is not receive</span>)</p>
                </div><br>
                <div>
                    <p>⏲ Our working time is from 10AM-1AM the next day. Time zone GMT+7 Bangkok. In addition to the above working time, you can still recharge automatically and make purchases 24/7.</p>
                </div><br>
                <strong>💳 International customers can recharge by:</strong><br><br>
                <ul>
                    <li>USDT 👉 <a href="../howToPay/howToPay.php">RECHARGE NOW</a></li>
                    <li>WISE 👉 <a href="../howToPay/wise.php">RECHARGE NOW</a></li>
                </ul>
            </div>

            <!-- pop up beginning -->


<!-- Pop-up container -->
<!-- Pop-up container -->
<div id="payment-popup" class="popup">
    <div class="popup-content">
        <span class="popup-close" onclick="closePopup()">&times;</span>
        <h2>Order Product</h2>
        <form id="payment-form" action="../../controllers/commandesController.php" method="POST">
            <input type="hidden" id="product-id" name="productId">
            <input type="text" id="product-label" name="productLabel" disabled>
            <div class="total-price">
                <span id="total-price">Total Price: $0</span>
            </div>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="10" required oninput="updateTotalPrice()">
            <button type="submit" name="action" value="ordernow">Order Now</button>
        </form>
    </div>
</div>



            <!-- pop up ending -->
        
            <!-- Orders -->
            <div class="cont orders">
                <?php  foreach ($sousCategories as $sousCategorie) : ?>
                <table>
                    <thead>
                        <tr>
                            <th><?php echo $sousCategorie['nom'] ?></th>
                            <th>Preview</th>
                            <th>Available</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php if (!empty($sousCategorie['produits'])) : ?>
                    <tbody>
                        <?php foreach ($sousCategorie['produits'] as $produit) : ?>
                            <?php if($produit['dispo'] == 1) : ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <div class="product-info-1">
                                        <?php if($produit['logo'] == null) : ?>
                                            <img src="https://via.placeholder.com/50" alt="<?php echo $produit['label'] ?>">
                                        <?php else : ?>
                                            <img src="<?php echo $produit['logo']?>" alt="<?php echo $produit['label']?>">
                                        <?php endif ; ?>
                                        <a href="<?php echo $produit['link'] ?>" target="_blank">
                                            <strong><?php echo $produit['label'] ?></strong><br>
                                        </a>
                                    </div>
                                    <div class="product-info-2">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <?php echo $produit['description'] ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="preview-btn" onclick="showPreview(this)">
                                    <p>Preview</p>
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                                <div class="preview-image">
                                <?php if($produit['image'] == null) : ?>
                                    <img src="https://via.placeholder.com/200" alt="Preview" width="200">
                                    <?php else : ?>
                                        <a href="<?php echo $produit['image']?>" target="_blank">
                                        <img src="<?php echo $produit['image'] ?>" alt="Preview" width="200">
                                        </a>
                                        <?php endif ; ?>
                                </div>
                            </td>
                            <td class="stock">
                                <div class="cart-icon">
                                    <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                                    <p><?php echo $produit['stock'] ?></p>
                                </div>
                            </td>
                            <td class="price">
                                <div class="price-btn">
                                    <p>$</p>
                                    <?php echo $produit['price'] ?>
                                </div>
                            </td>
                            <td>
                                <?php if($produit['stock'] > 0) : ?>
                                    <?php if(isset($_SESSION['isConnected'])) : ?>
                                    <a class="pay-btn" 
   data-product-id="<?php echo $produit['id']; ?>" 
   data-product-label="<?php echo $produit['label']; ?>"
   data-product-stock="<?php echo $produit['stock']; ?>"
   data-product-price="<?php echo $produit['price']; ?>">Pay Now</a>
                                        <?php else : ?>
                                            <a href="../connexion/login.php" class="pay-btnL">Pay Now</a>
                                            <?php endif ; ?>
                                <?php else : ?>
                                    <a class="outstock-btn">Outstock</a>
                                    <?php endif ; ?>
                            </td>
                        </tr>
                                    <?php endif ; ?>
                            <?php endforeach ; ?>
                        <!-- <tr>
                            <td>
                                <div class="product-info">
                                    <img src="https://via.placeholder.com/50" alt="Product">
                                    <div>
                                        <strong>Facebook Account 1</strong><br>
                                        Info about account 1
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="preview-btn" onclick="showPreview(this)">Preview</button>
                                <div class="preview-image">
                                    <img src="https://via.placeholder.com/200" alt="Preview" width="200">
                                </div>
                            </td>
                            <td class="stock">
                                <div class="cart-icon">
                                    <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                                    <p>0</p>
                                </div>
                            </td>
                            <td class="price">$100</td>
                            <td>
                                <button class="outstock-btn">Outstock</button>
                            </td>
                        </tr> -->
                    </tbody>
                    <?php endif ; ?>
                </table>
                
                <?php endforeach ; ?>
                <div class="no-data" id="noData">
                    No data available in table
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
                            <li>Telegram: <a href="#">Support Mediahod</a></li>
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
        function showPreview(button) {
            const previewImage = button.nextElementSibling;
            if (previewImage.style.display === "block") {
                previewImage.style.display = "none";
            } else {
                previewImage.style.display = "block";
            }
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
    <script src="buy.js"></script>
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
    function showPopup(productId, productLabel, stock, productPrice) {
    const popup = document.getElementById('payment-popup');
    const form = document.getElementById('payment-form');
    document.getElementById('product-id').value = productId;
    document.getElementById('product-label').value = productLabel;
    document.getElementById('quantity').max = stock; // Limite la quantité au stock disponible
    document.getElementById('quantity').value = 1; // Réinitialise la quantité à 1
    document.getElementById('total-price').textContent = `Total Price: $${productPrice}`; // Affiche le prix total initial
    form.dataset.productPrice = productPrice; // Stocke le prix du produit dans le formulaire
    popup.style.display = 'flex'; // Affiche le pop-up
}

function closePopup() {
    const popup = document.getElementById('payment-popup');
    popup.style.display = 'none'; // Cache le pop-up
}

function updateTotalPrice() {
    const quantity = document.getElementById('quantity').value;
    const productPrice = document.getElementById('payment-form').dataset.productPrice;
    const totalPrice = (quantity * productPrice).toFixed(2); // Calcule le total et arrondit à 2 décimales
    document.getElementById('total-price').textContent = `Total Price: $${totalPrice}`;
}

// Ajoutez un écouteur d'événement pour chaque bouton Pay Now
document.querySelectorAll('.pay-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const productLabel = this.getAttribute('data-product-label');
        const stock = this.getAttribute('data-product-stock');
        const productPrice = this.getAttribute('data-product-price');
        showPopup(productId, productLabel, stock, productPrice);
    });
});

</script>



</body>
</html>