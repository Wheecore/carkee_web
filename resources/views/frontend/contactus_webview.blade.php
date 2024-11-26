<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.html">
    <link rel="icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ static_asset('new_front_assets/css/lib.min.css') }}">
    <link rel="stylesheet" href="{{ static_asset('new_front_assets/css/main.min.css') }}">
</head>

<body>
    <main class="overflow-hidden">
        <header class="page header text-contrast bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="bold display-md-4 text-contrast mb-4">Contact</h1>
                        <p class="lead text-contrast">Including a Contact Form? Try out one of the variations we bring you.</p>
                    </div>
                </div>
            </div>
        </header>
        <div class="position-relative">
            <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-light"><svg viewBox="0 0 2880 48"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
                </svg></div>
        </div>
        <div class="container-fluid py-3 demo-blocks">
            <!-- ./Contact -->
            <section class="section block bg-contrast">
                <div class="container py-4">
                    <div class="row gap-y">
                        <div class="col-12 col-md-6">
                            <div class="section-heading">
                                <p class="text-uppercase">Get in touch</p>
                                <h2 class="font-md bold">We'd like to hear from you</h2>
                            </div>
                            <p class="lead mb-5">Don't hesitate to get in contact with us no matter your request. We are here to
                                help you.</p>
                                <p class="copyright">© {{ date('Y') }} <em>by</em> <span class="brand bold"> Carkee Automotive Sdn Bhd (1498396-V)</span></p>
                            <ul class="list-unstyled list-icon">
                                <li><i class="fas fa-map-marker text-primary"></i>
                                    <p>32, Jalan SS23/11 Taman SEA. 47400 Petaling Jaya. Selangor</p>
                                </li>
                                <li><i class="fas fa-phone text-primary"></i>
                                    <p>0123440911</p>
                                </li>
                                <li><i class="fas fa-envelope text-primary"></i>
                                    <p><a href="mailto:enquiry@carkee.my">enquiry@carkee.my</a></p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-md-6">
                            <form action="" method="POST">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="" class="text-dark bold mb-0">Email address</label>
                                    <div id="emailHelp" class="small form-text text-secondary mt-0 mb-2 italic">We'll never share your email with anyone else.</div>
                                    <input type="email" name="email" id="email" class="form-control bg-contrast" placeholder="Valid Email" required>
                                    <label id="email-error" class="is-invalid error d-none" for="email">This field is required.</label>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="" class="text-dark bold mb-0">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control bg-contrast" placeholder="Subject" required>
                                    <label id="subject-error" class="is-invalid error d-none" for="subject">This field is required.</label>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="contact_email" class="text-dark bold">Message</label>
                                    <textarea name="message" id="message" class="form-control bg-contrast" placeholder="What do you want to let us know?" rows="8" required></textarea>
                                    <label id="message-error" class="is-invalid error d-none" for="message">This field is required.</label>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="d-grid gap-2">
                                        <button type="button" id="btn-submit-form" class="btn btn-primary btn-rounded">Send Message</button>
                                    </div>
                                </div>
                                <div class="response-message alert alert-success d-none">
                                    <div class="section-heading"><i class="fas fa-check font-lg"></i>
                                        <p class="font-md m-0">Thank you!</p>
                                        <p class="response">Your message has been send, we will contact you as soon as possible.</p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src="{{ static_asset('new_front_assets/js/core.min.js') }}"></script>
    <script src="{{ static_asset('new_front_assets/js/lib.min.js') }}"></script>
    <script src="{{ asset('new_front_assets/js/main.min.js') }}"></script>
</body>
</html>
