<?php
// Include session check at the top before any output
include 'components/session_check.php';

// Check if user is logged in and has admin role
redirect_if_not_authorized('admin');

include 'components/header.php'; 
include 'components/conn.php';

// Get all feedback entries ordered by newest first
$query = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($query);

// Count total feedback entries
$feedback_count = 0;
$count_query = "SELECT COUNT(*) as total FROM feedback";
$count_result = $conn->query($count_query);
if ($count_result) {
    $row = $count_result->fetch_assoc();
    $feedback_count = $row['total'];
}
?>

<div class="flex h-screen bg-white overflow-hidden">
    <!-- Sidebar - Same as in dashboard.php -->
    <div class="w-64 bg-white border-r border-green-100 flex flex-col shadow-lg z-10 relative">
        <div class="p-4 mb-2 bg-gradient-to-r from-green-500 to-green-400 text-white">
            <div class="flex items-center justify-center">
                <svg class="w-8 h-8 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"></path>
                </svg>
                <h1 class="text-xl font-bold">Admin Panel</h1>
            </div>
        </div>
        <nav class="flex-1">
            <ul class="space-y-1 p-3">
                <li class="group">
                    <a href="dashboard.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v10m4-10l2 2m-2-2v10"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Home</span>
                        <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-0.5 rounded-full group-hover:bg-green-200 transition-colors duration-300">Dashboard</span>
                    </a>
                </li>
                <li class="group">
                    <a href="add_staff.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">Add Staff</span>
                    </a>
                </li>
                <li class="group">
                    <a href="ched_account.php" class="flex items-center p-3 rounded-lg hover:bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-500 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-green-700 font-medium">CHED Accounts</span>
                    </a>
                </li>
                <li class="group">
                    <a href="feedback.php" class="flex items-center p-3 rounded-lg bg-green-50 transition-all duration-300 group-hover:translate-x-1 transform">
                        <svg class="w-5 h-5 text-green-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        <span class="ml-3 text-green-700 font-medium">Feedback</span>
                        <?php if ($feedback_count > 0): ?>
                        <span class="ml-auto bg-green-500 text-white text-xs px-2 py-0.5 rounded-full animate-pulse"><?php echo $feedback_count; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="border-t border-gray-100 my-2 pt-2"></li>
                <li class="group">
                    <a href="index.php" class="flex items-center p-3 rounded-lg hover:bg-red-50 transition-all duration-300">
                        <svg class="w-5 h-5 text-red-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="ml-3 text-gray-700 group-hover:text-red-700 font-medium">Log Out</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold">A</div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700">Admin User</p>
                    <p class="text-xs text-gray-500">admin@iskonnect.com</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto bg-gradient-to-br from-white to-green-50 relative">
        <div id="particles-js" class="absolute inset-0 opacity-30"></div>
        
        <!-- Top Navigation Bar -->
        <div class="bg-white shadow-sm border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">Feedback Management</h2>
                <div class="ml-4 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Admin</div>
            </div>
            <div class="flex items-center space-x-4">
                <div>
                    <span class="text-sm text-gray-600"><?php echo date("F j, Y"); ?></span>
                </div>
            </div>
        </div>
        
        <!-- Feedback Management Section -->
        <div class="p-6 animate__animated animate__fadeIn">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-800">User Feedback</h1>
                        <div class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                            Total: <?php echo $feedback_count; ?>
                        </div>
                    </div>
                    
                    <?php if ($feedback_count == 0): ?>
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No feedback yet</h3>
                        <p class="mt-1 text-gray-500">Feedback from users will appear here when submitted.</p>
                    </div>
                    <?php else: ?>
                    
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="feedbackSearch" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Search by name, email or message content...">
                        </div>
                    </div>
                    
                    <!-- Feedback Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="feedbackContainer">
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="feedback-card bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 full-name"><?php echo htmlspecialchars($row['full_name']); ?></h3>
                                        <p class="text-sm text-blue-600 email"><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>"><?php echo htmlspecialchars($row['email']); ?></a></p>
                                    </div>
                                    <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        <?php echo date('M j, Y', strtotime($row['created_at'])); ?>
                                    </span>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg mb-3 message">
                                    <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                                </div>
                                <div class="flex justify-end space-x-2">
                                    <button onclick="markAsRead(<?php echo $row['id']; ?>)" class="py-1.5 px-3 text-xs font-medium text-center text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-100">
                                        Mark as Read
                                    </button>
                                    <button onclick="replyToFeedback('<?php echo htmlspecialchars($row['email']); ?>')" class="py-1.5 px-3 text-xs font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-2 focus:outline-none focus:ring-green-300">
                                        Reply
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate__animated animate__fadeInDown">
        <div class="flex justify-between items-center border-b p-4 md:p-6">
            <h3 class="text-xl font-semibold text-gray-800">Reply to Feedback</h3>
            <button id="closeReplyModal" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4 md:p-6">
            <form id="replyForm" class="space-y-4">
                <div>
                    <label for="recipient" class="block text-sm font-medium text-gray-700">To</label>
                    <input type="email" id="recipient" name="recipient" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500" readonly>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <input type="text" id="subject" name="subject" value="Re: Your feedback to Iskonnect" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label for="replyMessage" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea id="replyMessage" name="message" rows="5" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
                <div id="replyStatus" class="hidden p-3 rounded-md">
                </div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Send Reply
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Initialize particles.js effect -->
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
                },
            },
            "opacity": {
                "value": 0.3,
                "random": false,
                "anim": {
                    "enable": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#4ade80",
                "opacity": 0.2,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 2,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
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

    // Search functionality
    const searchInput = document.getElementById('feedbackSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const feedbackCards = document.querySelectorAll('.feedback-card');
            
            feedbackCards.forEach(card => {
                const name = card.querySelector('.full-name').textContent.toLowerCase();
                const email = card.querySelector('.email').textContent.toLowerCase();
                const message = card.querySelector('.message').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm) || message.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Reply modal functionality
    const replyModal = document.getElementById('replyModal');
    const closeReplyModal = document.getElementById('closeReplyModal');
    const replyForm = document.getElementById('replyForm');
    const replyStatus = document.getElementById('replyStatus');
    
    if (closeReplyModal) {
        closeReplyModal.addEventListener('click', function() {
            replyModal.classList.add('hidden');
        });
    }
    
    if (replyForm) {
        replyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show sending status
            replyStatus.classList.remove('hidden');
            replyStatus.classList.add('bg-blue-100', 'text-blue-800', 'border', 'border-blue-200');
            replyStatus.textContent = 'Sending reply...';
            
            // In a real application, you would connect to your email sending API here
            setTimeout(function() {
                replyStatus.classList.remove('bg-blue-100', 'text-blue-800', 'border-blue-200');
                replyStatus.classList.add('bg-green-100', 'text-green-800', 'border', 'border-green-200');
                replyStatus.textContent = 'Reply sent successfully!';
                
                // Reset form
                replyForm.reset();
                
                // Close modal after delay
                setTimeout(function() {
                    replyModal.classList.add('hidden');
                }, 2000);
            }, 1500);
        });
    }
});

// Function to reply to feedback
function replyToFeedback(email) {
    const replyModal = document.getElementById('replyModal');
    const recipientInput = document.getElementById('recipient');
    
    if (replyModal && recipientInput) {
        recipientInput.value = email;
        replyModal.classList.remove('hidden');
    }
}

// Function to mark feedback as read
function markAsRead(id) {
    // In a real application, you would make an AJAX call to update the status
    // For this example, we just change the style
    const card = event.target.closest('.feedback-card');
    card.classList.add('opacity-75');
    
    // Show success notification
    const notification = document.createElement('div');
    notification.classList.add('fixed', 'bottom-5', 'right-5', 'bg-green-100', 'border', 'border-green-400', 'text-green-700', 'px-4', 'py-3', 'rounded', 'shadow-md', 'animate__animated', 'animate__fadeIn');
    notification.innerHTML = 'Feedback marked as read';
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('animate__fadeIn');
        notification.classList.add('animate__fadeOut');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 1000);
    }, 3000);
}
</script>

<?php include 'components/footer.php'; ?>