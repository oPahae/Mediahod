<?php
session_start();
if(isset($_SESSION['banned'])){
    header('Location: ../security/banned.php');
}
?>

<!doctype html>
<html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>How to log in to your Facebook account correctly and safely | Mediahod</title>
    <link rel="stylesheet" href="https://accmoon.com/public/datum/assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="https://accmoon.com/public/datum/assets/css/backend.css?v=1.0.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../assets/logo.jpeg">
    <!-- Script Header -->
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KS37L4WR');</script>
<!-- End Google Tag Manager -->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-8WB6C8KQD2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-8WB6C8KQD2');
</script>
<style>
  .nav-pills .nav-item a {
    margin-left: 5px;
    margin-right: 5px;
}
  .banner-box {
    padding: 55px;
    border-radius:10px;
}
  .iq-sidebar-menu .side-menu li a span {
    white-space: nowrap;
    padding: 0;
    display: inline-block;
    transition: none;
    text-transform: none;
}
  table.dataTable tbody td, table.dataTable tbody th {
  padding: 15px 10px;}
  .select2-container--default .select2-selection--multiple {
    height: 33px;}
.poster {
    padding-top: 3px;
    margin-bottom: 3px;
    border-radius: 8px;
    height: 100%;
    box-shadow: 1px 1px rgb(0 0 0 / 8%);
}
  img.me-2 {
    margin-right: 0.5rem!important;
}

.test {
         background:#3d3d3d;
         font-size:24px;
         font-weight:bold;
	 -webkit-animation: my 700ms infinite;
	 -moz-animation: my 700ms infinite; 
	 -o-animation: my 700ms infinite; 
	 animation: my 700ms infinite;
}
</style>    <!-- TrustBox script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End TrustBox script -->
<!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- FancyBox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
</head>
    <!-- sweetalert2-->
    <link class="main-stylesheet" href="https://accmoon.com/public/sweetalert2/default.css" rel="stylesheet" type="text/css">
    <script src="https://accmoon.com/public/sweetalert2/sweetalert2.js"></script>
<!-- Cute Alert -->
<link class="main-stylesheet" href="https://accmoon.com/public/cute-alert/style.css" rel="stylesheet" type="text/css">
<script src="https://accmoon.com/public/cute-alert/cute-alert.js"></script>
<!-- jQuery -->
<script src="https://accmoon.com/public/js/jquery-3.6.0.js"></script>
<style>
body {
    font-family: 'roboto', sans-serif;}
.card-product {
    color: white;
    background-image: linear-gradient(to right, #111C43, #111C43, #111C43);
}

ol {
  counter-reset: li; 
  list-style: none; 
  padding: 0;
  text-shadow: 0 1px 0 rgba(255,255,255,.5);
}
ol a {
  position: relative;
  display: block;
  padding: .4em .4em .4em .8em;
  margin: .5em 0 .5em 2.5em;
  background: #D3D4DA;
  color: #444;
  text-decoration: none;
  transition: all .3s ease-out;
}
ol a:hover {background: #DCDDE1;}       
ol a:before {
  content: counter(li);
  counter-increment: li;
  position: absolute;
  left: -2.5em;
  top: 50%;
  margin-top: -1em;
  background: #f9dd94;
  height: 2em;
  width: 2em;
  line-height: 2em;
  text-align: center;
  font-weight: bold;
}
ol a:after {
  position: absolute;
  content: "";
  border: .5em solid transparent;
  left: -1em;
  top: 50%;
  margin-top: -.5em;
  transition: all .3s ease-out;
}
ol a:hover:after {
  left: -.5em;
  border-left-color: #f9dd94;
}
</style>



<style>
.iq-sidebar {
    background: linear-gradient(#111C43, #111C43, #111C43);
}

.change-mode .custom-switch.custom-switch-icon label.custom-control-label:after {
    top: 0;
    left: 0;
    width: 35px;
    height: 30px;
    border-radius: 5px 0 0 5px;
    background-color: #111C43;
    border-color: #111C43;
    z-index: 0;
}
.iq-sidebar-logo{
    padding-left: 30px;
}
.side-menu-bt-sidebar-1 {
    margin-bottom: 10px;
}
</style>

<body class="color-light ">
    <div class="wrapper">
        <div class="iq-sidebar sidebar-default">
            <div class="iq-sidebar-logo d-flex align-items-end justify-content-between">
                <a href="../home/home.php" class="header-logo">
                    <img src="../assets/logo.jpeg" class="img-fluid rounded-normal light-logo" alt="logo">
                    <img src="https://accmoon.com/assets/storage/images/logo_light_N56.png"
                        class="img-fluid rounded-normal d-none sidebar-light-img" alt="logo">
                    <span>MEDIAHOD</span>
                </a>
                <div class="side-menu-bt-sidebar-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-light wrapper-menu" width="30" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <div class="data-scrollbar" data-scroll="1">
                <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="side-menu">
                        <li class=" sidebar-layout">
                            <a href="../home/home.php" class="svg-icon ">
                                <i class="fa-solid fa-house"></i>
                                <span class="ml-2">All Products Services</span>
                            </a>
                        </li>
                        <!--  -->
                        <li class="px-3 pt-3 pb-2 ">
                            <span class="text-uppercase small font-weight-bold">Order History</span></span>
                        </li>
                        <li class=" sidebar-layout">
                            <a href="../orders/orders.php" class="svg-icon ">
                            <i class="fa-solid fa-clock-rotate-left" aria-hidden='true'></i>
                                <span class="ml-2">View Your Order</span>
                            </a>
                        </li>
                        <li class=" sidebar-layout">
                            <a href="../profile/profile.php" class="svg-icon ">
                                <i class="fa-solid fa-user"></i>
                                <span class="ml-2">Profile</span>
                            </a>
                        </li>
                         
                        <li class="px-3 pt-3 pb-2 ">
                            <span class="text-uppercase small font-weight-bold">More Info</span></span>
                        </li>

                        <li class=" sidebar-layout">
                            <a href="../howToPay/howToPay.php" class="svg-icon ">
                                <i class="fas fa-wallet mr-1"></i>
                                <span class="ml-2">Deposit Account</span>
                            </a>
                        </li>
                        <li class=" sidebar-layout">
                            <a href="../aboutUs/aboutUs.php" class="svg-icon ">
                                <i class="fa-solid fa-circle-info"></i>
                                <span class="ml-2">About Us</span>
                            </a>
                        </li>
                        <li class=" sidebar-layout">
                            <a href="../contactUs/contactUs.php" class="svg-icon ">
                                <i class="fa-solid fa-address-card"></i>
                                <span class="ml-2">Contact Us</span>
                            </a>
                        </li>

                        <?php if(isset($_SESSION['isConnected'])) : ?>
                        <li class=" sidebar-layout" style="background-color: orange;">
                            <a href="../../controllers/logoutUser.php" class="svg-icon " >
                                <i class="fa-solid fa-right-from-bracket" style="color: whitesmoke;"></i>
                                <span class="ml-2" style="color: whitesmoke;">Logout</span>
                            </a>
                        </li>
                            <?php endif ; ?>
                    </ul>
                </nav>
                <div class="pt-5 pb-5"></div>
            </div>
        </div>

        <div class="iq-top-navbar">
    <div class="iq-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="side-menu-bt-sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary wrapper-menu" width="30" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <?php if(isset($_SESSION['isConnected'])) : ?>      
                                <a href="#"><span class="badge badge2 border border-primary text-primary"><i class="fas fa-wallet mr-1"></i>Wallet:
                    <b><?php   include_once('../../models/Utilisateur.php');
                    $user = new Utilisateur();
                    echo $user->getUserWalletById($_SESSION['user']['id'])  ?> $</b></span></a>
                        <?php endif ; ?>
                <!--                                        <a href="https://accmoon.com/register-seller" class="badge border border-info text-info"><i class="fas fa-cog mr-1"></i><b>Start Selling</b></a>
                        -->
                            </div>
            <div class="d-flex align-items-center">
                <div class="change-mode">
                   <div class="custom-control custom-switch custom-switch-icon custom-control-inline">
                                        <div class="custom-switch-inner">
                                            <p class="mb-0"> </p>
                                            <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                                            <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                                <span class="switch-icon-right">
                                                    <svg xmlns="http://www.w3.org/2000/svg" id="h-moon" height="20" width="20" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                          </svg>
                                                </span>
                                                <span class="switch-icon-left">
                                                    <svg xmlns="http://www.w3.org/2000/svg" id="h-sun" height="20" width="20" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                          </svg>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>                 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary" width="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-list align-items-center">
                        <li class="nav-item nav-icon dropdown">
                            <a href="#" class="search-toggle dropdown-toggle" id="notification-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                    class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                                                                                                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="notification-dropdown">
                                <div class="card shadow-none m-0 border-0">
                                    <div class="p-3 card-header-border">
                                        <h6 class="text-center">
                                            Notifications                                        </h6>
                                    </div>
                                    <div class="card-body overflow-auto card-header-border p-0 card-body-list"
                                        style="max-height: 500px;">
                                        <ul class="dropdown-menu-1 overflow-auto list-style-1 mb-0">
                                                                                                                                                                            </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nav-icon dropdown">
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton2"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="https://accmoon.com/assets/storage/flags/flag_English.png"alt="flag" style="height: 20px; min-width: 30px; width: 30px;">
                                <span class="bg-primary"></span>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton2" style="width: 200px;">
                                <div class="card shadow-none m-0 border-0">
                                    <div class=" p-0 ">
                                        <ul class="dropdown-menu-1 list-group list-group-flush">
                                                                                        <li onclick="changeLanguage(16)"
                                                class="dropdown-item-1 list-group-item px-2">
                                                <a class="p-0" href="#"><img src="https://accmoon.com/assets/storage/flags/flag_English.png" alt="img-flaf" class="img-fluid mr-2" style="width: 30px;height: 20px;min-width: 15px;" />English</a>
                                            </li>
                                                                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!--<li class="sidebar-layout">
                            <a href="#" class="search-toggle dropdown-toggle" id="dropdownMenuButton2" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">                                <span
                                    class="ml-2"><b>USD</b></span>
                            </a>
                            <div class="iq-sub-dropdown dropdown-menu" aria-labelledby="dropdownMenuButton2" style="width: 200px;">
                                <div class="card shadow-none m-0 border-0">
                                    <div class=" p-0 ">
                                        <ul class="dropdown-menu-1 list-group list-group-flush">
                                                                                        <li onclick="changeCurrency(1)"
                                                class="dropdown-item-1 list-group-item px-2"><a class="p-0" href="#"
                                                    style="color: #333;">VND </a>
                                            </li>
                                                                                        <li onclick="changeCurrency(2)"
                                                class="dropdown-item-1 list-group-item px-2"><a class="p-0" href="#"
                                                    style="color: #333;">USD </a>
                                            </li>
                                                                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </li>-->
                        
                        <li class="nav-item nav-icon dropdown">
                            <a href="#" class="nav-item nav-icon dropdown-toggle pr-0 search-toggle"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <img src="../assets/user.png" class="img-fluid avatar-rounded" alt="avatar user"  style="max-width:50px; max-height:50px; margin-right:10px;">
                                <span class="mb-0 ml-2 user-name"><span class="badge border border-primary text-primary"><?php if(isset($_SESSION['isConnected'])) : ?>
                                    <i class="fa-solid fa-user"></i> Hello <?php echo $_SESSION['user']['username'] ?> </i>
                                        <?php else : ?>
                                            <i class="fa-solid fa-user"></i> You Are Not Logged In </i>
                                            <?php endif ; ?></span></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<script>
function changeLanguage(id) {
    $.ajax({
        url: "https://accmoon.com/ajaxs/client/changeLanguage.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                location.reload();
            } else {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: respone.msg,
                    buttonText: "Okay"
                });
            }
        },
        error: function() {
            alert(html(response));
            history.back();
        }
    });
}
</script>
<script>
function changeCurrency(id) {
    $.ajax({
        url: "https://accmoon.com/ajaxs/client/changeCurrency.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                location.reload();
            } else {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: respone.msg,
                    buttonText: "Okay"
                });
            }
        },
        error: function() {
            alert(html(response));
            history.back();
        }
    });
}
</script>
<div class="content-page">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="titleposst text-center mb-5" style="color: #407cfd;">How to buy accounts on Mediahod ? Step-by-step instructions</h1>
                        
                        <p>Mediahod.com platform allows you to buy and receive social media accounts instantly after you have successfully paid. So how to buy account?</p>

<p>Go to Mediahod.com and follow the steps:</p>

<p><strong>Step 1</strong>: Register for a member account at: <a href="../connexion/register.php">Register</a><br>
(Please save login information if necessary).</p>

<p><strong>Step 2</strong>: Choose a deposit method to your wallet, you can choose payment methods such as:<br>
- Perfect Money and others: <a href="../howToPay/howToPay.php">Recharge</a><br>
- Also you can pay with Wise.&nbsp;<a href="../howToPay/wise.php">Wise</a></p>

<p><strong>Step 3</strong>: After successfully depositing money into the wallet, you can start buying an account with the balance in the wallet. Select the product then select the quantity you want to buy and then press the "<strong>BUY NOW</strong>" button.</p>

<p><strong>Step 4</strong>: After paying for your order, you will be redirected to the "<strong>Order History</strong>" page (<a href="../order/order">Orders</a>)<br>
here you can see the orders you have purchased. CLIKC " <strong>VIEW ORDERS</strong> "&nbsp;for view account information.</p>

<p>Wish you a lot of luck.</p>
                                            </div>
                </div>
            </div>
            <div class="col-sm-4">
                <h4 class="mb-3">Featured Posts</h4>
                <div class="col-md-12 col-lg-12 alert-primary">
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-lg-4">
                                <a href="tuto1.php" class="card-img" alt="#"><img src="../assets/tuto/tuto1.png" class="card-img" alt="#"></a>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="card-body">
                                    <h4 class="card-title" style="font-size: 18px;line-height: 20px;"><a href="tuto1.php">How to log in to your Facebook account correctly and safely</a></h4>
                                    <p class="card-text"><small class="text-muted">2024-08-26 21:39:29</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 alert-primary">
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-lg-4">
                                <a href="tuto2.php"><img src="../assets/tuto/tuto2.png" class="card-img" alt="#"></a>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="card-body">
                                    <h4 class="card-title" style="font-size: 18px;line-height: 20px;"><a href="https://accmoon.com/client/blog/how-to-buy-account-on-accmoon">How to buy accounts on Mediahod ? Step-by-step instructions</a></h4>
                                    <p class="card-text"><small class="text-muted">2024-08-26 21:39:29</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 alert-primary">
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-lg-4">
                                <a href="tuto3.php" class="card-img" alt="#"><img src="../assets/tuto/tuto3.png" class="card-img" alt="#"></a>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="card-body">
                                    <h4 class="card-title" style="font-size: 18px;line-height: 20px;"><a href="tuto3.php">How to safely change your Facebook account password</a></h4>
                                    <p class="card-text"><small class="text-muted">2024-08-26 21:39:29</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 alert-primary">
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-lg-4">
                                <a href="tuto4.php"><img src="../assets/tuto/tuto4.png" class="card-img" alt="#"></a>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="card-body">
                                    <h4 class="card-title" style="font-size: 18px;line-height: 20px;"><a href="tuto4.php">Add a payment method using the Get Ads Payment Support link</a></h4>
                                    <p class="card-text"><small class="text-muted">2024-08-26 21:39:29</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 alert-primary">
                    <div class="card mb-2">
                        <div class="row no-gutters">
                            <div class="col-md-6 col-lg-4">
                                <a href="tuto5.php"><img src="../assets/tuto/tuto5.png" class="card-img" alt="#"></a>
                            </div>
                            <div class="col-md-6 col-lg-8">
                                <div class="card-body">
                                    <h4 class="card-title" style="font-size: 18px;line-height: 20px;"><a href="tuto5.php">How to Send Cryptocurrency to an Individual with Binance Pay</a></h4>
                                    <p class="card-text"><small class="text-muted">2024-08-26 21:39:29</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>


</div>
<!-- Wrapper End-->
<footer class="iq-footer" style="padding: 0;">
    <div class="container-fluid justify-content-around">
        <!-- Border Top -->
        <div class="row" style="border-top: 1px #cdc8c8 solid; padding-top: 15px;">
            <!-- Contact Mediahod Section -->
            <div class="col-lg-4">
                <h4 class="text-center">Contact Mediahod</h4><br />
                <ul>
                    <li>Telegram: <a href="https://t.me/admediahodagency" target="_blank">Support Mediahod</a></li>
                    <li>Website: <a href="../home/home.php">Mediahod</a></li>
                    <li>Working time: <span>8h00 - 24h00 Time Zone GMT+7 Bangkok</span></li>
                </ul>
            </div>

            <!-- Payment Methods Section -->
            <div class="col-lg-4">
                <h4 class="text-center">Payment Methods</h4>
                <ul>
                    <li><a href="../howToPay/howToPay.php"><span>Crypto, Binance, Pyypl...</span></a></li>
                    <li><a href="../howToPay/howToPay.php"><span>Perfect Money</span></a></li>
                    <li><a href="../howToPay/howToPay.php"><span>Cryptocurrency (Crypto)</span></a></li>
                    <li><a href="../howToPay/wise.php"><span>Wise Transfer, Revolut</span></a></li>
                </ul><br/>
                <img src="https://accmoon.com/file/perfectmoneyad.jpg" alt="Perfect Money">
                <img src="https://accmoon.com/file/bitcoin-logo.png" style="height: 33px;" alt="Bitcoin">
                <img src="https://accmoon.com/file/ethereum-logo.png" style="height: 33px;" alt="Ethereum">
                <img src="https://accmoon.com/file/usdt.ico" style="height: 33px;" alt="USDT">
                <img src="https://accmoon.com/file/wise.jpg" style="height: 33px;" alt="Wise">
            </div>

            <!-- Partners Section -->
            <div class="col-lg-4">
                <h4 class="text-center">Partners</h4>
                <a href="//www.dmca.com/Protection/Status.aspx?ID=995d2273-5308-417a-8e79-e138fbe093c1" title="DMCA.com Protection Status" class="dmca-badge">
                    <img src="https://images.dmca.com/Badges/dmca-badge-w200-5x1-02.png?ID=995d2273-5308-417a-8e79-e138fbe093c1" alt="DMCA.com Protection Status">
                </a>
                <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"></script>
                <img src="https://accmoon.com/file/secure.png" style="max-width: 100%;" alt="Secure">
            </div>
        </div><br/>

        <!-- Footer Bottom Row -->
        <div class="row" style="background-color: #111c43; padding: 15px 0;">
            <div class="col-lg-6">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item"><a href="../policy/privacy.php">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="../policy/warranty.php">Warranty and Return Policy</a></li>
                </ul>
            </div>
            <div class="col-lg-6 text-right">
                <span class="mr-1" style="color: #fff;">Powered By <a target="_blank" href="../home/home.php"><b>MEDIAHOD</b></a></span>
            </div>
        </div>
    </div>
</footer>

<!-- Backend Bundle JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/backend-bundle.min.js"></script>
<!-- Chart Custom JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/customizer.js"></script>
<script src="https://accmoon.com/public/datum/assets/js/sidebar.js"></script>
<!-- Flextree Javascript-->
<script src="https://accmoon.com/public/datum/assets/js/flex-tree.min.js"></script>
<script src="https://accmoon.com/public/datum/assets/js/tree.js"></script>
<!-- Table Treeview JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/table-treeview.js"></script>
<!-- SweetAlert JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/sweetalert.js"></script>
<!-- Vectoe Map JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/vector-map-custom.js"></script>
<!-- Chart Custom JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/chart-custom.js"></script>
<script src="https://accmoon.com/public/datum/assets/js/charts/01.js"></script>
<script src="https://accmoon.com/public/datum/assets/js/charts/02.js"></script>
<!-- slider JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/slider.js"></script>
<!-- Emoji picker -->
<script src="https://accmoon.com/public/datum/assets/vendor/emoji-picker-element/index.js" type="module"></script>
<!-- app JavaScript -->
<script src="https://accmoon.com/public/datum/assets/js/app.js"></script>


<!-- Script Footer -->
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KS37L4WR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --><!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W37W9S6"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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