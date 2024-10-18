@extends('frontend.layouts.user_panel')
@section('panel_content')
    @php
        $status = $order->delivery_status;
        $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
        $shop = \App\Shop::where('id', $order->seller_id)->first();
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4 py-4">
                    <div class="row text-center">
                        <div class="col-md-3 col-sm-4 ml-2">
                            <div id="elem">
                                {!! QrCode::size(250)->generate($order->user_id . '/' . $order->id) !!}
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-1">
                            <button class="btn btn-dark" style="float: right;" type="button"
                                onclick="PrintElem('elem')">Print</button>
                        </div>
                        <div class="col-md-1">
                            <form class="form-horizontal" action="{{ route('qrcode.user.download', ['type' => 'png']) }}"
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
                <div class="card mt-4">
                    <div class="card-header">
                        <b class="fs-15">{{ translate('Order Summary') }}</b>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Order Code') }}:</td>
                                        <td>{{ $order->code }}</td>
                                    </tr>

                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Email') }}:</td>
                                        @if ($order->user_id != null)
                                            <td>{{ $order->user->email }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Shop Address') }}:</td>
                                        <td> {{ $shop->address }}</td>
                                    </tr>

                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Appointment Date') }}:</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $order->workshop_date ? $order->workshop_date : '')) }},
                                            {{ ucfirst(str_replace('_', ' ', $order->workshop_time ? $order->workshop_time : '')) }}
                                        </td>
                                    </tr>

                                    @if ($order->car_plate)
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Car Plate') }}:</td>
                                            <td>{{ $order->car_plate }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Order date') }}:</td>
                                        <td>{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Order status') }}:</td>
                                        <td>{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Total order amount') }}:</td>
                                        <td>{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="w-50 fw-600">{{ translate('Payment method') }}:</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                    </tr>
                                    @if ($order->model_id)
                                        @php $model = \App\CarModel::where('id', $order->model_id)->first(); @endphp
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Car Model') }}:</td>
                                            <td>
                                                {{ isset($model) ? $model->name : '' }}
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card mt-4">
                            <div class="card-header">
                                <b class="fs-15">{{ translate('Order Details') }}</b>
                            </div>
                            <div class="card-body pb-0">
                                <table class="table table-borderless table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="30%">{{ translate('Product') }}</th>
                                            <th>{{ translate('Quantity') }}</th>
                                            <th>{{ translate('Price') }}</th>
                                            <th data-breakpoints="lg" class="min-col text-center text-uppercase">
                                                {{ translate('Workshop Status') }}</th>
                                            @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                                <th>{{ translate('Refund') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetails as $key => $orderDetail)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if ($orderDetail->product != null)
                                                        <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                            target="_blank">{{ $orderDetail->product->getTranslation('name') }}</a>
                                                    @else
                                                        <strong>{{ translate('Product Unavailable') }}</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $orderDetail->quantity }}
                                                </td>
                                                <td>{{ single_price($orderDetail->price) }}</td>
                                                @if ($refund_request_addon != null && $refund_request_addon->activated == 1)
                                                    @php
                                                        $no_of_max_day = get_setting('refund_request_time');
                                                        $last_refund_date = $orderDetail->created_at->addDays($no_of_max_day);
                                                        $today_date = Carbon\Carbon::now();
                                                    @endphp
                                                    <td>
                                                        @if ($orderDetail->product != null &&
                                                            $orderDetail->product->refundable != 0 &&
                                                            $orderDetail->refund_request == null &&
                                                            $today_date <= $last_refund_date &&
                                                            $order->payment_status == 'paid' &&
                                                            $order->delivery_status == 'delivered')
                                                            <a href="{{ route('refund_request_send_page', $orderDetail->id) }}"
                                                                class="btn btn-primary btn-sm">{{ translate('Send') }}</a>
                                                        @elseif ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 0)
                                                            <b class="text-info">{{ translate('Pending') }}</b>
                                                        @elseif ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 2)
                                                            <b class="text-success">{{ translate('Rejected') }}</b>
                                                        @elseif ($orderDetail->refund_request != null && $orderDetail->refund_request->refund_status == 1)
                                                            <b class="text-success">{{ translate('Approved') }}</b>
                                                        @elseif ($orderDetail->product->refundable != 0)
                                                            <b>{{ translate('N/A') }}</b>
                                                        @else
                                                            <b>{{ translate('Non-refundable') }}</b>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td class="text-center  alert alert-info">
                                                    <b>{{ $orderDetail->received_status ? $orderDetail->received_status : 'Not Received' }}</b>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card mt-4">
                            <div class="card-header">
                                <b class="fs-15">{{ translate('Order Amount') }}</b>
                            </div>
                            <div class="card-body pb-0" style="padding: 0px;">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Subtotal') }}</td>
                                            <td class="text-right">
                                                <span
                                                    class="strong-600">{{ single_price($order->orderDetails->sum('price')) }}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Coupon') }}</td>
                                            <td class="text-right">
                                                <span
                                                    class="text-italic">{{ single_price($order->coupon_discount) }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 fw-600">{{ translate('Total') }}</td>
                                            <td class="text-right">
                                                <strong><span>{{ single_price($order->grand_total) }}</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($order->manual_payment && $order->manual_payment_data == null)
                            <button onclick="show_make_payment_modal({{ $order->id }})"
                                class="btn btn-block btn-primary">{{ translate('Make Payment') }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function show_make_payment_modal(order_id) {
            $.post('{{ route('checkout.make_payment') }}', {
                _token: '{{ csrf_token() }}',
                order_id: order_id
            }, function(data) {
                $('#payment_modal_body').html(data);
                $('#payment_modal').modal('show');
                $('input[name=order_id]').val(order_id);
            });
        }
    </script>
    <script>
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
