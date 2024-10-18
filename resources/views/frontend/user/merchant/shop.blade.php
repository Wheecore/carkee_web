@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aiz-titlebar mt-4 mb-2">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h1 class="h3">{{ translate('Shop Settings')}}</h1>
                        </div>
                    </div>
                </div>
                {{-- Basic Info --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Basic Info') }}</h5>
                    </div>
                    <div class="card-body mt-2">
                        <form class="" action="{{ route('shops.update', ($shop)?$shop->id:'') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PATCH">
                            @csrf
                            <div class="row">
                                <label class="col-md-2 col-form-label">{{ translate('Shop Name') }}<span class="text-danger text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Shop Name')}}" name="name" value="{{ ($shop)?$shop->name:'' }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-2 col-form-label">{{ translate('Shop Logo') }}</label>
                                <div class="col-md-10">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="logo" value="{{ ($shop)?$shop->logo:'' }}" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-2 col-form-label">
                                    {{ translate('Shop Phone') }}
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('Phone')}}" name="phone" value="{{ ($shop)?$shop->phone:'' }}" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-md-2 col-form-label">
                                    {{ translate('Shop Address') }}
                                    <span class="text-danger text-danger">*</span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control autocomplete" id="autocomplete" placeholder="Pandamaran, 41200 Klang" name="address" value="{{ ($shop)?$shop->address:'' }}" required>
                                </div>
                            </div>
                            <input type="hidden" class="latitude-pts" name="latitude" value="{{ ($shop)?$shop->latitude:'' }}"/>
                            <input type="hidden" class="longitude-pts" name="longitude" value="{{ ($shop)?$shop->longitude:'' }}"/>
                            <div class="form-group mb-0 text-right">
                                <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script type="text/javascript">
        //var parts = $(location).attr("href").split('/');
        // var lastSegment = parts.pop() || parts.pop();
        var isInitGeoLocate = parseInt(0);
        $(document).ready(function() {
            setGeolocation($('#range-value').val());
        });

        function geoLocationResult()
        {
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            var url = mainurl + '/near-by?latitude=' + latitude + '&longitude=' + longitude;
            window.location = url;
        }

        $(document).on('click', '.btn_geolocation', function(e) {
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            if(latitude=='' || longitude=='' || latitude=='0' || longitude=='0') {
                showError("Please enter address correctly to get getlocation.\n You might not be supported Nearby Service.");
                return false;
            }

            setGeolocation($('#range-value').val());
        });

    </script>
    <script src="{{ static_asset('assets/js/geo-coder.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>

@endsection
