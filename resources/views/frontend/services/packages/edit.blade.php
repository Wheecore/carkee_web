@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <h5 class="mb-0 h6">{{ translate('Package Information') }}</h5>
    </div>

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-fill border-light">
                    @foreach (get_all_languages() as $key => $language)
                        <li class="nav-item">
                            <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                href="{{ route('brands.edit', ['id' => $package->id, 'lang' => $language->code]) }}">
                                <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}" height="11"
                                    class="mr-1">
                                <span>{{ $language->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <form class="p-4" action="{{ route('packages.update', $package->id) }}" method="POST"
                    enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PATCH">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    <div class="form-group row" id="brand">
                        <label class="col-md-3 col-from-label">{{ translate('Brand') }}</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="brand_id" id="brand_id"
                                data-live-search="true" onchange="models()">
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
                            <select name="model_id" id="model_id" class="form-control" onchange="details()">
                                <option value="">--select--</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car Details') }}</label>
                        <div class="col-md-8">
                            <select name="details_id" id="details_id" class="form-control" onchange="types()">
                                <option value="">--select--</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="">
                        <label class="col-md-3 col-from-label">{{ translate('Car Type') }}</label>
                        <div class="col-md-8">
                            <select name="type_id" id="type_id" class="form-control">
                                <option value="">--select--</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Name') }} <i
                                class="las la-language text-danger" title="{{ translate('Translatable') }}"></i></label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Name') }}" id="name" name="name"
                                value="{{ $package->getTranslation('name', $lang) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Logo') }}
                            <small>({{ translate('120x80') }})</small></label>
                        <div class="col-md-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="logo" value="{{ $package->logo }}" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{ translate('Price') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="price" value="{{ $package->price }}"
                                placeholder="{{ translate('Meta Title') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{ translate('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea name="description" rows="8" class="form-control">{{ $package->description }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Slug') }}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{ translate('Slug') }}" id="slug" name="slug"
                                value="{{ $package->slug }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function models() {
            var brand_id = $('#brand_id').val();
            $.ajax({
                url: "{{ url('admin/get-car-models') }}",
                type: 'post',
                data: {
                    _token: CSRF,
                    id: brand_id
                },
                success: function(res) {
                    $('#model_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }

        function details() {
            var model_id = $('#model_id').val();
            $.ajax({
                url: "{{ url('admin/get-car-details') }}",
                type: 'post',
                data: {
                    _token: CSRF,
                    id: model_id
                },
                success: function(res) {
                    $('#details_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }
        {{-- function car_years() { --}}
        {{-- var details_id = $('#details_id').val(); --}}
        {{-- $.ajax({ --}}
        {{-- url : "{{ url('admin/get-car-years') }}", --}}
        {{-- type: 'get', --}}
        {{-- data: { --}}
        {{-- id : details_id --}}
        {{-- }, --}}
        {{-- success: function(res) --}}
        {{-- { --}}
        {{-- $('#year_id').html(res); --}}
        {{-- }, --}}
        {{-- error: function() --}}
        {{-- { --}}
        {{-- alert('failed...'); --}}

        {{-- } --}}
        {{-- }); --}}
        {{-- } --}}

        function types() {
            var details_id = $('#details_id').val();
            $.ajax({
                url: "{{ url('admin/get-car-types') }}",
                type: 'post',
                data: {
                    _token: CSRF,
                    id: details_id
                },
                success: function(res) {
                    $('#type_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }
    </script>
@endsection
