@extends('backend.layouts.app')
@section('title', translate('Add New Car Wash Product'))
@section('css')

    <link rel="stylesheet" href="{{ static_asset('assets/css/product.css') }}">

@endsection
@section('content')

    <div class="">
        <form class="form form-horizontal mar-top" action="{{ route('car-washes.store') }}" method="POST"
            enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8 mx-auto">
                    @csrf
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
                                        <option value="S" {{ (old('ptype') == 'S') ? 'selected' : '' }}>{{ translate('Subscription') }}</option>
                                        <option value="M" {{ (old('ptype') == 'M') ? 'selected' : '' }}>{{ translate('Membership') }}</option>
                                        <option value="O" {{ (old('ptype') == 'O') ? 'selected' : '' }}>{{ translate('One Time') }}</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="form-group row" id="category">
                                <label class="col-md-3 col-from-label">{{ translate('Category') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                        data-live-search="true" required onchange="tyreSize()">
                                        <option value="" readonly="">--Select-</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('category_id') == $category->id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Name') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="{{ translate('Name') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Type') }} <span class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <select id="type" name="type[]" class="form-control" required multiple>
                                        <option value="MPV" {{ old('type') == 'MPV' ? 'selected' : '' }}>
                                            {{ translate('MPV') }}
                                        </option>
                                        <option value="Standard_Sedan" {{ old('type') == 'Standard_Sedan' ? 'selected' : '' }}>
                                            {{ translate('Standard Sedan') }}
                                        </option>
                                        <option value="Executive_Sedan" {{ old('type') == 'Executive_Sedan' ? 'selected' : '' }}>
                                            {{ translate('Executive Sedan') }}
                                        </option>
                                        <option value="SUV" {{ old('type') == 'SUV' ? 'selected' : '' }}>
                                            {{ translate('SUV') }}
                                        </option>
                                        <option value="4X4" {{ old('type') == '4X4' ? 'selected' : '' }}>
                                            {{ translate('4X4') }}
                                        </option>
                                        <option value="B-segment" {{ old('type') == 'B-segment' ? 'selected' : '' }}>
                                            {{ translate('B-segment') }}
                                        </option>
                                        <option value="Super_Sedan" {{ old('type') == 'Super_Sedan' ? 'selected' : '' }}>
                                            {{ translate('Super Sedan') }}
                                        </option>
                                        <option value="Sportscar" {{ old('type') == 'Sportscar' ? 'selected' : '' }}>
                                            {{ translate('Sportscar') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Description') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="description"
                                        value="{{ old('description') }}" placeholder="{{ translate('Description') }}"
                                        required>
                                </div>
                            </div>
                            <div id="div-unit-price">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Unit price') }} <span
                                        class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="number" min="0" value="{{ old('amount') ?? 0 }}" step="0.01"
                                            placeholder="{{ translate('Unit price') }}" name="amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Membership Fee') }} <span
                                    class="text-danger">*</span></label>
                                <div class="col-md-9">
                                    <input type="number" min="0" value="{{ old('membership_fee') ?? env('MEMBERSHIP_AMOUNT') }}" step="0.01"
                                        placeholder="{{ translate('Membership Fee') }}" name="membership_fee"
                                        class="form-control">
                                </div>
                            </div>
                            <div id="div-usage-limit">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Usage Limit') }} <span
                                        class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="usage_limit"
                                            value="{{ old('usage_limit') ?? 1 }}" placeholder="{{ translate('Usage Limit') }}">
                                    </div>
                                </div>
                            </div>
                            <div id="div-warranty" class="d-none">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Warranty In Years') }} <span class="text-danger">*</span></label>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" name="warranty" value="{{ old('warranty') ?? 0 }}" placeholder="{{ translate('Warranty') }}">
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
                                        <input type="hidden" name="upload_id" class="selected-files">
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
