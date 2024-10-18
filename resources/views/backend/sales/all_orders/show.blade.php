@extends('backend.layouts.app')
@section('title', translate('Order Details'))
@section('content')

    @php
        $delivery_status = $order->delivery_status;
        $payment_status = $order->payment_status;
    @endphp
    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
            <a class="btn btn-primary" href="{{ url()->previous() }}"><i class="las la-arrow-left mr-1"></i>Back</a>
        </div>
        <div class="card-body">
            <div class="row gutters-5">
                <div class="col-md-3">
                    <div id="elem">
                        {!! QrCode::size(216)->generate($order->id) !!}
                    </div>
                    <div class="mt-3">
                        <div class="form-group d-inline-flex">
                            <button class="btn btn-success" type="button" onclick="PrintElem('elem')">Print</button>
                        </div>
                        <div class="form-group d-inline-flex" style="float: right">
                            <form class="form-horizontal" action="{{ route('qrcode.download', ['type' => 'png']) }}"
                                method="post">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                @csrf
                                <button type="submit" class="align-middle btn btn-outline-primary">
                                    <i class="fas fa-fw fa-download"></i>
                                    Download
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 ml-auto">
                    <div class="form-group">
                        <label for="delivery_type">{{ translate('Delivery Type') }}</label>
                        <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                            id="delivery_type">
                            <option value="">{{ translate('Select') }}</option>
                            <option value="self delivery" {{ $order->delivery_type == 'self delivery' ? 'selected' : '' }}>
                                {{ translate('Self delivery') }}</option>
                            <option value="delivery company"
                                {{ $order->delivery_type == 'delivery company' ? 'selected' : '' }}>
                                {{ translate('Delivery company') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 ml-auto">
                    <div class="form-group">
                        <label for="update_delivery_status">{{ translate('Delivery Status') }}</label>
                        @if (
                            $delivery_status != 'delivered' &&
                                $delivery_status != 'cancelled' &&
                                $delivery_status != 'Done' && 
                                $delivery_status != 'completed')
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                                id="update_delivery_status">
                                @if ($delivery_status == 'Rejected')
                                    <option value="" @if ($delivery_status == 'Rejected') selected @endif disabled>
                                        {{ translate('Rejected') }}</option>
                                @endif
                                <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                                    {{ translate('Pending') }}</option>
                                <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>
                                    {{ translate('Picked Up') }}</option>
                                <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>
                                    {{ translate('On The Way') }}</option>
                                <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>
                                    {{ translate('Delivered') }}</option>
                                <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                    {{ translate('Cancel') }}</option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ $delivery_status }}" readonly>
                        @endif
                    </div>
                </div>
            </div>
            @if ($delivery_status == 'Rejected' && $order->reason)
                <div class="row gutters-5">
                    <div class="col-md-7 ml-auto mb-4">
                        <label for="">{{ translate('Rejection Reason') }}</label>
                        <textarea class="form-control">{{ $order->reason }}</textarea>
                    </div>
                </div>
            @endif
            <div class="row gutters-5">
                <div class="col text-center text-md-left">
                    @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                        <br>
                        <strong class="text-main">{{ translate('Payment Information') }}</strong><br>
                        {{ translate('Name') }}: {{ json_decode($order->manual_payment_data)->name }},
                        {{ translate('Amount') }}: {{ single_price(json_decode($order->manual_payment_data)->amount) }},
                        {{ translate('TRX ID') }}: {{ json_decode($order->manual_payment_data)->trx_id }}
                        <br>
                        <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank">
                            <img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt=""
                                height="100">
                        </a>
                    @endif
                </div>
                <div class="col-md-4 ml-auto">
                    <table>
                        <tbody>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                <td class="text-right text-info text-bold"> {{ $order->code }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Status') }}</td>
                                @php
                                    $status = $order->delivery_status;
                                @endphp
                                <td class="text-right">
                                    @if ($status == 'delivered')
                                        <span
                                            class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @else
                                        <span
                                            class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Date') }}</td>
                                <td class="text-right">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
                            </tr>
                            @if ($order->reassign_date)
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Reassign Date') }}</td>
                                    <td class="text-right">{{ convert_datetime_to_local_timezone($order->reassign_date, user_timezone(Auth::id())) }}</td>
                                </tr>
                            @endif
                            @if ($order->old_workshop_id)
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Old Workshop Name') }}</td>
                                    @php
                                        $old_shop = \DB::table('shops')
                                            ->where('id', $order->old_workshop_id)
                                            ->select('name')
                                            ->first();
                                        $old_shop_reassign_data = $order->reassign_data?json_decode($order->reassign_data, true):[];
                                        $old_shop_app_date = '';
                                        $old_shop_app_time = '';
                                        if(!empty($old_shop_reassign_data)){
                                            $old_shop_app_date = date(env('DATE_FORMAT'), strtotime($old_shop_reassign_data['old_workshop_date']));
                                            $old_shop_app_time = $old_shop_reassign_data['old_workshop_time'];
                                        }
                                    @endphp
                                    <td class="text-right">{{ $old_shop && $old_shop->name ? $old_shop->name : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Old Workshop Appointment Date') }}</td>
                                    <td class="text-right">{{ $old_shop_app_date }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Old Workshop Appointment Time') }}</td>
                                    <td class="text-right">{{ $old_shop_app_time }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-main text-bold">{{ translate('Workshop Name') }}</td>
                                <td class="text-right">{{ $shop && $shop->name ? $shop->name : '' }}</td>
                            </tr>
                            @if ($order->old_workshop_date)
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Old Appointment Date') }}</td>
                                    <td class="text-right">{{ date(env('DATE_FORMAT'), strtotime($order->old_workshop_date)) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Old Appointment Time') }}</td>
                                    <td class="text-right">{{ date(env('DATE_FORMAT'), strtotime($order->old_workshop_time)) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-main text-bold">{{ translate('Appointment Date') }}</td>
                                <td class="text-right">{{ date(env('DATE_FORMAT'), strtotime($order->workshop_date)) }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Appointment Time') }}</td>
                                <td class="text-right">{{ date('h:i A', strtotime($order->workshop_time)) }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">
                                    {{ translate('Total amount') }}
                                </td>
                                <td class="text-right">
                                    {{ single_price($order->grand_total) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Payment method') }}</td>
                                <td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    @if ($tyre_products)
                    <h6>Tyre Products</h6>
                        <table class="table table-bordered aiz-table invoice-summary">
                            <thead>
                                <tr class="bg-trans-dark">
                                    <th class="min-col">#</th>
                                    <th width="10%">{{ translate('Photo') }}</th>
                                    <th>{{ translate('Description') }}</th>
                                    <th class="min-col text-center">{{ translate('Qty') }}</th>
                                    <th class="min-col text-center">{{ translate('Price') }}</th>
                                    <th class="min-col text-center">{{ translate('Total') }}</th>
                                    <th class="min-col text-center">{{ translate('Workshop Status') }}</th>
                                    <th class="min-col text-center">{{ translate('Received By') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tyre_products as $key => $orderDetail)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($orderDetail->thumbnail_img != null)
                                                <a href="javascript::void(0);" target="_blank">
                                                    <img height="50" src="{{ uploaded_asset($orderDetail->thumbnail_img) }}">
                                                </a>
                                            @else
                                                <strong>{{ translate('N/A') }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($orderDetail->name != null)
                                                <strong>
                                                    <a href="javascript::void(0);" target="_blank" class="text-muted">{{ $orderDetail->name }}</a>
                                                </strong>
                                            @else
                                                <strong>{{ translate('Product Unavailable') }}</strong>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                                        <td class="text-center">{{ single_price($orderDetail->price / $orderDetail->quantity) }}</td>
                                        <td class="text-center">{{ single_price($orderDetail->price) }}</td>
                                        <td class="text-center"><b class="alert alert-info">{{ $orderDetail->received_status ? $orderDetail->received_status : 'Not Received' }}</b></td>
                                        <td class="text-center">{{ $orderDetail->receiver }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    @if ($package_products)
                    <h6 class="mt-5">Package Products</h6>
                        <table class="table table-bordered aiz-table invoice-summary">
                            <thead>
                                <tr class="bg-trans-dark">
                                    <th class="min-col">#</th>
                                    <th width="10%">{{ translate('Photo') }}</th>
                                    <th>{{ translate('Description') }}</th>
                                    <th class="min-col text-center">{{ translate('Qty') }}</th>
                                    <th class="min-col text-center">{{ translate('Price') }}</th>
                                    <th class="min-col text-center">{{ translate('Total') }}</th>
                                    <th>{{ translate('Package') }}</th>
                                    <th class="min-col text-center">{{ translate('Workshop Status') }}</th>
                                    <th class="min-col text-center">{{ translate('Received By') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package_products as $key => $orderDetail)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($orderDetail->thumbnail_img != null)
                                                <a href="javascript::void(0);" target="_blank">
                                                    <img height="50" src="{{ uploaded_asset($orderDetail->thumbnail_img) }}">
                                                </a>
                                            @else
                                                <strong>{{ translate('N/A') }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($orderDetail->name != null)
                                                <strong>
                                                    <a href="javascript::void(0);" target="_blank" class="text-muted">{{ $orderDetail->name }}</a>
                                                </strong>
                                            @else
                                                <strong>{{ translate('Product Unavailable') }}</strong>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                                        <td class="text-center">{{ single_price($orderDetail->price / $orderDetail->quantity) }}</td>
                                        <td class="text-center">{{ single_price($orderDetail->price) }}</td>
                                        <td class="text-center">{{ translate('Package') }}</td>
                                        <td class="text-center"><b class="alert alert-info">{{ $orderDetail->received_status ? $orderDetail->received_status : 'Not Received' }}</b></td>
                                        <td class="text-center">{{ $orderDetail->receiver }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            @if ($order->is_gift_product_availed)
                <div class="row">
                    <h6 class="ml-3">Discount Gift</h6>
                    <br>
                    <div class="col-lg-12 table-responsive">
                        <table class="table table-bordered aiz-table invoice-summary">
                            <thead>
                                <tr class="bg-trans-dark">
                                    <th class="text-uppercase">{{ translate('Discount Title') }}</th>
                                    <th class="min-col text-uppercase">{{ translate('Gift Name') }}</th>
                                    <th class="min-col text-uppercase">{{ translate('Gift Image') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @php $gift_datas = json_decode($order->gift_product_data); @endphp
                                    <td>{{ $gift_datas->discount_title }}</td>
                                    <td>{{ $gift_datas->gift_name }} </td>
                                    <td><img height="50" src="{{ uploaded_asset($gift_datas->gift_image) }}"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="clearfix float-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('Sub Total') }} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->orderDetails->sum('price')) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('Coupon') }} :</strong>
                            </td>
                            <td>
                                {{ single_price($order->coupon_discount) }}
                            </td>
                        </tr>
                        @if ($order->is_gift_discount_applied)
                            @php $gift_discount_data = json_decode($order->gift_discount_data); @endphp
                            <tr>
                                <th class="text-muted">{{ translate('Gift Discount') }}
                                    ({{ $gift_discount_data->title }})</th>
                                <td>{{ single_price($gift_discount_data->discount) }}</td>
                            </tr>
                        @endif
                        @if ($order->express_delivery)
                            <tr>
                                <td>
                                    <strong class="text-muted">{{ translate('Express Delivery') }} :</strong>
                                </td>
                                <td>
                                    {{ single_price($order->express_delivery) }}
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <strong class="text-muted">{{ translate('TOTAL') }} :</strong>
                            </td>
                            <td class="text-muted h5">
                                {{ single_price($order->grand_total) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right no-print">
                    <a href="{{ route('invoice.download', $order->id) }}" type="button"
                        class="btn btn-icon btn-light"><i class="las la-print"></i></a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">

        var order_id = {{ $order->id }};
        var order_update_success_notify = "{{ translate('Delivery status has been updated') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#delivery_type').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#delivery_type').val();
            $.ajax({
                url: "{{ route('orders.delivery_type') }}",
                _token: '{{ @csrf_token() }}',
                type: 'post',
                data: {
                    order_id: order_id,
                    status: status
                },
                success: function(res) {
                    AIZ.plugins.notify('success',
                        '{{ translate('Delivery status has been updated') }}');
                },
                error: function() {
                    alert('failed...');

                }
            });
        });

        function PrintElem(elem) {
            var mywindow = window.open('', 'PRINT', 'height=600,width=600');
            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/
            mywindow.print();
            mywindow.close();
            return true;
        }
    </script>
@endsection
