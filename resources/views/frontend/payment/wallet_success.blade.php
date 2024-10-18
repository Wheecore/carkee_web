@extends('frontend.layouts.custom_layout')
@section('content')
            <div class="row">
                <div class="col-md-12 col-12">
                            <div class="text-center py-4">
                                <img src="{{ static_asset('front_assets/img/success_image.png') }}" style="width: 25%">
                                <h1 class="h5 fw-700 mt-4" style="color: #000693">{{ translate('Thank You! Your wallet has been recharged successfully') }}</h1>
                            </div>
                                <div class="row pl-3 pr-3">
                                  <div class="col-md-12">
                                      <div style="text-align: center">
                                        <a class="btn" href="https://carkee.my/block" style="background: #000693; color: white;border-radius: 8px;font-weight: 600;font-size: 14px;width: 214px;">GO BACK</a>
                                      </div>
                                  </div>
                                </div>
                </div>
            </div>
        </div>

@endsection

