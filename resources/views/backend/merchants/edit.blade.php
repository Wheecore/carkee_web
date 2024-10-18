@extends('backend.layouts.app')
@section('title', translate('Edit Merchant Information'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Merchant Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('merchants.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>

            <div class="card-body">
                <form action="{{ route('merchants.update', $merchant->id) }}" method="POST">
                    <input name="_method" type="hidden" value="PATCH">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                class="form-control" value="{{ $merchant->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{ translate('Email Address') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Email Address') }}" id="email"
                                name="email" class="form-control" value="{{ $merchant->email }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="password">{{ translate('Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" placeholder="{{ translate('Password') }}" id="password" name="password"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="">{{ translate('Category') }}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="category" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $merchant->merchant_category == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="">{{ translate('Recommended') }}</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="recommended" required>
                                <option value="1" {{ $merchant->is_recommended == 1 ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $merchant->is_recommended == 0 ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for=""> {{ translate('Shop Address') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control autocomplete" id="autocomplete"
                                placeholder="Pandamaran, 41200 Klang" name="address" value="{{ $shop->address }}">
                        </div>
                    </div>
                    <input type="hidden" class="latitude-pts" name="latitude" value="{{ $shop->latitude }}" />
                    <input type="hidden" class="longitude-pts" name="longitude" value="{{ $shop->longitude }}" />
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
