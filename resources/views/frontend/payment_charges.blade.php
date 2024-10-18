@extends('frontend.layouts.app')

@section('content')
    <section class="pt-5" style="background:ghostwhite">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row aiz-steps arrow-divider">
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col done">
                            <div class="text-center text-success">
                                <i class="la-3x mb-2 las la-map"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('2. Workshop info') }}</h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center text-primary">
                                <i class="la-3x mb-2 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('3. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('4. Confirmation') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4 p-30px" style="background:ghostwhite">
        <div class="container text-left">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card rounded card-r">
                        <div class="card-header p-3">
                            <h3 class="fs-16 fw-600 mb-0">
                                {{ translate('Select a payment option') }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.checkout.charges') }}" class="form-default" role="form"
                                method="POST" id="checkout-form">
                                @csrf
                                <input type="hidden" value="{{ $product->id }}" name="product_id" id="product_id">
                                <input type="hidden" value="{{ $product->user_id }}" name="owner_id" id="owner_id">
                                <input type="hidden" value="{{ Auth::id() }}" name="user_id" id="user_id">
                                <input type="hidden" value="20" name="price" id="price">
                                <div class="row">
                                    <div class="col-xxl-8 col-xl-10 mx-auto">
                                        <div class="row gutters-10">
                                            @if (get_setting('paypal_payment') == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="paypal" class="online_payment" type="radio"
                                                            name="payment_option" checked>
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/cards/paypal.png') }}"
                                                                class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span
                                                                    class="d-block fw-600 fs-15">{{ translate('Paypal') }}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif

                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="ipay88" class="online_payment" type="radio"
                                                        name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/ipay88.png') }}"
                                                            class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span
                                                                class="d-block fw-600 fs-15">{{ translate('Ipay') }}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="stripe" class="online_payment" type="radio"
                                                        name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/stripe.png') }}"
                                                            class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span
                                                                class="d-block fw-600 fs-15">{{ translate('Stripe') }}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-3">
                                    <input type="checkbox" class="aiz-square-check" required id="agree_checkbox">
                                    <label class="aiz-checkbox" for="agree_checkbox">
                                        <span style="margin-left: -19px;">{{ translate('I agree to the') }}</span>
                                    </label>
                                    <a href="{{ route('terms') }}">{{ translate('terms and conditions') }}</a>,
                                    <a href="{{ route('returnpolicy') }}">{{ translate('return policy') }}</a> &
                                    <a href="{{ route('privacypolicy') }}">{{ translate('privacy policy') }}</a>
                                </div>
                                <div class="row align-items-center pt-3">
                                    <div class="col-6">
                                        <a href="{{ route('dashboard') }}" class="link link--style-3">
                                            <i class="las la-arrow-left"></i>
                                            {{ translate('Return to dashboard') }}
                                        </a>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" onclick="submitOrder(this)"
                                            class="btn btn-primary fw-600">{{ translate('Complete Order') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mx-auto">

                    <div class="card shadow-sm rounded card-r">
                        <div class="card-header">
                            <h3 class="fs-16 fw-600 mb-0">{{ translate('Summary') }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-name">{{ translate('Product') }}</th>
                                        <th class="product-total text-right">{{ translate('Charges') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @php
                                        $product = \App\Product::find($product->id);
                                    @endphp
                                    <tr>
                                        <td> Reschedule fee </td>
                                        <td> {{ single_price(20) }} </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table">

                                <tfoot>
                                    {{-- <tr class="cart-subtotal"> --}}
                                    {{-- <th>{{translate('Subtotal')}}</th> --}}
                                    {{-- <td class="text-right"> --}}
                                    {{-- <span class="fw-600">{{ single_price($subtotal) }}</span> --}}
                                    {{-- </td> --}}
                                    {{-- </tr> --}}

                                    <tr class="cart-total">
                                        <th><span class="strong-600">{{ translate('Total') }}</span></th>
                                        <td class="text-right">
                                            <strong><span> {{ single_price(20) }} </span></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".online_payment").click(function() {
                $('#manual_payment_description').parent().addClass('d-none');
            });
            toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
        });

        function use_wallet() {
            $('input[name=payment_option]').val('wallet');
            if ($('#agree_checkbox').is(":checked")) {
                $('#checkout-form').submit();
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
            }
        }

        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                $('#checkout-form').submit();
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id) {
            if (typeof id != 'undefined') {
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_' + id).html());
            }
        }

        $(document).on("click", "#coupon-apply", function() {
            var data = new FormData($('#apply-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.apply_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    AIZ.plugins.notify(data.response_message.response, data.response_message.message);
                    console.log(data.response_message);
                    $("#cart_summary").html(data.html);
                }
            })
        });

        $(document).on("click", "#coupon-remove", function() {
            var data = new FormData($('#remove-coupon-form')[0]);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ route('checkout.remove_coupon_code') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $("#cart_summary").html(data);
                }
            })
        })
    </script>
@endsection
