document.addEventListener('DOMContentLoaded', function () {
    
    document.querySelectorAll('.order-status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', function() {
            const orderId = this.getAttribute('data-order-id');
            const status = this.value;

            fetch('../../view/orders.view.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'update_order_status', order_id: orderId, status: status })
            });
        });
    });

    document.querySelectorAll('.literal-delete-order').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');

            fetch('../../view/orders.view.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'literal_delete_order', order_id: orderId })
            }).then(() => {
                window.location.reload();
            });
        });
    });

    // document.querySelectorAll('.delete-order').forEach(button => {
    //     button.addEventListener('click', function() {
    //         const orderId = this.getAttribute('data-order-id');

    //         fetch('../../view/orders.view.php', {
    //             method: 'POST',
    //             headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    //             body: new URLSearchParams({ action: 'delete_order', order_id: orderId })
    //         }).then(() => {
    //             // Remove the order from the DOM
    //             this.closest('.order-container').remove();
    //         });
    //     });
    // });

    document.querySelectorAll('.delete-order').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            const orderStatus = this.closest('.order-container').getAttribute('data-status'); 

            if (orderStatus === 'Pending') {
                alert("You cannot remove a pending order.");
                return;
            }

            if (confirm("Are you sure you want to remove this order?")) {
                fetch('../../view/orders.view.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ action: 'delete_order', order_id: orderId })
                }).then(() => {
                    // Remove the order from the DOM
                    this.closest('.order-container').remove();
                });
            }
        });
    });







    // Get the modal elements
    const modal = document.getElementById("calculator-modal");
    const totalPriceSpan = document.getElementById("total-price");
    const cashGivenInput = document.getElementById("cash-given");
    const changeAmountSpan = document.getElementById("change-amount");

    // Handle "Show Receipt" button clicks
    document.querySelectorAll(".generate-receipt").forEach(button => {
        button.addEventListener("click", function() {
            const orderId = this.getAttribute("data-order-id");
            const totalAmount = parseFloat(
                this.closest(".order-container").querySelector(".orderDetail p:nth-child(3)").innerText.replace("₱", "")
            );

            // Set the total price in the modal
            totalPriceSpan.innerText = totalAmount.toFixed(2);

            // Reset the fields in the modal
            cashGivenInput.value = "";
            changeAmountSpan.innerText = "0.00";

            // Show the modal
            modal.style.display = "block";

            // Store order ID and total amount in button data for later use
            button.setAttribute("data-order-total", totalAmount);
            button.setAttribute("data-order-id", orderId);
        });
    });

    // Handle "Calculate Change" button click in modal
    document.getElementById("calculate-change").addEventListener("click", function() {
        const totalAmount = parseFloat(totalPriceSpan.innerText);
        const cashGiven = parseFloat(cashGivenInput.value);

        if (isNaN(cashGiven) || cashGiven < totalAmount) {
            alert("Not enough cash provided. Please enter a sufficient amount.");
            changeAmountSpan.innerText = "0.00";
        } else {
            const change = cashGiven - totalAmount;
            changeAmountSpan.innerText = change.toFixed(2);

            // Redirect to the receipt page with order_id, cash_given, and change
            const orderId = document.querySelector(".generate-receipt").getAttribute("data-order-id");
            const receiptUrl = `OrderReceipt?order_id=${orderId}&cash_given=${cashGiven}&change=${change.toFixed(2)}`;
            
            // Open receipt page in new tab
            window.open(receiptUrl, '_blank');

            // Close the modal
            modal.style.display = "none";
        }
    });

    // Close the modal on close button click
    document.querySelector(".close").onclick = function() {
        modal.style.display = "none";
    };

    // Close the modal if clicking outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };


});
