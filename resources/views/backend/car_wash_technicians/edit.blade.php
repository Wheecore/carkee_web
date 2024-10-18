@extends('backend.layouts.app')
@section('title', translate('Update Car Wash Technician'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Car Wash Technician Details') }}</h5>
                <a class="btn btn-primary" href="{{ route('car-wash-technicians.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('car-wash-technicians.update', $technician->id) }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                class="form-control" value="{{ $technician->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{ translate('Email Address') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Email Address') }}" id="email"
                                name="email" class="form-control" value="{{ $technician->email }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Contact No') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"
                                placeholder="{{ translate('Contact No') }}" name="phone" value="{{ $technician->phone }}"
                                required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <label class="col-sm-3 col-form-label">{{ translate('Shop Name') }}<span
                                class="text-danger text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control mb-3" placeholder="{{ translate('Shop Name') }}"
                                name="shop_name" value="{{ $technician->shop_name }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Shop Address') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control autocomplete" id="autocomplete"
                                placeholder="Pandamaran, 41200 Klang" name="address" value="{{ $technician->address }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label"
                            for="signinSrEmail">{{ translate('Shop Logo') }}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="logo" value="{{ $technician->logo }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" class="latitude-pts" name="latitude" value="{{ $technician->latitude }}">
                    <input type="hidden" class="longitude-pts" name="longitude" value="{{ $technician->longitude }}">
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        var isInitGeoLocate = parseInt(0);
     </script>
    <script src="{{ static_asset('assets/js/geo-coder.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places&callback=initAutocomplete"
        async defer></script>

@endsection
