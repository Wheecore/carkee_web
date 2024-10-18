@extends('frontend.layouts.app')
@section('content')

    <style>
        * {
            margin: 0px;
            padding: 0px;
        }

        .top-heading {
            text-align: center;
        }

        .list p {
            margin-bottom: 0px;
        }


        /* Media Query */

        @media (max-width: 480px) {
            .voucher-btn {
                width: 100%;
            }
        }


        /* Qr code page */

        .bottom-area {
            margin-top: 30%;
        }
    </style>

    <div class="container">
        <div class="row mt-5 mb-5">
        <div class="col-md-1"></div>
        <div class="col-md-6 col-12">
                    <h3 class="top-heading">
                       {{$voucher->voucher_code }}
                    </h3>
                    <img class="lazyload" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                         data-src="@if ($voucher->image !== null) {{ uploaded_asset($voucher->image) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                         alt="" style="width: 100%;height: 300px;">
                    <h3 class="font-weight-bold ml-3 mt-5">Enjoy {{single_price($voucher->amount)}} off with no<br> minimum purchase.</h3>
                    <hr style="border-top: 2px solid rgba(0,0,0,.1);">
            <h6 class="font-weight-bold ml-3"><i class="fa-solid fa-star" style="color: green;"></i><span class="ml-3">Terms and conditions</span></h6>
                   <div class="ml-5">{!! $voucher->description !!}</div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-4 col-12">
                    <h3 class="top-heading">
                        {{$voucher->voucher_code }}
                    </h3>
                    <hr style="border-top: 2px solid rgba(0,0,0,.1);">
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <h6 class="font-weight-bold mt-2 mb-5" style="text-align: center;">Enjoy {{single_price($voucher->amount)}} off with no minimum purchase.</h6>
                            @php
                                $string = "Voucher Code: ".$voucher->voucher_code."\n";
                                $string.= "User Email: ".Auth::user()->email;
                            @endphp
                           {!! QrCode::size(200)->generate($string); !!}
                        </div>
                       <div class="mt-4" style="display: flex; flex-direction: column; align-items: center;">
                        <form class="form-horizontal text-right" action="{{ route('qrcode.merchant.voucher', [ 'type' => 'png' ])}}" method="post">
                            <input type="hidden" name="voucher_code" value="{{$voucher->voucher_code}}">
                            @csrf
                            <button type="submit" class="w-200px btn btn-primary btn-sm" style="padding: 10px;">
                                <i class="fas fa-fw fa-download"></i>
                                Download PNG
                            </button>
                        </form>
                    </div>
            </div>
    </div>
    </div>

@endsection
