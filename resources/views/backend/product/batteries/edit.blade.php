@extends('backend.layouts.app')
@section('title', translate('Edit Product'))
@section('css')
    <link rel="stylesheet" href="{{ static_asset('assets/css/product.css') }}">
@endsection
@section('content')

    <div>
        <form class="form form-horizontal mar-top" action="{{ route('battery.update', $battery->id) }}" method="POST"
            enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8">
                    <input name="_method" type="hidden" value="POST">
                    <input type="hidden" name="id" value="{{ $battery->id }}">
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
                                        <option value="{{ $battery_brand->id }}" {{ $battery->battery_brand_id == $battery_brand->id ? 'selected' : '' }}>
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
                                        <option value="{{ $category->id }}" {{ $battery->sub_category_id == $category->id ? 'selected' : '' }}>
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
                                    id="battery_sub_child_category_id" data-live-search="true" data-selected="{{ $battery->sub_child_category_id }}"></select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-from-label">{{ translate('Battery Name') }} <i
                                        class="text-danger">*</i></label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ translate('Battery Name') }}" value="{{ $battery->name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Battery Model') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="model"
                                        placeholder="{{ translate('Battery Model') }}" value="{{ $battery->model }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Capacity (AH@20HR)') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="capacity"
                                        placeholder="{{ translate('Capacity (AH@20HR)') }}"
                                        value="{{ $battery->capacity }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-4 col-from-label">{{ translate('Cold Craking Amperes (CCA - SAE)') }}</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="cold_cranking_amperes"
                                        value="{{ $battery->cold_cranking_amperes }}"
                                        placeholder="{{ translate('Cold Craking Amperes (CCA - SAE)') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Milleage Warranty') }} (In
                                    KM)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="mileage_warranty"
                                        value="{{ $battery->mileage_warranty }}"
                                        placeholder="{{ translate('Milleage Warranty') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-4 col-from-label">{{ translate('Reserve Capacity (RC - MINS)') }}</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="reserve_capacity"
                                        value="{{ $battery->reserve_capacity }}"
                                        placeholder="{{ translate('Reserve Capacity (RC - MINS)') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Height') }} (<small>In
                                        mm</small>)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="height"
                                        value="{{ $battery->height }}" placeholder="{{ translate('Height') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Length') }} (<small>In
                                        mm</small>)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="length"
                                        value="{{ $battery->length }}" placeholder="{{ translate('Length') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Width') }} (<small>In
                                        mm</small>)</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="width"
                                        value="{{ $battery->width }}" placeholder="{{ translate('Width') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Start/Stop Function') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="start_stop_function">
                                        <option value="Yes"
                                            {{ $battery->start_stop_function == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No"
                                            {{ $battery->start_stop_function == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-4 col-from-label">{{ translate('Japanese Industrial Standard') }}</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="jis"
                                        value="{{ $battery->jis }}"
                                        placeholder="{{ translate('Japanese Industrial Standard') }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Absorbed Glass Mat') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="absorbed_glass_mat">
                                        <option value="Yes"
                                            {{ $battery->absorbed_glass_mat == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No"
                                            {{ $battery->absorbed_glass_mat == 'No' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4 col-from-label">{{ translate('Description') }}</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="3" name="description" placeholder="{{ translate('Description') }}">{{ $battery->description }}</textarea>
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
                                    <small>(290x300)</small></label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="attachment_id" value="{{ $battery->attachment_id }}"
                                            class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
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
                                    <input type="number" min="0" step="0.01" value="{{ $battery->amount }}"
                                        placeholder="{{ translate('Unit price') }}" name="amount" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Discount') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" min="0" step="0.01"
                                        value="{{ $battery->discount }}" placeholder="{{ translate('Discount') }}"
                                        name="discount" class="form-control">
                                </div>
                            </div>
                            <div>
                                <div id="show-hide-div">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-from-label">{{ translate('Quantity') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input type="number" min="0" step="1"
                                                value="{{ $battery->stock }}" placeholder="{{ translate('Quantity') }}"
                                                name="stock" class="form-control" required>
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
                                <input type="number" step="any" class="form-control"
                                    value="{{ $battery->warranty }}" name="warranty" placeholder="Warranty" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3" style="text-align: center;">
                        <button type="submit" name="button"
                            class="btn btn-info">{{ translate('Update Battery') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.remove-files').on('click', function() {
                $(this).parents(".col-md-4").remove();
            });
            battery_get_sub_child_categories('{{ $battery->sub_child_category_id }}');
        });
    </script>
    <script>
        function battery_get_sub_child_categories(child_id) {
            $.ajax({
                url: SITE_URL + "/admin/battery-get-sub-child-categories",
                type: 'POST',
                data: {
                    _token: CSRF,
                    id: $('#battery_sub_category_id').val(),
                    child_id: child_id,
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
