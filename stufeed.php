<?php
include 'components/header.php'; 
include 'components/conn.php';

// Handle form submission
if(isset($_POST['submit_feedback'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $sql = "INSERT INTO feedback (full_name, email, message, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    
    if($stmt) {
        $stmt->bind_param("sss", $full_name, $email, $message);
        
        if($stmt->execute()) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Thank You!',
                        text: 'Your feedback has been submitted successfully!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                });
            </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error submitting your feedback. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Try Again',
                        confirmButtonColor: '#dc2626'
                    });
                });
            </script>";
        }
        $stmt->close();
    }
}
?>

<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 py-4 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-lg mx-auto w-full">
        <!-- Compact Header Section -->
        <div class="text-center mb-4">
            <div class="flex justify-center mb-2">
                <div class="bg-green-600 p-2 rounded-full">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Application Submitted!</h1>
            <p class="text-sm text-gray-600">How was your experience?</p>
        </div>

        <!-- Compact Feedback Form -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-green-600 px-4 py-3">
                <h2 class="text-lg font-bold text-white">Quick Feedback</h2>
            </div>

            <form class="px-4 py-4" method="post">
                <!-- Two Column Layout for Name and Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-xs font-medium text-gray-700 mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="full_name" 
                               name="full_name" 
                               required
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500"
                               placeholder="Your name">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500"
                               placeholder="your@email.com">
                    </div>
                </div>

                <!-- Compact Feedback Message -->
                <div class="mb-4">
                    <label for="message" class="block text-xs font-medium text-gray-700 mb-1">
                        Your Feedback <span class="text-red-500">*</span>
                    </label>
                    <textarea id="message" 
                              name="message" 
                              rows="3" 
                              required
                              class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 resize-none"
                              placeholder="Share your experience with the application process..."></textarea>
                </div>

                <!-- Compact Button Layout -->
                <div class="flex gap-2">
                    <button type="submit" 
                            name="submit_feedback"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md text-sm transition duration-200">
                        Submit Feedback
                    </button>
                    <a href="index.php" 
                       class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md text-sm transition duration-200 text-center">
                        Skip
                    </a>
                </div>
            </form>
        </div>

        <!-- Compact Info Section -->
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-xs font-medium text-blue-800">What's Next?</h3>
                    <div class="mt-1 text-xs text-blue-700">
                        <p>• Application under review (2-4 weeks)</p>
                        <p>• Updates via email/phone</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Compact Contact -->
        <div class="mt-3 text-center">
            <p class="text-xs text-gray-600">
                Questions? <a href="mailto:osas@msu.edu.ph" class="text-green-600 hover:text-green-800 font-medium">osas@msu.edu.ph</a>
            </p>
        </div>
    </div>
</div>

<style>
    .scale-animation {
        animation: scaleIn 0.3s ease-out;
    }
    
    @keyframes scaleIn {
        0% { transform: scale(0.95); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.max-w-lg');
        container.classList.add('scale-animation');
        
        // Simple form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const fullName = document.getElementById('full_name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (fullName.length < 2 || !email.includes('@') || message.length < 5) {
                e.preventDefault();
                alert('Please fill all fields properly.');
            }
        });
    });
</script>

<?php include 'components/footer.php'; ?>