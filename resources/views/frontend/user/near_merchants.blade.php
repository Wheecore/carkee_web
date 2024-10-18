@extends('frontend.layouts.user_panel')
@section('panel_content')
<style>
    input.autocomplete:focus {
        box-shadow: none !important;
    }
    .metismenu li {
        background-color: #434b55 !important;
    }
</style>
<div class="container">
    <div class="row">
    <div class="col-md-12">
        <div class="card card-r mt-4">
            <div class="card-header">
                <h1 class="h2 fs-16 mb-0">{{ translate('Near By Merchants') }}</h1>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        @if(Session::has('geolocation'))
                            <div class="input-group" style="margin-left: 15px;">
                                <input class="form-control py-2 border-right-0 border autocomplete" id="autocomplete" type="text" name="address" value="{{ Session::get('geolocation')->address }}" placeholder="Enter your location" style="border-top-left-radius: 22px;border-bottom-left-radius: 22px;height:43px;">
                                <span class="input-group-append">
                                <button class="btn btn-outline-secondary border-left-0 border btn_geolocation" type="button" style="background:white !important; border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                    <i class="la la-search la-flip-horizontal fs-18" style="color: #81D8D0"></i>
                                </button>
                            </span>
                                <input type="hidden" name="latitude" class="latitude-pts" value="{{Session::get('geolocation')->latitude}}"/>
                                <input type="hidden" name="latitude" class="longitude-pts" value="{{Session::get('geolocation')->longitude}}"/>
                            </div>
                        @else
                            <div class="input-group" style="margin-left: 15px;">
                                <input class="form-control py-2 border-right-0 border autocomplete" id="autocomplete" type="text" name="address" placeholder="Enter your location" style="border-top-left-radius: 22px;border-bottom-left-radius: 22px;height:43px">
                                <span class="input-group-append">
                                <button class="btn btn-outline-secondary border-left-0 border btn_geolocation" type="button" style="background:white !important; border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                    <i class="la la-search la-flip-horizontal fs-18" style="color: #81D8D0"></i>
                                    <!-- Go -->
                                </button>
                            </span>
                                <input type="hidden" name="latitude" class="latitude-pts"/>
                                <input type="hidden" name="latitude" class="longitude-pts"/>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="price-range-block">
                            <input type="range" id="range-value" min="1" max="50" value="25" class="slider" style="width: 200px; margin-bottom: 15px">
                            <p id="range-result">Current range : <b id="range-d"></b> km</p>
                        </div>
                    </div>
                </div>

                <div id="nearby-merchants">
                    <div class="mb-4" id="nearby-stores-section">
                        <div class="container-fluid">
                            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <div class="spinner-border text-secondary" style="margin: 50px;color: red !important"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        var isInitGeoLocate = parseInt("1");
        $(document).ready(function() {
            $("#range-d").html($("#range-value").val());
            setGeolocationOfMerchants($('#range-value').val());
        });

        $(document).on('click', '.btn_geolocation', function(e) {
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            if(latitude=='' || longitude=='' || latitude=='0' || longitude=='0') {
                showError("Please enter address correctly to get getlocation.\n You might not be supported Nearby Service.");
                return false;
            }
            setGeolocationOfMerchants($('#range-value').val());
        });

        $("#range-value").change(function() {
            $("#range-d").html($(this).val());
        });

        $(document).on('mouseup touchstart', '#range-value', function(e) {
            $('#nearby-merchants').html("<div class='col-lg-12 text-center'><div class='spinner-border text-secondary' style='margin: 50px;color: red !important'></div></div>");
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            if(latitude=='' || longitude=='' || latitude=='0' || longitude=='0') {
                showError("Please enter address correctly to get getlocation.\n You might not be supported Nearby Service.");
                return false;
            }
            setGeolocationOfMerchants($('#range-value').val());
        });
    </script>
    <script src="{{ static_asset('assets/js/geo-coder.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>

@endsection
