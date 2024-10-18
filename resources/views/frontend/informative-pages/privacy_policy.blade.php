@extends('frontend.informative-pages.layout')
@section('title', 'Privacy Policy')
@section('content')

    @php
        $privacy_policy = \App\Models\Page::where('type', 'privacy_policy_page')->first();
    @endphp
    <style>
        .bg-contrast.edge.bottom-right::after {
            background-image: unset;
        }
    </style>
    <header class="page header text-contrast bg-primary" style="">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="bold display-md-4 text-contrast mb-4">{{ $privacy_policy->getTranslation('title') }}</h1>
                    <p class="lead text-contrast"></p>
                </div>
            </div>
        </div>
    </header>

    <div class="position-relative">
        <div class="shape-divider shape-divider-bottom shape-divider-fluid-x text-contrast">
            <svg viewBox="0 0 2880 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z"></path>
            </svg>
        </div>
    </div>

    <section class="section overview">
        <div class="container">
            <div class="row align-items-center gap-y">
                <div class="col-lg-12">
                    @php
                        echo $privacy_policy->getTranslation('content');
                    @endphp
                </div>
            </div>
        </div>
    </section>

@endsection
