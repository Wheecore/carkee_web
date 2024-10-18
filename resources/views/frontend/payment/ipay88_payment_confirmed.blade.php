@extends('frontend.layouts.custom_layout')
@section('content')
    <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card shadow-sm border-0 rounded card-r">
                        <div class="card-body">
                            <div class="text-center py-4 mb-4">
                                <i class="la la-check-circle la-3x text-success mb-3"></i>
                                <h1 class="h3 mb-3 fw-600">{{ translate('Success!') }}</h1>
                                <h2 class="h5">
                                    @php
                                        switch ($reschedule) {
                                            case 'carwash_membership':
                                                echo translate('You have successfully become a new car wash member');
                                                break;
                                        }
                                    @endphp
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
