
// Simplified QR code handling (only for 192.168.101.78)
document.addEventListener('DOMContentLoaded', function() {
    // Network check function - defined in PHP file and injected when included
    if (typeof checkNetwork === 'function') {
        checkNetwork();
    }
    const qrImg = document.querySelector('.qr-image');
    
    // Handle QR image error
    qrImg.onerror = function() {
        console.error('QR code failed to load');
    };
    
    // Network diagnostics
    const diagnosticBtn = document.getElementById('run-diagnostics');
    const diagnosticResults = document.getElementById('diagnostic-results');
    
    diagnosticBtn.addEventListener('click', function() {
        diagnosticResults.classList.remove('hidden');
        diagnosticResults.innerHTML = '<p>Running network diagnostics...</p>';
        
        fetch('../components/network_diagnostic.php?t=' + new Date().getTime())
            .then(response => response.json())
            .then(data => {
                let html = '<h4 class="font-bold">Network Diagnostic Results</h4>';
                html += '<p class="mt-1"><strong>Server:</strong> ' + data.server_info.server_software + '</p>';
                html += '<p><strong>Host:</strong> ' + data.server_info.http_host + '</p>';
                html += '<p><strong>Server IP:</strong> ' + data.server_info.server_addr + '</p>';
                html += '<p><strong>Server Port:</strong> ' + data.server_info.server_port + '</p>';
                
                html += '<h4 class="font-bold mt-2">Using IP Address:</h4>';
                html += '<p>' + data.server_ips[0] + '</p>';
                
                diagnosticResults.innerHTML = html;
            })
            .catch(error => {
                diagnosticResults.innerHTML = '<p class="text-red-500">Error running diagnostics: ' + error.message + '</p>';
            });
    });
});
