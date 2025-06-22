@extends('backend.layouts.app')
@section('title', translate('Edit Product'))
@section('css')
    <link rel="stylesheet" href="{{ static_asset('assets/css/product.css') }}">
@endsection
@section('content')

    <div class="">
        <form class="form form-horizontal mar-top" action="{{ route('products.update', $product->id) }}" method="POST"
            enctype="multipart/form-data" id="choice_form">
            <div class="row gutters-5">
                <div class="col-lg-8">
                    <input name="_method" type="hidden" value="POST">
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Edit Product') }}</h5>
                            <a class="btn btn-primary" href="{{ route('products.all') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                            </div>
                        <div class="card-body">
                        @if(count($errors) > 0)
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
                        @endif
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">{{ translate('Product Name') }} <i
                                        class="las la-language text-danger"
                                        title="{{ translate('Translatable') }}"></i></label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ translate('Product Name') }}"
                                        value="{{ $product->getTranslation('name', $lang) }}" required>
                                </div>
                            </div>
                            <div class="form-group row" id="category">
                                <label class="col-lg-3 col-from-label">{{ translate('Category') }}</label>
                                <div class="col-lg-8">
                                    <select class="form-control aiz-selectpicker" name="category_id" id="category_id"
                                        data-selected="{{ $product->category_id }}" data-live-search="true" required
                                        onchange="tyreSize()">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->getTranslation('name') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">{{ translate('Minimum Purchase Qty') }}</label>
                                <div class="col-lg-8">
                                    <input type="number" lang="en" class="form-control" name="min_qty"
                                        value="{{ $product->min_qty }}" min="1" required>
                                </div>
                            </div>
                            <div class="form-group row" id="tyre_brands" style="display: none">
                                <label class="col-md-3 col-from-label">{{ translate('Tyre Brands') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="tyre_brand_id" id="tyre_brand_id"
                                        data-live-search="true">
                                        <option value="" readonly="">--Select-</option>
                                        @foreach ($tyre_brands as $tyre_brand)
                                            <option value="{{ $tyre_brand->id }}" {{ ($product->tyre_service_brand_id == $tyre_brand->id) ? 'selected' : '' }}>
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
                                            <option value="{{ $service_brand->id }}" {{ ($product->tyre_service_brand_id == $service_brand->id) ? 'selected' : '' }}>
                                                {{ $service_brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="part_brands" style="display: none">
                                <label class="col-md-3 col-from-label">{{ translate('Part Brands') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="part_brand_id" id="part_brand_id"
                                        data-live-search="true">
                                        <option value="" readonly="">--Select-</option>
                                        @foreach ($part_brands as $part_brand)
                                            <option value="{{ $part_brand->id }}" {{ ($product->tyre_service_brand_id == $part_brand->id) ? 'selected' : '' }}>
                                                {{ $part_brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="part_types" style="display: none">
                                <label class="col-md-3 col-from-label">{{ translate('Part Types') }}</label>
                                <div class="col-md-8">
                                    <select class="form-control aiz-selectpicker" name="part_type_id" id="part_type_id"
                                        data-live-search="true">
                                        <option value="" readonly="">--Select-</option>
                                        @foreach ($part_types as $part_type)
                                            <option value="{{ $part_type->id }}" {{ ($product->part_type_id == $part_type->id) ? 'selected' : '' }}>
                                                {{ $part_type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">{{ translate('Tags') }}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags"
                                        value="{{ $product->tags }}"
                                        placeholder="{{ translate('Type to add a tag') }}" data-role="tagsinput">
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
                                    for="signinSrEmail">{{ translate('Gallery Images') }}</label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image"
                                        data-multiple="true">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="photos" value="{{ $product->photos }}"
                                            class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label"
                                    for="signinSrEmail">{{ translate('Thumbnail Image') }}
                                    <small>(290x300)</small></label>
                                <div class="col-md-8">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="thumbnail_img" value="{{ $product->thumbnail_img }}"
                                            class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
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
                                        <input type="hidden" name="bg_img" value="{{ $product->bg_img }}"
                                            class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="signinSrEmail">{{ translate('Label Icon') }}
                                    <small>(300x300)</small></label>
                                <div class="col-md-6">
                                    <div class="input-group" data-toggle="aizuploader" data-type="image">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-soft-secondary font-weight-medium">
                                                {{ translate('Browse') }}</div>
                                        </div>
                                        <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                        <input type="hidden" name="label_img" value="{{ $product->label_img }}"
                                            class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin:auto">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_label_status_fun(this)" name="label_status"
                                            id="update_label_status" value="0" type="checkbox"
                                            {{ $product->label_status == 1 ? 'checked' : '' }}>
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
                                        <input type="hidden" name="return_days_img"
                                            value="{{ $product->return_days_img }}" class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin:auto">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_return_status_fun(this)" name="return_status"
                                            id="update_return_status" value="0" type="checkbox"
                                            {{ $product->return_status == 1 ? 'checked' : '' }}>
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
                                        <input type="hidden" name="shipping_img" value="{{ $product->shipping_img }}"
                                            class="selected-files">
                                    </div>
                                    <div class="file-preview box sm">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin:auto">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input onchange="update_shipping_status_fun(this)" name="shipping_status"
                                            id="update_shipping_status" value="0" type="checkbox"
                                            {{ $product->shipping_status == 1 ? 'checked' : '' }}>
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
                                <label class="col-lg-3 col-from-label">{{ translate('Video Provider') }}</label>
                                <div class="col-lg-8">
                                    <select class="form-control aiz-selectpicker" name="video_provider"
                                        id="video_provider">
                                        <option value="youtube" <?php if ($product->video_provider == 'youtube') { echo 'selected'; } ?>>{{ translate('Youtube') }}</option>
                                        <option value="dailymotion" <?php if ($product->video_provider == 'dailymotion') { echo 'selected'; } ?>>{{ translate('Dailymotion') }}
                                        </option>
                                        <option value="vimeo" <?php if ($product->video_provider == 'vimeo') { echo 'selected';} ?>>{{ translate('Vimeo') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">{{ translate('Video Link') }}</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="video_link"
                                        value="{{ $product->video_link }}"
                                        placeholder="{{ translate('Video Link') }}">
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
                                        placeholder="{{ translate('Cost Price') }}" name="cost_price" value="{{ $product->cost_price }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="service_price">
                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">{{ translate('Unit Price') }}</label>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="{{ translate('Unit Price') }}" name="unit_price"
                                        class="form-control" value="{{ $product->unit_price }}" required>
                                </div>
                            </div>
                            </div>

                            <div class="tyre_price">
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Quantity 1 Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Quantity 1 Price') }}" name="quantity_1_price" value="{{ $product->quantity_1_price }}"
                                        class="form-control" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Greater Then 1 & Equal to 3 Quantity Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Greater Then 1 & Equal to 3 Quantity Price') }}" name="greater_1_price" value="{{ $product->greater_1_price ?? 0 }}"
                                        class="form-control" required>
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">{{ translate('Greater Then 3 Quantity Price') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Greater Then 3 Quantity Price') }}" name="greater_3_price" value="{{ $product->greater_3_price }}"
                                        class="form-control" required>
                                </div>
                                </div>
                            </div>

                            @php
                                $start_date = date('d-m-Y H:i:s', $product->discount_start_date);
                                $end_date = date('d-m-Y H:i:s', $product->discount_end_date);
                            @endphp

                            <div class="form-group row">
                                <label class="col-sm-3 col-from-label"
                                    for="start_date">{{ translate('Discount Date Range') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control aiz-date-range"
                                        value="{{($product->discount_start_date && $product->discount_end_date)?$start_date . ' to ' . $end_date:'' }}" name="date_range"
                                        placeholder="Select Date" data-time-picker="true" data-format="DD-MM-Y HH:mm:ss"
                                        data-separator=" to " autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-from-label">{{ translate('Discount') }}</label>
                                <div class="col-lg-6">
                                    <input type="number" lang="en" min="0" step="0.01"
                                        placeholder="{{ translate('Discount') }}" name="discount"
                                        class="form-control" value="{{ $product->discount }}" required>
                                </div>
                                <div class="col-lg-3">
                                    <select class="form-control aiz-selectpicker" name="discount_type" required>
                                        <option value="amount" <?php if ($product->discount_type == 'amount') {    echo 'selected';} ?>>{{ translate('Flat') }}</option>
                                        <option value="percent" <?php if ($product->discount_type == 'percent') {    echo 'selected';} ?>>{{ translate('Percent') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-from-label">{{ translate('Quantity') }}</label>
                                        <div class="col-lg-6">
                                            <input type="number" lang="en"
                                                value="{{ $product->qty }}" step="1"
                                                placeholder="{{ translate('Quantity') }}" name="current_stock"
                                                class="form-control">
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-from-label">
                                        {{ translate('SKU') }}
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="{{ translate('SKU') }}"
                                            value="{{ $product->sku }}" name="sku"
                                            class="form-control">
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
                                <label class="col-lg-3 col-from-label">{{ translate('Description') }} <i
                                        class="las la-language text-danger"
                                        title="{{ translate('Translatable') }}"></i></label>
                                <div class="col-lg-9">
                                    <textarea class="aiz-text-editor"
                                        name="description">{{ $product->getTranslation('description', $lang) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-from-label">{{ translate('Terms & Conditions') }}</label>
                                <div class="col-md-8">
                                    <textarea class="aiz-text-editor"
                                        name="term_conditions">{{ $product->term_conditions }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if ($product->qty <= 0)
                        <button type="button" class="btn btn-lg btn-danger mb-3 btn-block" data-toggle="modal" data-target="#clear-product">
                            {{ translate('Clear Product') }}
                        </button>
                    @endif
                    <div class="size-card" style="display:{{ ($product->category_id == 1) ? '' : 'none' }}">
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
                                        @foreach ($featured_categories as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $product->featured_cat_id && $product->featured_cat_id == $data->id ? 'selected' : '' }}>
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
                                        @foreach ($featured_sub_categories as $data)
                                            @if ($product->featured_sub_cat_id && $product->featured_sub_cat_id == $data->id)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
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
                                            <option value="{{ $data->id }}"
                                                {{ $product->vehicle_cat_id && $product->vehicle_cat_id == $data->id ? 'selected' : '' }}>
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
                                        {{ translate('Size Category') }}
                                    </label>
                                    <select class="form-control aiz-selectpicker" name="size_cat_id" id="size_cat_id"
                                        onchange="size_subcats_ajax()">
                                        <option value="">--Select--</option>
                                        @foreach ($size_categories as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $product->size_category_id && $product->size_category_id == $data->id ? 'selected' : '' }}>
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
                                        @foreach ($size_sub_categories as $data)
                                            @if ($product->size_sub_category_id && $product->size_sub_category_id == $data->id)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Select Size Child Category') }}
                                    </label>
                                    <select class="form-control" name="child_cat_id" id="child_cat_id">
                                        @foreach ($size_child_categories as $data)
                                            @if ($product->size_child_category_id && $product->size_child_category_id == $data->id)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->name }}
                                                </option>
                                            @endif
                                        @endforeach
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
                                        <option value="front" {{ $product->front_rear == 'front' ? 'selected' : '' }}>Front
                                        </option>
                                        <option value="rear" {{ $product->front_rear == 'rear' ? 'selected' : '' }}>Rear
                                        </option>
                                        <option value="front/rear" {{ $product->front_rear == 'front/rear' ? 'selected' : '' }}>Front/Rear
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="">Other Attributes</h6>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Tyre Size') }}
                                    </label>
                                    <input type="text" class="form-control" name="tyre_size"
                                        value="{{ $product->tyre_size }}">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Speed & Load Index') }}
                                    </label>
                                    <input type="text" class="form-control" name="speed_index"
                                        value="{{ $product->speed_index }}">
                                </div>

                                <div class="form-group mb-3" style="display:none;">
                                    <label for="name">
                                        {{ translate('Load Index') }}
                                    </label>
                                    <input type="text" class="form-control" name="load_index"
                                        value="{{ $product->load_index }}">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Season') }}
                                    </label>
                                    <input type="text" class="form-control" name="season" value="{{ $product->season }}">
                                </div>


                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Vehicle Type') }}
                                    </label>
                                    <input type="text" class="form-control" name="vehicle_type"
                                        value="{{ $product->vehicle_type }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Label') }}
                                    </label>
                                    <input type="text" class="form-control" name="label" id="tag-input1"
                                        value="{{ $product->label }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Product Of') }}
                                    </label>
                                    <input type="text" class="form-control" name="product_of" id="tag-input1"
                                        value="{{ $product->product_of }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Warranty Type') }}
                                    </label>
                                    <input type="text" class="form-control" name="warranty_type" id="tag-input1"
                                        value="{{ $product->warranty_type }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">
                                        {{ translate('Warranty Period') }}
                                    </label>
                                    <input type="number" class="form-control" name="warranty_period" id="tag-input1"
                                        value="{{ $product->warranty_period }}">
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
                                        <input type="number" min="0" max="10" value="{{ $product->dry }}" name="dry" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Wet') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" max="10" value="{{ $product->wet }}" name="wet" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Sport') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" max="10" value="{{ $product->sport }}" name="sport" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Comfort') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" max="10" value="{{ $product->comfort }}" name="comfort" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-from-label">{{ translate('Mileage') }}</label>
                                    <div class="col-md-8">
                                        <input type="number" min="0" max="10" value="{{ $product->mileage }}" name="mileage" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="part-size-card" style="display:{{ ($product->category_id == 8) ? '' : 'none' }}">
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
                                        @foreach ($featured_categories as $data)
                                            <option value="{{ $data->id }}"
                                                {{ $product->featured_cat_id && $product->featured_cat_id == $data->id ? 'selected' : '' }}>
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
                                        @foreach ($featured_sub_categories as $data)
                                            @if ($product->featured_sub_cat_id && $product->featured_sub_cat_id == $data->id)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="card service_card-attributes" style="display:{{ ($product->category_id == 4) ? '' : 'none' }}">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Service Attributes') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="col-from-label">{{ translate('Sub Category') }} <span class="text-danger">*</span></label>
                                <select class="form-control aiz-selectpicker" name="sub_category_id" id="sub_category_id" data-live-search="true" onchange="get_sub_child_categories()">
                                    <option value="" readonly="">--Select-</option>
                                    @foreach ($subcategories as $category)
                                        <option value="{{ $category->id }}" {{ $product->sub_category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-from-label">{{ translate('Sub Child Category') }} <span class="text-danger">*</span></label>
                                <select class="form-control aiz-selectpicker" name="sub_child_category_id" id="sub_child_category_id" data-live-search="true" data-selected="{{ $product->sub_child_category_id }}"></select>
                            </div>
                        </div>
                    </div>
                    <div class="card service_card" style="display:none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Service Attributes') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Viscosity') }}
                                </label>
                                <input type="text" class="form-control" name="viscosity"
                                    value="{{ $product->viscosity }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Packaging') }}
                                </label>
                                <input type="text" class="form-control" name="packaging" id="tag-input1"
                                    value="{{ $product->packaging }}">
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Type') }}
                                </label>
                                <input type="text" class="form-control" name="vehicle_type1"
                                    value="{{ $product->vehicle_type }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Interval') }}
                                </label>
                                <input type="text" class="form-control" name="service_interval" id="tag-input1"
                                    value="{{ $product->service_interval }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Product Of') }}
                                </label>
                                <input type="text" class="form-control" name="product_of1" id="tag-input1"
                                    value="{{ $product->product_of }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Warranty Type') }}
                                </label>
                                <input type="text" class="form-control" name="warranty_type1" id="tag-input1"
                                    value="{{ $product->warranty_type }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Warranty Period') }}
                                </label>
                                <input type="number" class="form-control" name="warranty_period1" id="tag-input1"
                                    value="{{ $product->warranty_period }}">
                            </div>
                        </div>
                    </div>
                    <div class="card" style="display: none">
                        <div class="card-header">
                            <h5 class="mb-0 h6" class="dropdown-toggle" data-toggle="collapse"
                                data-target="#collapse_2">
                                {{ translate('Shipping Configuration') }}
                            </h5>
                        </div>
                        <div class="card-body collapse show" id="collapse_2">
                            @if (get_setting('shipping_type') == 'product_wise_shipping')
                                <div class="form-group row">
                                    <label class="col-lg-6 col-from-label">{{ translate('Free Shipping') }}</label>
                                    <div class="col-lg-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="radio" name="shipping_type" value="free"
                                                @if ($product->shipping_type == 'free') checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-6 col-from-label">{{ translate('Flat Rate') }}</label>
                                    <div class="col-lg-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="radio" name="shipping_type" value="flat_rate"
                                                @if ($product->shipping_type == 'flat_rate') checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flat_rate_shipping_div" style="display: none">
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-from-label">{{ translate('Shipping cost') }}</label>
                                        <div class="col-lg-6">
                                            <input type="number" lang="en" min="0" value="{{ $product->shipping_cost }}"
                                                step="0.01" placeholder="{{ translate('Shipping cost') }}"
                                                name="flat_shipping_cost" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label
                                        class="col-md-6 col-from-label">{{ translate('Is Product Quantity Multiply') }}</label>
                                    <div class="col-md-6">
                                        <label class="aiz-switch aiz-switch-success mb-0">
                                            <input type="checkbox" name="is_quantity_multiplied" value="1"
                                                @if ($product->is_quantity_multiplied == 1) checked @endif>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            @else
                                <p>
                                    {{ translate('Product wise shipping cost is disable. Shipping cost is configured from here') }}
                                    <a href="{{ route('shipping_configuration.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update']) }}">
                                        <span
                                            class="aiz-side-nav-text">{{ translate('Shipping Configuration') }}</span>
                                    </a>
                                </p>
                            @endif
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
                                <input type="number" name="low_stock_quantity"
                                    value="{{ $product->low_stock_quantity }}" min="0" step="1" class="form-control">
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
                                        <input type="radio" name="stock_visibility_state" value="quantity"
                                            @if ($product->stock_visibility_state == 'quantity') checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label
                                    class="col-md-6 col-from-label">{{ translate('Show Stock With Text Only') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="text"
                                            @if ($product->stock_visibility_state == 'text') checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-6 col-from-label">{{ translate('Hide Stock') }}</label>
                                <div class="col-md-6">
                                    <label class="aiz-switch aiz-switch-success mb-0">
                                        <input type="radio" name="stock_visibility_state" value="hide"
                                            @if ($product->stock_visibility_state == 'hide') checked @endif>
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card" style="display: none">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Cash On Delivery') }}</h5>
                        </div>
                        <div class="card-body">
                            @if (get_setting('cash_payment') == '1')
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-6 col-from-label">{{ translate('Status') }}</label>
                                            <div class="col-md-6">
                                                <label class="aiz-switch aiz-switch-success mb-0">
                                                    <input type="checkbox" name="cash_on_delivery" value="1"
                                                        @if ($product->cash_on_delivery == 1) checked @endif>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>
                                    {{ translate('Cash On Delivery option is disabled. Activate this feature from here') }}
                                    <a href="{{ route('activation.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update']) }}">
                                        <span
                                            class="aiz-side-nav-text">{{ translate('Cash Payment Activation') }}</span>
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Featured') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-from-label">{{ translate('Status') }}</label>
                                        <div class="col-md-6">
                                            <label class="aiz-switch aiz-switch-success mb-0">
                                                <input type="checkbox" name="featured" value="1"
                                                    @if ($product->featured == 1) checked @endif>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
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
                                        <option value="Primary" @if ($product->ps_status == 'Primary') selected @endif>Primary
                                        </option>
                                        <option value="Secondary" @if ($product->ps_status == 'Secondary') selected @endif>
                                            Secondary</option>
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
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-6 col-from-label">{{ translate('Status') }}</label>
                                        <div class="col-md-6">
                                            <label class="aiz-switch aiz-switch-success mb-0">
                                                <input type="checkbox" name="todays_deal" value="1"
                                                    @if ($product->todays_deal == 1) checked @endif>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
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
                                <select class="form-control aiz-selectpicker" name="deal_id" id="video_provider">
                                    <option value="">Choose Flash Title</option>
                                    @foreach ($flash_deals as $flash_deal)
                                        <option value="{{ $flash_deal->id }}"
                                            @if ($product->deal_product && $product->deal_product->deal_id == $flash_deal->id) selected @endif>
                                            {{ $flash_deal->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Discount') }}
                                </label>
                                <input type="number" name="flash_discount"
                                    value="{{ $product->deal_product ? $product->deal_product->discount : '0' }}"
                                    min="0" step="1" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">
                                    {{ translate('Discount Type') }}
                                </label>
                                <select class="form-control aiz-selectpicker" name="flash_discount_type" id="">
                                    <option value="">Choose Discount Type</option>
                                    <option value="amount" @if ($product->deal_product && $product->deal_product->discount_type == 'amount') selected @endif>
                                        {{ translate('Flat') }}
                                    </option>
                                    <option value="percent" @if ($product->deal_product && $product->deal_product->discount_type == 'percent') selected @endif>
                                        {{ translate('Percent') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3 text-right">
                        <button type="submit" name="button"
                            class="btn btn-info">{{ translate('Update Product') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="clear-product" class="modal fade">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Confirmation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p class="mt-1">{{ translate('Are you sure to clear the product brand, model, car cc, car years and car variants') }}?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <form action="{{ route('clear-product') }}" method="POST" style="display: contents;">
                        @csrf
                        <input type="hidden" name="id" value="{{ encrypt($product->id) }}">
                        <button type="submit" class="btn btn-primary mt-2">{{ translate('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            show_hide_shipping_div();
            get_sub_child_categories('{{ $product->sub_child_category_id }}');
        });

        $("[name=shipping_type]").on("change", function() {
            show_hide_shipping_div();
        });

        function show_hide_shipping_div() {
            var shipping_val = $("[name=shipping_type]:checked").val();

            $(".flat_rate_shipping_div").hide();

            if (shipping_val == 'flat_rate') {
                $(".flat_rate_shipping_div").show();
            }
        }

        function delete_row(em) {
            $(em).closest('.form-group').remove();
        }

        AIZ.plugins.tagify();

        $(document).ready(function() {
            $('.remove-files').on('click', function() {
                $(this).parents(".col-md-4").remove();
            });
        });

        function size_subcats_ajax() {
            var cat_id = $('#size_cat_id').val();
            $.ajax({
                url: "{{ url('admin/get-size-sub-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function(res) {
                    $('#sub_cat_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }

        function size_childcats_ajax() {
            var cat_id = $('#sub_cat_id').val();
            $.ajax({
                url: "{{ url('admin/get-size-child-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function(res) {
                    $('#child_cat_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }

        (function($) {
            $(document).ready(function() {
                var category_id = $('#category_id').val();
                if (category_id == 1) {
                    $('.size-card').css('display', 'block');
                    $('.part-size-card').css('display', 'none');
                    $('.service_price').css('display', 'none');
                    $('.tyre_price').css('display', 'block');
                    $('#tyre_brands').css('display', 'flex');
                    $('#part_brands').css('display', 'none');
                    $('#part_types').css('display', 'none');
                } else if (category_id == 4) {
                    $('.service_card').css('display', 'block');
                    $('.size-card').css('display', 'none');
                    $('.part-size-card').css('display', 'none');
                    $('.service_price').css('display', 'block');
                    $('.tyre_price').css('display', 'none');
                    $('#service_brands').css('display', 'flex');
                    $('#part_brands').css('display', 'none');
                    $('#part_types').css('display', 'none');
                } else if (category_id == 5) {
                    $('.service_card').css('display', 'none');
                    $('.size-card').css('display', 'none');
                    $('.part-size-card').css('display', 'none');
                    $('.service_price').css('display', 'block');
                    $('.tyre_price').css('display', 'none');
                    $('#tyre_brands').css('display', 'none');
                    $('#service_brands').css('display', 'none');
                    $('#part_brands').css('display', 'none');
                    $('#part_types').css('display', 'none');
                } else if (category_id == 8) {
                    $('.service_card').css('display', 'none');
                    $('.size-card').css('display', 'none');
                    $('.part-size-card').css('display', 'block');
                    $('.service_price').css('display', 'block');
                    $('.tyre_price').css('display', 'none');
                    $('#tyre_brands').css('display', 'none');
                    $('#service_brands').css('display', 'none');
                    $('#part_brands').css('display', 'flex');
                    $('#part_types').css('display', 'flex');
                }
            });
        })(jQuery);

        function tyreSize() {
            var category_id = $('#category_id').val();
            if (category_id == 1) {
                $('.size-card').css('display', 'block');
                $('.service_card').css('display', 'none');
                $('.service_price').css('display', 'none');
                $('.tyre_price').css('display', 'block');
                $('#service_brands').css('display', 'none');
                $('#tyre_brands').css('display', 'flex');
            } else if (category_id == 4) {
                $('.service_card').css('display', 'block');
                $('.size-card').css('display', 'none');
                $('.service_price').css('display', 'block');
                $('.tyre_price').css('display', 'none');
                $('#tyre_brands').css('display', 'none');
                $('#service_brands').css('display', 'flex');
            } else if (category_id == 5) {
                $('.service_card').css('display', 'none');
                $('.size-card').css('display', 'none');
                $('.service_price').css('display', 'block');
                $('.tyre_price').css('display', 'none');
                $('#tyre_brands').css('display', 'none');
                $('#service_brands').css('display', 'none');
            }
        }

        function featured_subcats_ajax() {
            var cat_id = $('#featured_cat_id').val();
            $.ajax({
                url: "{{ url('admin/get-featured-sub-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function(res) {
                    $('.featured_sub_cat_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }

        function featured_service_subcats_ajax() {
            var cat_id = $('#featureds_cat_id').val();
            $.ajax({
                url: "{{ url('admin/get-featured-sub-cats') }}",
                type: 'get',
                data: {
                    id: cat_id
                },
                success: function(res) {
                    $('.featureds_sub_cat_id').html(res);
                },
                error: function() {
                    alert('failed...');

                }
            });
        }

        function update_label_status_fun(el) {
            if (el.value == 0) {
                $('#update_label_status').val(1)
            } else {
                $('#update_label_status').val(0)
            }
        }

        function update_return_status_fun(el) {
            if (el.value == 0) {
                $('#update_return_status').val(1)
            } else {
                $('#update_return_status').val(0)
            }
        }

        function update_shipping_status_fun(el) {
            if (el.value == 0) {
                $('#update_shipping_status').val(1)
            } else {
                $('#update_shipping_status').val(0)
            }
        }

        function get_sub_child_categories(child_id) {
            $.ajax({
                url: SITE_URL + "/admin/get-sub-child-categories",
                type: 'POST',
                data: {
                    _token: CSRF,
                    id: $('#sub_category_id').val(),
                    child_id: child_id,
                },
                success: function(res) {
                    $('#sub_child_category_id').html(res);
                    $("#sub_child_category_id").selectpicker('refresh');
                },
                error: function() {
                    alert('failed...');
                }
            });
        }
    </script>

@endsection
