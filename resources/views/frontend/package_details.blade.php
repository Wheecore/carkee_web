@extends('frontend.layouts.app')

@section('content')

    <style>
        .card-title {
            font-size: 16px;
            font-family: Verdana;
        }
    </style>
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
                                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">
                                    {{ $package->getTranslation('name') }}</span>

                            </h3>
                        </div>

                        <div class="wrapper center-block">

                        </div>
                    </div>
                    <hr>

                    <div class="panel-body">

                        <h6><b>Recommended Products
                                <span style="float: right;"><a href="{{ url('cart/packageToCart', $package->id) }}"
                                        class="btn btn-soft-primary mr-2 fw-600">
                                        <i class="las la-shopping-bag"></i>
                                        <span class="d-none d-md-inline-block"> {{ translate('Add to cart') }}</span>
                                    </a></span></b></h6>
                        <hr class="mt-5">
                        {{-- //// --}}


                        <div class="row">


                            @if ($rproducts != null)
                                @foreach ($rproducts as $key => $item)
                                    @if ($item != 'on')
                                        <?php
                                        $product = DB::table('products')
                                            ->where('id', $item)
                                            ->first();
                                        $stock = DB::table('product_stocks')
                                            ->where('product_id', $item)
                                            ->first();
                                        
                                        $group_products = DB::table('product_groups')
                                            ->whereJsonContains('product_id', $item)
                                            ->first();
                                        if ($group_products) {
                                            $json_groups = json_decode($group_products->product_id);
                                        }
                                        ?>



                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                <img class="" style="height: 122px;width: 170px;"
                                                    src="{{ uploaded_asset($product->thumbnail_img) }}" alt=""
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </a>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <div class="clearfix mb-3">
                                                <span class="float-end"><a href="#"><a
                                                            href="{{ route('product', $product->slug) }}"
                                                            class="d-block text-reset">
                                                            {{ $product->name }}
                                                        </a></a></span>
                                            </div>
                                            <h5 class="card-title">{!! Str::limit($product->description, 190) !!}</h5>

                                            @if ($group_products)
                                                <div class="row" style="border: 2px solid #EC2303;padding: 20px;">
                                                    @foreach ($json_groups as $group_id)
                                                        <?php
                                                        $g_product = DB::table('products')
                                                            ->where('id', $group_id)
                                                            ->first();
                                                        $g_stock = DB::table('product_stocks')
                                                            ->where('product_id', $group_id)
                                                            ->first();
                                                        ?>
                                                        @if ($item != $g_product->id && !in_array($g_product->id, $rproducts))
                                                            <form action="" method="get" id="sort_ggroup">
                                                                <input type="hidden" value="{{ $product->id }}"
                                                                    name="old_id">
                                                                <input type="hidden" value="{{ $g_product->id }}"
                                                                    name="new_id">

                                                                <div class="col-2">
                                                                    <button href="javascript:void(0)"
                                                                        onclick="callGroupFunc()" class="d-block">
                                                                        <img class=""
                                                                            style="height: 40px;width: 60px;"
                                                                            src="{{ uploaded_asset($g_product->thumbnail_img) }}"
                                                                            alt=""
                                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                    </button>
                                                                    <small class="d-grid gap-2 mt-3 my-4"
                                                                        style="color: #E62E04">{{ single_price($g_product->unit_price) }}</small>
                                                                </div>
                                                                {{-- <input type="submit" value="" id="mysubmit"> --}}
                                                            </form>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <b class="d-grid gap-2 mt-3 my-4"
                                                style="color: #E62E04">{{ single_price($product->unit_price) }}</b>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    @endif
                                @endforeach
                            @else
                                <div class="text-center p-3">
                                    <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                    <h3 class="h6 fw-700">Recommended Products is empty</h3>
                                </div>
                            @endif
                        </div>
                        <hr>
                        <h6><b class="">Addon Products
                            </b></h6>
                        <hr>
                        <div class="row">
                            @if ($aproducts != null)
                                @foreach ($aproducts as $key => $item)
                                    @if ($item != 'on')
                                        <?php
                                        $product = DB::table('products')
                                            ->where('id', $item)
                                            ->first();
                                        $stock = DB::table('product_stocks')
                                            ->where('product_id', $item)
                                            ->first();
                                        
                                        $agroup_products = DB::table('product_groups')
                                            ->whereJsonContains('product_id', $item)
                                            ->first();
                                        if ($agroup_products) {
                                            $ajson_groups = json_decode($agroup_products->product_id);
                                            if (isset($json_groups)) {
                                                $ajson_groups = array_diff($ajson_groups, $json_groups);
                                            }
                                        }
                                        ?>



                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                <img class="" style="height: 122px;width: 170px;"
                                                    src="{{ uploaded_asset($product->thumbnail_img) }}" alt=""
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                            </a>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                            <div class="clearfix mb-3">
                                                <span class="float-end"><a href="#"><a
                                                            href="{{ route('product', $product->slug) }}"
                                                            class="d-block text-reset">
                                                            {{ $product->name }}
                                                        </a></a></span>
                                            </div>
                                            <h5 class="card-title">{!! Str::limit($product->description, 190) !!}</h5>

                                            @if (isset($ajson_groups) && count($ajson_groups) > 0)
                                                <div class="row" style="border: 2px solid #EC2303;padding: 20px;">
                                                    @foreach ($ajson_groups as $group_id)
                                                        <?php
                                                        $g_product = DB::table('products')
                                                            ->where('id', $group_id)
                                                            ->first();
                                                        $g_stock = DB::table('product_stocks')
                                                            ->where('product_id', $group_id)
                                                            ->first();
                                                        ?>
                                                        @if (isset($rproducts))
                                                            @if ($item != $g_product->id && !in_array($g_product->id, $rproducts))
                                                                <form action="" method="get" id="sort_ggroup">
                                                                    <input type="hidden" value="{{ $product->id }}"
                                                                        name="old_id">
                                                                    <input type="hidden" value="{{ $g_product->id }}"
                                                                        name="new_id">

                                                                    <div class="col-2">
                                                                        <button href="javascript:void(0)"
                                                                            onclick="callGroupFunc()" class="d-block">
                                                                            <img class=""
                                                                                style="height: 40px;width: 60px;"
                                                                                src="{{ uploaded_asset($g_product->thumbnail_img) }}"
                                                                                alt=""
                                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                        </button>
                                                                        <small class="d-grid gap-2 mt-3 my-4"
                                                                            style="color: #E62E04">{{ single_price($g_product->unit_price) }}</small>
                                                                    </div>
                                                                    {{-- <input type="submit" value="" id="mysubmit"> --}}
                                                                </form>
                                                            @endif
                                                        @else
                                                            <form action="" method="get" id="sort_ggroup">
                                                                <input type="hidden" value="{{ $product->id }}"
                                                                    name="old_id">
                                                                <input type="hidden" value="{{ $g_product->id }}"
                                                                    name="new_id">

                                                                <div class="col-2">
                                                                    <button href="javascript:void(0)"
                                                                        onclick="callGroupFunc()" class="d-block">
                                                                        <img class=""
                                                                            style="height: 40px;width: 60px;"
                                                                            src="{{ uploaded_asset($g_product->thumbnail_img) }}"
                                                                            alt=""
                                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                    </button>
                                                                    <small class="d-grid gap-2 mt-3 my-4"
                                                                        style="color: #E62E04">{{ single_price($g_product->unit_price) }}</small>
                                                                </div>
                                                                {{-- <input type="submit" value="" id="mysubmit"> --}}
                                                            </form>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            @endif

                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                            <b class="d-grid gap-2 mt-3 my-4"
                                                style="color: #E62E04">{{ single_price($product->unit_price) }}</b>
                                        </div>

                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    @endif
                                @endforeach
                            @else
                                <div class="text-center p-3">
                                    <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                    <p class="h6 fw-700">Addon Products is empty</p>
                                </div>
                                {{-- <p class="card-title ml-3">No Addon Products found!</p> --}}
                            @endif
                            {{-- ///// --}}
                        </div>
                    </div>




                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        function sort_mileges(el) {
            $('#sort_mileges').submit();
        }
    </script>

    <script>
        function callGroupFunc() {
            $('#sort_group').submit();
        }
    </script>
@endsection
