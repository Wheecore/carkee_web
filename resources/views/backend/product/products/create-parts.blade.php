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
            <form class="form form-horizontal mar-top" action="{{ route('add-parts-carwash-store.store') }}"
                method="POST" enctype="multipart/form-data" id="services-products-form">
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
                    </div>
                </div>
                <div class="row add-new-product">
                    <div class="col-md-12">
                        <ul class="nav nav-pills mb-3 d-block text-center" id="pills-tab" role="tablist">
                            <li class="nav-item d-inline-block" role="presentation">
                                <a class="nav-link active" id="pills-parts-tab" data-toggle="pill" href="#pills-parts"
                                    role="tab" aria-controls="pills-parts" aria-selected="true">
                                    {{ translate('Parts') }}
                                </a>
                            </li>
                            <li class="nav-item d-inline-block" role="presentation">
                                <a class="nav-link" id="pills-carwash-tab" data-toggle="pill" href="#pills-carwash"
                                    role="tab" aria-controls="pills-carwash" aria-selected="false">
                                    {{ translate('Car Wash') }}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-parts" role="tabpanel" aria-labelledby="pills-parts-tab">
                                <input type="hidden" id="added_parts" name="added_parts">
                                <div class="row text-right">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-md btn-info btn-parts-filter"
                                                onclick="get_all_parts_carwash('Parts')">
                                                {{ translate('Filter Parts Products') }}
                                                <div class="spinner-border d-none" role="status"></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 h6">{{ translate('Parts Information') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="name">
                                                            {{ translate('Featured Main Category') }}
                                                        </label>
                                                        <select class="form-control aiz-selectpicker"
                                                            name="parts_feature_categories" id="parts_feature_categories"
                                                            onchange="featured_subcats_ajax()">
                                                            <option value="">--Select--</option>
                                                            @foreach ($parts_feature_categories as $data)
                                                                <option value="{{ $data->id }}">
                                                                    {{ $data->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3 parts_featured_sub_cat_id">
                                                        <label for="name">
                                                            {{ translate('Featured Sub Category') }}
                                                        </label>
                                                        <select class="form-control aiz-selectpicker"
                                                            name="parts_featured_sub_cat_id" id="parts_featured_sub_cat_id">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="input-group col-md-5 ml-auto">
                                                <input class="form-control py-2 search-input" type="search" placeholder="Write here" data-tbl="tbl-parts">
                                                <span class="input-group-append">
                                                  <button class="btn btn-outline-secondary" type="button">
                                                    <i class="las la-search la-1x"></i>
                                                  </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tbl-parts">
                                                <thead>
                                                    <th width="5%">
                                                        <div class="aiz-checkbox-inline">
                                                            <label class="aiz-checkbox mb-3">
                                                                <input type="checkbox" class="check-all"
                                                                    data-check="parts">
                                                                <span class="aiz-square-check"></span>
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th>{{ translate('Name') }}</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-carwash" role="tabpanel" aria-labelledby="pills-carwash-tab">
                                <input type="hidden" id="added_carwash" name="added_carwash">
                                <div class="row text-right">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-md btn-info btn-carwash-filter"
                                                onclick="get_all_parts_carwash('Car Wash')">
                                                {{ translate('Filter Car Wash Products') }}
                                                <div class="spinner-border d-none" role="status"></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 h6">{{ translate('Car Wash Information') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="row">
                                                                 <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="name">
                                                            {{ translate('Featured Main Category') }}
                                                        </label>
                                                        <select class="form-control aiz-selectpicker"
                                                            name="carwash_featured_cat_id" id="carwash_featured_cat_id"
                                                            onchange="featured_subcats_ajax()">
                                                            <option value="">--Select--</option>
                                                            @foreach ($carwash_feature_categories as $data)
                                                                <option value="{{ $data->id }}">
                                                                    {{ $data->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3 carwash_sub_child_category_id">
                                                        <label for="name">
                                                            {{ translate('Featured Sub Category') }}
                                                        </label>
                                                        <select class="form-control aiz-selectpicker"
                                                            name="carwash_sub_child_category_id" id="carwash_sub_child_category_id">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mb-3">
                                            <div class="input-group col-md-5 ml-auto">
                                                <input class="form-control py-2 search-input" type="search" placeholder="Write here" data-tbl="tbl-carwash">
                                                <span class="input-group-append">
                                                  <button class="btn btn-outline-secondary" type="button">
                                                    <i class="las la-search la-1x"></i>
                                                  </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tbl-carwash">
                                                <thead>
                                                    <th width="5%">
                                                        <div class="aiz-checkbox-inline">
                                                            <label class="aiz-checkbox mb-3">
                                                                <input type="checkbox" class="check-all"
                                                                    data-check="carwash">
                                                                <span class="aiz-square-check"></span>
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th>{{ translate('Name') }}</th>
                                                    <th>{{ translate('Model') }}</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
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
