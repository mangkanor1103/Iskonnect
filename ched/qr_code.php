<?php
include '../components/session_check.php';

// Check if user is logged in and has ched role
redirect_if_not_authorized('ched');

include '../components/conn.php';

$username = $_SESSION['username'];

// Detect if running locally or online
$is_localhost = in_array($_SERVER['SERVER_ADDR'], ['127.0.0.1', '::1', '192.168.101.78']) || 
                strpos($_SERVER['HTTP_HOST'], 'localhost') !== false;

// Always use https:// server_name format for consistency across environments
$server_name = $_SERVER['HTTP_HOST'];
$form_url = "https://$server_name/students.php";

// Add network check JavaScript function
$network_check_js = "
    function checkNetwork() {
        // Create a unique endpoint with timestamp to avoid caching
        const testEndpoint = 'https://$server_name/components/network_check.php?t=' + new Date().getTime();
        
        return fetch(testEndpoint, { 
            mode: 'no-cors',
            cache: 'no-cache',
            timeout: 2000
        })
        .then(() => {
            document.getElementById('network-status').innerHTML = '<span class=\"bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full\">Connected to server</span>';
            document.getElementById('network-message').classList.add('hidden');
            return true;
        })
        .catch(() => {
            document.getElementById('network-status').innerHTML = '<span class=\"bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full\">Cannot connect to server</span>';
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
                <h1 class="text-lg font-semibold text-gray-900">Application Form QR Code</h1>                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="inline-flex items-center p-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" title="Back to Dashboard">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </a>
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print QR Code
                    </button>
                    <button id="download-pdf" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download as PDF
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
                    <p class="text-sm text-red-600">Warning: Users must be connected to the same network (192.168.101.78) to access the form.</p>
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
        visibility: hidden !important;
    }
    
    /* Ensure QR code is visible */
    .qr-image {
        display: block !important;
        visibility: visible !important;
        width: 350px !important;
        height: 350px !important;
    }
    
    .qr-container {
        margin-top: 2rem !important;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<script>
    <?php echo $network_check_js; ?>

    // Simplified QR code handling
    document.addEventListener('DOMContentLoaded', function () {
        const qrImg = document.querySelector('.qr-image');

        // Handle QR image error
        qrImg.onerror = function () {
            console.error('QR code failed to load');
        };
        
        // PDF download functionality
        const downloadPdfBtn = document.getElementById('download-pdf');
        if (downloadPdfBtn) {
            downloadPdfBtn.addEventListener('click', function() {
                // Show loading indicator
                const originalText = this.innerHTML;
                this.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Generating PDF...
                `;
                
                // Wait for libraries to load
                if (typeof html2canvas === 'undefined' || typeof window.jspdf === 'undefined') {
                    alert('PDF generation libraries are still loading. Please try again in a moment.');
                    this.innerHTML = originalText;
                    return;
                }
                
                // Get the section to convert to PDF
                const printSection = document.querySelector('.print-section');
                
                // Temporarily hide network status elements
                const networkStatus = document.getElementById('network-status');
                const networkMessage = document.getElementById('network-message');
                
                // Save original display states
                const networkStatusDisplay = networkStatus.style.display;
                const networkMessageDisplay = networkMessage.style.display;
                
                // Hide network elements for PDF
                networkStatus.style.display = 'none';
                networkMessage.style.display = 'none';
                
                // Use html2canvas to capture the content
                html2canvas(printSection, {
                    scale: 2, // Higher scale for better quality
                    useCORS: true, // Enable CORS for images from different domains
                    logging: false
                }).then(canvas => {
                    // Restore network elements display after canvas capture
                    networkStatus.style.display = networkStatusDisplay;
                    networkMessage.style.display = networkMessageDisplay;
                    
                    const { jsPDF } = window.jspdf;
                    
                    // Create PDF instance (A4 size)
                    const pdf = new jsPDF('portrait', 'mm', 'a4');
                    
                    // Get canvas dimensions
                                        // Get canvas dimensions
                    const imgWidth = 210; // A4 width in mm (210mm)
                    const pageHeight = 297; // A4 height in mm
                    const imgHeight = canvas.height * imgWidth / canvas.width;
                    
                    // Add the canvas as image with proper centering
                    const imgData = canvas.toDataURL('image/png');
                    
                    // Calculate vertical position to center on page
                    const yPosition = Math.max(0, (pageHeight - imgHeight) / 2);
                    
                    // Add the image centered with a slight adjustment to avoid cutting off content at bottom
                    pdf.addImage(imgData, 'PNG', 0, yPosition * 0.7, imgWidth, imgHeight * 0.9);
                    
                    
                    
                    // Save the PDF
                    pdf.save('application_form_qr_code.pdf');
                    
                    // Restore button text
                    this.innerHTML = originalText;
                }).catch(err => {
                    // Restore network elements display in case of error
                    networkStatus.style.display = networkStatusDisplay;
                    networkMessage.style.display = networkMessageDisplay;
                    
                    console.error('Error generating PDF:', err);
                    alert('Error generating PDF. Please try again.');
                    this.innerHTML = originalText;
                });
            });
        }

        // Existing code for trying alternative URL formats
        const tryAltBtn = document.getElementById('tryAltBtn');
        if (typeof tryAltBtn !== 'undefined' && tryAltBtn) {
            tryAltBtn.addEventListener('click', function () {
                if (usingAltUrl) {
                    qrImg.classList.remove('hidden');
                    qrImgAlt.classList.add('hidden');
                    currentUrlDisplay.textContent = urlMain;
                    altUrlDisplay.textContent = urlMain;
                    tryAltBtn.textContent = 'Try alternative URL format';
                    usingAltUrl = false;
                } else {
                    switchToAltQr();
                }
            });
        }

        // Rest of your existing code
        // ...
    });
</script>

<?php include '../components/footer.php'; ?>
