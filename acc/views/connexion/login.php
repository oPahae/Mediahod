<?php
session_start();
if(isset($_SESSION['isConnected'])){
    header('Location: ../home/home.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../assets/logo.jpeg">
    <style>
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
            height: 100vh;
            background-attachment: fixed;
            overflow: hidden;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .container h1 {
            font-size: 2em;
            margin-bottom: 30px;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }
        .input-container {
            margin-bottom: 20px;
            position: relative;
        }
        .input-container input {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        .input-container input:focus {
            background-color: rgba(255, 255, 255, 0.3);
            outline: none;
        }
        .input-container label {
            position: absolute;
            top: 15px;
            left: 20px;
            font-size: 1em;
            color: #bbb;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        .input-container input:focus + label,
        .input-container input:not(:placeholder-shown) + label {
            top: -10px;
            left: 15px;
            background-color: rgba(0, 51, 102, 0.8);
            padding: 0 5px;
            border-radius: 5px;
            color: #fff;
            font-size: 0.85em;
        }
        .login-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: #ff6347;
            color: #fff;
            font-size: 1.2em;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .login-btn:hover {
            background-color: #ff4500;
            transform: translateY(-3px);
        }
        .login-links {
            margin-top: 20px;
        }
        .login-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .login-links a:hover {
            color: #ff6347;
        }
        .login-links a.create-account {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
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
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
            animation: float 6s ease-in-out infinite;
        }
        .circle.small {
            width: 100px;
            height: 100px;
            bottom: 10%;
            right: 20%;
            animation-duration: 8s;
        }
        .circle.medium {
            width: 200px;
            height: 200px;
            top: 20%;
            left: 10%;
        }
        .circle.large {
            width: 300px;
            height: 300px;
            bottom: 20%;
            left: 50%;
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





    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="../../controllers/SignController.php" method="post">
            <div class="input-container">
                <input type="email" id="username" name="email" required placeholder="" />
                <label for="username">Email</label>
            </div>
            <div class="input-container">
                <input type="password" id="password" name="password" required placeholder=" " />
                <label for="password">Password</label>
            </div>
            <button type="submit" class="login-btn" name="login">Login</button>
        </form>
        <div class="login-links">
            <a href="forgot.php" class="forgot-password">Forgot Password?</a>
            <a href="register.php" class="create-account">Create New Account</a>
        </div>
    </div>
    <div class="decorative-elements">
        <div class="circle small"></div>
        <div class="circle medium"></div>
        <div class="circle large"></div>
    </div>




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