@extends('backend.layouts.app')
@section('title', translate('Add New Package'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Add New Package') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('packages.store') }}" method="POST">
                    @csrf
                    <div class="form-group row" id="brand">
                        <label class="col-md-3 col-from-label">{{ translate('Brand') }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="brand_id[]" id="brand_id" data-live-search="true"
                                onchange="pmodels()" multiple>
                                <option value="">{{ translate('Select Brand') }}</option>
                                @foreach (\App\Models\Brand::all() as $brand)
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
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car Years') }}</label>
                        <div class="col-md-8">
                            <select name="details_id[]" id="details_id" class="form-control" onchange="car_years()"
                                multiple>
                                {{-- <option value="">--select--</option> --}}

                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car CC') }}</label>
                        <div class="col-md-8">
                            <select name="year_id[]" id="year_id" class="form-control" onchange="ptypes()" multiple>
                                {{-- <option value="" disabled>--select--</option> --}}

                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car Type') }}</label>
                        <div class="col-md-8">
                            <select name="type_id[]" id="type_id" class="form-control" multiple>
                                {{-- <option value="">--select--</option> --}}

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label" for="name">{{ translate('Name') }}</label>
                        <div class="col-md-8">
                            <input type="text" placeholder="{{ translate('Name') }}" name="name" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label" for="name">{{ translate('Mileage') }} <small class="text-success">(In KM)</small></label>
                        <div class="col-md-8">
                            <input type="number" step="any" placeholder="{{ translate('Mileage') }}" name="mileage" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label" for="package_type">{{ translate('Package Type') }}</label>
                        <div class="col-md-8">
                            <select class="form-control" name="package_type" required>
                                <option value="">{{ translate('Select Package Type') }}</option>
                                    <option value="semi">Semi</option>
                                    <option value="fully">Fully</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label" for="name">{{ translate('Expiry Month') }} <small class="text-success">(Enter months e.g 2)</small></label>
                        <div class="col-md-8">
                            <input type="number" placeholder="{{ translate('Expiry Month') }}" name="expiry_month"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label" for="signinSrEmail">{{ translate('Package Logo') }}</label>
                        <div class="col-md-8">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="logo" class="selected-files">
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

@endsection
@section('script')
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
