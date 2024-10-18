@extends('backend.layouts.app')
@section('title', translate('Update Car Wash Product'))
@section('css')

    <link rel="stylesheet" href="{{ static_asset('assets/css/product.css') }}">

@endsection
@section('content')

    <div class="">
        <form class="form form-horizontal mar-top" action="{{ route('car-washes.update', $car_wash->id) }}" method="POST"
            enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8 mx-auto">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Car Wash Information') }}</h5>
                            <a class="btn btn-primary" href="{{ route('car-washes.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                        </div>
                        <div class="card-body">
                            {{-- <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Product Type') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control aiz-selectpicker" name="ptype" id="product_type">
                                        <option value="S" {{ ($car_wash->ptype == 'S') ? 'selected' : '' }}>{{ translate('Subscription') }}</option>
                                        <option value="M" {{ ($car_wash->ptype == 'M') ? 'selected' : '' }}>{{ translate('Membership') }}</option>
                                        <option value="O" {{ ($car_wash->ptype == 'O') ? 'selected' : '' }}>{{ translate('One Time') }}</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group row" id="category">
                                <label class="col-lg-3 col-from-label">{{ translate('Category') }}</label>
                                <div class="col-lg-8">
                                    <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                        data-selected="{{ $car_wash->category_id }}" data-live-search="true" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Name') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" value="{{ $car_wash->name }}"
                                        placeholder="{{ translate('Name') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Type') }} <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    @php
                                        $car_type = (array) (json_decode($car_wash->type) ?? []);
                                    @endphp
                                    <select id="car_type" name="car_type[]" class="form-control" required multiple>
                                        <option value="MPV" {{ in_array('MPV', $car_type) ? 'selected' : '' }}>
                                            {{ translate('MPV') }}
                                        </option>
                                        <option value="Standard_Sedan" {{ in_array('Standard_Sedan', $car_type) ? 'selected' : '' }}>
                                            {{ translate('Standard Sedan') }}
                                        </option>
                                        <option value="Executive_Sedan" {{ in_array('Executive_Sedan', $car_type) ? 'selected' : '' }}>
                                            {{ translate('Executive Sedan') }}
                                        </option>
                                        <option value="SUV" {{ in_array('SUV', $car_type) ? 'selected' : '' }}>
                                            {{ translate('SUV') }}
                                        </option>
                                        <option value="4X4" {{ in_array('4X4', $car_type) ? 'selected' : '' }}>
                                            {{ translate('4X4') }}
                                        </option>
                                        <option value="B-segment" {{ in_array('B-segment', $car_type) ? 'selected' : '' }}>
                                            {{ translate('B-segment') }}
                                        </option>
                                        <option value="Super_Sedan" {{ in_array('Super_Sedan', $car_type) ? 'selected' : '' }}>
                                            {{ translate('Super Sedan') }}
                                        </option>
                                        <option value="Sportscar" {{ in_array('Sportscar', $car_type) ? 'selected' : '' }}>
                                            {{ translate('Sportscar') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Description') }} <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="description" value="{{ $car_wash->description }}" placeholder="{{ translate('Description') }}" required>
                                </div>
                            </div>
                            <div id="div-unit-price" class="{{ (in_array($car_wash->ptype, ['M'])) ? 'd-none' : '' }}">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Unit price') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="{{ $car_wash->amount }}" step="0.01" placeholder="{{ translate('Unit price') }}" name="amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Membership Fee') }} <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="number" min="0" value="{{ $car_wash->membership_fee }}" step="0.01" placeholder="{{ translate('Membership Fee') }}" name="membership_fee" class="form-control">
                                </div>
                            </div>
                            <div id="div-usage-limit" class="{{ (in_array($car_wash->ptype, ['O', 'M'])) ? 'd-none' : '' }}">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Usage Limit') }} <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="usage_limit" value="{{ $car_wash->usage_limit }}" placeholder="{{ translate('Usage Limit') }}">
                                    </div>
                                </div>
                            </div>
                            <div id="div-warranty" class="{{ (in_array($car_wash->ptype, ['M', 'S'])) ? 'd-none' : '' }}">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Warranty In Years') }} <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="warranty" value="{{ $car_wash->warranty }}" placeholder="{{ translate('Warranty') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Image') }}</label>
                                <div class="col-md-9">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="upload_id" class="selected-files" value="{{ $car_wash->upload_id }}">
                                    </div>
                                    <div class="file-preview box sm"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="button" class="btn btn-success">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')
    <script src="{{ static_asset('assets/js/product.js') }}"></script>
    <script>
        $(document).on('change', '#product_type', function () {
            if ($(this).val() == 'O') {
                $('#div-usage-limit').addClass('d-none');
                $('#div-warranty').removeClass('d-none');
                $('#div-unit-price').removeClass('d-none');
            } else if ($(this).val() == 'M') {
                $('#div-warranty').addClass('d-none');
                $('#div-usage-limit').addClass('d-none');
                $('#div-unit-price').addClass('d-none');
            } else {
                $('#div-unit-price').removeClass('d-none');
                $('#div-warranty').addClass('d-none');
                $('#div-usage-limit').removeClass('d-none');
            }
        });
    </script>
@endsection
