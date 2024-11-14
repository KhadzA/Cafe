<?php
// session_start();

// Check if user is authenticated and is an admin
if (!isset($_SESSION['user_id']) && $_SESSION['role'] !== 'admin') {
    header("Location: ../../"); 
    exit();
}

include 'view/manageUser.view.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="icon" href="../../image/Cafe_Logo.png" type="image/icon type">

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/script.js"></script>
    <script src="../../js/manageUser.js"></script>
    <!-- <script src="../../resources/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="../../resources/fontawesome-free-6.6.0-web/js/all.js"></script> -->

    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/manageUser.css">
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
                        <li class="title_section">Manage Users</li>
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
                    <li id="Manage" class="Manage"><i class="fas fa-users-cog"></i> <span>Manage</span></li>
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
            <div class="userBox">

                <?php if (!empty($users)): ?>
                    <div class="userBox">
                        <?php foreach ($users as $user): ?>
                            <div class="user-container">
                                <div class="userDetail">
                                    <p class="mainDetail">User: <?php echo htmlspecialchars($user['username']); ?></p>
                                    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
                                    <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
                                </div>
                                <div class="userActions">
                                    <button class="edit-user" data-user-id="<?php echo $user['user_id']; ?>" data-username="<?php echo $user['username']; ?>">Edit</button>
                                    <button class="delete-user" data-user-id="<?php echo $user['user_id']; ?>">Delete</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No users found.</p>
                <?php endif; ?>

                <!-- Modal for Editing User -->
                <div id="editUserModal" class="modal">
                    <div class="modalContent">
                        <h2>Edit User</h2>
                        <form id="editUserForm">
                            <input type="hidden" id="userId" name="user_id">
                            <label for="newUsername">New Username:</label>
                            <input type="text" id="newUsername" name="username" required>
                            
                            <label for="newPassword">New Password:</label>
                            <input type="password" id="newPassword" name="password">
                            
                            <button type="submit">Update User</button>
                            <button type="button" id="closeModal">Cancel</button>
                        </form>
                    </div>
                </div>


            </div>
        </main>
    </div>
</body>

</html>
