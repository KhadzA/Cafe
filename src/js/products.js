




$(document).ready(function () {
    addPorm = $("#addProductForm").detach();
    addCat = $(".categoryForm-outer").detach();

    // $(".myproducts").detach(addPorm);
    $("#addProductForm").detach();
    // $(".categoryForm-outer").detach();
    let actionSelect;
    allProducts("");

    open_Insertion = true;

    let interval = "";

    $("#addProduct").click(function (e) {
        e.preventDefault();
        if (open_Insertion) {
            formData = new FormData()

            formData.append("transac", "getCategory")
            $.ajax({
                url: '../src/views/productView.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#prod_category').html(response);
                }
            });
            $("#overlay_prod").show();
            $(".myproducts").append(addPorm);

            setTimeout(() => {
                console.log("sada");
                $(".label_style").addClass("newlabel_style");
            }, 600);

            interval = setInterval(() => {
                manipulated = $("#overlay_prod").css("display", "none");
                if (manipulated) {
                    $("#overlay_prod").show();
                }
            }, 800);

            open_Insertion = false;

        }

    });

    $(".myproducts").on("change", "#addpic", function (e) {
        e.preventDefault();
        const input = $('#addpic')[0];
        console.log("entered111");

        if (input) {
            imagePick();
        }
    });


    $(".myproducts").on("click", "#canc", function (e) {
        e.preventDefault();
        open_Insertion = true;
        clearInterval(interval)
        $(".label_style").removeClass("newlabel_style");
        $("#overlay_prod").hide();
        $("#addProductForm").detach();


    });

    // $("#submit_prod").click(function (e) { 
    //     $("#submit_form").submit(); 
    // });  method="post" action="../views/productView.php"


    $(".myproducts").on("submit", "#submit_form", function (e) {
        e.preventDefault();
        formData = new FormData(this)
        formData.append("transac", "addProd")

        $.ajax({
            url: '../src/views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()
                if (response == "productAdded") {
                    notify("Product Added Successfully")
                    open_Insertion = true;
                    clearInterval(interval)
                    $("#imgdisplay").attr('src', '../image/dpTemplate.png');
                    allProducts("")
                    $(".label_style").removeClass("newlabel_style");
                    $("#overlay_prod").hide();
                    $("#addProductForm input").val("");
                    $("#addProductForm .response").html("");

                    $("#addProductForm").detach();


                }
                $('.response').html(response);
            }
        });

    });



    $("#content_products").on("click", ".more_showPane", function (e) {
        e.preventDefault();
        // console.log(54444444444444444);
        hasClass = $(this).closest("li").find(".action_selectNew").hasClass("action_selectNew");

        if (!hasClass) {
            console.log("hello");
            $("#content_products li").css("z-index", "1");
            $(this).closest("li").css("z-index", "2");
            $("#content_products .action_select").removeClass("action_selectNew");
            $(this).closest("li").find(".action_select").addClass("action_selectNew");
            // $(this).closest("li").append(actionSelect);
        } else {

            $("#content_products .action_select").removeClass("action_selectNew");
            // $(".action_select").detach();

        }
        // new_id = $(this).closest("#content_products li").find(".action_select").attr("id");
        // console.log(new_id);

        // if (clicked_count == 2) {
        //     prev_clicked = 1;
        //     clicked_count = 1;
        // }
        // if (prev_clicked != new_id) {
        //     $(this).closest("li").append(actionSelect);

        // } else if (clicked_count == 1) {
        //     // $(this).closest("li").find(".action_select").detach();
        //     $(".action_select").detach();
        // } else {
        //     $(".action_select").detach();
        //     $(this).closest("li").append(actionSelect);
        // }
        // clicked_count = clicked_count + 1;

        // prev_clicked = new_id;


    });


    let interval2 = "";

    $("#addCategory").click(function (e) {
        e.preventDefault();
        if (open_Insertion) {

            $("#overlay_prod").show();
            $(".myproducts").append(addCat);
            $(".uiInfo").hide();

            setTimeout(() => {
                $(".uiInfo").fadeIn(200);
            }, 600);

            interval2 = setInterval(() => {
                manipulated = $("#overlay_prod").css("display", "none");
                if (manipulated) {
                    $("#overlay_prod").show();
                }
                console.log('ngiao');

            }, 800);
            open_Insertion = false;
        }
    });

    $(".myproducts").on("click", "#cancelAddCat", function (e) {
        e.preventDefault();
        open_Insertion = true;
        clearInterval(interval2)
        $(".uiInfo").hide();
        $("#overlay_prod").hide();
        $(".categoryForm-outer").detach();
    });


    $(".myproducts").on("submit", "#category", function (e) {
        e.preventDefault()
        formData = new FormData(this)
        formData.append("transac", "addCategory")

        $.ajax({
            url: '../src/views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()
                if (response == "categoryAdded") {
                    notify("Category Added Successfully")
                    open_Insertion = true;
                    clearInterval(interval2)

                    $("#categoryForm .category-response").html("");
                    $("#categoryForm input").val("");
                    $(".uiInfo").hide();
                    $("#overlay_prod").hide();
                    $(".categoryForm-outer").detach();
                    allProducts("")
                }
                $('.category-response').html(response);
            }
        });

    });


    $(".find_prod").on("input", "#findExec", function () {

        allProducts($(this).val())

    });






    $("#content_products").on("click", "", function () {

    });




});



// let loading_sc = "ngiao"; 

function allProducts(searchArg) {
    // hasClass = $("#content_products").children().hasClass("loading_sc");
    $('#content_products li').hide();
    $(".loading_sc").show();

    formData = new FormData()
    formData.append("transac", "showSearchProd")
    formData.append("name", searchArg)
    // if (hasClass) {
    //     $(".loading_sc").show();
    // }else{
    //     console.log("helll");

    //     $('#content_products li').detach();
    //     $('#content_products').append(loading_sc);

    // }


    $.ajax({
        url: '../src/views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#content_products').html(response);
            $('#content_products li').hide();
            $(".loading_sc").show();
            // $(".loading_sc").parent().css("overflow-y", "hidden");
            setTimeout(() => {
                $(".loading_sc").hide();
                $("#content_products li").each(function (index) {
                    $(this).delay(index * 100).fadeIn(200);
                });
                // $(".loading_sc").parent().css("overflow-y", "scroll");
            }, 1500);

        }
    });
}

function notify(msg) {
    notif = `<div class="notification">
                    <i class="fas fa-check"></i>
                    <h5>${msg}...</h5>
                </div>`;
    $(".myproducts").append(notif);

    setTimeout(() => {
        $(".notification i").css("animation-name", "on_notif");
    }, 1500);

    setTimeout(() => {
        $(".notification").css("transform", "translateX(20rem)");
    }, 4000);

    setTimeout(() => {
        $(".notification").detach();
    }, 6000);
}


function imagePick() {
    const profileImage = $('#imgdisplay');
    const input = $('#addpic')[0];
    const file = input.files[0];
    console.log("entered");

    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            profileImage.attr('src', reader.result);
        };
        reader.readAsDataURL(file);
        console.log("readed");

    } else {
        profileImage.attr('src', '../image/dpTemplate.png');

    }

}