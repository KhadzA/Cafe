<?php

if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../../"); 
    exit();
}

include 'view/menu.view.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Overview</title>
    <link rel="icon" href="../../image/Cafe_Logo.png" type="image/icon type">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/script.js"></script>
    <script src="../../js/menu.js"></script>
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
                        <li class="title_section">Menu Overview</li>
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
                    <li id="History" class="History"><i class="fas fa-history"></i> <span>History</span></li>
                </section>
            </div>

            <!-- Sidebar Bottom Section for Logout -->
            <section class="bottom-section">
                <li id="settings" class="settings"><i class="fas fa-cog"></i> <span>Settings</span></li>
                <li id="logout" class="logout"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></li>
            </section>
        </nav>

        <main class="content">
            <div class="topLeft">
                <h2>Create Category</h2>
                <div class="forms">
                    <form method="POST" action="../../view/menu.view.php">
                        <input type="hidden" name="action" value="create_category">
                        <div class="form-group-input">
                            <label for="name">Category Name</label>
                            <input type="text" name="name" id="name" required>
                            <label for="description">Description</label>
                            <textarea name="description" id="description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="has_size"> Has Size
                            </label>
                            <label>
                                <input type="checkbox" name="has_sugar_level"> Has Sugar Level
                            </label>
                        </div>
                        <div class="createBtn">
                            <button type="submit">Create Category</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="topRight">

                <h2>Create Product</h2>
                <form method="POST" action="../../view/menu.view.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create_product">

                    <div class="createProd">
                        <div class="top-row">
                            <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" required>
                                    <?php foreach ($categories as $category): ?>
                                        <option 
                                            value="<?php echo $category['category_id']; ?>"
                                            data-has-size="<?php echo $category['has_size']; ?>"
                                            data-has-sugar-level="<?php echo $category['has_sugar_level']; ?>"
                                        >
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>

                                    <?php endforeach; ?>
                                </select>


                            <label for="name">Product Name:</label>
                            <input type="text" name="name" id="name" required>
                        </div>


                        <div class="middle-row">
                            <label for="image">Product Image:</label>
                            <label for="image" class="custom-file-upload" id="file-label">Choose File</label>
                            <input type="file" name="image" id="image" accept="image/*" class="file-input">
                            <span id="file-name" class="file-name"></span> 
                            
                            <label for="description">Description:</label>
                            <textarea name="description" id="description"></textarea>
                        </div>


                        <div class="bottom-row" id="size-options" style="display: none;">
                            
                            <div class="sizeField">
                                <label for="sizes">Size Options:</label>
                                <div class="size-group">
                                    <input type="text" name="sizes[0][size]" placeholder="Size (e.g., Small)">
                                    <input type="number" name="sizes[0][price_modifier]" placeholder="Price Modifier">
                                </div>
                            </div>
                        </div>


                        <div class="bottom-row" id="sugar-level-options" style="display: none;">
                            <div class="sugarField">
                                <label for="sugar_levels">Sugar Levels:</label>
                                <input type="number" name="sugar_levels[]" placeholder="Sugar Level (e.g., 25)">
                            </div>
                        </div>


                        <div class="price-row">
                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" required>
                        </div>

                    </div>

                    <div class="createBtn">
                        <button type="submit">Create Product</button>
                    </div>
                </form>
                
            </div>


            <div class="bottomLeft">
                <h2>Categories</h2>
                <div class="category-list">
                    <ul>
                        <li><a href="#" class="category-link" data-category-id="">All</a></li>
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="#" class="category-link" data-category-id="<?php echo $category['category_id']; ?>">
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>


            <div class="bottomRight">
                <h2>Products</h2>
                <div id="product-list">
                    
                </div>
            </div>

        </main>
    </div>
</body>

</html>


