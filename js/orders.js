document.addEventListener('DOMContentLoaded', function() {
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

    document.querySelectorAll('.delete-order').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');

            fetch('../../view/orders.view.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ action: 'delete_order', order_id: orderId })
            }).then(() => {
                window.location.reload();
            });
        });
    });
});
