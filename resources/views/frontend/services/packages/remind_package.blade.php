@extends('frontend.layouts.app')

@section('content')
    {{--{{ route('package.show', ['id'=>$package->id, 'lang'=>env('DEFAULT_LANGUAGE')]) }}--}}
    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                </div>
                <div class="col-lg-6">

                </div>
            </div>
        </div>
    </section>
    <div id="section_featured">
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="row">

                        <div class="col-md-3 col-sm-12">
                            <h3 class="h5 fw-700 mb-0">
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">Re-Purchase Now</span>
                            </h3></div>

                        {{--<div class="offset-md-6 col-md-3 col-sm-12">--}}
                            {{--<form class="" id="sort_mileges" action="" method="GET">--}}
                                {{--<input type="hidden" name="category_id" value="{{ $cat_name }}">--}}
                                {{--<h3 class="h5 fw-700 ml-5">--}}

                                    {{--<select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" id="package_id" name="package_id" onchange="sort_mileges()">--}}
                                        {{--<option value="">{{ translate('Mileages') }}</option>--}}
                                        {{--<option value="All">{{ translate('All') }}</option>--}}
                                        {{--@foreach (\App\Package::all() as $key => $package)--}}
                                            {{--<option value="{{ $package->id }}">{{ $package->mileage }}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}

                                {{--</h3>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    </div>







                    {{--////--}}

                    <style>
                        /*.wrapper{*/
                        /*width:70%;*/
                        /*}*/
                        @media(max-width:992px){
                            .wrapper{
                                width:100%;
                            }
                        }
                        .panel-heading {
                            padding: 0;
                            border:0;
                        }
                        .panel-title>a, .panel-title>a:active{
                            display:block;
                            padding:15px;
                            color:#555;
                            font-size:16px;
                            font-weight:bold;
                            text-transform:uppercase;
                            letter-spacing:1px;
                            word-spacing:3px;
                            text-decoration:none;
                        }
                        .panel-heading  a:before {
                            font-family: 'Glyphicons Halflings';
                            content: "\e114";
                            float: right;
                            transition: all 0.5s;
                        }
                        .panel-heading.active a:before {
                            -webkit-transform: rotate(180deg);
                            -moz-transform: rotate(180deg);
                            transform: rotate(180deg);
                        }
                    </style>

                    <style>

                        input[type="checkbox"]{ width: 19px; height: 19px; vertical-align: -2px;  }

                        input:checked {  /* input[type="checkbox"]:checked  only makes checkboxes big -- Confirm\tested */
                            height: 25px;
                            width: 25px;
                        }

                        #info { background-color: hsl(0, 0%, 92%);
                            padding: 8px 15px;
                            box-shadow: 0 0 1px hsl(0, 0%, 61%);
                            margin: 5px 0 10px -10px;
                            color: black; font: 17px Calibri;
                            width: 90%;
                        } </style>

                    <style>

                        .tools {
                            overflow: auto;
                            zoom: 1;
                        }
                        .search-area {
                            float: left;
                            width: 60%;
                        }
                        .settings {
                            display: none;
                            float: right;
                            width: 40%;
                            text-align: right;
                        }
                        #view {
                            display: none;
                            width: auto;
                            height: 47px;
                        }
                        #searchbutton {
                            width: 60px;
                            height: 47px;
                        }
                        @media screen and (max-width:400px) {
                            .search-area {
                                width: 100%;
                            }
                        }

                        .products {
                            width: 100%;
                            /*font-family: Raleway;*/
                        }
                        .product {
                            display: inline-block;
                            width: calc(24% - 13px);
                            margin: 10px 10px 30px 10px;
                            vertical-align: top;
                        }
                        .product img {
                            display: block;
                            margin: 0 auto;
                            width: auto;
                            height: 200px;
                            max-width: calc(100% - 20px);
                            background-cover: fit;
                            box-shadow: 0px 0px 7px 0px rgba(0,0,0,0.8);
                            border-radius: 2px;
                        }
                        .product-content {
                            text-align: center;
                        }
                        .product h3 {
                            font-size: 20px;
                            font-weight: 600;
                            margin: 10px 0 0 0;
                        }
                        .product h3 small {
                            display: block;
                            font-size: 16px;
                            font-weight: 400;
                            /*font-style: italic;*/
                            margin: 7px 0 0 0;
                        }
                        .product .product-text {
                            margin: 7px 0 0 0;
                            color: #777;
                        }
                        .product .price {
                            /*font-family: sans-serif;*/
                            font-size: 16px;
                            font-weight: 700;
                        }
                        .product .genre {
                            font-size: 14px;
                        }


                        @media screen and (max-width:1150px) {
                            .product {
                                width: calc(33% - 23px);
                            }
                        }
                        @media screen and (max-width:700px) {
                            .product {
                                width: calc(50% - 43px);
                            }
                        }
                        @media screen and (max-width:400px) {
                            .product {
                                width: 100%;
                            }
                        }

                        /* TABLE VIEW */
                        @media screen and (min-width:401px) {
                            .settings {
                                display: block;
                            }
                            #view {
                                display: inline;
                            }
                            .products-table .product {
                                display: block;
                                width: auto;
                                margin: 10px 10px 30px 10px;
                            }
                            .products-table .product .product-img {
                                display: inline-block;
                                margin: 0;
                                width: 120px;
                                height: 120px;
                                /*vertical-align: middle;*/
                            }
                            .products-table .product img {
                                width: auto;
                                height: 120px;
                                max-width: 120px;
                            }
                            .products-table .product-content {
                                text-align: left;
                                display: inline-block;
                                margin-left: 20px;
                                vertical-align: middle;
                                width: calc(100% - 145px);
                            }
                            .products-table .product h3 {
                                margin: 0;
                            }
                        }
                        .product img{
                            box-shadow: 0px 0px 0px 0px rgb(0 0 0 / 80%); !important;
                        }
                        h6{
                            color:#FB5531;
                        }
                        h4{
                            color:#FB5531;
                        }
                    </style>

                    {{--/////--}}

                    <style>
                        .btn-circle.btn-xl {
                            width: 35px;
                            height: 35px;
                            padding: 10px 16px;
                            border-radius: 35px;
                            font-size: 24px;
                            line-height: 1.33;
                        }

                        .btn-circle {
                            width: 30px;
                            height: 30px;
                            padding: 6px 0px;
                            border-radius: 15px;
                            text-align: center;
                            font-size: 12px;
                            line-height: 1.42857;
                        }

                    </style>

                    {{--////--}}



                            <?php
                            $package = App\Package::where('id', $package->id)->first();
                            $aproducts=[];
                            $ppr = App\PackageProduct::where('package_id', $package->id)->where('type', 'Recommended')->first();
                            $ppa = App\PackageProduct::where('package_id', $package->id)->where('type', 'Addon')->first();
                            //
                            $rproducts = json_decode(!empty($ppr->products)?$ppr->products:'', TRUE);
                            if ($ppa) {
                                $aproducts = json_decode($ppa->products, TRUE);
                            }
                            ?>

                            <div class="wrapper center-block">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="" role="tab" id="headingOne">
                                            <h4 class="panel-title">

                                                <a role="button" class="collapse_action" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$package->id}}" aria-expanded="true" aria-controls="collapseOne" onclick="chkfunc('{{$package->id}}')">
                                                    <div id="check_container_div">

                                                        <b>
                                                            <button type="button" class="btn btn-circle btn-xl" id="btn-circle{{ $package->id }}" style="border: 1px solid"><i class="fa fa-heart"></i>
                                                            </button>
                                                            {{--<input type="checkbox"  value="val_1"  id="ch_obx_1"  myattr="mt1"  class="c1">--}}
                                                            {{ $package->getTranslation('name') }}
                                                        </b>

                                                    </div>
                                                </a>
                                            </h4>
                                        </div> <hr>
                                        <div id="collapseOne{{$package->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">

                                                <h6><b>Recommended Products
                                                        <span style="float: right;"><a href="{{ url('cart/packageToCart',$package->id) }}" class="btn btn-soft-primary mr-2 fw-600">
                                            <i class="las la-shopping-bag"></i>
                                            <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
                                        </a></span></b></h6>
                                                <hr class="mt-5">
                                                {{--////--}}
                                                @if($rproducts != null)
                                                    @foreach($rproducts as $key=>$item)
                                                        @if ($item != "on")
                                                            <?php
                                                            //                                      $prod_id = $product;

                                                            $product = DB::table('products')->where('id', $item)->first();
                                                            //                                    dd($product->slug);
                                                            $stock = DB::table('product_stocks')->where('product_id', $item)->first(); ?>
                                                            <div class="products products-table">
                                                                <div class="product">
                                                                    <div class="product-img">
                                                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                                            <img
                                                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                    alt=""
                                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                            >
                                                                        </a>
                                                                    </div>
                                                                    <div class="product-content">
                                                                        <p>
                                                                            {!! Str::limit($product->description, 200) !!}
                                                                        </p>
                                                                        <p class="product-text price">RM {{ $stock->price }}</p>
                                                                        <p class="product-text genre"><a href="{{ route('product', $product->slug) }}" class="d-block text-reset">
                                                                                {{ $product->name }}
                                                                            </a></p>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <hr>
                                                        @endif
                                                    @endforeach

                                                @else
                                                    {{--<p class="card-title ml-3">No Recommended Products found!</p>--}}
                                                    <div class="text-center p-3">
                                                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                                        <h3 class="h6 fw-700">Recommended Products is empty</h3>
                                                    </div>
                                                @endif

                                                <h6><b>Addon Products
                                                    </b></h6>
                                                <hr>
                                                @if($rproducts != null)
                                                    @foreach($rproducts as $key=>$item)
                                                        @if ($item != "on")
                                                            <?php
                                                            $product = DB::table('products')->where('id', $item)->first();
                                                            $stock = DB::table('product_stocks')->where('product_id', $item)->first(); ?>
                                                            <div class="products products-table">
                                                                <div class="product">
                                                                    <div class="product-img">
                                                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                                            <img
                                                                                    class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                                    alt=""
                                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                            >
                                                                        </a>
                                                                    </div>
                                                                    <div class="product-content">
                                                                        <p>
                                                                            {!! Str::limit($product->description, 200) !!}
                                                                        </p>
                                                                        <p class="product-text price">RM {{ $stock->price }}</p>
                                                                        <p class="product-text genre"><a href="{{ route('product', $product->slug) }}" class="d-block text-reset">
                                                                                {{ $product->name }}
                                                                            </a></p>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <hr>
                                                        @endif
                                                    @endforeach

                                                @else
                                                    <div class="text-center p-3">
                                                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                                        <p class="h6 fw-700">Addon Products is empty</p>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
    <script>
        function sort_mileges(el){
            $('#sort_mileges').submit();
        }
    </script>
@endsection
