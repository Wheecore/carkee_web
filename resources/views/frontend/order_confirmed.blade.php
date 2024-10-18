@extends('frontend.layouts.custom_layout')
@section('content')
    @php
        $tyre_products = [];
        $package_products = [];
        $status = $order->delivery_status;
        $shop = \App\Models\Shop::where('id', $order->seller_id)->first();
        if($order->order_type == 'N'){
            $invoice_download_url = url('api/v2/invoice/download', $order->id);
            $tyre_products = DB::table('order_details')
            ->where('order_details.order_id', $order->id)
            ->where('order_details.type', 'T')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('product_translations.name', 'order_details.quantity', 'order_details.price')
            ->get();
            $package_products = DB::table('order_details')
            ->where('order_details.order_id', $order->id)
            ->where('order_details.type', 'P')
            ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
            ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select('product_translations.name', 'order_details.quantity', 'order_details.price')
            ->get();
        }
        else{
            if($order->order_type == 'CW'){
                $type = 'car_wash';
            }
            else if($order->order_type == 'B'){
                $type = 'battery';
            }
            else if($order->order_type == 'T'){
                $type = 'tyre';
            }
            else{
                $type = 'petrol';
            }
            $invoice_download_url = url('api/v2/emergency-order-invoice/download/'.$order->id.'/'.$type);
        }
    @endphp
    <section class="py-4">
        <div class="container text-left">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="card shadow-sm border-0 rounded card-r">
                        <div class="card-body">
                            <div class="text-center py-4 mb-4">
                                <i class="la la-check-circle la-3x text-success mb-3"></i>
                                <h1 class="h3 mb-3 fw-600">{{ translate('Thank You for Your Order!') }}</h1>
                                <h2 class="h5">{{ translate('Order Code:') }} <span
                                        class="fw-700 text-primary">{{ $order->code }}</span></h2>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-600 mb-3 fs-17 pb-2">{{ translate('Order Summary') }}
                                    <span>
                                        <a class="btn btn-soft-primary btn-icon btn-circle float-right"
                                            href="{{ $invoice_download_url }}"
                                            title="{{ translate('Download Invoice') }}">
                                            <i class="las la-download"></i>
                                        </a>
                                    </span>
                                </h5>
                                <div class="row">
                                    <table class="table">
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Order Code') }}:</td>
                                            <td>{{ $order->code }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Order date') }}:</td>
                                            <td>{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone($order->user_id)) }}</td>
                                        </tr>
                                        @if($order->order_type != 'N' && $order->order_type != 'CW')
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Order Schedule Time') }}:</td>
                                            <td>{{ date(env('DATE_FORMAT').' h:i a', strtotime($order->order_schedule_time)) }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Order status') }}:</td>
                                            <td>{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Total order amount') }}:</td>
                                            <td>{{ single_price($order->grand_total) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Payment method') }}:</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                        </tr>
                                        @if($order->order_type == 'N')
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Workshop Name') }}:</td>
                                                <td> {{ $shop->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Workshop Address') }}:</td>
                                                <td> {{ $shop->address }}</td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Workshop Date') }}:</td>
                                                <td>{{ $order->workshop_date ? date(env('DATE_FORMAT'), strtotime($order->workshop_date)) : '' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="w-50 fw-600">{{ translate('Workshop Time') }}:</td>
                                                <td>{{ $order->workshop_time ? $order->workshop_time : '' }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Car Model') }}:</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $order->model_name ? $order->model_name : '--')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Car Plate') }}:</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $order->car_plate ? $order->car_plate : '--')) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 0px 20px 0px 20px;">
                            @if($order->order_type != 'N')
                             <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="fw-600 mb-3 fs-17 pb-2">{{ translate('Order Details') }}</h5>
                                    <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ translate('Product Name') }}</th>
                                                <th>{{ translate('Unit Price') }}</th>
                                                <th>{{ translate('Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderDetails as $key => $orderDetail)
                                                    <tr>
                                                        <td>
                                                        @if($order->order_type == 'B')	
                                                        @if($order->battery_type == 'N')
                                                        {{ ($orderDetail->batteryProduct != null)?$orderDetail->batteryProduct->name:translate('Battery Unavailable') }}
                                                        @else
                                                        Jumpstart
                                                        @endif
                                                        @elseif($order->order_type == 'T')	
                                                        {{ ($orderDetail->tyreProduct != null)?$orderDetail->tyreProduct->name:translate('Spare Tyre') }}
                                                        @elseif($order->order_type == 'CW')	
                                                        {{ ($orderDetail->carwashProduct != null)?$orderDetail->carwashProduct->name:translate('Car Wash') }}
                                                        @else
                                                        {{ ($orderDetail->petrolProduct != null)?$orderDetail->petrolProduct->name:translate('Petrol') }}
                                                        @endif
                                                        </td>
                                                        <td>{{ single_price($orderDetail->price) }}</td>
                                                        <td>{{ single_price($orderDetail->price+$orderDetail->tax) }}</td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                             </div>
                            @endif
                            @if(count($tyre_products) > 0 && $order->order_type == 'N')
                            <div class="row">
                                <div class="col-md-12">
                                <h5 class="fw-600 mb-3 fs-17 pb-2">{{ translate('Tyre Products') }}</h5>
                                <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th width="30%">{{ translate('Product') }}</th>
                                            <th>{{ translate('Quantity') }}</th>
                                            <th>{{ translate('Price') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tyre_products as $key => $orderDetail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if ($orderDetail->name != null)
                                                        <a href="#" class="text-reset">
                                                            {{ $orderDetail->name }}
                                                        </a>
                                                    @else
                                                        {{ translate('Product Unavailable') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $orderDetail->quantity }}
                                                </td>
                                                <td>{{ single_price($orderDetail->price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                           </div>
                        </div>
                        @endif

                        @if(count($package_products) > 0 && $order->order_type == 'N')
                            <div class="row mt-4">
                                <div class="col-md-12">
                                <h5 class="fw-600 mb-3 fs-17 pb-2">{{ translate('Package Products') }}</h5>
                                <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th width="30%">{{ translate('Product') }}</th>
                                            <th>{{ translate('Quantity') }}</th>
                                            <th>{{ translate('Price') }}</th>
                                            <th>{{ translate('Package') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($package_products as $key => $orderDetail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if ($orderDetail->name != null)
                                                        <a href="#" class="text-reset">
                                                            {{ $orderDetail->name }}
                                                        </a>
                                                    @else
                                                        {{ translate('Product Unavailable') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $orderDetail->quantity }}
                                                </td>
                                                <td>{{ single_price($orderDetail->price) }}</td>
                                                <td>{{ translate('Package') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                           </div>
                        </div>
                        @endif

                        @if($order->is_gift_product_availed)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="fw-600 mb-3 fs-17 pb-2">{{ translate('Discount Gift') }}</h5>
                                <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-left">{{ translate('Discount Title') }}</th>
                                            <th class="text-left">{{ translate('Gift Name') }}</th>
                                            <th class="text-left">{{ translate('Gift Image') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $gift_datas = json_decode($order->gift_product_data); @endphp
                                            <tr>
                                                <td>{{ $gift_datas->discount_title }}</td>
                                                <td>{{ $gift_datas->gift_name }}</td>
                                                <td><img src="{{ uploaded_asset($gift_datas->gift_image) }}" alt="" height="50"></td>
                                            </tr>
                                    </tbody>
                                </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="row">
                                <div class="col-xl-5 col-md-6 ml-auto mr-0">
                                    <table class="table ">
                                        <tbody>
                                            <tr>
                                                <th>{{ translate('Subtotal') }}</th>
                                                <td class="text-right">
                                                    <span class="font-italic">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ translate('Coupon Discount') }}</th>
                                                <td class="text-right">
                                                    <span class="font-italic">{{ single_price($order->coupon_discount) }}</span>
                                                </td>
                                            </tr>
                                            @if($order->is_gift_discount_applied)
                                            @php $gift_discount_data = json_decode($order->gift_discount_data);  @endphp
                                            <tr>
                                                <th>{{ translate('Gift Discount Title') }}</th>
                                                <td class="text-right">
                                                    <span class="font-italic">{{ $gift_discount_data->title }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>{{ translate('Gift Discount') }}</th>
                                                <td class="text-right">
                                                    <span class="font-italic">{{ single_price($gift_discount_data->discount) }}</span>
                                                </td>
                                            </tr>
                                            @endif
                                            @if($order->express_delivery)
                                                <tr>
                                                    <th>{{ translate('Express Delivery') }}</th>
                                                    <td class="text-right">
                                                        <span class="font-italic">{{ single_price($order->express_delivery) }}</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th><span class="fw-600">{{ translate('Total') }}</span></th>
                                                <td class="text-right">
                                                    <strong><span>{{ single_price($order->grand_total) }}</span></strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection
