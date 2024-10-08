<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../src/js/jquery-3.5.1.min.js"></script>
    <script src="../src/js/script.js"></script>
    <script src="../src/js/dashBoard.js"></script>
    <script src="../src/js/node_modules/chart.js/dist/chart.umd.js"></script>
    <link rel="stylesheet" href="../src/styles/style.css">
    <link rel="stylesheet" href="../src/styles/dashBoard.css">
    <link rel="stylesheet" href="../src/styles/fontawesome-free-5.15.4-web/css/all.css">
    <title>POS</title>
</head>

<body>


    <div id="header">
        <div class="header_inner">

            <section>
                <li><img src="../src/img/Cafe_Logo.png" alt="logo" id="logo"></li>
                <li class="title_section">Dashboard</li>
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
                    <li id="overview" class="on_select">
                        <div class="bgsect"></div>
                        <div class="textdp"><i class="fas fa-chart-pie"></i>Dashboard</div>
                    </li>
                    <li id="menu">
                        <div class="textdp"><i class="fas fa-home"></i><br>Menu</div>
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
            <div class="dashboard">
                <div class="summary_show">
                    <li>
                        <div class="summary_cont">
                            <h6>Income Today</h6>
                            <p>₱0</p>
                        </div>
                    </li>
                    <li>
                        <div class="summary_cont">
                            <h6>Profit Today</h6>
                            <p>₱0</p>
                        </div>
                    </li>
                    <li>
                        <div class="summary_cont">
                            <h6>Present Month Profit</h6>
                            <p>₱0</p>
                        </div>
                    </li>
                </div>
                <div class="dashboard_body">
                    <div>
                        <canvas id="myBarChart"></canvas>
                        <div class="data_from_graphical">
                            <li>
                                <div class="summary_cont">
                                    <h6>Highest</h6>
                                    <p>₱0</p>
                                    <div class="date">MM/DD/YYY</div>
                                </div>
                            </li>
                            <li>
                                <div class="summary_cont">
                                    <h6>Lowest</h6>
                                    <p>₱0</p>
                                    <div class="date">MM/DD/YYYY</div>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>

</html>