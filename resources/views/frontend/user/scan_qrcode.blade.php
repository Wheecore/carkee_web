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

        function onScanSuccess(qrMessage) {
          const currentUrl = window.location.pathname;

          if (currentUrl.includes('scan-do')) {
            const qrMessageJson = JSON.parse(qrMessage);
            console.log(qrMessageJson);

            location.href = 'do-order/' + decodeURIComponent(qrMessageJson.order_code);
          } else {
            location.href = 'qrcode-order/' + decodeURIComponent(qrMessage);
          }

            // handle the scanned code as you like
            //console.log(`QR matched = ${qrMessage}`);
            //location.href = decodeURIComponent(qrMessage);
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning
            console.warn(`QR error = ${error}`);
            //$('#qr-reader-error').text(error);

        }

        let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 }, /* verbose= */ true);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        $(document).ready(function() {
            $(document).on('click', 'input.device_control', function() {
                $('#deviceModal').modal('hide');
                var cameraId = $(this).attr('data-id');
                startScan(cameraId);
            });

            $('button', $('#reader__dashboard_section_csr')).trigger('click');
        });

        function startScan(cameraId) {
            const html5QrCode = new Html5Qrcode("reader", true);
            html5QrCode.start(
                cameraId,
                {
                    fps: 10,    // Optional frame per seconds for qr code scanning
                    qrbox: 250  // Optional if you want bounded box UI
                },
                qrCodeMessage => {
                    alert('matched');
                    // do something when code is read
                    location.href = qrCodeMessage;
                    $('#qr-reader-results').text(qrCodeMessage);
                },
                errorMessage => {
                    // parse error, ignore it.
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
