<?php

require_once '../../src/control/menuController.php';



if ($_SERVER["REQUEST_METHOD"] === "POST") {




    // PRODUCTS SHOW/SEARCH

    if (isset($_POST['transac']) && $_POST["transac"] === "searchNView" ) {
        session_start();

        $searchVal = $_POST["searchVal"];
        $category_id = $_POST["category_id"];

        $pdoTemp = new cashierController(null, $searchVal, null);
        $allProd = $pdoTemp->getAllProducts($category_id);

        if ($allProd) {

            foreach ($allProd as $prod) {
                echo '
                    <ol>
                        <li><img id="' . $prod['productID'] . '" src="data:image/jpeg;base64,' . base64_encode($prod['displayPic']) . '" alt="item"></li>
                        <li>
                            <h5>' . $prod['name'] . '</h5>
                            <h4><b>₱' . $prod['price'] . '</b></h4>
                        </li>
                    </ol>
                
                ';
            }
        } else {
            echo '<div class="nopr">No products..</div>';
        }
    }


    // CART CHANGE QUANTITY

    if (isset($_POST['transac']) && $_POST["transac"] === "changeqntity" &&  isset($_POST["qntity"])) {



        $qntity = $_POST["qntity"];
        $product_id = $_POST["product_id"];

        $ordersSession = array();

        session_start();
        if (isset($_SESSION['orders'])) {
            $ordersSession = $_SESSION['orders'];
        }

        $array_size = count($ordersSession);


        for ($i = 0; $i < $array_size; $i++) {
            if ($product_id == $ordersSession[$i]["product_id"]) {
                $tempNewP = $ordersSession[$i]["price"] / $ordersSession[$i]["qntity"];
                $newP = $tempNewP * $qntity;
                $ordersSession[$i]["qntity"] = $qntity;
                $ordersSession[$i]["price"] = $newP;
                break;
            }
        }

        $_SESSION['orders'] = $ordersSession;
    }


    // CART VIEW

    if (isset($_POST['transac']) && $_POST["transac"] === "viewCart" ) {
        $ordersSession = array();

        session_start();
        if (isset($_SESSION['orders'])) {
            $ordersSession = $_SESSION['orders'];
        }
        if (isset($_POST["fakeTransac"]) && $_POST["fakeTransac"] === 'itsaprank') {
            unset($ordersSession);
            unset($_SESSION['orders']);
        }
        $ordersSession = array();

        dpCart($ordersSession);
    }


    // CART ITEM REMOVE

    if (isset($_POST['transac']) && $_POST["transac"] === "removeToCart" ) {
        $product_id = $_POST["product_id"];


        $ordersSession = array();

        session_start();
        if (isset($_SESSION['orders'])) {
            $ordersSession = $_SESSION['orders'];
        }
        $array_size = count($ordersSession);


        for ($i = 0; $i < $array_size; $i++) {
            if ($product_id == $ordersSession[$i]["product_id"]) {
                unset($ordersSession[$i]);
                $ordersSession = array_values($ordersSession);
                break;
            }
        }

        $array_size = count($ordersSession);



        $_SESSION['orders'] = $ordersSession;
        dpCart($ordersSession);
        if ($array_size > 0) {
            echo "not_empty";
        }
    }


    // CART ADD

    if (isset($_POST['transac']) && $_POST["transac"] === "addToCart" ) {
        // $transac =;
        $product_id = $_POST["product_id"];


        $pdoTemp = new cashierController(null, null, $product_id);
        $product_fetch = $pdoTemp->addToCart();
        $price = (int)$product_fetch['price'];

        $orderList = array(
            "product_id" => $product_id,
            "product_name" => $product_fetch['name'],
            "qntity" => 1,
            "price" => $price
        );

        session_start();
        $ordersSession = array();

        if (isset($_SESSION['orders'])) {
            $ordersSession = $_SESSION['orders'];
        }



        // array_push($ordersSession, $product_id);

        $array_size = count($ordersSession);

        $tempVar = 1;

        for ($i = 0; $i < $array_size; $i++) {
            if ($product_id == $ordersSession[$i]["product_id"]) {
                $ordersSession[$i]["qntity"] += 1;
                $ordersSession[$i]["price"] += $price;
                $tempVar++;
            }
        }

        if ($tempVar === 1) {
            array_push($ordersSession, $orderList);
        }
        $product_id = "";

        $_SESSION['orders'] = $ordersSession;
        // var_dump($ordersSession);
        $array_size = count($ordersSession);
        // var_dump($_SESSION['orders']);
        dpCart($ordersSession);
    }


    // CATEGORY GET

    // if (isset($_POST['transac']) && $_POST['transac'] === "getCateguri") {
        
    //     $pdoTemp = new cashierController(null, null, null);
    //     $categories = $pdoTemp->getAllCategory();

    //     echo '<li class="prod_nav" id="">All</li>';
    //     if ($categories) {
            
    //         foreach ($categories as $cat) {
    //             echo '<li id="'.$cat['category_id'].'">'.$cat['category_name'].'</li>';
    //         }
    //     }


    // }

    if (isset($_POST['transac']) && $_POST['transac'] === "getCateguri") {
        
        $pdoTemp = new cashierController(null, null, null);
        $categories = $pdoTemp->getAllCategory();

        // Display the "All" option
        echo '<li class="prod_nav" id="">All</li>';
        
        if ($categories) {
            foreach ($categories as $cat) {
                // Display each category with its image and name
                echo '<li id="' . $cat['id'] . '">';
                echo '<img src="../../src/img/' . $cat['category_image'] . '" alt="' . $cat['category_name'] . '" class="category-img">';
                // echo '<span>' . $cat['category_name'] . '</span>';
                echo '</li>';
            }
        }
    }


}

function dpCart($ordersSession)
{
    if ($ordersSession) {
        foreach ($ordersSession as $value) {
            echo '
                    <ol>
                        <li>
                            <p class="arrow_controll"><i class="fas fa-arrow-right"></i></p>
                            <p>' . $value['qntity'] . '</p>
                            <p>' . $value['product_name'] . '</p>
                            <p class="pr">₱' . $value['price'] . '</p>
                            <div id="' . $value['product_id'] . '" class="edga"><i id="rmitem" class="fas fa-plus" title="Remove Item" style="transform: rotate(45deg);"></i></div>
                        </li>
                        <li class="qntity">
                            <div>
                                <p>Quantity</p>
                                <form id="changeqntity">
                                    <input type="number" value="' . $value['qntity'] . '" name="qntity" >
                                </form>
                            </div>
                        </li>
                    </ol>
        ';
        }
    }
}
