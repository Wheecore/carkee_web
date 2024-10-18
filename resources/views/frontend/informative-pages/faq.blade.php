@extends('frontend.informative-pages.layout')
@section('title', 'Carkee | FAQ')
@section('content')
        <header class="page header text-contrast bg-primary">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="bold display-md-4 text-contrast mb-4">FAQ&#39;s</h1>
                        <p class="lead text-contrast">Help your users to hel discover and answer their questions in an easy way</p>
                    </div>
                </div>
            </div>
        </header>
        <div class="position-relative">
            <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-light"><svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
                </svg></div>
        </div>
        <div class="container-fluid py-3 demo-blocks">
            <!-- ./FAQs -->
            <section class="section block bg-contrast">
                <div class="container py-4">
                    <div class="row">
                        <div class="col-md-4">
                            <h2>Do you have <span class="bold">questions?</span></h2>
                            <p class="lead">Not sure how this template can help you? Wonder why you need to buy our theme?</p>
                            <p class="text-muted">Here are the answers to some of the most common questions we hear from our appreciated customers</p>
                        </div>
                        <div class="col-md-8">
                            <div class="accordion accordion-clean" id="faqs-accordion">
                                <div class="card mb-3">
                                    <div class="card-header"><a href="#" class="card-title btn" data-bs-toggle="collapse" data-bs-target="#v1-q1"><i class="fas fa-angle-down angle"></i> What does the package include?</a></div>
                                    <div id="v1-q1" class="collapse show" data-bs-parent="#faqs-accordion">
                                        <div class="card-body">When you buy Carkee, you get all you see in the demo but the images. We include SASS files for styling, complete JS files with comments, all HTML variations. Besides we include all mobile PSD mockups.</div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header"><a href="#" class="card-title btn collapsed" data-bs-toggle="collapse" data-bs-target="#v1-q2"><i class="fas fa-angle-down angle"></i> What is the typical response time for a support question?</a></div>
                                    <div id="v1-q2" class="collapse" data-bs-parent="#faqs-accordion">
                                        <div class="card-body">Since you report us a support question we try to make our best to find out what is going on, depending on the case it could take more or les time, however a standard time could be minutes or hours.</div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header"><a href="#" class="card-title btn collapsed" data-bs-toggle="collapse" data-bs-target="#v1-q3"><i class="fas fa-angle-down angle"></i> What do I need to know to customize this template?</a></div>
                                    <div id="v1-q3" class="collapse" data-bs-parent="#faqs-accordion">
                                        <div class="card-body">Our documentation give you all you need to customize your copy. However you will need some basic web design knowledge (HTML, Javascript and CSS)</div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header"><a href="#" class="card-title btn collapsed" data-bs-toggle="collapse" data-bs-target="#v1-q4"><i class="fas fa-angle-down angle"></i> Can I suggest a new feature?</a></div>
                                    <div id="v1-q4" class="collapse" data-bs-parent="#faqs-accordion">
                                        <div class="card-body">Definitely <span class="bold">Yes</span>, you can contact us to let us know your needs. If your suggestion represents any value to both we can include it as a part of the theme or you can request a custom build by an extra cost. Please note it could take some time in order for the feature to be implemented.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- ./FAQs -->
            <section class="section block bg-contrast">
                <div class="container py-4">
                    <div class="row gap-y">
                        <div class="col-md-4">
                            <div class="light text-center text-md-end font-lg">
                                <p class="my-0">Frequently <span class="d-block font-md text-secondary">asked</span></p>
                                <p class="my-0 text-uppercase text-info mt-n3">questions</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="accordion accordion-clean accordion-collapsed accordion-4" id="faqs-accordion-2">
                                <div class="card">
                                    <div class="card-header"><a href="#" class="card-title btn" data-bs-toggle="collapse" data-bs-target="#v2-q1"><i class="fas fa-angle-down angle"></i> What does the package include?</a></div>
                                    <div id="v2-q1" class="collapse" data-bs-parent="#faqs-accordion-2">
                                        <div class="card-body">When you buy Carkee, you get all you see in the demo but the images. We include SASS files for styling, complete JS files with comments, all HTML variations. Besides we include all mobile PSD mockups.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header"><a href="#" class="card-title btn" data-bs-toggle="collapse" data-bs-target="#v2-q2"><i class="fas fa-angle-down angle"></i> What is the typical response time for a support question?</a></div>
                                    <div id="v2-q2" class="collapse" data-bs-parent="#faqs-accordion-2">
                                        <div class="card-body">Since you report us a support question we try to make our best to find out what is going on, depending on the case it could take more or les time, however a standard time could be minutes or hours.</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header"><a href="#" class="card-title btn" data-bs-toggle="collapse" data-bs-target="#v2-q3"><i class="fas fa-angle-down angle"></i> What do I need to know to customize this template?</a></div>
                                    <div id="v2-q3" class="collapse" data-bs-parent="#faqs-accordion-2">
                                        <div class="card-body">Our documentation give you all you need to customize your copy. However you will need some basic web design knowledge (HTML, Javascript and CSS)</div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header"><a href="#" class="card-title btn" data-bs-toggle="collapse" data-bs-target="#v2-q4"><i class="fas fa-angle-down angle"></i> Can I suggest a new feature?</a></div>
                                    <div id="v2-q4" class="collapse" data-bs-parent="#faqs-accordion-2">
                                        <div class="card-body">Definitely <span class="bold">Yes</span>, you can contact us to let us know your needs. If your suggestion represents any value to both we can include it as a part of the theme or you can request a custom build by an extra cost. Please note it could take some time in order for the feature to be implemented.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- ./FAQs -->
            <section class="section block bg-contrast">
                <div class="container py-4">
                    <div class="section-heading text-center">
                        <h2 class="text-capitalize">frequently <span class="bold">asked questions</span></h2>
                        <p class="lead text-secondary">Here are the answers to some of the most common questions we hear from our appreciated customers</p>
                    </div>
                    <div class="row gap-y">
                        <div class="col-md-6">
                            <h5 class="bold">What does the package include?</h5>
                            <p>When you buy Carkee, you get all you see in the demo but the images. We include SASS files for styling, complete JS files with comments, all HTML variations. Besides we include all mobile PSD mockups.</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="bold">What is the typical response time for a support question?</h5>
                            <p>Since you report us a support question we try to make our best to find out what is going on, depending on the case it could take more or les time, however a standard time could be minutes or hours.</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="bold">What do I need to know to customize this template?</h5>
                            <p>Our documentation give you all you need to customize your copy. However you will need some basic web design knowledge (HTML, Javascript and CSS)</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="bold">Can I suggest a new feature?</h5>
                            <p>Definitely <span class="bold">Yes</span>, you can contact us to let us know your needs. If your suggestion represents any value to both we can include it as a part of the theme or you can request a custom build by an extra cost. Please note it could take some time in order for the feature to be implemented.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @endsection
