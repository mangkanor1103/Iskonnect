<?php
// Start session
session_start();

// Check if the logout is confirmed
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    // Unset all session variables
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: index.php");
    exit();
} else {
    // Display confirmation page with SweetAlert
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Logout - Iskonnect</title>
        <!-- Include the project's header which has SweetAlert -->
        <?php include 'components/header.php'; ?>
        <style>
            body {
                background-color: #f9fafb;
                overflow: hidden;
            }
        </style>
    </head>
    <body>
        <script>
            // Show SweetAlert as soon as page loads
            document.addEventListener('DOMContentLoaded', function() {
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
                                // Redirect to logout with confirmation
                                setTimeout(() => {
                                    window.location.href = 'logout.php?confirm=yes';
                                }, 1500);
                            }
                        });
                    } else {
                        // If user cancels, go back to previous page
                        window.history.back();
                    }
                });
            });
        </script>
    </body>
    </html>
    <?php
}
?>