<div class="container">
    @if( $cartss && count($cartss) > 0 )
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
                                             \DB::table('old_batteries')->where('product_id', $cartItem['product_id'])->where('user_id', Auth::id())->update([
                                                'old_battery_status' => 0
                                            ]);

                                            $category = \App\Models\Category::find($product->category_id);
                                            $total = $total + ($cartItem['price'] * $cartItem['quantity']) + $cartItem['tax'];
                                            $product_name_with_choice = $product->getTranslation('name');
                                            if ($cartItem['variation'] != null) {
                                                $product_name_with_choice = $product->getTranslation('name').' - '.$cartItem['variation'];
                                            }
                                            $tyre = 0;
                                        @endphp
                                        @if($category->name == 'Tyre')
                                            <?php
                                            $chktyre = 1;
                                            ?>
                                            <input type="hidden" name="products[]" value="{{ $cartItem['product_id'] }}">
                                        @endif
                                    @endforeach
                                    @if($chktyre == 1)
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
                                            <th>{{ translate('Product')}}</th>
                                            <th>{{ translate('Price')}}</th>
                                            <th>{{ translate('Quantity')}}</th>
                                            <th>Total</th>
                                            <th>{{ translate('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $j = 1;  @endphp
                                        @foreach ($cartss as $key => $cartItem)
                                            @php
                                                $product = \App\Product::find($cartItem['product_id']);
                                                 \DB::table('old_batteries')->where('product_id', $cartItem['product_id'])->where('user_id', Auth::id())->update([
                                                    'old_battery_status' => 0
                                                ]);

                                               $category = \App\Models\Category::find($product->category_id);
                                               $product_name_with_choice = $product->getTranslation('name');
                                                if ($cartItem['variation'] != null) {
                                                    $product_name_with_choice = $product->getTranslation('name').' - '.$cartItem['variation'];
                                                }
                                                $tyre = 0;
                                            @endphp
                                            @if($category->name == 'Tyre')
                                                <tr>
                                                    <td class="tyre_item_radio">
                                                    <input type="radio" name="product_radio" value="{{$cartItem['id']}}" class="cart_check" id="cart_{{$cartItem['id']}}" @if(Session::get('tyre_product_id') == $cartItem['product_id']) checked @elseif($j == 1) checked @endif onclick="saveValue(this)" required>
                                                    <label for="cart_{{$cartItem['id']}}"></label>
                                                </td>
                                                    <td>
                                                        @if($product->thumbnail_img)
                                                            <img
                                                                src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                class="img-fit size-60px rounded"
                                                                alt="{{  $product->getTranslation('name')  }}"
                                                            >
                                                        @else
                                                            <img
                                                                src="{{ static_asset('assets/img/tyre.png') }}"
                                                                class="img-fit size-60px rounded"
                                                                alt="{{  $product->getTranslation('name')  }}"
                                                            >
                                                        @endif
                                                    </td>
                                                    <td><span class="fs-14 opacity-60">{{ $product_name_with_choice }}</span></td>
                                                    <td>
                                                        <div>
                                                            <span class="fw-600 fs-16">{{ single_price($cartItem['price']) }}</span>
                                                        </div>
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                            <div class="no-gutters align-items-center aiz-plus-minus">
                                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                                    <i class="las la-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity[{{ $cartItem['id'] }}]" class="border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="10" onchange="updateQuantity({{ $cartItem['id'] }}, this)" style="width: 22px;">
                                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                                    <i class="las la-plus"></i>
                                                                </button>
                                                            </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-lg">
                                                            <span class="fw-600 fs-16 text-primary">{{ single_price(($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity']) }}</span>
                                                        </div>
                                                    </td>
                                                    @if($product->ps_status != 'Primary')
                                                        <td>
                                                            <a href="javascript:void(0)" onclick="removeFromCartView(event, {{ $cartItem['id'] }})" class="btn btn-icon btn-sm btn-soft-primary btn-circle">
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
                                            $category = \App\Models\Category::find($product->category_id);
                                            $tyre = 0;
                                        @endphp
                                        @if($category->name == 'Services')
                                            <?php
                                            $chkother = 1;
                                            ?>
                                            <input type="hidden" name="products[]" value="{{ $cartItem['product_id'] }}">
                                        @endif
                                    @endforeach
                                    @if($chkother == 1)
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
                                            <th>{{ translate('Product')}}</th>
                                            <th>{{ translate('Price')}}</th>
                                            <th>{{ translate('Quantity')}}</th>
                                            <th>Total</th>
                                            <th>{{ translate('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($cartss as $key => $cartItem)
                                            @php
                                                $product = \App\Product::find($cartItem['product_id']);
                                                $category = \App\Models\Category::find($product->category_id);
                                                $product_name_with_choice = $product->getTranslation('name');
                                                $tyre = 0;
                                            @endphp
                                            @if($category->name == 'Services')
                                                <tr>
                                                    <td>
                                                        @if($product->thumbnail_img)
                                                            <img
                                                                src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                class="img-fit size-60px rounded"
                                                                alt="{{  $product->getTranslation('name')  }}"
                                                            >
                                                        @else
                                                            <img
                                                                src="{{ static_asset('assets/img/repairing-service.png') }}"
                                                                class="img-fit size-60px rounded"
                                                                alt="{{  $product->getTranslation('name')  }}"
                                                            >
                                                        @endif
                                                    </td>
                                                    <td><span class="fs-14 opacity-60">{{ $product_name_with_choice }}</span></td>
                                                    <td>
                                                        <span class="fw-600 fs-16">{{ single_price($cartItem['price']) }}</span>
                                                    </td>
                                                    <td style="white-space:nowrap">
                                                            <div class="no-gutters align-items-center aiz-plus-minus">
                                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                                    <i class="las la-minus"></i>
                                                                </button>
                                                                <input type="number" name="quantity[{{ $cartItem['id'] }}]" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="10" onchange="updateQuantity({{ $cartItem['id'] }}, this)" style="width:22px;">
                                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                                    <i class="las la-plus"></i>
                                                                </button>
                                                            </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-600 fs-16 text-primary">{{ single_price(($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity']) }}</span>
                                                    </td>
                                                    <td>
                                                        @if(isset($product->ps_status) && $product->ps_status != 'Primary')
                                                            <a href="javascript:void(0)" onclick="removeFromCartView(event, {{ $cartItem['id'] }})" class="btn btn-icon btn-sm btn-soft-primary btn-circle">
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
                <div class="shadow-sm p-3 rounded text-left card-r" style="background:ghostwhite">
                    <div class="mb-4">
                        <div id="cart_summary_div">
                        @include('frontend.partials.cart_summary')
                        </div>
                        {{--                                    <div class="card card-r">--}}
                        {{--                                        <div class="card-header">--}}
                        {{--                                            <h5>Order Summary</h5>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="card-body">--}}
                        {{--                                            <div class="px-3 py-2 mb-4 border-top d-flex justify-content-between">--}}
                        {{--                                                <span class="opacity-60 fs-15">{{translate('Subtotal')}}</span>--}}
                        {{--                                                <span class="fw-600 fs-17">{{ single_price($total) }}</span>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                            <a href="{{ route('home') }}" class="btn btn-link">
                                <i class="las la-arrow-left"></i>
                                {{ translate('Return to shop')}}
                            </a>
                        </div>
                        <div class="col-md-6 text-center text-md-right">
                            @if(Auth::check())
                                <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary fw-600">
                                    {{ translate('Proceed Workshop')}}
                                </a>
                            @else
                                <button class="btn btn-primary fw-600" onclick="showCheckoutModal()">{{ translate('Proceed Workshop')}}</button>
                            @endif
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
                        <h3 class="h4 fw-700">{{translate('Your Cart is empty')}}</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<script type="text/javascript">
    AIZ.extra.plusMinus();
</script>
