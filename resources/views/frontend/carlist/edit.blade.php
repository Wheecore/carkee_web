@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-r mt-4">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Update Car List') }}</h5>
                    </div>
                    <div class="card-body">
                        <link rel="stylesheet" href="{{ static_asset('assets/css/test.css') }}">
                        <div class="classified-container  flexbox  flexbox--fixed">
                            <div class="flexbox__item">
                                <div class="classified-search  classified-search--malaysia  one-whole" style="z-index: unset;">
                                
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
                                        <form action="{{ route('carlist.update', $carlist->id) }}"
                                              class="classified-form  js-classified-form  js-form-validation mt-2" method="post">
                                            @csrf
                                            <div class="form-group classified-input  classified-input--brand  float--left  one-whole  palm--one-whole  classified-input--left">
                                                <label>Car Plate</label>
                                                <input type="text" class="form-control" name="car_plate" placeholder="Enter Car Plate" value="{{ $carlist->car_plate }}" required>
                                            </div>
                                            <div class="form-group classified-input  classified-input--model  float--left  one-whole  palm--one-whole  classified-input--right">
                                                <label>Mileage</label>
                                                <input type="text" class="form-control" name="mileage" placeholder="Enter Mileage"  value="{{ $carlist->mileage }}">
                                            </div>
                                            <div class="form-group classified-input  classified-input--model  float--left  one-whole  palm--one-whole  classified-input--right">
                                                <label>Chassis Number</label>
                                                <input type="text" class="form-control" name="chassis_number" placeholder="Enter Chassis Number" value="{{ $carlist->chassis_number }}">
                                            </div>
                                            <div class="form-group classified-input  classified-input--model  float--left  one-whole  palm--one-whole  classified-input--right">
                                                <label>Vehicle Size</label>
                                                <input type="text" class="form-control" name="vehicle_size" placeholder="Enter Vehicle Size" value="{{ $carlist->vehicle_size }}">
                                            </div>
                                            <div class="form-group classified-input  classified-input--model  float--left  one-whole  palm--one-whole  classified-input--right">
                                                <label>Insurance</label>
                                                <input type="date" class="form-control" name="insurance" placeholder="mm/dd/YYYY" value="{{ $carlist->insurance?date('Y-m-d',strtotime($carlist->insurance)):'' }}">
                                            </div>
                                            <div class="search-button  one-whole">
                                                <button class="btn  btn-primary" type="submit">Update
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
