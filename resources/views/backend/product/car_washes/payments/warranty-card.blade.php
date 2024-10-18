@extends('backend.layouts.app')
@section('title', translate('Car Wash Warranty Card'))
@section('css')

    <style>
        .warranty-no {
            padding: 10px;
            background: #fff;
        }
        .bb-1 {
            border-bottom: 1px solid;
        }
    </style>

@endsection
@section('content')

    <div class="card">
        <div class="card-header row">
            <div class="col">
                <a class="btn btn-primary" href="{{ route('car-wash-payments') }}" style="float: right"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="bg-dark">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-white">WARRANTY STATEMENT</h6>
                        <h4 class="text-white">AUTOMOTIVE APPLICATION</h4>
                        <p class="text-white">
                            • The warranty is made in lieu ot warranties. exprossed or implied by VANTO AUTOCARE This warranty only warrants. the sputtered firs against Peeling, bubbling. loosening, oxidising or colour-fading for a period of 10 years after installation.
                            • VANTO AUTOCARE holds no liability for damages caused by misuse or sell inflicted damaged to the films and not be held liable for any loss, damage or injuries arising from the use of this product
                            • VANTO AUTOCARE also does not warrant the glass against breakage after the product has been installed.
                            • Damages herounder shall in no case exceed the purchase price of the product.
                            • The warranty will be deemed void if the product has been tampered with, subjected to abuse, improper care, loose panels, poor grounding or if installed by anyone than VANTO AUTOCARE certitied technicians:
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="left-side m-4">
                            <div class="text-right mt-4">
                                <span class="warranty-no h6">{{ translate('Warranty No') }}: {{ $payment->id }}</span>
                            </div>
                            <img src="{{ uploaded_asset(get_setting('header_logo')) }}" width="300px">
                            <h3 class="text-white fw-800 mt-4">CARKEE SEAL OF AUTHENTICITY</h3>
                            <p class="text-white fs-16 mt-2" style="text-align: justify;">Thank you for choosing CARKEE for
                                the latest in solar film technology for your car! You've made a great choice and we will
                                assure that you would be satisfied with our products. Even though we are certain that our
                                products will withstand the tet of time, the tint you purchased will be backed by the CARKEE
                                for {{ $payment->warranty }} years warranty for your peace of mind!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white m-4">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p class="mb-1 bb-1">
                            <span class="fs-16">{{ translate('Name') }}:</span> 
                            <span class="fs-16">{{ $payment->name }}</span>
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 bb-1">
                            <span class="fs-16">{{ translate('Installation Date') }}:</span> 
                            <span class="fs-16">
                                @php
                                    $date = date("Y-m-d", strtotime("+" . $payment->warranty . " years", strtotime($payment->updated_at)));
                                    if (strtotime(date('Y-m-d')) <= strtotime($date)) {
                                        $warranty = translate('You warranty will expire on ' . $date);
                                    } else {
                                        $warranty = translate('You warranty has expired');
                                    }
                                @endphp
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 bb-1">
                            <span class="fs-16">{{ translate('Warranty Years') }}:</span> 
                            <span class="fs-16">{{ $payment->warranty }} {{ ($payment->warranty <= 1) ? translate('year') : translate('years') }}</span>
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 bb-1">
                            <span class="fs-16">{{ translate('Vehicle No') }}:</span> 
                            <span class="fs-16">{{ $payment->car_plate }}<</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 bb-1">
                            <span class="fs-16">{{ translate('Model') }}:</span> 
                            <span class="fs-16">{{ $payment->model_name }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
