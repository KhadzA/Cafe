document.addEventListener("DOMContentLoaded", function () {
    const categorySelect = document.getElementById("category_id");
    const sizeOptions = document.getElementById("size-options");
    const sugarLevelOptions = document.getElementById("sugar-level-options");

    // Category selection change event to toggle size and sugar level options
    categorySelect.addEventListener("change", function () {
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        const hasSize = selectedOption.getAttribute("data-has-size") === "1";
        const hasSugarLevel = selectedOption.getAttribute("data-has-sugar-level") === "1";

        // Show or hide size and sugar level options based on category selection
        sizeOptions.style.display = hasSize ? "block" : "none";
        sugarLevelOptions.style.display = hasSugarLevel ? "block" : "none";
    });

    // Trigger the change event to set initial visibility of size and sugar level options
    categorySelect.dispatchEvent(new Event("change"));

    // Image file selection change event to display selected file name
    document.getElementById('image').addEventListener('change', function () {
        const fileLabel = document.getElementById('file-label');
        const fileNameDisplay = document.getElementById('file-name');

        if (this.files.length > 0) {
            const fileName = this.files[0].name;
            fileLabel.textContent = fileName;
            fileNameDisplay.textContent = ''; 
        } else {
            fileLabel.textContent = 'Choose File';
            fileNameDisplay.textContent = ''; 
        }
    });

});

$(document).ready(function () {
    // Load default products on page load
    $.post('../../view/menu.view.php', { action: 'filter_category', category_id: null }, function (response) {
        
        if (response) {
            try {
                const products = JSON.parse(response);
                let productList = '';

                products.forEach(product => {
                    productList += `
                        <div class="product-item">
                            <img src="${product.image}" alt="${product.product_name}" class="product-image">
                            <div class="product-name">${product.product_name}</div>
                        </div>`;
                });

                $('#product-list').html(productList);
            } catch (error) {
                console.error("Error parsing product data:", error);
            }
        } else {
            console.error("No products found or response is null");
        }
    });


    // Category navigation click function
    $('.category-link').click(function (e) {
        e.preventDefault();
        const categoryId = $(this).data('category-id');

        $.post('../../view/menu.view.php', { action: 'filter_category', category_id: categoryId }, function (response) {
            try {
                const products = JSON.parse(response);
                let productList = '';

                products.forEach(product => {
                    productList += `
                        <div class="product-item">
                            <img src="${product.image}" alt="${product.product_name}" class="product-image">
                            <div class="product-name">${product.product_name}</div>
                        </div>`;
                });

                $('#product-list').html(productList);
            } catch (error) {
                console.error("Error parsing product data:", error);
            }
        });
    });

    // Category navigation click function with corrected selector
    $('.all-category-link').click(function (e) {
        e.preventDefault();
        const categoryId = $(this).closest('li').data('category-id');

        // AJAX call to filter products by selected category
        $.post('../../view/menu.view.php', { action: 'filter_category', category_id: categoryId }, function (response) {
            try {
                const products = JSON.parse(response);
                let productList = '';

                // Loop through each product and match HTML structure
                products.forEach(product => {
                    productList += `
                        <div class="all-product-item">
                            <h4>${product.product_name}</h4>
                            <div class="button-group">
                                <button onclick="document.getElementById('edit-product-modal').style.display='block'" 
                                        class="edit-product-btn" id="edit-product-btn"
                                        data-product-id="${product.product_id}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="delete-product-btn" 
                                        data-product-id="${product.product_id}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>`;
                });

                // Update product list HTML with new content
                $('#all-product-list').html(productList);
            } catch (error) {
                console.error("Error parsing product data:", error);
            }
        });
    });


    $('.all-category-list').on('click', '.all-category-link', function (e) {
        e.preventDefault();
        $('.all-category-list li').removeClass('active');
        $(this).parent().addClass('active');

        const categoryId = $(this).data('category-id') || null; 
        loadProducts(categoryId);
    });


    document.querySelectorAll('.edit-category-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-category-id');

            fetchCategoryData(categoryId);
        });
    });

    function fetchCategoryData(categoryId) {
        fetch('../../view/menu.view.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=fetch_category&category_id=${categoryId}`
        })
        .then(response => response.json())
        .then(category => {
            if (category.error) {
                console.error(category.error);
                return;
            }
            
            // Populate the form fields with fetched data
            document.querySelector('#edit-category-modal input[name="category_id"]').value = category.category_id;
            document.querySelector('#edit-category-modal input[name="name"]').value = category.category_name;
            document.querySelector('#edit-category-modal textarea[name="description"]').value = category.description;
            document.querySelector('#edit-category-modal input[name="has_size"]').checked = category.has_size == 1;
            document.querySelector('#edit-category-modal input[name="has_sugar_level"]').checked = category.has_sugar_level == 1;

            // Display the modal
            document.getElementById('edit-category-modal').style.display = 'block';
        })
        .catch(error => console.error('Error fetching category data:', error));
    }


    $('.edit-product-btn').click(function () {
        const productId = $(this).data('product-id');

        $.post('../../view/menu.view.php', { action: 'fetch_product', product_id: productId }, function (response) {
            try {
                const product = JSON.parse(response);

                // Populate form fields
                $('#edit-product-id').val(product.product_id);
                $('#edit-product-name').val(product.product_name);
                $('#edit-product-description').val(product.description);
                $('#edit-product-price').val(product.price);
                $('#edit-category-id').val(product.category_id);
                $('#edit-current-image').val(product.image);

                // Handle size and sugar level visibility
                if (product.sizes && product.sizes.length > 0) {
                    $('#size-options').show();
                    $('#edit-size').val(product.sizes[0].size); 
                } else {
                    $('#size-options').hide();
                }

                if (product.sugar_levels && product.sugar_levels.length > 0) {
                    $('#sugar-level-options').show();
                    $('#edit-sugar-level').val(product.sugar_levels[0].sugar_level);
                } else {
                    $('#sugar-level-options').hide();
                }

                // Show modal
                document.getElementById('edit-product-modal').style.display = 'block';
            } catch (error) {
                console.error("Error fetching product data:", error);
            }
        });
    });



    $('.delete-category-btn').click(function(e) {
        e.preventDefault();
        const categoryId = $(this).data('category-id');
        
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: '../../view/menu.view.php',
                type: 'POST',
                data: { action: 'delete_category', category_id: categoryId },
                success: function(response) {
                    if (response.success) {
                        $(`li[data-category-id="${categoryId}"]`).remove();
                        window.location.reload();
                    } else {
                        window.location.reload();
                    }
                },
                error: function() {
                    alert('Error occurred while trying to delete category.');
                }
            });
        }
    });

    $('.delete-product-btn').click(function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: '../../view/menu.view.php',
                type: 'POST',
                data: { action: 'delete_product', product_id: productId },
                success: function(response) {
                    if (response.success) {
                        $(`li[data-product-id="${productId}"]`).remove();
                        window.location.reload();
                    } else {
                        window.location.reload();
                    }
                },
                error: function() {
                    alert('Error occurred while trying to delete product.');
                }
            });
        }
    });

});


