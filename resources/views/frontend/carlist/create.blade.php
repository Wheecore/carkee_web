@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-r mt-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Add Car List') }}</h5>
                    </div>
                    <div class="card-body mt-2">
                        <div class="classified-container  flexbox  flexbox--fixed">
                            <div class="flexbox__item">
                                <div class="">
                                    <div class="classified-search__head" style="border-radius: 30px 30px 0px 0px">
                                        <h4 class="zeta  flush--bottom  weight--semibold  text--white">
                                            Find brand &amp; car models </h4>
                                    </div>
                                    <div class="classified-search__body  soft-half--bottom">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <p><strong>Opps Something went wrong</strong></p>
                                            <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                        {{--<div>--}}

                                        {{--<span style="color: red;display:none" class="catreq">Please Select Category</span>--}}
                                        {{--</div>--}}
                                        {{--<div class="btn-group" style="width: -webkit-fill-available;">--}}
                                        {{--@foreach(\App\Models\Category::orderBy('id', 'asc')->get() as $item)--}}
                                        {{--<button type="button" class="btn btn-primary" onclick="select_type({{ $item->id }})">{{ $item->name }}</button>--}}
                                        {{--@endforeach--}}
                                        {{--</div>--}}
                                        <form action="{{ route('carlist.store') }}"
                                              class="classified-form  js-classified-form  js-form-validation mt-2" method="post">
                                            @csrf
                                            {{--<input type="text" name="category_id" id="category_id">--}}
                                            {{--<div class="classified-input  classified-input--condition  float--left  one-whole">--}}
                                            {{--<select class="form-control selectize-input items input-readonly not-full has-options" name="category_id" id="category_id"--}}
                                            {{--data-live-search="true">--}}
                                            {{--<option value="">{{ translate('Select Category') }}</option>--}}
                                            {{--@foreach (\App\Models\Category::orderBy('id', 'asc')->get() as $item)--}}
                                            {{--<option value="{{ $item->id }}">{{ $item->name }}</option>--}}
                                            {{--@endforeach--}}
                                            {{--</select>--}}
                                            {{--</div>--}}

                                                <div class="form-group">
                                                <label>Car Plate</label>
                                                <div class="classified-input  classified-input--brand  float--left  one-half  palm--one-whole  classified-input--left">
                                                <input type="text" class="form-control" name="car_plate" value="{{old('car_plate')}}" placeholder="Enter Car Plate" id="car_plate_no" required>
                                                </div>
                                                </div>

                                            <div class="form-group">
                                                <label>Mileage</label>
                                            <div class="classified-input  classified-input--model  float--left  one-half  palm--one-whole  classified-input--right">
                                                <input type="number" class="form-control" name="mileage" value="{{old('mileage')}}" placeholder="Enter Mileage" required>
                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Chassis Number <small style="color: green">* optional</small></label>
                                            <div class="classified-input  classified-input--model  float--left  one-whole  palm--one-whole  classified-input--right">
                                                <input type="text" class="form-control" name="chassis_number" value="{{old('chassis_number')}}" placeholder="Enter Chassis Number">
                                            </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Insurance <small style="color: green">* optional</small></label>
                                            <div class="classified-input  classified-input--model  float--left  one-whole  palm--one-whole  classified-input--right">
                                            <input type="date" class="form-control" name="insurance" value="{{old('insurance')}}" placeholder="mm/dd/YYYY">
                                            </div>
                                           </div>
                                              <div class="form-group">
                                                <label>Brand</label>
                                                <div class="classified-input  classified-input--condition  float--left  one-whole">
                                                <select class="form-control" name="brand_id" id="cbrand_id"
                                                        data-live-search="true" onchange="cmodels()" required>
                                                    <option value="">{{ translate('Select Brand') }}</option>
                                                    @foreach (\App\Models\Brand::all() as $brand)
                                                        <option value="{{ $brand->id }}" {{ (old("brand_id") == $brand->id ? "selected":"") }}>{{ $brand->getTranslation('name') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            </div>
                                              <div class="form-group">
                                                <label>Model</label>
                                            <div class="classified-input  classified-input--brand  float--left  one-half  palm--one-whole  classified-input--left">
                                                <select name="model_id" id="cmodel_id" class="form-control"
                                                        data-live-search="true" onchange="cdetails()">
                                                    <option value="">Select Model</option>
                                                </select>
                                            </div>
                                            </div>

                                                <div class="form-group">
                                                <label>Years</label>
                                            <div class="classified-input  classified-input--model  float--left  one-half  palm--one-whole  classified-input--right">
                                                <select name="year_id" id="cyear_id" class="form-control"
                                                        onchange="ccar_years()">
                                                    <option value="">Select Years</option>
                                                </select>
                                            </div>
                                            </div>
                                             <div class="form-group">
                                                <label>Details</label>
                                            <div class="classified-input  classified-input--location  float--left  one-half  palm--one-whole  classified-input--left">
                                                <select name="details_id" id="cdetails_id" class="form-control" onchange="ctypes()">
                                                    <option value="">Select Details</option>
                                                </select>
                                            </div>
                                            </div>
                                             <div class="form-group">
                                                <label>Variants</label>
                                            <div class="classified-input  classified-input--location  float--left  one-half  palm--one-whole  classified-input--left">
                                                <select name="type_id" id="ctype_id" class="form-control">
                                                    <option value="">Select Variants</option>
                                                </select>
                                            </div>
                                            </div>
                                             <div class="form-group">
                                                <label>Vehicle Size</label>
                                            <div class="classified-input  classified-input--model  float--left  one-half    palm--one-whole  classified-input--right">
                                                <select name="vehicle_size" id="vehicle_size" class="form-control">
                                                    <option value="">Vehicle Size</option>
                                                </select>
                                            </div>
                                            </div>
                                             <div class="form-group">
                                                <label>Size Alternative</label>
                                            <div class="classified-input  classified-input--model  float--left  one-half    palm--one-whole  classified-input--right">
                                                <select name="size_alternative_id" id="alternative_size" class="form-control">
                                                    <option value="">Size Alternative</option>
                                                </select>
                                            </div>
                                            </div>

                                            <div class="search-button  one-whole">
                                                <button class="btn  btn-primary" type="submit">Save
                                                </button>
                                            </div>
                                        </form>
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
    <script>
    $(document).ready(function(){
           var brand_id = $('#cbrand_id').val();
           if(brand_id != ''){
            $.ajax({
                url: "{{ url('get-ca-models') }}",
                type: 'get',
                data: {
                    id: brand_id
                },
                success: function (res) {
                    $('#cmodel_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
           }
    });
        function cmodels() {
            var brand_id = $('#cbrand_id').val();
            $.ajax({
                url: "{{ url('get-ca-models') }}",
                type: 'get',
                data: {
                    id: brand_id
                },
                success: function (res) {
                    $('#cmodel_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }

        function cdetails() {
            var model_id = $('#cmodel_id').val();
            $.ajax({
                url: "{{ url('get-ca-details') }}",
                type: 'get',
                data: {
                    id: model_id
                },
                success: function (res) {
                    $('#cyear_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
            $.ajax({
                url: "{{ url('get-vehicle-size') }}",
                type: 'get',
                data: {
                    id: model_id
                },
                success: function (res) {
                    $('#vehicle_size').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
            $.ajax({
                url: "{{ url('get-alternative-size') }}",
                type: 'get',
                data: {
                    id: model_id
                },
                success: function (res) {
                    $('#alternative_size').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }

        function ccar_years() {
            var year_id = $('#cyear_id').val();
            $.ajax({
                url: "{{ url('get-ca-years') }}",
                type: 'get',
                data: {
                    id: year_id
                },
                success: function (res) {
                    $('#cdetails_id').html(res);
                },
                error: function () {
                    alert('failed...');

                }
            });
        }

        function ctypes() {
            var cdetails_id = $('#cdetails_id').val();
            $.ajax({
                url: "{{ url('get-ca-types') }}",
                type: 'get',
                data: {
                    id: cdetails_id
                },
                success: function (res) {
                    $('#ctype_id').html(res);
                },
                // error: function()
                // {
                //     alert('failed...');
                //
                // }
            });
        }
    </script>
    <script>
        function select_type($val) {
            if ($val == 'Tyre') {
                $('#category_id').val($val);
            }
            else if ($val == 'Battery') {
                $('#category_id').val($val);
            }
            else {
                $('#category_id').val($val);
            }

        }
    </script>
    <script>
        $(document).ready(function(){
            $('#car_plate_no').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
        });
    </script>

@endsection
