$(document).ready(function () {
    // Load initial products without category filtering
    loadProducts(null);

    // Handle category selection to filter products
    $('.category-list').on('click', '.category-link', function (e) {
        e.preventDefault();
        $('.category-list li').removeClass('active');
        $(this).parent().addClass('active');

        const categoryId = $(this).data('category-id') || null;
        loadProducts(categoryId);
    });

    // Function to load products based on selected category
    function loadProducts(categoryId) {
        $.post('../../view/createOrders.view.php', { action: 'filter_category', category_id: categoryId }, function (response) {
            try {
                const products = JSON.parse(response);
                let productList = '';

                products.forEach(product => {
                    const price = product.price_modifier
                        ? (parseFloat(product.base_price) + parseFloat(product.price_modifier)).toFixed(2)
                        : parseFloat(product.base_price).toFixed(2);

                    productList += `
                        <div class="product-item" data-product-id="${product.product_id}" data-price="${price}">
                            <img src="/${product.image}" alt="${product.product_name}" class="product-image">
                            <div class="product-name">${product.product_name}</div>
                            <div class="product-size-sugar">${product.size_sugar_combination}</div> 
                            <div class="product-price">Price: ₱${price}</div>
                        </div>`;
                });

                $('#product-list').html(productList);

                // Bind click event to each product item to add to cart
                $('.product-item').off('click').on('click', function () {
                    const productId = $(this).data('product-id');
                    const productName = $(this).find('.product-name').text();
                    const productSpecs = $(this).find('.product-size-sugar').text();
                    const productPrice = parseFloat($(this).data('price'));
                    
                    addToCart(productId, productName, productSpecs, productPrice);
                });
            } catch (error) {
                console.error("Error parsing product data:", error);
            }
        });
    }

    function addToCart(productId, productName, productSpecs, productPrice) {
        // Assuming productSpecs contains size and sugar level, split them
        const [size, sugarLevel] = productSpecs.split(" "); 

        let cartItem = $(`#cart-item-${productId}`);

        if (cartItem.length) {
            // If the product is already in the cart, increment its quantity
            let quantityElement = cartItem.find('.cart-item-quantity');
            let quantity = parseInt(quantityElement.text()) + 1;
            quantityElement.text(quantity);

            // Update the subtotal for the item
            let subtotalElement = cartItem.find('.cart-item-subtotal');
            let newSubtotal = (quantity * productPrice).toFixed(2);
            subtotalElement.text(`₱${newSubtotal}`);
        } else {
            // If the product is not in the cart, add it
            $('#cart').append(`
                <div class="cart-item" id="cart-item-${productId}" data-price="${productPrice}" data-id="${productId}" data-quantity="1" data-size="${size}" data-sugar-level="${sugarLevel}">
                    <div class="start">
                        <span class="cart-item-name">${productName}</span>
                        <div class="small">
                            <span class="product-size-sugar">${size} ${sugarLevel}</span> 
                        </div>
                    </div>
                    <div class="proice">
                        <span class="cart-item-subtotal">₱${productPrice.toFixed(2)}</span>
                    </div>
                    <div class="quantite">
                        <i class="fas fa-minus-circle remove-item" data-product-id="${productId}" title="Remove"></i>
                        <span class="cart-item-quantity">1</span>
                        <i class="fas fa-plus-circle add-item" data-product-id="${productId}" title="Add"></i>
                    </div>
                </div>
            `);
        }

        updateTotalAmount();
    }


    // Event delegation for add and remove item functionality in the cart
    $('#cart').on('click', '.add-item', function () {
        const productId = $(this).data('product-id');
        const productPrice = parseFloat($(`#cart-item-${productId}`).data('price')); 
        
        let quantityElement = $(`#cart-item-${productId} .cart-item-quantity`);
        let quantity = parseInt(quantityElement.text()) + 1;
        quantityElement.text(quantity);

        // Update subtotal for the item
        let subtotalElement = $(`#cart-item-${productId} .cart-item-subtotal`);
        let newSubtotal = (quantity * productPrice).toFixed(2);
        subtotalElement.text(`₱${newSubtotal}`);
        
        updateTotalAmount();
    });

    $('#cart').on('click', '.remove-item', function () {
        const productId = $(this).data('product-id');
        const productPrice = parseFloat($(`#cart-item-${productId}`).data('price')); 
        
        let quantityElement = $(`#cart-item-${productId} .cart-item-quantity`);
        let quantity = parseInt(quantityElement.text());

        if (quantity > 1) {
            // Decrease quantity and update subtotal
            quantityElement.text(quantity - 1);
            let subtotalElement = $(`#cart-item-${productId} .cart-item-subtotal`);
            let newSubtotal = ((quantity - 1) * productPrice).toFixed(2);
            subtotalElement.text(`₱${newSubtotal}`);
        } else {
            // Remove the item from the cart if quantity reaches 0
            $(`#cart-item-${productId}`).remove();
        }

        updateTotalAmount();
    });

    // Function to update the total amount in the cart
    function updateTotalAmount() {
        let totalAmount = 0;

        // Sum the subtotals of each cart item
        $('#cart .cart-item').each(function () {
            let subtotal = parseFloat($(this).find('.cart-item-subtotal').text().replace('₱', ''));
            if (!isNaN(subtotal)) { // Check for NaN
                totalAmount += subtotal;
            }
        });

        // Update total amount display
        $('.total_amount').text(`Total Amount: ₱${totalAmount.toFixed(2)}`);
    }


    // Event handler to remove all items from the cart
    $(document).on('click', '#removeAllFromCart', function () {
        // Clear all items from the cart
        $('#cart').empty();

        // Update the total amount to 0
        updateTotalAmount();
    });



    document.getElementById('place_order').addEventListener('click', function() {
        // Gather cart data
        const cartItems = [];
        $('#cart .cart-item').each(function() {
            const productId = $(this).data('id');
            const productName = $(this).find('.cart-item-name').text();
            const quantity = parseInt($(this).find('.cart-item-quantity').text());
            const size = $(this).data('size'); 
            const sugarLevel = $(this).data('sugar-level'); 
            const price = parseFloat($(this).data('price'));

            cartItems.push({
                product_id: productId,
                product_name: productName,
                quantity: quantity,
                size: size,  
                sugar_level: sugarLevel,  
                price: price
            });

        });

        const totalAmount = parseFloat($('.total_amount').text().replace('Total Amount: ₱', ''));

        $.post('../../view/createOrders.view.php', {
            action: 'place_orders',
            cart_items: cartItems,
            total_amount: totalAmount
        }, function(response) {
            console.log(response); 
            if (response.success) {
                alert("Order placed successfully!");
                window.location.reload();
            } else {
                alert("Failed to place order. Please try again.");
            }
        }, 'json');

    });


});
