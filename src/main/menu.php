<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../src/styles/style.css">
    <link rel="stylesheet" href="../src/styles/menu.css">
    <link rel="stylesheet" href="../src/styles/fontawesome-free-5.15.4-web/css/all.css">
    <script src="../src/js/jquery-3.5.1.min.js"></script>
    <script src="../src/js/script.js"></script>
    <script src="../src/js/menu.js"></script>
    <title>POS</title>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../src/img/Cafe_Logo.png" alt="logo" id="logo"></li>
                <li class="search"><input type="search" name="search" placeholder="Seach products..." id="search"
                       ><label for="search"><i class="fas fa-search"></i></label>
                </li>
            </section>
            <section>
                <li class="first">r</li>
                <li class="second">f</li>
                <li>
                    <a id="signout" 
                        href="../../logout.php" 
                        class="fas fa-sign-out-alt" 
                    >
                    </a>
                </li>
            </section>
        </div>
    </div>
    <div class="outwrap">

        <div class="side_nav">
            <div class="side_nav2d">
                <div class="inner_side_nav">
                    <li id="dashBoard" >
                        <div class="textdp"><i class="fas fa-chart-pie"></i>Dashboard</div>
                    </li>
                    <li id="cashier" class="on_select">
                        <div class="bgsect"></div>
                        <div class="textdp"><i class="fas fa-home"></i>Cashier</div>
                    </li>
                    <li id="reports">
                        <div class="textdp"><i class="fas fa-file-medical-alt"></i>Reports</div>
                    </li>
                    <li id="myproducts">
                        <div class="textdp"><i class="fas fa-hamburger"></i>Products</div>
                    </li>

                    <li id="history">
                        <div class="textdp"><i class="fas fa-history"></i>History</div>
                    </li>
                </div>
                <div class="inner_side_nav_settings">
                    <li id="settings">
                        <div class="textdp"><i class="fas fa-cog"></i>Settings</div>
                    </li>
                </div>

            </div>
        </div>
        <div class="middle_side">

            <div class="products">
                <div class="category_cont">


                    <div class="category_nav">
                        <div class="category_nav_inner">

                            <li class="prod_nav">All</li>
 
                        </div>
                        <button id="allcategory_open"><img src="../image/seemore.png" alt=""></button>
                    </div>
                </div>
                <div class="products_content">
                    <!-- <ol>
                        <li><img src="../src/img/theme.png" alt="item"></li>
                        <li>
                            <h5>Beef patty asfasdewsd sad</h5>
                            <h4><b>₱4544</b></h4>
                        </li>
                    </ol> -->

                </div>
            </div>
            <div class="counting">
                <!-- <div class="counting_header"></div> -->
                 <div class="counter-header">
                    <li><div></div>Cart</li>
                    <li><i id="removeAllFromCart" class="fas fa-plus" title="Remove All"></i></li>
                 </div>
                <div id="counter_body">

    
 
                    
                </div>
                <div class="totaling">
                    <section>
                        <!-- <li>Payment Method</li>
                        <li>
                            <select name="paymentmethod" id="pm">
                                <option value="Cash">Cash</option>
                                <option value="Digital_Payment">Digital Payment</option>
                            </select>
                        </li> -->
                    </section>
                    <section>
                        <li>Subtotal</li>
                        <li>₱0</li>
                    </section>
                    <section>
                        <li>Discount (%)</li>
                        <li>0</li>
                    </section>
                    <section>
                        <li>Total Amount</li>
                        <li>₱0</li>
                    </section>
                    <section>
                        <button id="discount">Discount</button>
                        <button id="proceed">Proceed</button>
                    </section>
                </div>
            </div>
        </div>

    </div>



</body>

</html>