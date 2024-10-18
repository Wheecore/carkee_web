@extends('backend.layouts.app')
@section('content')
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Update Package Information') }}</h5>
                </div>
                <form class="p-4" action="{{ route('packages.update', $package->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    <div class="form-group row" id="brand">
                        <label class="col-md-3 col-from-label">{{ translate('Brand') }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="brand_id[]" id="brand_id" data-live-search="true"
                                onchange="pmodels()" multiple>
                                <option value="">{{ translate('Select Brand') }}</option>
                                @foreach ($ibrands as $brand)
                                    <option value="{{ $brand->id }}" selected>{{ $brand->getTranslation('name') }}
                                    </option>
                                @endforeach
                                @foreach ($nbrands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Model') }}</label>
                        <div class="col-md-8">
                            <select name="model_id[]" id="model_id" class="form-control" data-live-search="true"
                                onchange="pdetails()" multiple>
                                {{-- <option value="">--select--</option> --}}
                                @if (count($models) > 0)
                                    @foreach ($models as $data)
                                        <option value="{{ $data->id }}" selected>{{ $data->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car Years') }}</label>
                        <div class="col-md-8">
                            <select name="details_id[]" id="details_id" class="form-control" onchange="car_years()"
                                multiple>
                                {{-- <option value="" disabled>--select--</option> --}}
                                @if (count($years) > 0)
                                    @foreach ($years as $data)
                                        <option value="{{ $data->id }}" selected>{{ $data->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car CC') }}</label>
                        <div class="col-md-8">
                            <select name="year_id[]" id="year_id" class="form-control" onchange="ptypes()" multiple>
                                {{-- <option value="" disabled>--select--</option> --}}
                                @if (count($details) > 0)
                                    @foreach ($details as $data)
                                        <option value="{{ $data->id }}" selected>{{ $data->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car Type') }}</label>
                        <div class="col-md-8">
                            <select name="type_id[]" id="type_id" class="form-control" multiple>
                                {{-- <option value="">--select--</option> --}}
                                @if (count($types) > 0)
                                    @foreach ($types as $data)
                                        <option value="{{ $data->id }}" selected>{{ $data->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                value="{{ $package->getTranslation('name', $lang) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Mileage') }}
                            <small style="color: green">(In KM)</small>
                        </label>
                        <div class="col-sm-8">
                            <input type="number" step="any" placeholder="{{ translate('Mileage') }}" name="mileage"
                                class="form-control" value="{{ $package->mileage }}" required>
                        </div>
                    </div>
                     <div class="form-group row">
                        <label class="col-md-3 col-from-label" for="package_type">{{ translate('Package Type') }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="package_type" required>
                                <option value="">{{ translate('Select Package Type') }}</option>
                                    <option value="semi" {{($package->type =='semi') ?'selected':''}}>Semi</option>
                                    <option value="fully" {{($package->type =='fully') ?'selected':''}}>Fully</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Expiry Month') }}
                            <small style="color: green">(Enter months e.g 2)</small>
                        </label>
                        <div class="col-sm-8">
                            <input type="number" placeholder="{{ translate('Expiry Month') }}" name="expiry_month"
                                class="form-control" value="{{ $package->expiry_month }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label"
                            for="signinSrEmail">{{ translate('Package Logo') }}</label>
                        <div class="col-sm-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="logo" class="selected-files"
                                    value="{{ $package->logo }}">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function pmodels() {
            var brand_id = $('#brand_id').val();
            $.ajax({
                url: "{{ url('admin/p-get-car-models') }}",
                type: 'post',
                data: {
                    _token: CSRF,
                    id: brand_id
                },
                success: function(res) {
                    $('#model_id').html(res);
                },
                // error: function()
                // {
                //     alert('failed...');
                //
                // }
            });
        }

        function pdetails() {
            var model_id = $('#model_id').val();
            $.ajax({
                url: SITE_URL + "/admin/p-get-car-details",
                type: 'post',
                data: {
                    _token: CSRF,
                    id: model_id
                },
                success: function(res) {
                    $('#details_id').html(res);
                },
                // error: function()
                // {
                //     alert('failed...');
                //
                // }
            });
        }

        function car_years() {
            var details_id = $('#details_id').val();
            $.ajax({
                url: SITE_URL + "/admin/p-get-car-years",
                type: 'post',
                data: {
                    _token: CSRF,
                    id: details_id
                },
                success: function(res) {
                    $('#year_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }

        function ptypes() {
            var year_id = $('#year_id').val();
            $.ajax({
                _token: CSRF,
                url: SITE_URL + "/admin/p-get-car-types",
                type: 'POST',
                data: {
                    _token: CSRF,
                    id: year_id
                },
                success: function(res) {
                    $('#type_id').html(res);
                },
                // error: function()
                // {
                //     alert('failed...');
                //
                // }
            });
        }
    </script>
@endsection
