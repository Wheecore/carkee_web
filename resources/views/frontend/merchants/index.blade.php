@extends('frontend.layouts.app')
@section('content')

    <style>
        .right-cards h5 {
            font-weight: bold;
        }
        .right-cards p {
            font-size: 11px;
            font-weight: 600;
        }
        .search-form .form-control-lg {
            background-color: rgb(241, 241, 241);
            border: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            padding-top: 15px;
            padding-bottom: 15px;
            height: 40px;
        }
        .form-control:focus{
            box-shadow: none;
        }
        .vvv{
            background-color: rgb(241, 241, 241);
            border: 1px solid #f1f1f1;
            font-size: 13px;
            font-weight: 600;
            height: 40px;
        }
        .vvv:focus {
            background-color: #f1f1f1;
            border-color: #f1f1f1;
        }
        #range-result{
            font-size: 13px;
            font-weight: 600;
        }
        .aiz-table td, .aiz-table th{
            border-top: none !important;
        }
        .recom p,
        .hot_d p
        {
            font-weight: 700;
            font-size: 20px;
            color: black;
            display: inline;
        }
        .card {
            border: none;
            margin: 10px 7px;
            transition: .6s ease;
            box-shadow: rgb(99 99 99 / 20%) 0px 2px 8px 0px;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-block {
            padding: 10px;
        }
        @media (max-width:370px) {
            .m_b_vie .recom p,
            .m_b_vie .hot_d p
            {
                font-size: 15px;
            }
        }
        .m_b_vie img{
            height: 144px;
            border-radius: 8px;
        }
        .category-card img {
            width: 100%;
            height: 74px;
        }
        .category-card h5 {
            font-weight: 700;
            font-size: 17px;
        }
        .category-card h6 {
            font-weight: 600;
            font-size: 13px;
        }
        .category-card p {
            color: grey;
        }
    </style>
    <!-- owl-carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous"
          referrerpolicy="no-referrer" />
    <!-- /owl-carousel -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 search-form">
                @if(Session::has('geolocationMerchants'))
                    <div class="input-group">
                        <input class="form-control form-control-lg search_map" id="autocomplete" type="text" name="address" value="{{ Session::get('geolocationMerchants')->address }}" placeholder="Enter your location">
                        <span class="input-group-append">
                                <button class="btn btn-outline-secondary border-left-0 border btn_geolocation" id="btn11" type="button" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;border:1px solid #d8cec9 !important">
                                    <i class="la la-search la-flip-horizontal fs-18" style="color: #f3763b"></i>
                                </button>
                            </span>
                        <input type="hidden" name="latitude" class="latitude-pts" value="{{Session::get('geolocationMerchants')->latitude}}"/>
                        <input type="hidden" name="latitude" class="longitude-pts" value="{{Session::get('geolocationMerchants')->longitude}}"/>
                    </div>
                @else
                    <div class="input-group">
                        <input class="form-control form-control-lg search_map" id="autocomplete" type="text" name="address" placeholder="Enter your location">
                        <span class="input-group-append">
                                <button class="btn btn-outline-secondary border-left-0 border btn_geolocation" type="button" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;border:1px solid #d8cec9 !important">
                                    <i class="la la-search la-flip-horizontal fs-18" style="color: #f3763b"></i>
                                </button>
                            </span>
                        <input type="hidden" name="latitude" class="latitude-pts"/>
                        <input type="hidden" name="latitude" class="longitude-pts"/>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <select name="category" id="categories" class="form-control vvv merchant-cat" onchange="categoryChange()">
                            <option value="all">All Categories</option>
                            @foreach($merchant_categories as $merchant_category)
                                <option value="{{$merchant_category->id}}">{{$merchant_category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="price-range-block float-right">
                            <input type="range" id="range-value" min="1" max="50" value="25" class="slider" style="width: 200px;">
                            <p id="range-result">Current range : <b id="range-d"></b> km</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="container-fluid">--}}
{{--        <div class="row mb-4">--}}
{{--            <div class="col-md-10">--}}
{{--                <div class="map-side">--}}
{{--                    <div class="mapouter">--}}
{{--                        <div id="map-canvas" style="height: 600px; width: 100%; position: relative; overflow: hidden;">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-2"></div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="container-fluid">
        <div class="row mb-4 mt-3">
            <div class="col-md-9 right-cards">
                <h3 class="h5 fw-700 mb-3">
                        <span class="border-bottom border-primary border-width-2 pb-2 d-inline-block">
                            {{ translate('Near By Merchants') }}
                        </span>
                </h3>
                <div id="nearby-stores-section">
                    <div id="nearby-merchants">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h3 class="h5 fw-700 mb-3">
                        <span class="border-bottom border-primary border-width-2 pb-2 d-inline-block">
                            {{ translate('Merchant Vouchers') }}
                        </span>
                        <div id="nearby-merchants-vouchers">
                           <div class="mt-4">
                           <span class="alert alert-info" style="color: black;font-size: 14px;">Select merchant store first</span>
                           </div>
                        </div>
                </h3>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var isInitGeoLocate = parseInt("1");
        $(document).ready(function() {
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            $("#range-d").html($("#range-value").val());
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
        function categoryChange() {
            $('#nearby-merchants').html("<div class='col-lg-12 text-center'><div class='spinner-border text-secondary' style='margin: 50px;color: red !important'></div></div>");
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            if(latitude=='' || longitude=='' || latitude=='0' || longitude=='0') {
                showError("Please enter address correctly to get getlocation.\n You might not be supported Nearby Service.");
                return false;
            }
            else{
                setGeolocationOfMerchants($('#range-value').val());
            }
        }
    </script>
{{--    <script src="{{ static_asset('assets/js/geo-coder.js') }}"></script>--}}
    <script>
        var placeSearch, autocomplete;
        if(typeof isFullAddress == 'undefined') isFullAddress = false;

        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
        };

        function initAutocomplete() {
            if(isInitGeoLocate)
                initGeoLocate();
            // Create the autocomplete object, restricting the search predictions to
            // geographical location types.
            if($('.autocomplete').length==0){
                return;
            }
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('autocomplete'), {types: ['geocode']});

            // Avoid paying for data that you don't need by restricting the set of
            // place fields that are returned to just the address components.
            autocomplete.setFields(['address_component']);

            // When the user selects an address from the drop-down, populate the
            // address fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            getGeoLocate($('.autocomplete').val());
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

            for (var component in componentForm) {
                if($('#'+component).length>0){
                    $('#'+component).val('');
                    $('#'+component).prop('disabled', false);
                }
            }

            // Get each component of the address from the place details,
            // and then fill-in the corresponding field on the form.
            var address = '';
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    if($('#'+addressType).length>0)
                        $('#'+addressType).val(val);
                    if(addressType == 'street_number' || addressType == 'route') {
                        address += ' ' + val;
                    }
                }
            }
            if(address != '' && !isFullAddress)
                $('.autocomplete').val(address);
        }

        function getGeoLocate(address) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode(
                { 'address': address},
                function(results, status) {
                    if (status === "OK") {
                        if (results[0]) {
                            var latitude = results[0].geometry.location.lat();
                            var longitude = results[0].geometry.location.lng();
                            $('.latitude-pts').val(latitude);
                            $('.longitude-pts').val(longitude);
                        }
                    } else {
                        showError("Geocoder failed due to: " + status);
                    }
                }
            );
        }
        function showError(msg) {
            var ele = $('.alert-danger');
            if(ele.length>0) {
                $('ul', ele).html('').append('<li>'+msg+'</li>');
                ele.show();
            } else {
                alert(msg);
            }
        }
        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function initGeoLocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode(
                        {
                            location: geolocation
                        },
                        function(results, status) {
                            if (status === "OK") {
                                if (results[0]) {
                                    $('#autocomplete').val(results[0].formatted_address);
                                    $('.latitude-pts').val(geolocation.lat);
                                    $('.longitude-pts').val(geolocation.lng);
                                    if($('#range-value').length>0)
                                        setGeolocationOfMerchants($('#range-value').val());
                                }
                            } else {
                                showError("Geocoder failed due to: " + status);
                            }
                        }
                    );
                });
            }
        }
        function setGeolocationOfMerchants(radius, which_range) {
            var token = $('input[name=_token]').val();
            if(typeof which_range == 'undefined') which_range = -1;
            var data = {
                address: $('#autocomplete').val(),
                latitude: $('.latitude-pts').val(),
                longitude: $('.longitude-pts').val(),
                category: $("#categories").val(),
                radius: radius,
                which_range: which_range,
                _token: token
            };
            $.ajax({
                url: mainurl+'/set_geolocation_merchants',
                type: 'POST',
                data: data,
                success: function(result){
                    $('#nearby-merchants').html(result);
                }
            });
        }
        $(document).ready(function() {
            $(document).on('keyup', '#autocomplete', function() {
                $('.latitude-pts').val('');
                $('.longitude-pts').val('');
            });
        });
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
    <script defer>
        var map;
        var myLatLng;
        var google;
        $(document).ready(function() {
            geoLocationInit();
        });
        function geoLocationInit() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(initialize, showErrorr);
            } else {
                alert("Geolocation is not supported by this browser");
            }
        }
        function showErrorr(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("Please turn on location for this feature");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
        function initialize(position) {
            var latval = position.coords.latitude;
            var lngval = position.coords.longitude;
            // var mapOptions = {
            //     zoom: 12,
            //     minZoom: 6,
            //     maxZoom: 17,
            //     zoomControl:true,
            //     zoomControlOptions: {
            //         style:google.maps.ZoomControlStyle.DEFAULT
            //     },
            //     center: new google.maps.LatLng(latval, lngval),
            //     mapTypeId: google.maps.MapTypeId.ROADMAP,
            //     scrollwheel: true,
            //     panControl:false,
            //     mapTypeControl:true,
            //     scaleControl:false,
            //     overviewMapControl:false,
            //     rotateControl:false
            // }
            // var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            // var image = new google.maps.MarkerImage("public/images/pin.png", null, null, null, new google.maps.Size(40,52));

{{--            var places = @json($mapShops);--}}

            // for(place in places)
            // {
            //     place = places[place];
            //     if(place.latitude && place.longitude)
            //     {
            //         var marker = new google.maps.Marker({
            //             position: new google.maps.LatLng(place.latitude, place.longitude),
            //             icon:image,
            //             map: map,
            //             title: place.name
            //         });
            //         var infowindow = new google.maps.InfoWindow();
            //         google.maps.event.addListener(marker, 'click', (function (marker, place) {
            //             return function () {
            //                 infowindow.setContent(generateContent(place))
            //                 infowindow.open(map, marker);
            //             }
            //         })(marker, place));
            //     }
            // }
            var mps = $('.search_map')[0];
            var searchBox = new google.maps.places.SearchBox(mps);
            google.maps.event.addListener(searchBox,'places_changed',function(){
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for(i=0; place=places[i];i++){
                    bounds.extend(place.geometry.location);
                    // var lat = marker.getPosition().lat();
                    // var lng = marker.getPosition().lng();

                    var latitude = place.geometry.location.lat();
                    var longitude = place.geometry.location.lng();
                    $('.latitude-pts').val(latitude);
                    $('.longitude-pts').val(longitude);
                    // marker.setPosition(place.geometry.location); //set marker position new...
                }
                // map.fitBounds(bounds);
                // map.setZoom(15);
            });
            // google.maps.event.addListener(marker,'position_changed',function(){
            //     var lat = marker.getPosition().lat();
            //     var lng = marker.getPosition().lng();
            // });
        }

        {{--function replaces(){--}}
        {{--    var places = @json($mapShops);--}}
        {{--    for(place in places)--}}
        {{--    {--}}
        {{--        place = places[place];--}}
        {{--        if(place.latitude && place.longitude)--}}
        {{--        {--}}
        {{--            var marker = new google.maps.Marker({--}}
        {{--                position: new google.maps.LatLng(place.latitude, place.longitude),--}}
        {{--                icon:image,--}}
        {{--                map: map,--}}
        {{--                title: place.name--}}
        {{--            });--}}
        {{--            var infowindow = new google.maps.InfoWindow();--}}
        {{--            google.maps.event.addListener(marker, 'click', (function (marker, place) {--}}
        {{--                return function () {--}}
        {{--                    infowindow.setContent(generateContent(place))--}}
        {{--                    infowindow.open(map, marker);--}}
        {{--                }--}}
        {{--            })(marker, place));--}}
        {{--        }--}}
        {{--    }--}}
        {{--}--}}
        {{--function generateContent(place)--}}
        {{--{--}}
        {{--    var content = `<div class="row p-3">--}}
        {{--    <div class="col-4">--}}
        {{--        <a href="#"><img src="`+'public/'+place.logo_image+`" alt="`+place.name+`" style="height: 100px;width: 100px;float: right;"></a>--}}
        {{--    </div>--}}
        {{--    <div class="col-8">--}}
        {{--        <h4 class="geodir-entry-title">--}}
        {{--            <a href="#">`+place.name+`</a>--}}
        {{--        </h4>--}}
        {{--        <div class="geodir_post_meta_title">Address: </span><span itemprop="streetAddress">`+place.address+`</div>--}}
        {{--    </div>--}}
        {{--    </div>`;--}}

        {{--    return content;--}}
        {{--}--}}
    </script>
    <script>
        $(document).on("click",".voucher_btn", function(){
                $('#nearby-merchants-vouchers').html("<div class='text-center'><div class='spinner-border text-secondary' style='margin: 50px;color: red !important'></div></div>");
                var merchant_id = $(this).attr("data-merchant_id");
                var shop_name = $(this).attr("data-shop_name");
                    var token = $('input[name=_token]').val();
                    var data = {
                        merchant_id: merchant_id,
                        shop_name: shop_name,
                        _token: token
                    };
                    $.ajax({
                        url: mainurl+'/get/merchant/vouchers',
                        type: 'POST',
                        data: data,
                        success: function(result){
                            $('#nearby-merchants-vouchers').html(result);
                        }
                    });
        });
    </script>

@endsection
