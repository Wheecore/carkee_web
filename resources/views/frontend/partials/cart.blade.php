@php
    $total = 0;
    $user_id = Auth::user()->id;
    $cart = \App\Models\Cart::where('user_id', $user_id)->get();
@endphp
<p>
<i class="fa-solid fa-cart-shopping"></i>
<span class="flex-grow-1">
        @if(isset($cart) && count((is_countable($cart)?$cart:[])) > 0)
        <span style="background-color: #92370d; color: white; padding: 0px 3px 2px 3px;position: relative;
                top: -13px;
                left: -5px;
                font-size: 10px;font-weight: bold;">
                {{ count($cart)}}
            </span>
    @else
        <span style="background-color: #92370d; color: white; padding: 0px 3px 2px 3px;position: relative;
                top: -13px;
                left: -5px;
                font-size: 10px;font-weight: bold;">0</span>
    @endif
    </span>
</p>
<div class="dropdown-menu dropdown-menu-right p-0 stop-propagation ml-auto">
    @if(isset($cart) && count((is_countable($cart)?$cart:[])) > 0)
        <div class="p-3 fs-15 fw-600 p-3 border-bottom">
            {{translate('Cart Items')}}
        </div>
        <ul class="h-250px overflow-auto c-scrollbar-light list-group list-group-flush">
            @foreach($cart as $key => $cartItem)
                @php
                    $product = \App\Product::find($cartItem['product_id']);
                    $total = $total + $cartItem['price'] * $cartItem['quantity'];
                @endphp
                @if ($product != null)
                    <li class="list-group-item">
                        <span class="d-flex align-items-center">
                            <a href="{{ route('product', $product->slug) }}" class="text-reset d-flex align-items-center flex-grow-1">
                                <img
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                    class="img-fit lazyload size-60px rounded"
                                    alt="{{  $product->getTranslation('name')  }}"
                                >
                                <span class="minw-0 pl-2 flex-grow-1">
                                    <span class="fw-600 mb-1 text-truncate-2">
                                            {{  $product->getTranslation('name')  }}
                                    </span>
                                    <span class="">{{ $cartItem['quantity'] }}x</span>
                                    <span class="">{{ single_price($cartItem['price']) }}</span>
                                </span>
                            </a>
                            @if($product->ps_status != 'Primary')
                                <span class="">
                                <button onclick="removeFromCart({{ $cartItem['id'] }})" class="btn btn-sm btn-icon stop-propagation">
                                    <i class="la la-close"></i>
                                </button>
                            </span>
                            @endif
                        </span>
                    </li>
                @endif
            @endforeach
        </ul>
        <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between">
            <span class="opacity-60">{{translate('Subtotal')}}</span>
            <span class="fw-600">{{ single_price($total) }}</span>
        </div>
        <div class="px-3 py-2 text-center border-top">
            <ul class="list-inline mb-0">
                <li class="list-inline-item">
                    <a href="{{ route('cart') }}" class="btn btn-primary btn-sm">
                        {{translate('View cart')}}
                    </a>
                </li>
                @if (Auth::check())
                    <li class="list-inline-item">
                        <a href="{{ route('cart') }}" class="btn btn-primary btn-sm">
                            {{translate('Checkout')}}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    @else
        <div class="text-center p-3">
            <i class="las la-frown la-3x opacity-60 mb-3"></i>
            <h3 class="h6 fw-700">{{translate('Your Cart is empty')}}</h3>
        </div>
    @endif

</div>
<a href="javascript:void(0)" class="text-reset" data-toggle="dropdown" data-display="static">
    <p>Cart</p>
    <p><strong>{{ single_price($total) }}</strong></p>
</a>
