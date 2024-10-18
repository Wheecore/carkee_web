@extends('backend.layouts.app')
@section('title', translate('Add New Battery'))
@section('css')
    <link rel="stylesheet" href="{{ static_asset('assets/css/product.css') }}">
@endsection
@section('content')

    <div class="">
        <form class="form form-horizontal mar-top" action="{{ route('battery.store') }}" method="POST"
            enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Battery Information') }}</h5>
                            <a class="btn btn-primary" href="{{ route('batteries.all') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                        </div>
                        <div class="card-body">
                            @include('backend.inc.error')
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Battery Brands') }}</label>
                                <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="battery_brand_id"
                                    data-live-search="true">
                                    <option value="" readonly="">--Select-</option>
                                    @foreach ($battery_brands as $battery_brand)
                                        <option value="{{ $battery_brand->id }}">
                                            {{ $battery_brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Sub Category') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="sub_category_id" id="battery_sub_category_id"
                                    data-live-search="true" onchange="battery_get_sub_child_categories()">
                                    <option value="" readonly="">--Select-</option>
                                    @foreach ($subcategories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Sub Child Category') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                <select class="form-control aiz-selectpicker" name="sub_child_category_id"
                                    id="battery_sub_child_category_id" data-live-search="true"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Battery Name') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ translate('Battery Name') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Battery Model') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="model"
                                        placeholder="{{ translate('Battery Model') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Capacity (AH@20HR)') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="capacity"
                                        placeholder="{{ translate('Capacity (AH@20HR)') }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-4 col-from-label">{{ translate('Cold Craking Amperes (CCA - SAE)') }}</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="cold_cranking_amperes"
                                        placeholder="{{ translate('Cold Craking Amperes (CCA - SAE)') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Milleage Warranty') }} (In KM)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="mileage_warranty"
                                        placeholder="{{ translate('Milleage Warranty') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-4 col-from-label">{{ translate('Reserve Capacity (RC - MINS)') }}</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="reserve_capacity"
                                        placeholder="{{ translate('Reserve Capacity (RC - MINS)') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Height') }} (<small>In
                                        mm</small>)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="height"
                                        placeholder="{{ translate('Height') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Length') }} (<small>In
                                        mm</small>)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="length"
                                        placeholder="{{ translate('Length') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Width') }} (<small>In
                                        mm</small>)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="width"
                                        placeholder="{{ translate('Width') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Start/Stop Function') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="start_stop_function">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-4 col-from-label">{{ translate('Japanese Industrial Standard') }}</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="jis"
                                        placeholder="{{ translate('Japanese Industrial Standard') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Absorbed Glass Mat') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="absorbed_glass_mat">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Description') }}</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="3" name="description" placeholder="{{ translate('Description') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Battery Images') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label"
                                    for="signinSrEmail">{{ translate('Thumbnail Image') }}
                                    <small>(300x300)</small></label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="attachment_id" class="selected-files" required>
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                    <small
                                        class="text-muted">{{ translate('This image is visible in battery box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Battery price + stock') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Unit price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" min="0" value="0" step="0.01"
                                        placeholder="{{ translate('Unit price') }}" name="amount" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Discount') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" min="0" value="0" step="0.01"
                                        placeholder="{{ translate('Discount') }}" name="discount" class="form-control">
                                </div>
                            </div>
                            <div>
                                <div id="show-hide-div">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-from-label">{{ translate('Quantity') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input type="number" min="0" value="0" step="1"
                                                placeholder="{{ translate('Quantity') }}" name="stock"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card size-card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Warranty Period') }} (<small>In months</small>)
                                </label>
                                <input type="number" step="any" class="form-control" name="warranty"
                                    placeholder="Warranty" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3" role="toolbar" aria-label="Toolbar with button groups"
                        style="text-align: center;">
                        <button type="submit" name="button" value="publish"
                            class="btn btn-success">{{ translate('Save Battery') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')

    <script src="{{ static_asset('assets/js/product.js') }}"></script>
    <script>
        function battery_get_sub_child_categories() {
            $.ajax({
                url: SITE_URL + "/admin/battery-get-sub-child-categories",
                type: 'POST',
                data: {
                    _token: CSRF,
                    id: $('#battery_sub_category_id').val()
                },
                success: function(res) {
                    $('#battery_sub_child_category_id').html(res);
                    $("#battery_sub_child_category_id").selectpicker('refresh');
                },
                error: function() {
                    alert('failed...');

                }
            });
        }
    </script>

@endsection
