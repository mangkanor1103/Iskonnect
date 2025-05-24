<?php 
include '../components/session_check.php';

// Check if user is logged in and has ched role
redirect_if_not_authorized('ched');

include '../components/conn.php';

$username = $_SESSION['username'];

// IP address for local network access
$server_ip = "192.168.92.10";
$form_url = "http://$server_ip/iskonnect/students.php";

// Add network check JavaScript function
$network_check_js = "
    function checkNetwork() {
        // Create a unique endpoint with timestamp to avoid caching
        const testEndpoint = 'http://$server_ip/iskonnect/components/network_check.php?t=' + new Date().getTime();
        
        return fetch(testEndpoint, { 
            mode: 'no-cors',
            cache: 'no-cache',
            timeout: 2000
        })
        .then(() => {
            document.getElementById('network-status').innerHTML = '<span class=\"bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full\">Connected to network</span>';
            document.getElementById('network-message').classList.add('hidden');
            return true;
        })
        .catch(() => {
            document.getElementById('network-status').innerHTML = '<span class=\"bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full\">Not on the same network</span>';
            document.getElementById('network-message').classList.remove('hidden');
            return false;
        });
    }
    
    // Check network status when page loads
    document.addEventListener('DOMContentLoaded', function() {
        checkNetwork();
        // Re-check every 10 seconds
        setInterval(checkNetwork, 10000);
    });
";
?>

<?php include '../components/header.php'; ?>

<div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Simple header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-lg font-semibold text-gray-900">Application Form QR Code</h1>
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Back to Dashboard
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print QR Code
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- QR Code Section -->
    <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="print-section max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <div class="text-center">
                <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Student Application Form</h2>
                <p class="mt-2 text-md text-gray-600">
                    Scan the QR code below to access the scholarship application form on your mobile device
                </p>
            </div>
              <div class="qr-container flex flex-col items-center justify-center space-y-6 py-6">
                <div id="network-status" class="mb-2">
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Checking network...</span>
                </div>
                
                <div id="network-message" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-md text-center hidden">
                    <p class="text-sm text-red-600">Warning: Users must be connected to the same network (192.168.92.10) to access the form.</p>
                </div>
                  <!-- QR Code Image -->
                <div id="qr-container">
                    <img 
                        src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode($form_url); ?>&size=300x300&margin=10" 
                        alt="Application QR Code" 
                        class="qr-image border-4 border-green-100 rounded-lg shadow-lg"
                    />
                </div>
                  <div class="text-center">
                    <p id="current-url" class="text-lg font-bold text-green-600"><?php echo $form_url; ?></p>
                    <p class="text-sm text-gray-500 mt-1">Scan to open the application form</p>
                </div>
                  <div class="text-center mt-4">
                    <p class="text-xs text-gray-400">Generated on <?php echo date("F j, Y"); ?></p>
                    <p class="text-xs text-gray-500 mt-2">If QR code doesn't work, try typing this URL in your browser:</p>
                    <p class="text-xs font-mono bg-gray-100 p-1 rounded mt-1"><strong><?php echo $form_url; ?></strong></p>
                </div>
            </div>
            
            <div class="mt-6 text-center print-instructions">
                <p class="text-sm text-gray-500">(This page will look best when printed in portrait orientation)</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    header, .print-instructions, button, footer {
        display: none !important;
    }
    
    body, html {
        background-color: white !important;
        height: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .print-section {
        box-shadow: none !important;
        margin: 0 auto !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: none !important;
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }
    
    .qr-image {
        width: 350px !important;
        height: 350px !important;
    }

    /* Hide network status elements when printing */
    #network-status, #network-message {
        display: none !important;
    }
    
    .qr-container {
        margin-top: 2rem !important;
    }
}
</style>

<script>
<?php echo $network_check_js; ?>

// QR code handling
document.addEventListener('DOMContentLoaded', function () {
    const qrImg = document.querySelector('.qr-image');

    // Handle QR image error
    qrImg.onerror = function () {
        console.error('QR code failed to load');
        // Try to reload with a different parameter to avoid cache issues
        qrImg.src = "https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode($form_url); ?>&size=300x300&margin=10&t=" + new Date().getTime();
    };
    
    // Test direct URL access
    function testUrlAccess(url) {
        const testImg = new Image();
        testImg.onload = function () {
            console.log('URL appears to be accessible: ' + url);
        };
        testImg.onerror = function () {
            console.warn('URL might not be accessible: ' + url);
        };
        // Add a small random parameter to prevent caching
        testImg.src = url + '?test=' + Math.random();
    }
    
    // Test URL after a short delay
    setTimeout(function () {
        testUrlAccess('<?php echo $form_url; ?>');
    }, 1000);
});

// Function to update QR code with a specific URL if needed
function updateQrWithUrl(url) {
    // Update QR code
    const qrContainer = document.getElementById('qr-container');
    qrContainer.innerHTML = `
    <img 
        src="https://api.qrserver.com/v1/create-qr-code/?data=${encodeURIComponent(url)}&size=300x300&margin=10" 
        alt="Custom URL QR Code" 
        class="qr-image border-4 border-green-100 rounded-lg shadow-lg"
    />
    `;

    // Update displayed URL
    document.getElementById('current-url').textContent = url;
}
</script>

<?php include '../components/footer.php'; ?>
