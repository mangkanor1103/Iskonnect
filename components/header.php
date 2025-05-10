<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iskonnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Add Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Add animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Add SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add Lottie Player for animations -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
<body class="bg-gray-50">
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

    <!-- About Modal -->
    <div id="aboutModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center hidden modal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate__animated animate__fadeInDown">
            <div class="flex justify-between items-center border-b p-4 md:p-6">
                <h3 class="text-xl font-semibold text-gray-800">About Iskonnect</h3>
                <button class="closeModal text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 md:p-6">
                <div class="mb-4 text-center">
                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-gray-800 mb-2">Iskonnect Platform</h4>
                    <p class="text-gray-600">Version 1.0.0</p>
                </div>
                <div class="space-y-3 text-gray-600">
                    <p>Iskonnect is a comprehensive management platform designed for educational institutions to streamline communication between staff and CHED officials.</p>
                    <p>Our mission is to simplify administrative tasks and improve coordination between different stakeholders in the education sector.</p>
                    <p>Developed by the IT Department of Iskonnect, this platform offers robust features for user management, reporting, and data analytics.</p>
                </div>
                <div class="border-t mt-6 pt-4">
                    <p class="text-sm text-gray-500">&copy; 2025 Iskonnect. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center hidden modal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate__animated animate__fadeInDown">
            <div class="flex justify-between items-center border-b p-4 md:p-6">
                <h3 class="text-xl font-semibold text-gray-800">Contact Us</h3>
                <button class="closeModal text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 md:p-6">
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">support@iskonnect.com</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone</p>
                            <p class="font-medium">+63 (2) 8123-4567</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-purple-100 rounded-full p-2 mr-3">
                            <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="font-medium">123 CHED Building, Quezon Avenue, Quezon City, Philippines</p>
                        </div>
                    </div>
                </div>
                <form id="contactForm" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="3" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>
                    <div id="formMessage" class="hidden p-3 rounded-md">
                    </div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="helpModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center hidden modal">
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full mx-4 animate__animated animate__fadeInDown">
            <div class="flex justify-between items-center border-b p-4 md:p-6">
                <h3 class="text-xl font-semibold text-gray-800">Help & Documentation</h3>
                <button class="closeModal text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 md:p-6 max-h-[70vh] overflow-y-auto">
                <div class="mb-6">
                    <h4 class="text-lg font-medium text-gray-800 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Frequently Asked Questions
                    </h4>
                    <div class="space-y-4">
                        <details class="border rounded-lg overflow-hidden">
                            <summary class="cursor-pointer p-4 bg-gray-50 flex justify-between items-center font-medium">
                                How do I add a new staff member?
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="p-4 border-t text-gray-600 text-sm">
                                <p>To add a new staff member:</p>
                                <ol class="list-decimal ml-5 mt-2 space-y-1">
                                    <li>Navigate to the "Add Staff" page from the sidebar</li>
                                    <li>Click on the "Add New Staff" button</li>
                                    <li>Fill in the username and password in the modal form</li>
                                    <li>Click "Add Staff" to create the new account</li>
                                </ol>
                            </div>
                        </details>
                        
                        <details class="border rounded-lg overflow-hidden">
                            <summary class="cursor-pointer p-4 bg-gray-50 flex justify-between items-center font-medium">
                                How do I add a CHED account?
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="p-4 border-t text-gray-600 text-sm">
                                <p>To add a new CHED account:</p>
                                <ol class="list-decimal ml-5 mt-2 space-y-1">
                                    <li>Navigate to the "CHED Accounts" page from the sidebar</li>
                                    <li>Click on the "Add New CHED Account" button</li>
                                    <li>Fill in the username and password in the modal form</li>
                                    <li>Click "Add CHED Account" to create the new account</li>
                                </ol>
                            </div>
                        </details>
                        
                        <details class="border rounded-lg overflow-hidden">
                            <summary class="cursor-pointer p-4 bg-gray-50 flex justify-between items-center font-medium">
                                How do I view system statistics?
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="p-4 border-t text-gray-600 text-sm">
                                <p>To view system statistics:</p>
                                <ol class="list-decimal ml-5 mt-2 space-y-1">
                                    <li>Navigate to the "Home" page from the sidebar</li>
                                    <li>The dashboard displays key statistics at the top</li>
                                    <li>For more detailed reports, click on the "View Reports" button</li>
                                </ol>
                            </div>
                        </details>
                        
                        <details class="border rounded-lg overflow-hidden">
                            <summary class="cursor-pointer p-4 bg-gray-50 flex justify-between items-center font-medium">
                                How do I log out of my account?
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="p-4 border-t text-gray-600 text-sm">
                                <p>To log out of your account:</p>
                                <ol class="list-decimal ml-5 mt-2 space-y-1">
                                    <li>Click on the "Log Out" option at the bottom of the sidebar</li>
                                    <li>Your session will end and you'll be redirected to the login page</li>
                                </ol>
                            </div>
                        </details>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-medium text-gray-800 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Need More Help?
                    </h4>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <p class="text-gray-700 mb-3">Can't find what you're looking for? Our support team is here to help!</p>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Contact Support
                            </a>
                            <a href="#" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-green-700 bg-white border-green-300 hover:bg-green-50">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                View Documentation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get modal elements
            const aboutModal = document.getElementById('aboutModal');
            const contactModal = document.getElementById('contactModal');
            const helpModal = document.getElementById('helpModal');
            
            // Get button elements
            const aboutBtn = document.getElementById('aboutBtn');
            const contactBtn = document.getElementById('contactBtn');
            const helpBtn = document.getElementById('helpBtn');
            
            // Get all close buttons
            const closeButtons = document.querySelectorAll('.closeModal');
            
            // Contact form handling
            const contactForm = document.getElementById('contactForm');
            const formMessage = document.getElementById('formMessage');
            
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Get form data
                    const formData = new FormData(contactForm);
                    
                    // Show loading message
                    formMessage.classList.remove('hidden');
                    formMessage.classList.add('bg-blue-100', 'text-blue-800', 'border', 'border-blue-200');
                    formMessage.textContent = 'Sending your message...';
                    
                    // Send AJAX request
                    fetch('submit_feedback.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Show response message
                        formMessage.classList.remove('hidden', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
                        
                        if (data.success) {
                            formMessage.classList.add('bg-green-100', 'text-green-800', 'border', 'border-green-200');
                            formMessage.classList.remove('bg-red-100', 'text-red-800', 'border', 'border-red-200');
                            formMessage.textContent = data.message;
                            
                            // Reset form on success
                            contactForm.reset();
                            
                            // Hide success message after 5 seconds
                            setTimeout(() => {
                                formMessage.classList.add('hidden');
                            }, 5000);
                        } else {
                            formMessage.classList.add('bg-red-100', 'text-red-800', 'border', 'border-red-200');
                            formMessage.classList.remove('bg-green-100', 'text-green-800', 'border', 'border-green-200');
                            formMessage.textContent = data.message;
                        }
                    })
                    .catch(error => {
                        // Show error message
                        formMessage.classList.remove('hidden', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
                        formMessage.classList.add('bg-red-100', 'text-red-800', 'border', 'border-red-200');
                        formMessage.classList.remove('bg-green-100', 'text-green-800', 'border', 'border-green-200');
                        formMessage.textContent = 'An error occurred. Please try again later.';
                        console.error('Error:', error);
                    });
                });
            }
            
            // Open modal functions
            aboutBtn.addEventListener('click', function() {
                aboutModal.classList.remove('hidden');
                document.body.classList.add('modal-active');
            });
            
            contactBtn.addEventListener('click', function() {
                contactModal.classList.remove('hidden');
                document.body.classList.add('modal-active');
            });
            
            helpBtn.addEventListener('click', function() {
                helpModal.classList.remove('hidden');
                document.body.classList.add('modal-active');
            });
            
            // Close modal function
            function closeModal() {
                aboutModal.classList.add('hidden');
                contactModal.classList.add('hidden');
                helpModal.classList.add('hidden');
                document.body.classList.remove('modal-active');
            }
            
            // Add click event to all close buttons
            closeButtons.forEach(function(button) {
                button.addEventListener('click', closeModal);
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === aboutModal || event.target === contactModal || event.target === helpModal) {
                    closeModal();
                }
            });
            
            // Close modal with ESC key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>
</body>
</html>