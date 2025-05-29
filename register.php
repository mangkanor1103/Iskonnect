<?php
// Start session
session_start();

// If user is already logged in, redirect to appropriate dashboard
if (isset($_SESSION['user_id'])) {
    switch ($_SESSION['role']) {
        case 'student':
            header('Location: student/dashboard.php');
            break;
        case 'staff':
            header('Location: staff/dashboard.php');
            break;
        case 'admin':
            header('Location: dashboard.php');
            break;
        case 'ched':
            header('Location: ched/dashboard.php');
            break;
    }
    exit();
}

// Include database connection
include 'components/conn.php';

// Initialize variables for form data and errors
$fullname = $username = $password = '';
$errors = [];

// Process registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validate full name
    if (empty($fullname)) {
        $errors['fullname'] = 'Full name is required';
    }
    
    // Validate username
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Username must be at least 3 characters';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['username'] = 'Username already exists';
        }
        $stmt->close();
    }
    
    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }
    
    // Validate password confirmation
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Set role to "student"
        $role = 'student';
        
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (fullname, username, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $username, $hashed_password, $role);
        
        if ($stmt->execute()) {
            // Get the new user ID
            $user_id = $stmt->insert_id;
            
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['role'] = $role;
            
            // Return JSON response for AJAX
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Registration successful',
                'redirect' => 'student/dashboard.php'
            ]);
            // Ensure we exit after sending the JSON response
            exit();
        } else {
            // Return error response for AJAX
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ]);
            exit();
        }
    } else {
        // Return validation errors for AJAX
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Iskonnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(74, 222, 128, 0.4);
        }
        .register-btn {
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        .register-btn:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(to right, #4ade80, #059669);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s ease;
        }
        .register-btn:hover:after {
            transform: scaleX(1);
            transform-origin: left;
        }
        .particles-container {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-300 min-h-screen">
    <!-- Animated particles -->
    <div id="particles-js" class="particles-container"></div>
    
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gradient-to-r from-green-600 to-green-800 text-white shadow-lg py-4">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <div class="flex items-center animate__animated animate__fadeIn">
                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_uwh9uhdt.json" background="transparent" speed="1" style="width: 50px; height: 50px;" autoplay loop></lottie-player>
                    <h1 class="text-3xl font-extrabold ml-2">Iskonnect</h1>
                </div>
                <div class="space-x-4 hidden md:block animate__animated animate__fadeIn animate__delay-1s">
                    <a href="index.php" class="hover:text-green-100 transition cursor-pointer">Login</a>
                    <button class="hover:text-green-100 transition cursor-pointer">About</button>
                    <button class="hover:text-green-100 transition cursor-pointer">Contact</button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center px-4 py-8">
            <div class="register-container p-8 rounded-xl shadow-2xl max-w-md w-full mx-auto animate__animated animate__fadeIn">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 animate__animated animate__zoomIn">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">Create Account</h2>
                    <p class="text-gray-600 mt-2">Sign up as a student to access Iskonnect</p>
                </div>
                
                <form id="registerForm" class="space-y-4">
                    <div class="register-error text-red-500 text-center text-sm hidden"></div>
                    
                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-input block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Enter your full name" required>
                        <p class="error-fullname text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" id="username" class="form-input block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Choose a username" required>
                        <p class="error-username text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" id="password" class="form-input block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Create a strong password" required>
                        <p class="error-password text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-input block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500" placeholder="Confirm your password" required>
                        <p class="error-confirm_password text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    
                    <button type="submit" class="register-btn w-full py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 flex justify-center items-center mt-6">
                        <span>Register Account</span>
                        <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">Already have an account? <a href="index.php" class="text-green-600 hover:text-green-700 font-medium transition">Sign in</a></p>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">© 2025 Iskonnect. All rights reserved.</p>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Load particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize particles.js
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 50,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#4ade80"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": false,
                        "anim": {
                            "enable": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#4ade80",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 2,
                        "direction": "none",
                        "random": false,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });

            // Handle form submission with AJAX
            const registerForm = document.getElementById('registerForm');
            const errorDiv = document.querySelector('.register-error');
            
            registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Reset error messages
                errorDiv.classList.add('hidden');
                document.querySelectorAll('.text-red-500').forEach(el => {
                    el.classList.add('hidden');
                });
                
                // Show loading animation
                const buttonText = registerForm.querySelector('button span');
                const originalText = buttonText.textContent;
                buttonText.textContent = 'Creating Account...';
                registerForm.querySelector('button').disabled = true;
                
                // Get form data
                const formData = new FormData(registerForm);
                
                // Send AJAX request
                fetch('register.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {                        // Show success message with SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration Successful!',
                            text: 'Your account has been created. Redirecting to student dashboard...',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        }).then(() => {
                            // Ensure redirection to student dashboard
                            window.location.href = 'student/dashboard.php';
                        });
                    } else {
                        // Display error messages
                        buttonText.textContent = originalText;
                        registerForm.querySelector('button').disabled = false;
                        
                        if (data.message) {
                            // General error message
                            errorDiv.textContent = data.message;
                            errorDiv.classList.remove('hidden');
                        } else if (data.errors) {
                            // Validation errors
                            for (const [field, message] of Object.entries(data.errors)) {
                                const errorElement = document.querySelector(`.error-${field}`);
                                if (errorElement) {
                                    errorElement.textContent = message;
                                    errorElement.classList.remove('hidden');
                                }
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorDiv.textContent = 'An error occurred. Please try again.';
                    errorDiv.classList.remove('hidden');
                    buttonText.textContent = originalText;
                    registerForm.querySelector('button').disabled = false;
                });
            });

            // Password matching validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const confirmError = document.querySelector('.error-confirm_password');
            
            confirmPassword.addEventListener('input', function() {
                if (password.value !== confirmPassword.value) {
                    confirmError.textContent = 'Passwords do not match';
                    confirmError.classList.remove('hidden');
                } else {
                    confirmError.classList.add('hidden');
                }
            });
            
            // Animate input fields on focus
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.classList.add('scale-102');
                });
                input.addEventListener('blur', function() {
                    this.classList.remove('scale-102');
                });
            });
        });
    </script>
</body>
</html>