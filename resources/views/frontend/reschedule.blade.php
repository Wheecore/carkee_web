@extends('frontend.layouts.app')
@section('content')
    <section class="pt-5 mb-4" style="background:ghostwhite">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row aiz-steps arrow-divider">
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ translate('1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block ">{{ translate('2. Workshop info') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('4. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50 ">{{ translate('5. Confirmation') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .right-cards .card {
            background-color: rgb(241, 241, 241);
            border-radius: 15px;
        }

        .right-cards h5 {
            font-weight: bold;
        }

        .right-cards p {
            font-size: 11px;
            font-weight: 600;
        }

        .right-cards span {
            font-size: 14px;
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

        .form-control:focus {
            box-shadow: none;
        }

        .store_a {
            color: black;
        }

        .store_a:hover {
            color: black;
            text-decoration: none;
        }

        .card .card-body {
            padding: 10px 25px;
        }

        #nearby-stores-section {
            max-height: 496px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .vvv {
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

        #range-result {
            font-size: 13px;
            font-weight: 600;
        }
    </style>
    <?php
    $shops = \DB::table('shops');
    $latitude = $shops->count() ? $shops->average('latitude') : 27.72;
    $longitude = $shops->count() ? $shops->average('longitude') : 85.36;
    $shops = $shops->select(
        '*',
        DB::raw(
            '6371 * acos(cos(radians(' .
                $latitude .
                "))
                                    * cos(radians(latitude)) * cos(radians(longitude) - radians(" .
                $longitude .
                "))
                                    + sin(radians(" .
                $latitude .
                ')) * sin(radians(latitude))) AS distance',
        ),
    );
    //            $shops          =       $shops->having('distance', '<', 25);
    $shops = $shops->orderBy('distance', 'asc');
    $shops = $shops->whereJsonContains('category_id', '1')->orWhereJsonContains('category_id', '2');
    $mapShops = $shops->get();
    ?>
    <!-- //////////////////search ////////////////////////////////////// -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 search-form">
                @if (Session::has('geolocation'))
                    <div class="input-group">
                        <input class="form-control form-control-lg search_map" id="autocomplete" type="text"
                            name="address" value="{{ Session::get('geolocation')->address }}"
                            placeholder="Enter your location">
                        <span class="input-group-append">
                            <button class="btn btn-outline-secondary border-left-0 border btn_geolocation" id="btn11"
                                type="button"
                                style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;border:1px solid #d8cec9 !important">
                                <i class="la la-search la-flip-horizontal fs-18" style="color: #f3763b"></i>
                            </button>
                        </span>
                        <input type="hidden" name="latitude" class="latitude-pts"
                            value="{{ Session::get('geolocation')->latitude }}" />
                        <input type="hidden" name="latitude" class="longitude-pts"
                            value="{{ Session::get('geolocation')->longitude }}" />
                    </div>
                @else
                    <div class="input-group">
                        <input class="form-control form-control-lg search_map" id="autocomplete" type="text"
                            name="address" placeholder="Enter your location">
                        <span class="input-group-append">
                            <button class="btn btn-outline-secondary border-left-0 border btn_geolocation" type="button"
                                style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;border:1px solid #d8cec9 !important">
                                <i class="la la-search la-flip-horizontal fs-18" style="color: #f3763b"></i>
                            </button>
                        </span>
                        <input type="hidden" name="latitude" class="latitude-pts" />
                        <input type="hidden" name="latitude" class="longitude-pts" />
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <select name="rating_shops" id="rating" class="form-control vvv" onchange="rating_shops()">
                            <option value="">Filter By Ratings</option>
                            <option value="5">5 Star Rating</option>
                            <option value="4">4 Star Rating</option>
                            <option value="3">3 Star Rating</option>
                            <option value="2">2 Star Rating</option>
                            <option value="1">1 Star Rating</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="price-range-block float-right">
                            <input type="range" id="range-value" min="1" max="50" value="25"
                                class="slider" style="width: 200px;">
                            <p id="range-result">Current range : <b id="range-d"></b> km</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /////////////////////search///////////////////////////////// -->
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="map-side">
                    <div class="mapouter">
                        <div id="map-canvas" style="height: 600px; width: 100%; position: relative; overflow: hidden;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 right-cards">
                <h3 class="h5 fw-700 mb-3">
                    <span class="border-bottom border-primary border-width-2 pb-2 d-inline-block">
                        {{ translate('Near By Workshops') }}
                    </span>
                </h3>
                <div id="nearby-stores-section">
                    <div id="nearby-store">

                    </div>
                </div>
                <hr>

                <div class="row mb-3">
                    <div class="col-md-6 col-6 text-center">
                        <input id="userDate" placeholder="Select Date" class="form-control selected_date vvv">
                    </div>
                    <div class="col-md-6 col-6 text-center">
                        <select id="userTime" class="form-control timeslot vvv" style="height: 42px;">
                            <option value="">Select Time</option>
                        </select>
                    </div>
                    <p id="datetime-error" class="mt-2 ml-3 fs-12" style="display: none; color: red;text-align: left;">
                    </p>
                    <p id="time-error" class="mt-2 ml-3 fs-12" style="display: none; color: red;text-align: left;"></p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                        <a href="{{ route('home') }}" class="btn btn-link">
                            <i class="las la-arrow-left"></i>
                            {{ translate('Return to shop') }}
                        </a>
                    </div>
                    <div class="col-md-6 text-center text-md-right">
                        <form action="{{ url('reschedule/update', $order_id) }}" method="post" id="shop_form">
                            @csrf
                            <input type="hidden" value="" name="selected_date" id="selected_date">
                            <input type="hidden" value="" name="availability_id" id="availability_id">
                            <input type="hidden" value="" name="selected_time" id="selected_time">
                            <input type="hidden" value="" name="shop_id" id="shop_id">
                            <button type="submit"
                                class="btn btn-primary fw-600">{{ translate('Reschedule Now') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modal')
    <div class="modal fade" id="new-address-modal" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Address') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control textarea-autogrow mb-3" placeholder="{{ translate('Your Address') }}" rows="1"
                                        name="address" required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Country') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true"
                                        name="country" required>
                                        <option value="">Select Country</option>
                                        @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('City') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true"
                                        name="city" required>

                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Postal code') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3"
                                        placeholder="{{ translate('Your Postal Code') }}" name="postal_code"
                                        value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Phone') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3"
                                        placeholder="{{ translate('+880') }}" name="phone" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="edit_modal_body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ static_asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"
        integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg=="
        crossorigin="anonymous"></script>
    <script>
        function activeWorkshop(id) {
            $("#datetime-error").hide();
            $('#shop_id').val(id);
            $(".removehighlight").css({
                "background-color": "rgb(241, 241, 241)"
            });
            $("#highlight" + id).css({
                "background-color": "honeydew"
            });
            $("#userDate").val('');
            $('#userTime').html('<option value="" selected>Select Time</option>');
        }

        $(document).on("click", ".ui-datepicker-next", function() {
            var shop_id = $('#shop_id').val();
            // apply border color to available dates
            applyBorderToDates(shop_id);
        });

        $(document).on("click", ".ui-datepicker-prev", function() {
            var shop_id = $('#shop_id').val();
            // apply border color to available dates
            applyBorderToDates(shop_id);
        });

        $('.timeslot').on('change', function() {
            $("#time-error").hide();
            $('#selected_time').val(this.value);
        });
    </script>
    <script>
        $(document).ready(function() {
            var shop_count = $('#shop_count').val();
        });

        $(document).on('click', '#userDate', function() {
            $(this).datepicker({
                minDate: new Date(new Date().getTime() + (3 * 24 * 60 * 60 * 1000)),
                onSelect: function(dateText) {
                    var selected_date = dateText;
                    $('#selected_date').val(selected_date);
                    selected_date = moment(moment(selected_date)).format("YYYY-MM-DD");
                    $('#userTime').html('<option value="" selected>Select Time</option>');
                    $("#datetime-error").hide();
                    var shop_id = $('#shop_id').val();
                    if (shop_id) {
                        showTimeOfSelectedDate(shop_id, selected_date);
                    } else {
                        $("#datetime-error").show();
                        $("#datetime-error").html('please select shop first');
                        return false;
                    }
                }
            }).datepicker("show")
            var shop_id = $('#shop_id').val();
            // apply border color to available dates
            applyBorderToDates(shop_id);
        });

        function applyBorderToDates(shop_id) {
            $.get('{{ route('check-timings') }}', {
                shop_id: shop_id
            }, function(data) {
                if (data != 'empty') {
                    var selected_year = $(".current_year").html();
                    $.each(data, function(key, value) {
                        slotDate = moment(value.date).format('D');
                        slotMonth = moment(value.date).format('M');
                        slotMonth = slotMonth - 1;
                        slotYear = moment(value.date).format('YYYY');
                        $('.ui-datepicker-calendar td[data-month="' + slotMonth + '"][data-year="' +
                            slotYear + '"]').filter(function() {
                            return $(this).children().text() === slotDate;
                        }).css("border", "2px solid #6ce06c");
                    });
                }
            });
        }

        function showTimeOfSelectedDate(shop_id, selected_date) {
            var i;
            $.ajax({
                type: 'GET',
                url: '{{ route('shop.get-date-time') }}',
                data: {
                    'selected_date': selected_date,
                    'shop_id': shop_id
                },
                success: function(response) {
                    if (response['code'] == 200) {
                        $('#availability_id').val(response['availability_id']);
                        $('#userTime').html('<option value="" selected>Select Time</option>');
                        $.each(response['time_array'], function(index, val) {
                            $('#userTime').append('<option value="' + moment(val).format('h:mm A') +
                                '">' + moment(val).format('h:mm A') + '</option>');
                        });
                        $("#userTime").focus();
                    } else {
                        $("#datetime-error").show();
                        $("#datetime-error").html(response['message']);
                    }
                }
            });
        }

        $("#shop_form").submit(function() {
            var current_date = $('#userDate').val();
            var current_time = $('#userTime').val();
            if (!current_date) {
                $("#datetime-error").show();
                $("#datetime-error").html('please select date');
                return false;
            } else if (!current_time) {
                $("#time-error").show();
                $("#time-error").html('please select time');
                return false;
            } else {
                return true;
            }
        });
    </script>
    <script type="text/javascript">
        function edit_address(address) {
            var url = '{{ route('addresses.edit', ':id') }}';
            url = url.replace(':id', address);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#edit_modal_body').html(response);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');
                    var country = $("#edit_country").val();
                    get_city(country);
                }
            });
        }

        $(document).on('change', '[name=country]', function() {
            var country = $(this).val();
            get_city(country);
        });

        function get_city(country) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get-city') }}",
                type: 'POST',
                data: {
                    country_name: country
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj != '') {
                        $('[name="city"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function add_new_address() {
            $('#new-address-modal').modal('show');
        }
    </script>
    <script type="text/javascript">
        var isInitGeoLocate = parseInt("1");
        $(document).ready(function() {
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            $("#range-d").html($("#range-value").val());
            // setGeolocation($('#range-value').val());
        });

        function geoLocationResult() {
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            var url = mainurl + '/checkout?latitude=' + latitude + '&longitude=' + longitude;
            window.location = url;
        }

        $(document).on('click', '.btn_geolocation', function(e) {
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            if (latitude == '' || longitude == '' || latitude == '0' || longitude == '0') {
                showError(
                    "Please enter address correctly to get getlocation.\n You might not be supported Nearby Service."
                    );
                return false;
            }

            setGeolocation($('#range-value').val());
        });

        $("#range-value").change(function() {
            $("#range-d").html($(this).val());
        });

        $(document).on('mouseup touchstart', '#range-value', function(e) {
            $('#nearby-store').html(
                "<div class='col-lg-12 text-center'><div class='spinner-border text-secondary' style='margin: 50px;color: red !important'></div></div>"
                );
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            if (latitude == '' || longitude == '' || latitude == '0' || longitude == '0') {
                showError(
                    "Please enter address correctly to get getlocation.\n You might not be supported Nearby Service."
                    );
                return false;
            }
            setGeolocation($('#range-value').val());
        });

        function rating_shops() {
            var search_map = $('.search_map').val();
            var token = $('input[name=_token]').val();
            var rate_by_shop = $('#rate_by_shops').val();
            var rating = $('#rating').val();

            if (rating == '') {
                $('.btn_geolocation').click();
            }
            $('#nearby-store').html(
                "<div class='col-lg-12 text-center'><div class='spinner-border text-secondary' style='margin: 50px;color: red !important'></div></div>"
                );
            var latitude = $('.latitude-pts').val();
            var longitude = $('.longitude-pts').val();
            if (latitude == '' || longitude == '' || latitude == '0' || longitude == '0') {
                showError(
                "Please enter address correctly to get getlocation.\n You might not be supported Nearby Service.");
                return false;
            }
            var data = {
                rating: rating,
                search_map: search_map,
                rate_by_shop: rate_by_shop,
                _token: token
            };
            $.ajax({
                url: mainurl + '/shop_by_ratings',
                type: 'POST',
                data: data,
                success: function(result) {
                    $('#nearby-store').html(result);
                }
            });
        }
    </script>
    <script src="{{ static_asset('assets/js/geo-coder.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places&callback=initAutocomplete"
        async defer></script>
    <script defer>
        var map;
        var myLatLng;
        $(document).ready(function() {
            geoLocationInit();
        });

        function geoLocationInit() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(initialize, showError);
            } else {
                alert("Geolocation is not supported by this browser");
            }
        }

        function showError(error) {
            switch (error.code) {
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
            var mapOptions = {
                zoom: 12,
                minZoom: 6,
                maxZoom: 17,
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.DEFAULT
                },
                center: new google.maps.LatLng(latval, lngval),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: true,
                panControl: false,
                mapTypeControl: true,
                scaleControl: false,
                overviewMapControl: false,
                rotateControl: false
            }
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            var image = new google.maps.MarkerImage("public/images/pin.png", null, null, null, new google.maps.Size(40,
            52));

            var places = @json($mapShops);

            for (place in places) {
                place = places[place];
                if (place.latitude && place.longitude) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(place.latitude, place.longitude),
                        icon: image,
                        map: map,
                        title: place.name
                    });
                    var infowindow = new google.maps.InfoWindow();
                    google.maps.event.addListener(marker, 'click', (function(marker, place) {
                        return function() {
                            infowindow.setContent(generateContent(place))
                            infowindow.open(map, marker);
                        }
                    })(marker, place));
                }
            }
            var mps = $('.search_map')[0];
            var searchBox = new google.maps.places.SearchBox(mps);
            google.maps.event.addListener(searchBox, 'places_changed', function() {
                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;
                for (i = 0; place = places[i]; i++) {
                    bounds.extend(place.geometry.location);
                    // var lat = marker.getPosition().lat();
                    // var lng = marker.getPosition().lng();

                    var latitude = place.geometry.location.lat();
                    var longitude = place.geometry.location.lng();
                    $('.latitude-pts').val(latitude);
                    $('.longitude-pts').val(longitude);
                    // marker.setPosition(place.geometry.location); //set marker position new...
                }
                map.fitBounds(bounds);
                map.setZoom(15);
            });
            google.maps.event.addListener(marker, 'position_changed', function() {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();

                // $('.latitude-pts').val(lat);
                // $('.longitude-pts').val(lng);

                // replaces();
                // $('#lat').val(lat);
                // $('#lng').val(lng);
            });
        }
        // google.maps.event.addDomListener(window, 'load', initialize);

        function replaces() {
            var places = @json($mapShops);

            for (place in places) {
                place = places[place];
                if (place.latitude && place.longitude) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(place.latitude, place.longitude),
                        icon: image,
                        map: map,
                        title: place.name
                    });
                    var infowindow = new google.maps.InfoWindow();
                    google.maps.event.addListener(marker, 'click', (function(marker, place) {
                        return function() {
                            infowindow.setContent(generateContent(place))
                            infowindow.open(map, marker);
                        }
                    })(marker, place));
                }
            }
        }

        function generateContent(place) {
            var content = `<div class="row p-3">
    <div class="col-4">
        <a href="#"><img src="` + 'public/' + place.logo_image + `" alt="` + place.name + `" style="height: 100px;width: 100px;float: right;"></a>
    </div>

    <div class="col-8">
        <h4 class="geodir-entry-title">
            <a href="#">` + place.name + `</a>
        </h4>

        <b class="geodir_post_meta  geodir-field-post_title"><span class="geodir_post_meta_icon geodir-i-text">
                            <i class="fas fa-minus" aria-hidden="true"></i>
                            <span class="geodir_post_meta_title">Place Title: </span></span>` + place.name + `</b>
        <div class="geodir_post_meta_title">Address: </span><span itemprop="streetAddress">` + place.address + `</div>
    </div>
</div>`;

            return content;

        }
    </script>
@endsection
