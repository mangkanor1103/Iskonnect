// Add event listeners to all logout links
document.addEventListener('DOMContentLoaded', function() {
    // Find all logout links
    const logoutLinks = document.querySelectorAll('a[href*="logout.php"]');
    
    // Add click event listener to each logout link
    logoutLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            
            // Show SweetAlert confirmation
            Swal.fire({
                title: 'Logout Confirmation',
                text: 'Are you sure you want to log out?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10B981', // Green color matching the theme
                cancelButtonColor: '#EF4444', // Red color
                confirmButtonText: 'Yes, log out',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-lg',
                    confirmButton: 'font-medium',
                    cancelButton: 'font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show a loading message while logging out
                    Swal.fire({
                        title: 'Logging out...',
                        text: 'You will be redirected to the login page.',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            // Redirect to the logout page after timer
                            setTimeout(() => {
                                window.location.href = link.getAttribute('href');
                            }, 1500);
                        }
                    });
                }
            });
        });
    });
});