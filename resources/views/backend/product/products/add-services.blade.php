@extends('backend.layouts.app')
@section('title', translate('Add New Product'))
@section('css')

    <link rel="stylesheet" href="{{ static_asset('assets/css/datatables.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/dt-global_style.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/product.css') }}">
    <style>
        .add-new-product .nav-pills .nav-item {width: 33%;border: 1px solid #d7d7d7;border-radius: 5px;}
        .add-new-product .nav-pills .nav-link {color: #333;background-color: #ffffff;}
        .add-new-product .nav-pills .nav-link.active {color: #fff;background-color: #141423;}
        .add-new-product .nav-link {display: block;padding: 1rem 1rem;}
        .spinner-border {width: 1rem;height: 1rem;margin-left: 10px;}
        .btn-top-bottom-action {position: fixed;right: 4%;bottom: 10%;top: auto;z-index: 999;}
    </style>

@endsection
@section('content')

    <div class="row gutters-5">
        <div class="col-lg-9 mx-auto">
            <form class="form form-horizontal mar-top" action="{{ route('add-services.store') }}" method="POST" enctype="multipart/form-data" id="services-products-form">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{ translate('Product Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group" id="brand">
                                    <label class="col-from-label">{{ translate('Car Brand') }}</label>
                                    <select class="form-control" name="brand_id" id="brand_id" onchange="pmodels()"
                                        required>
                                        <option value="">{{ translate('Select Brand') }}</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                                {{ $brand->getTranslation('name') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="">
                                    <label class="col-from-label">{{ translate('Car Model') }}</label>
                                    <select name="model_id" id="model_id" class="form-control" onchange="pyears()"
                                        required></select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group" id="">
                                    <label class="col-from-label">{{ translate('Car Years') }}</label>
                                    <select name="year_id" id="year_id" class="form-control"
                                        onchange="car_variants()"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="">
                                    <label class="col-from-label">{{ translate('Car Variant') }}</label>
                                    <select name="variant_id" id="variant_id" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-sm btn-info btn-filter-mileages mb-3">{{ translate('Filter Mileages') }}</button>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label class="col-from-label">{{ translate('Mileage') }}</label>
                                    <span class="text-danger"> *</span>
                                    <select id="mileages" name="mileages[]" class="form-control mileage" multiple>
                                        @php
                                            $mileage = 0;
                                        @endphp
                                        @while ($mileage <= 200000)
                                            <option value="{{ $mileage }}">{{ $mileage }}</option>
                                            @php
                                                $mileage = $mileage + 5000;
                                            @endphp
                                        @endwhile
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button type="button" class="btn btn-sm btn-info btn-generate-expiry-months mb-3">{{ translate('Generate Expiry Months') }}</button>
                                </div>
                                <table class="table d-none" id="expiry-months">
                                    <thead>
                                        <th>{{ translate('Mileage') }}</th>
                                        <th>{{ translate('Expiry Month') }}</th>
                                    </thead>
                                </table>
                                <tbody></tbody>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row add-new-product">
                    <div class="col-md-12">
                        <input type="hidden" id="added_services" name="added_services">
                        <div class="row text-right">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-info btn-service-filter" onclick="get_all_services()">
                                        {{ translate('Filter Products') }}
                                        <div class="spinner-border d-none" role="status"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Service Information') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="service-details">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-from-label">{{ translate('Sub Category') }}</label>
                                                <select class="form-control aiz-selectpicker" name="sub_category_id" id="sub_category_id" onchange="get_sub_child_categories()" required>
                                                    <option value="">--{{ translate('Select') }}--</option>
                                                    @foreach ($subcategories as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-from-label">{{ translate('Sub Child Category') }}</label>
                                                <select class="form-control aiz-selectpicker" name="sub_child_category_id" id="sub_child_category_id" required></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group d-inline-block mr-3">
                                                <label class="aiz-radio">
                                                    <input type="radio" name="group_type" value="R" checked>
                                                    <span class="aiz-square-check"></span>
                                                    {{ translate('Recommended') }}
                                                </label>
                                            </div>
                                            <div class="form-group d-inline-block mr-3">
                                                <label class="aiz-radio">
                                                    <input type="radio" name="group_type" value="A">
                                                    <span class="aiz-square-check"></span>
                                                    {{ translate('Addon') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-3">
                                    <div class="input-group col-md-5 ml-auto">
                                        <input class="form-control py-2 search-input" type="search" placeholder="Write here" data-tbl="tbl-services">
                                        <span class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button">
                                            <i class="las la-search la-1x"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tbl-services">
                                        <thead>
                                            <th width="5%">
                                                <div class="aiz-checkbox-inline">
                                                    <label class="aiz-checkbox mb-3">
                                                        <input type="checkbox" class="check-all"
                                                            data-check="service">
                                                        <span class="aiz-square-check"></span>
                                                    </label>
                                                </div>
                                            </th>
                                            <th>{{ translate('Name') }}</th>
                                            <th>{{ translate('Quantity') }}</th>
                                            <th></th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-save">
                                {{ translate('Save') }}
                                <div class="spinner-border d-none" role="status"></div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="btn-top-bottom-action">
        <button class="btn btn-dark" type="button" id="btn-to-bottom"><i class="la la-angle-double-down la-1x"></i></button>
        <button class="btn btn-info d-none" type="button" id="btn-to-top"><i class="la la-angle-double-up la-1x"></i></button>
    </div>

@endsection
@section('script')

    <script src="{{ static_asset('assets/js/product.js') }}"></script>
    <script src="{{ static_asset('assets/js/datatables.js') }}"></script>
    <script>
        var request_brand_id = "{{ session()->get('request_brand_id') }}";
        if (request_brand_id) {
            $('#brand_id option[value="' + request_brand_id + '"]').prop('selected', true);
        }
        var request_model_id = "{{ session()->get('request_model_id') }}";
        if (request_model_id) {
            pmodels(request_model_id);
            var request_year_id = "{{ session()->get('request_year_id') }}";
            var request_variant_id = "{{ session()->get('request_variant_id') }}";
        }
        $(document).on("click", "#btn-to-top",function(){
            var percentageToScroll = 100;
            var percentage = percentageToScroll/100;
            var height = $(document).scrollTop();
            var scrollAmount = height * (1 - percentage);
            $('html,body').animate({ scrollTop: scrollAmount }, 'slow', function () {
                $("#btn-to-top").addClass("d-none");
                $("#btn-to-bottom").removeClass("d-none");
            });
        });
        $(document).on("click", "#btn-to-bottom",function() {
            var percentageToScroll = 100;
            var height = $(document).innerHeight();
            var scrollAmount = height * percentageToScroll/ 100;
            var overheight = jQuery(document).height() - jQuery(window).height();
            jQuery("html, body").animate({scrollTop: scrollAmount}, 900, function () {
                $("#btn-to-top").removeClass("d-none");
                $("#btn-to-bottom").addClass("d-none");
            });    
        });
    </script>
    <script src="{{ static_asset('assets/js/new-flow-product.js') }}"></script>

@endsection
