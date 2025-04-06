@extends('backend.layouts.app')
@section('title', translate('Add New Product'))
@section('css')

    <link rel="stylesheet" href="{{ static_asset('assets/css/product.css') }}">

@endsection
@section('content')

    <div class="">
        <form class="form form-horizontal mar-top" action="{{ route('products.store') }}" method="POST"
            enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8">
                    @csrf
                    <input type="hidden" name="added_by" value="admin">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                            <a class="btn btn-primary" href="{{ route('products.all') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                        </div>
                        @if(count($errors) > 0)
                            <div class="row ml-2 mt-1">
                                <div class="col-md-11">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <ul class="p-0 m-0" style="list-style: none;">
                                            @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Product Name') }} <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ translate('Product Name') }}" onchange="update_sku()" required>
                                </div>
                            </div>
                            <div class="form-group row" id="category">
                                <label class="col-md-3 col-from-label">{{ translate('Category') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                        data-live-search="true" required onchange="tyreSize()">
                                        <option value="" readonly="">--Select-</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ (old('category_id') == $category->id) ? 'selected' : '' }}>
                                                {{ $category->getTranslation('name') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Minimum Purchase Qty') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="number" lang="en" class="form-control" name="min_qty" value="{{ (old('min_qty'))?old('min_qty'):1 }}" min="1" required>
                                </div>
                            </div>
                            <div class="form-group row" id="tyre_brands" style="display: none">
                                <label class="col-md-3 col-from-label">{{ translate('Tyre Brands') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="tyre_brand_id" id="tyre_brand_id"
                                        data-live-search="true">
                                        <option value="" readonly="">--Select-</option>
                                        @foreach ($tyre_brands as $tyre_brand)
                                            <option value="{{ $tyre_brand->id }}" {{ (old('tyre_brand_id') == $tyre_brand->id) ? 'selected' : '' }}>
                                                {{ $tyre_brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="service_brands" style="display: none">
                                <label class="col-md-3 col-from-label">{{ translate('Service Brands') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="service_brand_id" id="service_brand_id"
                                        data-live-search="true">
                                        <option value="" readonly="">--Select-</option>
                                        @foreach ($service_brands as $service_brand)
                                            <option value="{{ $service_brand->id }}" {{ (old('service_brand_id') == $service_brand->id) ? 'selected' : '' }}>
                                                {{ $service_brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Tags') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control aiz-tag-input" name="tags[]" value="" placeholder="{{ translate('Type and hit enter to add a tag') }}">
                                    <small class="text-muted">{{ translate('This is used for search. Input those words by which cutomer can find this product.') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Product Images') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Gallery Images') }}
                                    <small>(600x600)</small></label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image"
                                        data-multiple="true">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="photos" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                    <small class="text-muted">{{ translate('These images are visible in product details page gallery. Use 600x600 sizes images.') }}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Thumbnail Image') }}
                                    <small>(300x300)</small></label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="thumbnail_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                    <small
                                        class="text-muted">{{ translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.') }}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Background Image') }}
                                    <small>(300x300)</small></label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="bg_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                    <small
                                        class="text-muted">{{ translate('This image is visible in all product box. Use 300x300 sizes image. Keep some blank space around main object of your image as we had to crop some edge in different devices to make it responsive.') }}</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Label Icon') }}</label>
                                <div class="col-md-6">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="label_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin:auto">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_label_status_fun(this)" name="label_status"
                                            id="update_label_status" value="0" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Return Days') }}</label>
                                <div class="col-md-6">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="return_days_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin:auto">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_return_status_fun(this)" name="return_status"
                                            id="update_return_status" value="0" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Shipping Icon') }}</label>
                                <div class="col-md-6">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="shipping_img" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin:auto">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_shipping_status_fun(this)" name="shipping_status"
                                            id="update_shipping_status" value="0" type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Product Videos') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Video Provider') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="video_provider"
                                        id="video_provider">
                                        <option value="youtube">{{ translate('Youtube') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Video Link') }}</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="video_link" value="{{ old('video_link') }}" placeholder="{{ translate('Video Link') }}">
                                    <small class="text-muted">{{ translate("Use proper link without extra parameter. Don't use short share link/embeded iframe code.") }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Product price + stock') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Cost Price') }}</label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Cost Price') }}" name="cost_price" value="{{ old('cost_price') ?? 0 }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="service_price">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Unit Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Unit Price') }}" name="unit_price" value="{{ old('unit_price') ?? 0 }}"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="tyre_price" style="display: none">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Quantity 1 Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Quantity 1 Price') }}" name="quantity_1_price" value="{{ old('quantity_1_price') ?? 0 }}"
                                        class="form-control" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Greater Then 1 & Equal to 3 Quantity Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Greater Then 1 & Equal to 3 Quantity Price') }}" name="greater_1_price" value="{{ old('greater_1_price')?? 0 }}"
                                        class="form-control" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Greater Then 3 Quantity Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Greater Then 3 Quantity Price') }}" name="greater_3_price" value="{{ old('greater_3_price') ?? 0 }}"
                                        class="form-control" required>
                                </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label"
                                    for="start_date">{{ translate('Discount Date Range') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control aiz-date-range" name="date_range" value="{{ old('date_range') }}"
                                        placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss"
                                        data-separator=" to " autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Discount') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" value="0" step="0.01" value="{{ old('discount') }}"
                                        placeholder="{{ translate('Discount') }}" name="discount" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control aiz-selectpicker" name="discount_type">
                                        <option value="amount" {{ old('discount_type') == 'amount' ? 'selected' : '' }}>{{ translate('Flat') }}</option>
                                        <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>{{ translate('Percent') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-from-label">{{ translate('Quantity') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input type="number" lang="en" min="0" value="{{ old('current_stock') ?? 0 }}" step="1" placeholder="{{ translate('Quantity') }}" name="current_stock" class="form-control" required>
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        {{ translate('SKU') }}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="{{ translate('SKU') }}" value="{{ old('sku') }}" name="sku" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Product Description') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Description') }}</label>
                                <div class="col-md-8">
                                    <textarea class="aiz-text-editor" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Terms & Conditions') }}</label>
                                <div class="col-md-8">
                                    <textarea class="aiz-text-editor" name="term_conditions">{{ old('term_conditions') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="size-card" style="display: none">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Featured Category') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Main Category') }}
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="featured_cat_id" id="featured_cat_id"
                                        onchange="featured_subcats_ajax()">
                                        <option value="">--Select--</option>
                                        @foreach ($feature_categories as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3 featured_sub_cat_id">
                                    <label for="name">
                                        {{ translate('Sub Category') }}
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="featured_sub_cat_id"
                                        id="featured_sub_cat_id">

                                    </select>
                                </div>
                            </div>
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Vehicle Category') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Main Category') }}
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="vehicle_cat_id" id="vehicle_cat_id">
                                        <option value="">--Select--</option>
                                        @foreach ($vehicle_categories as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Size Category') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Main Category') }}
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="size_cat_id" id="size_cat_id"
                                        onchange="size_subcats_ajax()">
                                        <option value="">--Select--</option>
                                        @foreach ($size_categories as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Select Size Sub Category') }}
                                    </label>
                                    <select class="form-control" name="sub_cat_id" id="sub_cat_id"
                                        onchange="size_childcats_ajax()">

                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Select Size Child Category') }}
                                    </label>
                                    <select class="form-control" name="child_cat_id" id="child_cat_id">

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Front/Rear') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Choose Category') }}
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="front_rear" id="front_rear">
                                        <option value="">--Select--</option>
                                        <option value="front">Front</option>
                                        <option value="rear">Rear</option>
                                        <option value="front/rear">Front/Rear</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="">Other Attributes</h6>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Tyre Size') }}
                                    </label>
                                    <input type="text" class="form-control" name="tyre_size" value="{{ old('tyre_size') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Speed & Load Index') }}
                                    </label>
                                    <input type="text" class="form-control" name="speed_index" value="{{ old('speed_index') }}">
                                </div>

                                <div class="form-group mb-3" style="display:none">
                                    <label for="name">
                                        {{ translate('Load Index') }}
                                    </label>
                                    <input type="text" class="form-control" name="load_index" value="{{ old('load_index') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Season') }}
                                    </label>
                                    <input type="text" class="form-control" name="season" value="{{ old('season') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Vehicle Type') }}
                                    </label>
                                    <input type="text" class="form-control" name="vehicle_type" value="{{ old('vehicle_type') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Label') }}
                                    </label>
                                    <input type="text" class="form-control" name="label" value="{{ old('label') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Product Of') }}
                                    </label>
                                    <input type="text" class="form-control" name="product_of" value="{{ old('product_of') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Warranty Type') }}
                                    </label>
                                    <input type="text" class="form-control" name="warranty_type" value="{{ old('warranty_type') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Warranty Period') }}
                                    </label>
                                    <input type="number" class="form-control" name="warranty_period" value="{{ old('warranty_period') }}">
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Performance') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Dry') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" value="0" max="10" name="dry" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Wet') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" value="0" max="10" name="wet" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Sport') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" value="0" max="10" name="sport" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Comfort') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" value="0" max="10" name="comfort" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Mileage') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" value="0" max="10" name="mileage" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card service_card" style="display:none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Service Attributes') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="col-from-label">{{ translate('Sub Category') }} <span class="text-danger">*</span></label>
                                <select class="form-control aiz-selectpicker" name="sub_category_id" id="sub_category_id" data-live-search="true" onchange="get_sub_child_categories()">
                                    <option value="" readonly="">--Select-</option>
                                    @foreach ($subcategories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-from-label">{{ translate('Sub Child Category') }} <span class="text-danger">*</span></label>
                                <select class="form-control aiz-selectpicker" name="sub_child_category_id" id="sub_child_category_id" data-live-search="true"></select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Viscosity') }}
                                </label>
                                <input type="text" class="form-control" name="viscosity" value="{{ old('viscosity') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Packaging') }}
                                </label>
                                <input type="text" class="form-control" name="packaging" id="tag-input1" value="{{ old('packaging') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Type') }}
                                </label>
                                <input type="text" class="form-control" name="vehicle_type1" value="{{ old('vehicle_type1') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Interval') }}
                                </label>
                                <input type="text" class="form-control" name="service_interval" id="tag-input1" value="{{ old('service_interval') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Product Of') }}
                                </label>
                                <input type="text" class="form-control" name="product_of1" id="tag-input1" value="{{ old('product_of1') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Warranty Type') }}
                                </label>
                                <input type="text" class="form-control" name="warranty_type1" id="tag-input1" value="{{ old('warranty_type1') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Warranty Period') }}
                                </label>
                                <input type="number" class="form-control" name="warranty_period1" id="tag-input1" value="{{ old('warranty_period1') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Low Stock Quantity Warning') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Quantity') }}
                                </label>
                                <input type="number" name="low_stock_quantity" value="{{ old('low_stock_quantity') ?? 0 }}" min="0" step="1"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card" style="display: none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">
                                {{ translate('Stock Visibility State') }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Show Stock Quantity') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="quantity" checked>
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-6 col-from-label">{{ translate('Show Stock With Text Only') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="text">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Hide Stock') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="hide">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Featured') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Status') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="featured" value="1">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Primary, Secondary') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Choose') }}</label>
                                <div class="col-md-6">
                                    <select name="ps_status" id="ps_status" class="form-control">
                                        <option value="Secondary">Select</option>
                                        <option value="Primary">Primary</option>
                                        <option value="Secondary">Secondary</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="display: none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Todays Deal') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Status') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="checkbox" name="todays_deal" value="1">
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="display: none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Flash Deal') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Add To Flash') }}
                                </label>
                                <select class="form-control aiz-selectpicker" name="deal_id" id="flash_deal">
                                    <option value="">Choose Flash Title</option>
                                    @foreach ($flash_deals as $flash_deal)
                                        <option value="{{ $flash_deal->id }}">
                                            {{ $flash_deal->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Discount') }}
                                </label>
                                <input type="number" name="flash_discount" value="{{ old('flash_discount') ?? 0 }}" min="0" step="1"
                                    class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Discount Type') }}
                                </label>
                                <select class="form-control aiz-selectpicker" name="flash_discount_type"
                                    id="flash_discount_type">
                                    <option value="">Choose Discount Type</option>
                                    <option value="amount" {{ old('flash_discount_type') == 'amount' ? 'selected' : '' }}>{{ translate('Flat') }}</option>
                                    <option value="percent" {{ old('flash_discount_type') == 'percent' ? 'selected' : '' }}>{{ translate('Percent') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <button type="submit" name="button" value="unpublish" class="btn btn-primary">{{ translate('Save & Unpublish') }}</button>
                        </div>
                        <div class="btn-group" role="group" aria-label="Second group">
                            <button type="submit" name="button" value="publish" class="btn btn-success">{{ translate('Save & Publish') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')
    <script src="{{ static_asset('assets/js/product.js') }}"></script>
@endsection
