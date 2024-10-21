@extends('frontend.layouts.user_panel')
@section('panel_content')

    <style>
        /* General Styles */
        #deviceModal .modal-header {
            margin-top: 10px;
            font-weight: bold;
        }
        .device label {
            display: flex;
        }
        .device label span {
            line-height: 38px;
            margin-left: 10px;
        }
        .device .form-control {
            display: inline-block;
            width: 30px;
        }
        .hero-area {
            border: 2px solid green;
            margin: 10px;
            min-height: 50vh;
        }
        #reader {
            border: none !important;
            width: 100%;
            max-width: 500px; /* Adjust as needed */
            margin: 0 auto;
            position: relative;
        }
        #reader > div > span:nth-child(1) {
            font-size: 25px;
            font-weight: bold;
        }
        #reader__dashboard_section_csr button {
            color: white;
            background-color: #01f3ff;
            border-color: #01f3ff;
            font-size: 20px;
            border-radius: 5px;
            margin: 10px 0 20px;
            padding: 5px 10px;
        }
        #reader__dashboard_section_csr select {
            width: 100%; /* Make select element responsive */
            height: 44px;
            border-radius: 5px;
        }
        #reader__scan_region > img {
            width: 100%; /* Make the scanning area responsive */
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            #reader {
                max-width: 90%;
            }
        }
    </style>

    <section class="mb-4 mt-4">
        <div class="container">
            <div class="mb-3 bg-white shadow-sm rounded">
                <div class="p-3 border-bottom fs-16 fw-600">
                    <div id="qr-reader-error" style="color: red;"></div>
                    <div id="reader"></div>
                    <div id="qr-reader-results"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Camera Selection Modal (Optional) -->
    <div class="modal fade" id="deviceModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Please Choose a Camera Device To Scan
                </div>
                <div class="modal-body">
                    <div class="devices">
                        <!-- Dynamically populated camera devices -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript" src="{{ static_asset('assets/js/html5-qrcode.min.js') }}"></script>
    <script type="text/javascript">

        // Define a global variable to store the scanner instance
        let html5QrCodeScanner;
        let isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent); // Detect if it's a mobile device

        // Function to determine the initial QR box size based on screen width
        function getInitialQrBoxSize() {
            return window.innerWidth < 768 ? 200 : 350; // Adjust sizes as needed
        }

        // Full screen for mobile view
        function enterFullScreenMode() {
            const readerElement = document.getElementById('reader');
            if (readerElement.requestFullscreen) {
                readerElement.requestFullscreen();
            } else if (readerElement.mozRequestFullScreen) { // Firefox
                readerElement.mozRequestFullScreen();
            } else if (readerElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
                readerElement.webkitRequestFullscreen();
            } else if (readerElement.msRequestFullscreen) { // IE/Edge
                readerElement.msRequestFullscreen();
            }
        }

        // Callback when a QR code is successfully scanned
        function onScanSuccess(qrMessage) {
            console.log("QR Code scanned: ", qrMessage);  // For debugging
            
            // Stop the scanner once a QR code is scanned successfully
            html5QrCodeScanner.clear();

            // Redirect logic
            const currentUrl = window.location.pathname;

            if (currentUrl.includes('scan-do')) {
                try {
                    const qrMessageJson = JSON.parse(qrMessage);
                    // Delay the redirection by 1 second (1000 milliseconds)
                    setTimeout(() => {
                        location.href = 'do-order/' + decodeURIComponent(qrMessageJson.order_code);
                    }, 1000); // Adjust delay if necessary
                } catch (error) {
                    console.error("Error parsing QR code: ", error);
                }
            } else {
                // Delay the redirection by 1 second (1000 milliseconds)
                setTimeout(() => {
                    location.href = 'qrcode-order/' + decodeURIComponent(qrMessage);
                }, 1000); // Adjust delay if necessary
            }
        }

        // Callback when a QR code scan fails
        function onScanFailure(error) {
            console.warn(`QR error = ${error}`);
            // Optionally, display scan errors to the user
        }

        // Automatically select the back camera on mobile
        async function getBackCamera() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            let backCameraId = null;

            devices.forEach((device) => {
                if (device.kind === 'videoinput') {
                    // Look for "back" or "rear" in the label to find the back camera
                    if (device.label.toLowerCase().includes('back') || device.label.toLowerCase().includes('rear')) {
                        backCameraId = device.deviceId;
                    }
                }
            });

            // If no back camera found, return the first available camera
            return backCameraId || devices.find(device => device.kind === 'videoinput').deviceId;
        }

        // Initialize the QR Code Scanner with the initial QR box size
        async function initializeQrScanner() {
            let qrboxSize = getInitialQrBoxSize();
            let cameraId = null;

            if (isMobile) {
                enterFullScreenMode();  // Enter full screen for mobile devices
                cameraId = await getBackCamera();  // Automatically select the back camera
            }

            html5QrCodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: qrboxSize
            }, /* verbose= */ false);

            html5QrCodeScanner.render(onScanSuccess, onScanFailure, cameraId ? { deviceId: cameraId } : undefined);
        }

        // Initialize the scanner when the document is ready
        $(document).ready(function() {
            initializeQrScanner();
        });

        // Make the scanner responsive without re-initializing on resize
        window.addEventListener('resize', () => {
            console.log('Window resized. QR scanner remains with initial settings.');
        });

    </script>

@endsection
