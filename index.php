<?php
// Start session at the very top before any output
session_start();

// Include the database connection, but NOT the header component
include 'components/conn.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
              // Return JSON response for AJAX
            header('Content-Type: application/json');
            
            // Determine the correct redirect URL based on role
            $redirectUrl = '';
            switch($user['role']) {
                case 'admin':
                    $redirectUrl = 'dashboard.php';
                    break;
                case 'staff':
                    $redirectUrl = 'staff/dashboard.php';
                    break;
                case 'student':
                    $redirectUrl = 'student/dashboard.php';
                    break;
                case 'ched':
                    $redirectUrl = 'ched/dashboard.php';
                    break;
                default:
                    // Default fallback to student dashboard for any new roles
                    $redirectUrl = 'student/dashboard.php';
            }
            
            echo json_encode([
                'success' => true,
                'role' => $user['role'],
                'redirect' => $redirectUrl
            ]);
            exit();
        } else {
            // Return error response for AJAX
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
            exit();
        }
    } else {
        // Return error response for AJAX
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iskonnect - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .particles-container {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(74, 222, 128, 0.4);
        }
        .login-btn {
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        .login-btn:after {
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
        .login-btn:hover:after {
            transform: scaleX(1);
            transform-origin: left;
        }
        .modal {
            transition: opacity 0.25s ease;
        }
        .modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
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
                    <button id="aboutBtn" class="hover:text-green-100 transition cursor-pointer">About</button>
                    <button id="contactBtn" class="hover:text-green-100 transition cursor-pointer">Contact</button>
                    <button id="helpBtn" class="hover:text-green-100 transition cursor-pointer">Help</button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center px-4 py-12">
            <div class="grid md:grid-cols-2 gap-8 max-w-6xl w-full">
                <!-- Left side with floating illustrations -->
                <div class="hidden md:flex flex-col justify-center items-center">
                    <div class="relative w-full h-96">
                        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_iorpbol0.json" background="transparent" speed="1" class="absolute floating" style="width: 400px; height: 400px;" autoplay loop></lottie-player>
                    </div>
                    <div class="mt-8 bg-white bg-opacity-80 p-6 rounded-lg shadow-lg animate__animated animate__fadeInUp">
                        <h2 class="text-2xl font-bold text-green-700 mb-2">Welcome to Iskonnect</h2>
                        <p class="text-gray-600">Your comprehensive platform for educational institution management and CHED coordination.</p>
                    </div>
                </div>
                
                <!-- Right side with login form -->
                <div class="flex flex-col justify-center">
                    <div class="login-container p-8 rounded-xl shadow-2xl max-w-md mx-auto w-full animate__animated animate__fadeIn animate__delay-1s">
                        <div class="text-center mb-8">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 animate__animated animate__zoomIn">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-4xl font-extrabold text-gray-800">Welcome Back</h2>
                            <p class="text-gray-600 mt-2">Please enter your credentials to access your account</p>
                        </div>
                        
                        <form id="loginForm" class="space-y-6">
                            <div class="login-error text-red-500 text-center text-sm hidden animate__animated animate__headShake"></div>
                            
                            <div class="transform transition duration-300 hover:scale-105">
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" name="username" id="username" class="form-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-400 focus:border-green-400" placeholder="Enter your username" required>
                                </div>
                            </div>
                            
                            <div class="transform transition duration-300 hover:scale-105">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-input block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-400 focus:border-green-400" placeholder="Enter your password" required>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center">
                                    <input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                    <label for="remember_me" class="ml-2 block text-gray-600">Remember me</label>
                                </div>
                                <a href="#" class="text-green-600 hover:text-green-500 transition">Forgot password?</a>
                            </div>
                            
                            <button type="submit" class="login-btn w-full py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 flex justify-center items-center">
                                <span>Sign In</span>
                                <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">Don't have an account? <a href="register.php" class="text-green-600 hover:text-green-700 font-medium transition">Sign up as a student</a></p>
                        </div>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">© 2025 Iskonnect. All rights reserved.</p>
                        </div>
                    </div>
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
                        "value": 80,
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

            // GSAP animations
            gsap.from(".login-container", {
                duration: 1,
                y: 50,
                opacity: 0,
                ease: "power3.out",
                delay: 0.5
            });
            
            // Handle form submission with AJAX
            const loginForm = document.getElementById('loginForm');
            const errorDiv = document.querySelector('.login-error');
            
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading animation
                const buttonText = loginForm.querySelector('button span');
                const originalText = buttonText.textContent;
                buttonText.textContent = 'Signing in...';
                loginForm.querySelector('button').disabled = true;
                
                // Get form data
                const formData = new FormData(loginForm);
                
                // Send AJAX request
                fetch('index.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {                        // Show success message with SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Welcome Back!',
                            text: 'Login successful. Redirecting you to your dashboard...',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        }).then(() => {
                            // Ensure student users go to student dashboard
                            if (data.role === 'student') {
                                window.location.href = 'student/dashboard.php';
                            } else {
                                window.location.href = data.redirect;
                            }
                        });
                    } else {
                        // Show error message
                        errorDiv.textContent = data.message;
                        errorDiv.classList.remove('hidden');
                        
                        // Reset button
                        buttonText.textContent = originalText;
                        loginForm.querySelector('button').disabled = false;
                        
                        // Shake animation for error
                        errorDiv.classList.add('animate__animated', 'animate__headShake');
                        setTimeout(() => {
                            errorDiv.classList.remove('animate__animated', 'animate__headShake');
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorDiv.textContent = 'An error occurred. Please try again.';
                    errorDiv.classList.remove('hidden');
                    buttonText.textContent = originalText;
                    loginForm.querySelector('button').disabled = false;
                });
            });

            // Animate input fields on focus
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.classList.add('scale-105');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.parentElement.classList.remove('scale-105');
                });
            });
        });
    </script>
    
</body>
</html>
