<div class="card shadow-sm rounded card-r">
    <div class="card-header">
        <h5 class="fs-16 fw-600 mb-0">{{ translate('Order Summary') }}</h5>
        <div class="text-right">
            <span class="badge badge-inline badge-primary">
                {{ count($carts) }}
                {{ translate('Items') }}
            </span>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th class="product-name">{{ translate('Product') }}</th>
                    <th class="product-total text-right">{{ translate('Total') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                    $tax = 0;
                    $shipping = 0;
                    $product_shipping_cost = 0;
                @endphp
                @foreach ($carts as $key => $cartItem)
                    @php
                        $product = \App\Product::find($cartItem['product_id']);
                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $tax += $cartItem['tax'] * $cartItem['quantity'];
                        $product_shipping_cost = $cartItem['shipping_cost'];
                        
                        $shipping += $product_shipping_cost;
                        
                        $product_name_with_choice = $product->getTranslation('name');
                        if ($cartItem['variant'] != null) {
                            $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem['variant'];
                        }
                    @endphp
                    <tr class="cart_item">
                        <td class="product-name fs-14">
                            {{ $product_name_with_choice }}
                            <strong class="product-quantity">
                                × {{ $cartItem['quantity'] }}
                            </strong>
                        </td>
                        <td class="product-total text-right">
                            <span
                                class="pl-4 pr-0 fs-14">{{ single_price($cartItem['price'] * $cartItem['quantity']) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="table">
            <tfoot>
                <tr class="workshop_info">
                    <th>{{ translate('Workshop Name') }}</th>
                    <td class="text-right">
                        <span
                            class="fw-600">{{ \Session::has('shop_name') ? \Session::get('shop_name')->name : '' }}</span>
                    </td>
                </tr>
                <tr class="workshop_info">
                    <th>{{ translate('Workshop Date') }}</th>
                    <td class="text-right">
                        <span class="fw-600">{{ \Session::has('sdate') ? \Session::get('sdate') : '' }}</span>
                    </td>
                </tr>
                <tr class="workshop_info">
                    <th>{{ translate('Workshop Time') }}</th>
                    <td class="text-right">
                        <span class="fw-600">{{ \Session::has('time_slot') ? \Session::get('time_slot') : '' }}</span>
                    </td>
                </tr>
                <tr class="cart-subtotal">
                    <th>{{ translate('Subtotal') }}</th>
                    <td class="text-right">
                        <span class="fw-600">{{ single_price($subtotal) }}</span>
                    </td>
                </tr>
                @if (Session::get('express_delivery'))
                    <tr class="cart-shipping">
                        <th>{{ translate('Express Delivery') }}</th>
                        <td class="text-right">
                            <span class="font-italic">{{ single_price(Session::get('express_delivery')) }}</span>
                        </td>
                    </tr>
                @endif

                @if ($carts->sum('discount') > 0)
                    <tr class="cart-shipping">
                        <th>{{ translate('Coupon Discount') }}</th>
                        <td class="text-right">
                            <span class="font-italic">{{ single_price($carts->sum('discount')) }}</span>
                        </td>
                    </tr>
                @endif
                @php
                    $total = $subtotal + $tax + $shipping;
                    if ($carts->sum('discount') > 0) {
                        $total -= $carts->sum('discount');
                    }
                @endphp
                <tr class="cart-total">
                    <th><span class="strong-600">{{ translate('Total') }}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($total + Session::get('express_delivery')) }}</span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        @if (Auth::check() && get_setting('coupon_system') == 1)
            @if (isset($carts[0]) && $carts[0]['discount'] > 0)
                <div class="mt-3 coupon_section">
                    <form class="" id="remove-coupon-form" action="{{ route('checkout.remove_coupon_code') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="owner_id"
                            value="{{ isset($carts[0]) ? $carts[0]['owner_id'] : '' }}">
                        <div class="input-group">
                            <div class="form-control">{{ isset($carts[0]) ? $carts[0]['coupon_code'] : '' }}</div>
                            <div class="input-group-append">
                                <button type="button" id="coupon-remove"
                                    class="btn btn-primary">{{ translate('Change Coupon') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <style>
                    @media (prefers-reduced-motion:reduce) {
                        .form-control {
                            transition: none;
                        }
                    }

                    @media (prefers-reduced-motion:reduce) {
                        .btn {
                            transition: none;
                        }
                    }

                    @media print {

                        *,
                        ::after,
                        ::before {
                            text-shadow: none !important;
                            box-shadow: none !important;
                        }
                    }
                </style>
                <div class="mt-3 coupon_section"
                    style="-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;">
                    <form class="" id="apply-coupon-form" action="{{ route('checkout.apply_coupon_code') }}"
                        method="POST" enctype="multipart/form-data"
                        style="-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;">
                        @csrf
                        <input type="hidden" name="owner_id"
                            value="{{ isset($carts[0]) ? $carts[0]['owner_id'] : '' }}"
                            style="-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; margin: 0; font-family: inherit; font-size: inherit; line-height: inherit; overflow: visible; -webkit-transition: all 0.3s ease; transition: all 0.3s ease;">
                        <div class="input-group"
                            style="-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; position: relative; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; -ms-flex-align: stretch; align-items: stretch; width: 100%;">
                            <input type="text" class="form-control" name="code"
                                placeholder="{{ translate('Have coupon code? Enter here') }}" required
                                style="-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; margin: 0; font-family: inherit; overflow: visible; -webkit-transition: all 0.3s ease; display: block; font-weight: 400; line-height: 1.5; background-color: #fff; background-clip: padding-box; border-radius: .25rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; padding: 0.6rem 1rem; font-size: 0.875rem; height: calc(1.3125rem + 1.2rem + 2px); border: 1px solid #e2e5ec; color: #898b92; position: relative; -ms-flex: 1 1 auto; flex: 1 1 auto; width: 1%; min-width: 0; margin-bottom: 0; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <div class="input-group-append"
                                style="-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; display: -ms-flexbox; display: flex; margin-left: -1px;">
                                <button type="button" id="coupon-apply" class="btn btn-primary"
                                    style="-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; margin: 0; font-family: inherit; overflow: visible; text-transform: none; -webkit-appearance: button; display: inline-block; text-align: center; vertical-align: middle; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; border: 1px solid transparent; line-height: 1.5; border-radius: .25rem; -webkit-transition: all 0.3s ease; transition: all 0.3s ease; padding: 0.6rem 1.2rem; font-size: 0.875rem; font-weight: inherit; background-color: #f37539; border-color: #f37539; color: var(--white); position: relative; z-index: 2; border-top-left-radius: 0; border-bottom-left-radius: 0;">{{ translate('Apply') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif
    </div>
</div>
