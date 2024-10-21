@extends('frontend.layouts.user_panel')
@section('panel_content')

    <style>
        #deviceModal .modal-header{margin-top: 10px; font-weight:bold;}
        .device label{display: flex; }
        .device label span{line-height: 38px; margin-left: 10px;}
        .device .form-control{display: inline-block;width:30px;}
        .hero-area{border: 2px solid green;   margin: 10px;  min-height: 50vh;}
        #reader{border:none !important;}
        #reader > div > span:nth-child(1){font-size: 25px; font-weight: bold;}
        #reader__dashboard_section_csr button{
            color: white;
            background-color: #01f3ff;
            border-color: #01f3ff;
            font-size: 20px;
            border-radius: 5px;
            margin: 10px 0 20px;
            padding: 5px 10px;
        }
        #reader__dashboard_section_csr select{width: 30%; height: 44px; border-radius: 5px;}
        /*#reader__dashboard_section_swaplink{display:none;}*/
        #reader__scan_region > img{width: 40%;}
    </style>

    <section class="mb-4 mt-4">
        <div class="container">
            <div class="mb-3 bg-white shadow-sm rounded">
                <div class="p-3 border-bottom fs-16 fw-600">
                    <div id="qr-reader-error" style="color: red;"></div>
                    <div id="reader" style="width:100%"></div>
                    <div id="qr-reader-results"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="deviceModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Please Choose a Camera Device To Scan
                </div>
                <div class="modal-body">
                    <div class="devices">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript" src="{{ static_asset('assets/js/html5-qrcode.min.js') }}"></script>
    <script type="text/javascript">

        function getQrBoxSize() {
            if (window.innerWidth < 768) {
                // Smaller screen (e.g., mobile)
                return { width: window.innerWidth * 0.8, height: window.innerWidth * 0.8 }; // 80% of screen width
            } else {
                // Larger screen (e.g., desktop)
                return { width: 350, height: 350 }; // Fixed size for desktops
            }
        }

        function onScanSuccess(qrMessage) {
            console.log("QR Code scanned: ", qrMessage);  // For debugging

            // Stop the scanner once a QR code is successfully scanned
            html5QrcodeScanner.clear(); // Stop the QR code scanner

            const currentUrl = window.location.pathname;

            if (currentUrl.includes('scan-do')) {
                try {
                    const qrMessageJson = JSON.parse(qrMessage);
                    // Delay redirection slightly to ensure stopping
                    setTimeout(() => {
                        location.href = 'do-order/' + decodeURIComponent(qrMessageJson.order_code);
                    }, 1000); // Optional delay for a smoother transition
                } catch (error) {
                    console.error("Error parsing QR code: ", error);
                }
            } else {
                // Delay redirection slightly to ensure stopping
                setTimeout(() => {
                    location.href = 'qrcode-order/' + decodeURIComponent(qrMessage);
                }, 1000); // Optional delay for a smoother transition
            }
        }

        function onScanFailure(error) {
            console.warn(`QR error = ${error}`);
        }

        // Initialize the QR code scanner
        let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,
            qrbox: getQrBoxSize(),
        }, true);

        // Render the QR code scanner
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        // Re-render the scanner when the window is resized
        window.addEventListener('resize', () => {
            html5QrcodeScanner.clear(); // Clear the scanner
            html5QrcodeScanner.render(onScanSuccess, onScanFailure); // Re-render with the new size
        });

        $(document).ready(function() {
            $(document).on('click', 'input.device_control', function() {
                $('#deviceModal').modal('hide');
                var cameraId = $(this).attr('data-id');
                startScan(cameraId);
            });

            $('button', $('#reader__dashboard_section_csr')).trigger('click');
        });

        function startScan(cameraId) {
            const html5QrCode = new Html5QrCode("reader", true);
            html5QrCode.start(
                cameraId,
                {
                    fps: 10,    // Optional frame per seconds for qr code scanning
                    qrbox: getQrBoxSize()  // Optional if you want bounded box UI
                },
                qrCodeMessage => {
                    alert('matched');
                    location.href = qrCodeMessage;
                    $('#qr-reader-results').text(qrCodeMessage);
                },
                errorMessage => {
                    $('#qr-reader-error').text(errorMessage);
                }
            ).catch(
                err => {
                    $('#qr-reader-error').text(err);
                }
            );
        }

    </script>


@endsection
