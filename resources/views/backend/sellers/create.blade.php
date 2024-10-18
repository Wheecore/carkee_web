@extends('backend.layouts.app')
@section('title', translate('Add New Workshop'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Workshop Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('sellers.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('sellers.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label">{{ translate('Shop Name') }}<span
                                class="text-danger text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control mb-3" placeholder="{{ translate('Shop Name') }}"
                                name="shop_name" value="" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Shop Address') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control autocomplete" id="autocomplete"
                                placeholder="Pandamaran, 41200 Klang" name="address" value="" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Category') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <select name="category_id[]" id="category_id" class="form-control aiz-selectpicker"
                                data-selected-text-format="count" data-live-search="true" multiple required>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Operation Hours') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>From Time</label>
                                        <input type="time" class="form-control" placeholder="From Time"
                                            name="from_time" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>To Time</label>
                                        <input type="time" class="form-control" placeholder="To Time"
                                            name="to_time" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('No of Staff/Workers') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder=""
                                name="no_of_staff" value="" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Contact No') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder=""
                                name="contact_no" value="" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Working Bay') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder=""
                                name="working_bay" value="" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">
                            {{ translate('Description') }}
                            <span class="text-danger text-danger">*</span>
                        </label>
                        <div class="col-sm-9">
                            <textarea name="description" id="description" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" class="latitude-pts" name="latitude">
                    <input type="hidden" class="longitude-pts" name="longitude">


                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{ translate('Email Address') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Email Address') }}" id="email"
                                name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="password">{{ translate('Password') }}</label>
                        <div class="col-sm-9">
                            <input type="password" placeholder="{{ translate('Password') }}" id="password"
                                name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="password">{{ translate('Availability Duration') }}
                            (In mints)</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{ translate('Availability Duration') }}"
                                name="avail_duration" class="form-control">
                        </div>
                    </div>
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
