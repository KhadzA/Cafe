<?php
// session_start();

if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../../"); 
    exit();
}

include __DIR__ . '/../../view/menu.view.php';

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="../../image/Cafe_Logo.png" type="image/icon type">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/menu.js"></script>
    <script src="../../js/script.js"></script>
    
    <!-- <script src="../../resources/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../../resources/fontawesome-free-6.6.0-web/js/all.js"></script> -->

    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/menu.css">
    <!-- <link rel="stylesheet" href="../../resources/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../resources/fontawesome-free-6.6.0-web/css/all.css"> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>
    <div class=body>
        <!-- Header Section -->
        <div id="header">
            <div class="header_inner">
                <!-- Top Left Navbar -->
                <div class="top_left">
                    <section>
                        <a href="../../AdminDashboard">
                            <img src="../../image/cafe-alegria.png" alt="logo" id="logo">
                        </a>
                        <li class="title_section">Menu Config</li>
                    </section>
                </div>
            </div>
        </div>

        <!-- Sidebar Section -->
        <nav class="side_nav minimized">
            <div class="top_items">
                <button id="toggle-side_nav" class="toggle-btn">
                    ☰
                </button>

                <!-- Sidebar Menu Items -->
                <section class="menu-items">
                    <li id="AdminDashboard" class="AdminDashboard"><i class="fas fa-chart-bar"></i> <span>Dashboard</span></li>
                    <li id="Menu" class="Menu"><i class="fa-solid fa-clipboard-list"></i> <span>Menu</span></li>
                    <li id="MenuConfig" class="MenuConfig"><i class="fa-solid fa-sliders"></i> <span>Menu Config</span></li>
                    <li id="CreateOrders" class="CreateOrders"><i class="fas fa-cash-register"></i> <span>Create Orders</span></li>
                    <li id="Orders" class="Orders"><i class="fas fa-th-list"></i> <span>Orders</span></li>
                    <li id="manage" class="manage"><i class="fas fa-users-cog"></i> <span>Manage</span></li>
                    <li id="history" class="history"><i class="fas fa-history"></i> <span>History</span></li>
                </section>
            </div>

            <!-- Sidebar Bottom Section for Logout -->
            <section class="bottom-section">
                <li id="settings" class="settings"><i class="fas fa-cog"></i> <span>Settings</span></li>
                <li id="logout" class="logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></li>
            </section>
        </nav>

        <main class="content">
            <div class="leftSide">

                <h2>Categories</h2>
                <div class="all-category-list">
                    <ul>
 
                        <li>
                            <a href="#" id="separate" class="all-category-link" data-category-id="">All</a>
                        </li>

                        <?php foreach ($categories as $category): ?>
                                
                            <li data-category-id="<?php echo $category['category_id']; ?>">
                                <a href="#" class="all-category-link">
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </a>
                                <div class="button-group">
                                    <button onclick="document.getElementById('edit-category-modal').style.display='block'" 
                                            class="edit-category-btn" id="edit-category-btn"
                                            data-category-id="<?php echo $category['category_id']; ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <button class="delete-category-btn" 
                                            data-category-id="<?php echo $category['category_id']; ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </li>

                        <?php endforeach; ?>

                    </ul>
                </div>

            </div>

            <div class="rightSide">

                <h2>Products</h2>
                <div id="all-product-list">

                    <?php foreach ($products as $product): ?>

                        <div class="all-product-item">
                            <h4><?php echo htmlspecialchars($product['product_name']); ?></h4>
                            <div class="button-group">
                                <button 

                                    onclick="document.getElementById('edit-product-modal').style.display='block'" 
                                    class="edit-product-btn" id="edit-product-btn"
                                    data-product-id="<?php echo $product['product_id']; ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    
                                </button>

                                <button 

                                    class="delete-product-btn" 
                                    data-product-id="<?php echo $product['product_id']; ?>">
                                    <i class="fa-solid fa-trash"></i>

                                </button>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
                
            </div>

            
            <!-- Edit Category Modal Form -->
            <div id="edit-category-modal" class="modal">
                <div class="modalContent">
                    <header class="modalHeader"> 
                        <span onclick="document.getElementById('edit-category-modal').style.display='none'" class="close">&times;</span>
                        <h2>Edit Category</h2>
                    </header>
                    <div class="forms">
                        <form action="../../view/menu.view.php" method="post">
                            <input type="hidden" name="action" value="update_category">
                            <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>">
                            
                            <label for="name">Category Name:</label>
                            <input type="text" name="name" id="name" value="<?= $category['category_name'] ?>" required>
                            
                            <label for="description">Description:</label>
                            <textarea name="description" id="description"><?= $category['description'] ?></textarea>

                            <div class="middle-bottom">
                                <div class="check1">
                                    <label for="has_size">Has Size:</label>
                                    <input type="checkbox" name="has_size" id="has_size" <?= $category['has_size'] ? 'checked' : '' ?>>
                                </div>
                                <div class="checks2">
                                    <label for="has_sugar_level">Has Sugar Level:</label>
                                    <input type="checkbox" name="has_sugar_level" id="has_sugar_level" <?= $category['has_sugar_level'] ? 'checked' : '' ?>>
                                </div>
                            </div>

                            <div class="bottom">
                                <button type="submit">Update Category</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- Edit Product Modal Form -->
            <div id="edit-product-modal" class="modal">
                <div class="modalContent">
                    <header class="modalHeader"> 
                        <span onclick="document.getElementById('edit-product-modal').style.display='none'" class="close">&times;</span>
                        <h2>Edit Product</h2>
                    </header>
                    <div class="forms">
                        <form action="../../view/menu.view.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update_product">
                            <input type="hidden" name="product_id" id="edit-product-id">
                            <input type="hidden" name="category_id" id="edit-category-id">
                            <input type="hidden" name="current_image" id="edit-current-image">

                            <label for="edit-product-name">Product Name:</label>
                            <input type="text" name="name" id="edit-product-name" required>

                            <label for="edit-product-description">Description:</label>
                            <textarea name="description" id="edit-product-description"></textarea>

                            

                            
                            <div id="size-options" style="display: none;">
                                <label for="size">Size:</label>
                                <input type="text" name="sizes[]" id="edit-size">
                            </div>

                            <div id="sugar-level-options" style="display: none;">
                                <label for="sugar_level">Sugar Level:</label>
                                <input type="text" name="sugar_levels[]" id="edit-sugar-level">
                            </div>

                            <div class="img-price">

                                <label for="edit-product-image">Product Image:</label>
                                <label for="image" class="custom-file-upload" id="file-label">Choose File</label>
                                <input type="file" name="image" id="edit-product-image" accept="image/*" class="file-input">
                                <span id="file-name" class="file-name"></span> 
                                
                                <label for="edit-product-price">Price:</label>
                                <input type="number" name="price" id="edit-product-price" required>

                            </div>

                            <div class="bottom">

                                <button type="submit">Save Changes</button>

                            </div>

                            
                        </form>
                    </div>
                </div>
            </div>





        </main>
    </div>
</body>

</html>


