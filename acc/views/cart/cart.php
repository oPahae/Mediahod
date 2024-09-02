<?php
session_start();
if(!isset($_SESSION['isConnected'])){
    header('Location: ../connexion/login.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/sidebar.css">
    <link rel="stylesheet" href="home.css">
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
            color: #fff;
            display: flex;
            justify-content: center;
        }
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .cart {
            width: 100%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
        }
        #validate {
            background-color: #1e90ff;
            padding-block: 10px;
            padding-inline: 20px;
            color: #fff;
            font-weight: bold;
            font-size: 20px;
            border: none;
            border-radius: 8px;
        } #validate:hover {
            background-color: #003366;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            text-align: center;
            color: #1e90ff;
        }
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 20px;
            background: #003366;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .cart-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .item-info {
            display: flex;
            align-items: center;
            flex: 1;
            min-width: 200px;
        }
        .item-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            overflow: hidden;
            margin-right: 20px;
            border: 2px solid #fff;
        }
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .item-name {
            font-size: 1.5em;
            color: #fff;
        }
        .item-price {
            font-size: 1.2em;
            color: yellow;
            margin-left: 20px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            margin-top: 10px;
            flex-shrink: 0;
        }
        .quantity-control input {
            width: 50px;
            padding: 10px;
            text-align: center;
            font-size: 1.2em;
            border-radius: 10px;
            border: 2px solid #fff;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            margin: 0 10px;
        }
        .quantity-control button {
            background: #1e90ff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .quantity-control button:hover {
            background: #004080;
        }
        .remove-icon {
            color: #ff4c4c;
            font-size: 1.5em;
            cursor: pointer;
            transition: 0.3s ease;
            margin-top: 10px;
            margin-left: 20px;
        }
        .remove-icon:hover {
            color: #ff1c1c;
            transform: rotate(360deg);
        }
        .summary-container {
            background: rgb(10, 10, 10);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 10px 20px rgba(0, 51, 102, 0.2);
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .summary-container h2 {
            margin-bottom: 15px;
            font-size: 1.8em;
            color: #ffeb3b;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        .summary-products {
            margin-bottom: 15px;
        }
        .summary-product {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        .summary-total {
            font-size: 1.4em;
            text-align: right;
            color: #ffeb3b;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }
            .item-info {
                margin-bottom: 10px;
                flex-direction: column;
                align-items: flex-start;
            }
            .item-image {
                margin-right: 0;
                margin-bottom: 10px;
                width: 60px;
                height: 60px;
            }
            .item-name {
                font-size: 1.3em;
            }
            .item-price {
                font-size: 1em;
                margin-left: 0;
            }
            .quantity-control input {
                width: 40px;
                font-size: 1em;
            }
            .quantity-control button {
                padding: 8px 12px;
            }
            .remove-icon {
                font-size: 1.3em;
            }
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



    </style>
</head>
<body>
    <div class="container">
        <!-- sidebar -->
        <div class="sidebar">
            <a class="sidebarHeader" href="../home/home.php">
                <img src="../assets/logo1.png" alt="logo">
                <p>ACCMOON</p>
            </a>

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
                    <a class="sidebarElement" href="../cart/cart.php">
                        <i class="fa fa-cart-arrow-down"></i>
                        <p>Cart</p>
                    </a>
                    <a class="sidebarElement" href="../profile/profile.php">
                        <i class="fa-solid fa-user"></i>
                        <p>Profile</p>
                    </a>
                </fieldset>

                <fieldset>
                    <legend>MORE INFOS</legend>
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
                <?php if(!isset($_SESSION['isConnected'])) : ?>
                    <i class="fa-solid fa-bars" id="openSidebar"></i>
                    <a href="../connexion/login.php" class="headerLeftLoginRegister">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <p>Login</p>
                    </a>
                    <a href="../connexion/register.php" class="headerLeftLoginRegister">
                        <i class="fa-solid fa-user-plus"></i>
                        <p>Sign up</p>
                    </a>
                    <!-- <a href="" class="headerLeftWallet">
                        <i class="fas fa-wallet mr-1"></i>
                        <p>Wallet : <b> $${wallet}.00 </b></p>
                    </a> -->
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
            <!-- cart -->
            <div class="cart">
                <h1>Your Cart</h1>
        
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/80" alt="Product Image">
                        </div>
                        <div>
                            <span class="item-name">Product1</span>
                            <span class="item-price">$200</span>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button onclick="decrementQuantity(this)">-</button>
                        <input type="number" value="1" min="1">
                        <button onclick="incrementQuantity(this)">+</button>
                    </div>
                    <span class="remove-icon" onclick="removeItem(this)">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                </div>
        
                <div class="cart-item">
                    <div class="item-info">
                        <div class="item-image">
                            <img src="https://via.placeholder.com/80" alt="Product Image">
                        </div>
                        <div>
                            <span class="item-name">Product2</span>
                            <span class="item-price">$200</span>
                        </div>
                    </div>
                    <div class="quantity-control">
                        <button onclick="decrementQuantity(this)">-</button>
                        <input type="number" value="1" min="1">
                        <button onclick="incrementQuantity(this)">+</button>
                    </div>
                    <span class="remove-icon" onclick="removeItem(this)">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                </div>

                <!-- Summary Div -->
                <div class="summary-container">
                    <h2>Summary</h2>
                    <div class="summary-products">
                        <!-- Each product summary -->
                        <div class="summary-product">
                            <span class="product-name">Product 1</span>
                            <span class="product-price">$20.00</span>
                            <span class="product-quantity">x2</span>
                        </div>
                        <div class="summary-product">
                            <span class="product-name">Product 2</span>
                            <span class="product-price">$15.00</span>
                            <span class="product-quantity">x1</span>
                        </div>
                        <!-- Add more products as needed -->
                    </div>
                    <div class="summary-total">
                        <strong>Total:</strong> <span>$55.00</span>
                    </div>
                    <button id="validate">Validate</button>
                </div>

            </div>
        </div>

    </div>

    <script src="cart.js"></script>
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