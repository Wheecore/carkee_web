@extends('frontend.layouts.app')
@section('content')
    <style>
        h4 {
            font-weight: 700;
        }

        .coupon_section {
            display: none;
        }

        .workshop_info {
            display: none;
        }
    </style>
    <section class="pt-5" style="background:ghostwhite">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row aiz-steps arrow-divider ">
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('2. Workshop info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('4. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('5. Confirmation') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        $lists = \App\CarList::orderBy('id', 'desc')
            ->where('user_id', Auth::id())
            ->limit(8)
            ->get();
        $brand_s = \App\Models\Brand::where('id', Session::get('session_brand_id'))->first();
        $model_s = \App\CarModel::where('id', Session::get('session_model_id'))->first();
        $detail_s = \App\CarDetail::where('id', Session::get('session_details_id'))->first();
        $year_s = \App\CarYear::where('id', Session::get('session_year_id'))->first();
        $type_s = \App\CarType::where('id', Session::get('session_type_id'))->first();
    @endphp
    <section class="pt-30px" style="background:ghostwhite">
        <div class="container">
            <div class="row pl-3 pr-3">
                <div class="col-md-12 mx-auto">
                    <div class="card rounded card-body mb-auto">
                        <form action="{{ route('checkout.shipping_info') }}" class="navsearchform" method="post"
                            id="carlist_form">
                            @csrf
                            <input type="hidden" name="cart_id" id="cart_id" value="">
                            <input type="hidden" name="category_id" value="{{ $category_id }}">
                            <div class="row">
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label class="label_top"
                                            for=""><b>{{ translate('Select Brand') }}</b></label>
                                        <select class="form-control pq items input-readonly not-full has-options"
                                            name="brand_id" id="brand_id" onchange="models()" required>
                                            <option value="">{{ translate('Select Brand') }}
                                            </option>
                                            @foreach (\App\Models\Brand::all() as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ Session::get('session_brand_id') == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->getTranslation('name') }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label class="label_top" for=""><b>Select Model</b></label>
                                        <select name="model_id" id="model_id"
                                            class="form-control pq items input-readonly not-full has-options"
                                            onchange="details()" required>
                                            <option value="">Select Model</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label class="label_top" for=""><b>Select Year</b></label>
                                        <select name="details_id" id="details_id"
                                            class="form-control pq items input-readonly not-full has-options"
                                            onchange="car_years()">
                                            <option value="">Select Year</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label class="label_top" for=""><b>Select Car CC</b></label>
                                        <select name="year_id" id="year_id"
                                            class="form-control pq items input-readonly not-full has-options"
                                            onchange="types()">
                                            <option value="">Select Car CC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6">
                                    <div class="form-group">
                                        <label class="label_top" for=""><b>Select Variant</b></label>
                                        <select name="type_id" id="type_id"
                                            class="form-control pq items input-readonly not-full has-options">
                                            <option value="">Select Variant</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <p id="psb" style="color: red;display:none;">Brand and model is required.</p>
                        </form>
                        <div class="row" style="margin-left: -7px;">
                            <button class="btn btn-success ml-2" onclick="changeActionUrl()">+
                                Add To My Vehicle</button>
                        </div>

                        <hr style="border-color:#f37539 !important">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pr_list">
                                    <div class="p-3">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <span style="font-weight: 700">Your Vehicle</span>:
                                                <span style="font-weight: 600" id="vehicle_span">
                                                    {{ $brand_s ? $brand_s->name : '' }}{{ $model_s ? ', ' . $model_s->name : '' }}{{ $detail_s ? ', ' . $detail_s->name : '' }}{{ $year_s ? ', ' . $year_s->name : '' }}{{ $type_s ? ', ' . $type_s->name : '' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row" id="" style="padding: 17px 17px 27px 7px;">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            @if (Auth::user())
                                                @if (count($lists) > 0)
                                                    @php $k = 1;  @endphp
                                                    @foreach ($lists as $key => $list)
                                                        <?php
                                                        $category = \App\Category::where('id', $list->category_id)->first();
                                                        $brand = \App\Models\Brand::where('id', $list->brand_id)->first();
                                                        $model = \App\CarModel::where('id', $list->model_id)->first();
                                                        $details = \App\CarDetail::where('id', $list->details_id)->first();
                                                        $year = \App\CarYear::where('id', $list->year_id)->first();
                                                        $type = \App\CarType::where('id', $list->type_id)->first();
                                                        if ($model) {
                                                            $carlist = \App\CarList::where('model_id', $model->id)->first();
                                                        }
                                                        ?>
                                                        <div class="col-md-3 mr-3 mb-3">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="category_id" value="tyre">
                                                                <input type="hidden" name="brand_id"
                                                                    value="{{ $list->brand_id }}"
                                                                    id="brand_{{ $k }}"
                                                                    data-brand_name="{{ $brand ? $brand->name : '' }}">
                                                                <input type="hidden" name="model_id"
                                                                    value="{{ $list->model_id }}"
                                                                    id="model_{{ $k }}"
                                                                    data-model_name="{{ $model ? $model->name : '' }}">
                                                                <input type="hidden" name="details_id"
                                                                    value="{{ $list->details_id }}"
                                                                    id="details_{{ $k }}"
                                                                    data-details_name="{{ $details ? $details->name : '' }}">
                                                                <input type="hidden" name="year_id"
                                                                    value="{{ $list->year_id }}"
                                                                    id="year_{{ $k }}"
                                                                    data-year_name="{{ $year ? $year->name : '' }}">
                                                                <input type="hidden" name="type_id"
                                                                    value="{{ $list->type_id }}"
                                                                    id="type_{{ $k }}"
                                                                    data-type_name="{{ $type ? $type->name : '' }}">
                                                                <button style="border: 2px solid;" type="button"
                                                                    class="btn btn-default list_btn"
                                                                    onclick="makeActive(this,{{ $k }})">
                                                                    {{ $brand ? $brand->name : '' }}
                                                                    , {{ $model ? $model->name : '' }}
                                                                    @if (isset($list->car_plate))
                                                                        , {{ $list->car_plate }}
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </div>
                                                        @php $k++;  @endphp
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4" id="cart-summary" style="background:ghostwhite">
        <div class="container">
            @if ($cartss && count($cartss) > 0)
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="p-3 text-left">
                            <div class="mb-4">
                                @php
                                    $total = 0;
                                    $cat_type = Session::get('cat_type');
                                @endphp
                                <div class="card card-r rounded">
                                    <div class="card-header">
                                        <h5>Tyre Items</h5>
                                        <form action="{{ route('remove.all') }}" method="post">
                                            @csrf
                                            <?php
                                            $chktyre = 0;
                                            ?>
                                            @foreach ($cartss as $key => $cartItem)
                                                @php
                                                    $product = \App\Product::find($cartItem['product_id']);
                                                    \DB::table('old_batteries')
                                                        ->where('product_id', $cartItem['product_id'])
                                                        ->where('user_id', Auth::id())
                                                        ->update([
                                                            'old_battery_status' => 0,
                                                        ]);
                                                    
                                                    $category = \App\Category::find($product->category_id);
                                                    $total = $total + $cartItem['price'] * $cartItem['quantity'] + $cartItem['tax'];
                                                    $product_name_with_choice = $product->getTranslation('name');
                                                    if ($cartItem['variation'] != null) {
                                                        $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem['variation'];
                                                    }
                                                    $tyre = 0;
                                                @endphp
                                                @if ($category->name == 'Tyre')
                                                    <?php
                                                    $chktyre = 1;
                                                    ?>
                                                    <input type="hidden" name="products[]"
                                                        value="{{ $cartItem['product_id'] }}">
                                                @endif
                                            @endforeach
                                            @if ($chktyre == 1)
                                                <button type="submit" class="btn btn-primary">Remove All</button>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Image</th>
                                                        <th>{{ translate('Product') }}</th>
                                                        <th>{{ translate('Price') }}</th>
                                                        <th>{{ translate('Quantity') }}</th>
                                                        <th>Total</th>
                                                        <th>{{ translate('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $j = 1;  @endphp
                                                    @foreach ($cartss as $key => $cartItem)
                                                        @php
                                                            $product = \App\Product::find($cartItem['product_id']);
                                                            \DB::table('old_batteries')
                                                                ->where('product_id', $cartItem['product_id'])
                                                                ->where('user_id', Auth::id())
                                                                ->update([
                                                                    'old_battery_status' => 0,
                                                                ]);
                                                            
                                                            $category = \App\Category::find($product->category_id);
                                                            $product_name_with_choice = $product->getTranslation('name');
                                                            if ($cartItem['variation'] != null) {
                                                                $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem['variation'];
                                                            }
                                                            $tyre = 0;
                                                        @endphp
                                                        @if ($category->name == 'Tyre')
                                                            <tr>
                                                                <td class="tyre_item_radio">
                                                                    <input type="radio" name="product_radio"
                                                                        value="{{ $cartItem['id'] }}" class="cart_check"
                                                                        id="cart_{{ $cartItem['id'] }}"
                                                                        @if (Session::get('tyre_product_id') == $cartItem['product_id']) checked @elseif($j == 1) checked @endif
                                                                        onclick="saveValue(this)" required>
                                                                    <label for="cart_{{ $cartItem['id'] }}"></label>
                                                                </td>
                                                                <td>
                                                                    @if ($product->thumbnail_img)
                                                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                            class="img-fit size-60px rounded"
                                                                            alt="{{ $product->getTranslation('name') }}">
                                                                    @else
                                                                        <img src="{{ static_asset('assets/img/tyre.png') }}"
                                                                            class="img-fit size-60px rounded"
                                                                            alt="{{ $product->getTranslation('name') }}">
                                                                    @endif
                                                                </td>
                                                                <td><span
                                                                        class="fs-14 opacity-60">{{ $product_name_with_choice }}</span>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <span
                                                                            class="fw-600 fs-16">{{ single_price($cartItem['price']) }}</span>
                                                                    </div>
                                                                </td>
                                                                <td style="white-space:nowrap">
                                                                        <div
                                                                            class="no-gutters align-items-center aiz-plus-minus">
                                                                            <button
                                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                                type="button" data-type="minus"
                                                                                data-field="quantity[{{ $cartItem['id'] }}]">
                                                                                <i class="las la-minus"></i>
                                                                            </button>
                                                                            <input type="number"
                                                                                name="quantity[{{ $cartItem['id'] }}]"
                                                                                class="border-0 text-center flex-grow-1 fs-16 input-number"
                                                                                placeholder="1"
                                                                                value="{{ $cartItem['quantity'] }}"
                                                                                min="1" max="10"
                                                                                onchange="updateQuantity({{ $cartItem['id'] }}, this)"
                                                                                style="width: 22px;">
                                                                            <button
                                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                                type="button" data-type="plus"
                                                                                data-field="quantity[{{ $cartItem['id'] }}]">
                                                                                <i class="las la-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-lg">
                                                                        <span
                                                                            class="fw-600 fs-16 text-primary">{{ single_price(($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity']) }}</span>
                                                                    </div>
                                                                </td>
                                                                @if ($product->ps_status != 'Primary')
                                                                    <td>
                                                                        <a href="javascript:void(0)"
                                                                            onclick="removeFromCartView(event, {{ $cartItem['id'] }})"
                                                                            class="btn btn-icon btn-sm btn-soft-primary btn-circle">
                                                                            <i class="las la-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            @php $j++; @endphp
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-r rounded">
                                    <div class="card-header">
                                        <h5>Services Items</h5>
                                        <form action="{{ route('remove.all') }}" method="post">
                                            @csrf
                                            <?php
                                            $chkother = 0;
                                            ?>
                                            @foreach ($cartss as $key => $cartItem)
                                                @php
                                                    $product = \App\Product::find($cartItem['product_id']);
                                                    $category = \App\Category::find($product->category_id);
                                                    $tyre = 0;
                                                @endphp
                                                @if ($category->name == 'Services')
                                                    <?php
                                                    $chkother = 1;
                                                    ?>
                                                    <input type="hidden" name="products[]"
                                                        value="{{ $cartItem['product_id'] }}">
                                                @endif
                                            @endforeach
                                            @if ($chkother == 1)
                                                <button type="submit" class="btn btn-primary">Remove All</button>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>{{ translate('Product') }}</th>
                                                        <th>{{ translate('Price') }}</th>
                                                        <th>{{ translate('Quantity') }}</th>
                                                        <th>Total</th>
                                                        <th>{{ translate('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($cartss as $key => $cartItem)
                                                        @php
                                                            $product = \App\Product::find($cartItem['product_id']);
                                                            $category = \App\Category::find($product->category_id);
                                                            $product_name_with_choice = $product->getTranslation('name');
                                                            $tyre = 0;
                                                        @endphp
                                                        @if ($category->name == 'Services')
                                                            <tr>
                                                                <td>
                                                                    @if ($product->thumbnail_img)
                                                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                            class="img-fit size-60px rounded"
                                                                            alt="{{ $product->getTranslation('name') }}">
                                                                    @else
                                                                        <img src="{{ static_asset('assets/img/repairing-service.png') }}"
                                                                            class="img-fit size-60px rounded"
                                                                            alt="{{ $product->getTranslation('name') }}">
                                                                    @endif
                                                                </td>
                                                                <td><span
                                                                        class="fs-14 opacity-60">{{ $product_name_with_choice }}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="fw-600 fs-16">{{ single_price($cartItem['price']) }}</span>
                                                                </td>
                                                                <td style="white-space:nowrap">
                                                                        <div
                                                                            class="no-gutters align-items-center aiz-plus-minus">
                                                                            <button
                                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                                type="button" data-type="minus"
                                                                                data-field="quantity[{{ $cartItem['id'] }}]">
                                                                                <i class="las la-minus"></i>
                                                                            </button>
                                                                            <input type="number"
                                                                                name="quantity[{{ $cartItem['id'] }}]"
                                                                                class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                                                                placeholder="1"
                                                                                value="{{ $cartItem['quantity'] }}"
                                                                                min="1" max="10"
                                                                                onchange="updateQuantity({{ $cartItem['id'] }}, this)"
                                                                                style="width:22px;">
                                                                            <button
                                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                                type="button" data-type="plus"
                                                                                data-field="quantity[{{ $cartItem['id'] }}]">
                                                                                <i class="las la-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="fw-600 fs-16 text-primary">{{ single_price(($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity']) }}</span>
                                                                </td>
                                                                <td>
                                                                    @if (isset($product->ps_status) && $product->ps_status != 'Primary')
                                                                        <a href="javascript:void(0)"
                                                                            onclick="removeFromCartView(event, {{ $cartItem['id'] }})"
                                                                            class="btn btn-icon btn-sm btn-soft-primary btn-circle">
                                                                            <i class="las la-trash"></i>
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mx-auto">
                        <div class="p-3 text-left" style="background:ghostwhite">
                            <div class="mb-4">
                                <div id="cart_summary_div">
                                    @include('frontend.partials.cart_summary')
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                                        <a href="{{ route('home') }}" class="btn btn-link" style="margin-left: -11px;">
                                            <i class="las la-arrow-left"></i>
                                            {{ translate('Return to shop') }}
                                        </a>
                                    </div>
                                    <div class="col-md-6 text-center text-md-right">
                                        @if (Auth::check())
                                            <a href="javascript:void(0)" class="btn btn-primary fw-600" id="workshop_btn"
                                                style="margin-left: -20px;">
                                                {{ translate('Proceed Workshop') }}
                                            </a>
                                        @else
                                            <button class="btn btn-primary fw-600" onclick="showCheckoutModal()"
                                                style="margin-left: -20px;">{{ translate('Proceed Workshop') }}</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-xl-8 mx-auto">
                        <div class="shadow-sm bg-white p-4 rounded">
                            <div class="text-center p-3">
                                <i class="las la-frown la-3x opacity-60 mb-3"></i>
                                <h3 class="h4 fw-700">{{ translate('Your Cart is empty') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection

@section('modal')
    <div class="modal fade" id="GuestCheckout">
        <div class="modal-dialog modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email"
                                    class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg"
                                    placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}"
                                        class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit"
                                    class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>

                    </div>
                    <div class="text-center mb-3">
                        <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                        <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                    </div>
                    @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1)
                        <div class="separator mb-3">
                            <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                        </div>
                        <ul class="list-inline social colored text-center mb-3">
                            @if (get_setting('facebook_login') == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                            @endif
                            @if (get_setting('google_login') == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                        <i class="lab la-google"></i>
                                    </a>
                                </li>
                            @endif
                            @if (get_setting('twitter_login') == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }

        function updateQuantity(key, element) {
            var checked_val = $(".cart_check:checked ").val();
            $.post('{{ route('cart.updateQuantity') }}', {
                _token: '{{ csrf_token() }}',
                id: key,
                quantity: element.value,
                checked_id: checked_val
            }, function(data) {
                updateNavCart();
                $('#cart-summary').html(data);
            });
        }

        function showCheckoutModal() {
            $('#GuestCheckout').modal();
        }

        $(document).ready(function() {
            $("#cart_id").val($(".tyre_item_radio input[type='radio']:checked").val());
        });

        function saveValue(el) {
            $("#cart_id").val($(el).val());
            $.ajax({
                url: "{{ url('update-cart-summary') }}",
                type: 'get',
                data: {
                    cart_id: $(el).val()
                },
                success: function(res) {
                    $('#cart_summary_div').html(res);
                }
            });
        }
        $("#workshop_btn").click(function() {
            var brand_id = $('#brand_id').val();
            var model_id = $('#model_id').val();
            if (brand_id != '' && model_id != '') {
                $("#psb").hide();
                $("#carlist_form").submit();
            } else {
                $("#psb").show();
            }
        });

        $(document).ready(function() {
            var brand_id = $('#brand_id').val();
            if (brand_id != '') {
                $.ajax({
                    url: "{{ url('get-ca-models') }}",
                    type: 'get',
                    data: {
                        id: brand_id
                    },
                    success: function(res) {
                        $('#model_id').html(res);
                        var save_model = '{{ Session::get('session_model_id') }}';
                        $('#model_id').val(save_model);
                        var model_id = $('#model_id').val();
                        det(model_id);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }
        });

        function det(model_id) {
            if (model_id != '') {
                $.ajax({
                    url: "{{ url('get-ca-details') }}",
                    type: 'get',
                    data: {
                        id: model_id
                    },
                    success: function(res) {
                        $('#details_id').html(res);
                        var save_details = '{{ Session::get('session_details_id') }}';
                        $('#details_id').val(save_details);
                        var details_id = $('#details_id').val();
                        yea(details_id);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }
        }

        function yea(details_id) {
            if (details_id != '') {
                $.ajax({
                    url: "{{ url('get-ca-years') }}",
                    type: 'get',
                    data: {
                        id: details_id
                    },
                    success: function(res) {
                        $('#year_id').html(res);
                        var save_year = '{{ Session::get('session_year_id') }}';
                        $('#year_id').val(save_year);
                        var year_id = $('#year_id').val();
                        typ(year_id);
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }
        }

        function typ(year_id) {
            if (year_id != '') {
                $.ajax({
                    url: "{{ url('get-ca-types') }}",
                    type: 'get',
                    data: {
                        id: year_id
                    },
                    success: function(res) {
                        $('#type_id').html(res);
                        var save_type = '{{ Session::get('session_type_id') }}';
                        $('#type_id').val(save_type);
                    }
                });
            }
        }

        function makeActive(el, s_no) {
            $(".list_btn").css("background", "#fff");
            $(el).css("background", "#dbf8f9");
            $('#brand_id').val($("#brand_" + s_no).val());
            $.ajax({
                url: "{{ url('get-ca-models') }}",
                type: 'get',
                data: {
                    id: $("#brand_" + s_no).val()
                },
                success: function(res) {
                    $('#model_id').html(res);
                    $('#model_id').val($("#model_" + s_no).val());
                },
                error: function() {
                    alert('failed...');
                }
            });

            if ($("#model_" + s_no).val() != '') {
                $.ajax({
                    url: "{{ url('get-ca-details') }}",
                    type: 'get',
                    data: {
                        id: $("#model_" + s_no).val()
                    },
                    success: function(res) {
                        $('#details_id').html(res);
                        $('#details_id').val($("#details_" + s_no).val());
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            if ($("#details_" + s_no).val() != '') {
                $.ajax({
                    url: "{{ url('get-ca-years') }}",
                    type: 'get',
                    data: {
                        id: $("#details_" + s_no).val()
                    },
                    success: function(res) {
                        $('#year_id').html(res);
                        $('#year_id').val($("#year_" + s_no).val());
                    },
                    error: function() {
                        alert('failed...');

                    }
                });
            }

            if ($("#year_" + s_no).val() != '') {
                $.ajax({
                    url: "{{ url('get-ca-types') }}",
                    type: 'get',
                    data: {
                        id: $("#year_" + s_no).val()
                    },
                    success: function(res) {
                        $('#type_id').html(res);
                        $('#type_id').val($("#type_" + s_no).val());
                    }
                });
            }
            var vehicle_string = $("#brand_" + s_no).attr("data-brand_name");
            if ($("#model_" + s_no).attr("data-model_name") != '') {
                vehicle_string += ', ' + $("#model_" + s_no).attr("data-model_name");
            }
            if ($("#details_" + s_no).attr("data-details_name") != '') {
                vehicle_string += ', ' + $("#details_" + s_no).attr("data-details_name");
            }
            if ($("#year_" + s_no).attr("data-year_name") != '') {
                vehicle_string += ', ' + $("#year_" + s_no).attr("data-year_name");
            }
            if ($("#type_" + s_no).attr("data-type_name") != '') {
                vehicle_string += ', ' + $("#type_" + s_no).attr("data-type_name");
            }
            $("#vehicle_span").html(vehicle_string);

        }
    </script>
@endsection
