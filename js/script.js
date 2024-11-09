document.addEventListener('DOMContentLoaded', function () {

    // Event listener for the Sign Up and Login links
    const signUpLinks = document.querySelectorAll('.toSignUp-text a, .toLogin a');
    signUpLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            let pageID = this.id; 
            let targetURL = pageID;

            console.log(`Navigating to: ${targetURL}`);
            window.location.href = targetURL; 
        });
    });

    // Event listener for sidebar menu items
    const menuItems = document.querySelectorAll('.side_nav li');
    menuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            let clicked_location = this.id; 
            console.log(clicked_location);

            window.location.href = clicked_location;
        });
    });

    // Sidebar toggle functionality
    const sidebar = document.querySelector('.side_nav');
    const toggleBtn = document.getElementById('toggle-side_nav');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('minimized'); 
        });
    } else {
        console.error('Toggle button not found!');
    }

    
});
