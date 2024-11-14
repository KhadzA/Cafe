$(document).ready(function() {
    // Open the Edit User modal and populate the fields
    $('.edit-user').on('click', function() {
        const userId = $(this).data('user-id');
        const username = $(this).data('username');
        
        // Set the data in the modal
        $('#userId').val(userId);
        $('#newUsername').val(username);
        
        $('#editUserModal').show();
    });

    // Close the modal
    $('#closeModal').on('click', function() {
        $('#editUserModal').hide();
    });

    // Handle form submission (Update user)
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        
        const userId = $('#userId').val();
        const newUsername = $('#newUsername').val();
        const newPassword = $('#newPassword').val();

        $.ajax({
            url: '../../view/manageUser.view.php',
            type: 'POST',
            data: {
                action: 'update_user',
                user_id: userId,
                username: newUsername,
                password: newPassword
            },
            success: function(response) {
                alert('User updated successfully');
                location.reload();  // Reload the page after update
            },
            error: function() {
                alert('Failed to update user');
            }
        });
    });

    // Delete user
    $('.delete-user').on('click', function() {
        const userId = $(this).data('user-id');
        if (confirm('Are you sure you want to delete this user?')) {
            $.ajax({
                url: '../../view/manageUser.view.php',
                type: 'POST',
                data: { action: 'delete_user', user_id: userId },
                success: function(response) {
                    alert('User deleted successfully');
                    location.reload();  // Reload the page after deletion
                },
                error: function() {
                    alert('Failed to delete user');
                }
            });
        }
    });



    // Get modal elements
    const editUserModal = document.getElementById("editUserModal");
    const closeModalButton = document.getElementById("closeModal");
    const editUserForm = document.getElementById("editUserForm");
    const userIdInput = document.getElementById("userId");
    const newUsernameInput = document.getElementById("newUsername");
    const newPasswordInput = document.getElementById("newPassword");

    // Handle "Edit User" button click
    document.querySelectorAll(".edit-user").forEach(button => {
        button.addEventListener("click", function() {
            const userId = this.getAttribute("data-user-id");
            const currentUsername = this.getAttribute("data-username");

            // Set the form fields with the existing user data
            userIdInput.value = userId;
            newUsernameInput.value = currentUsername;
            newPasswordInput.value = "";  // Clear password field for editing

            // Show the modal
            editUserModal.style.display = "block";
        });
    });

    // Handle "Update User" form submission
    editUserForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const userId = userIdInput.value;
        const newUsername = newUsernameInput.value;
        const newPassword = newPasswordInput.value;

        // Add form submission logic here (e.g., Ajax request)
        console.log(`Updating user ${userId} with username: ${newUsername} and password: ${newPassword}`);

        // Close the modal after submission
        editUserModal.style.display = "none";
    });

    // Close the modal on cancel button click
    closeModalButton.onclick = function() {
        editUserModal.style.display = "none";
    };

    // Close the modal if clicking outside of it
    window.onclick = function(event) {
        if (event.target === editUserModal) {
            editUserModal.style.display = "none";
        }
    };

});