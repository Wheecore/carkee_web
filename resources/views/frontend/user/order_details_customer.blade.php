<style>
    .info_p .lead {
        background: #F8F8F8;
        border-radius: 18px;
    }

    .info_p .lead img {
        width: 30px;
        border-radius: 10px;
    }

    .info_p .lead .lead_down {
        display: block;
    }

    .info_p .lead .lead_down p {
        display: inline;
    }

    .info_p .lead .ad_an {
        border-radius: 20px;
        border: 2px solid #cfcfcf;
        background-color: #ecebeb;
    }

    .info_p .lead .use_g {
        padding: 10px;
        border-radius: 20px;
        border: 2px solid #cfcfcf;
        background-color: #fdfdfd;
    }

    .info_p .compare_right .score {
        background-color: #DDEEE6;
        color: #79A090;
        border: 1px solid #D0DEDB;
        border-radius: 10px;
        padding: 20px;
    }

    .info_p .compare_right .top {
        border: 1px solid #c8bcbc;
        border-radius: 10px;
    }

    @media (max-width: 1024px) {
        .info_p .lead .ad_an {
            font-size: 15px;
        }

        .info_p .lead .use_g {
            font-size: 13px;
        }
    }

    @media (max-width: 768px) {
        .info_p .lead .ad_an {
            font-size: 15px;
        }

        .info_p .lead .use_g {
            font-size: 13px;
        }

        .info_p .lead .lead_down p {
            font-size: 14px
        }
    }

    @media (max-width: 480px) {
        .info_p .lead .ad_an {
            font-size: 15px;
        }

        .info_p .lead .use_g {
            font-size: 13px;
        }

        .info_p .compare_right .score {
            margin-bottom: 10px;
        }
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Order id') }}: {{ $order->code }}</h5>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
@php
    $status = $order->delivery_status;
    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
    $shop = \App\Shop::where('id', $order->seller_id)->first();
@endphp
<div class="modal-body px-3 pt-3">
    <div class="info_p">
        <div class="row">
            <div class="col-md-4 p-3 lead">
                <div id="elem" class="text-center mb-3">
                    {!! QrCode::size(250)->generate($order->user_id . '/' . $order->id) !!}
                </div>
                <div class="lead_down">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary" type="button" onclick="PrintElem('elem')">Print</button>
                        </div>
                        <div class="col-6">
                            <form class="form-horizontal text-right"
                                action="{{ route('qrcode.user.download', ['type' => 'png']) }}" method="post">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                @csrf
                                <button type="submit" class="align-middle btn btn-outline-primary btn-sm"
                                    style="padding: 10px;">
                                    <i class="fas fa-fw fa-download"></i>
                                    Download PNG
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="ad_an m-4">
                    <p class="text-center p-auto pt-1 h-20px">{{ translate('Order Summary') }}</p>
                </div>
                <div class="use_g m-2 p-2">
                    <div class="row mt-1 mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Order Code') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>{{ $order->code }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Email') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>
                                @if ($order->user_id != null)
                                    {{ $order->user->email }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Shop Address') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>{{ $shop->address }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Appointment Date') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>{{ $order->workshop_date ? date(env('DATE_FORMAT'), strtotime($order->workshop_date)) : '' }},
                                {{ $order->workshop_time ? $order->workshop_time : '' }}</span>
                        </div>
                    </div>
                    @if ($order->car_plate)
                        <div class="row mb-2">
                            <div class="col-md-6 col-12">
                                <strong>{{ translate('Car Plate') }}:</strong>
                            </div>
                            <div class="col-md-6 col-12">
                                <span>{{ $order->car_plate }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Order date') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Order status') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Total order amount') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>{{ single_price($order->orderDetails->sum('price') + $order->orderDetails->sum('tax')) }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <strong>{{ translate('Payment method') }}:</strong>
                        </div>
                        <div class="col-md-6 col-12">
                            <span>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</span>
                        </div>
                    </div>
                    @if ($order->model_id)
                        @php $model = \App\CarModel::where('id', $order->model_id)->first(); @endphp
                        <div class="row mb-2">
                            <div class="col-md-6 col-12">
                                <strong>{{ translate('Car Model') }}:</strong>
                            </div>
                            <div class="col-md-6 col-12">
                                <span>{{ isset($model) ? $model->name : '' }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-8 compare_right pt-7 pl-4">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>{{ translate('Order Details') }}</h5>
                        <div class="top">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead class="border-bottom">
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
                                                        {{ translate('Product Unavailable') }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $orderDetail->quantity }}
                                                </td>
                                                <td>{{ single_price($orderDetail->price) }}</td>
                                                <td class="text-center  alert alert-info">
                                                    <b>{{ $orderDetail->received_status ? $orderDetail->received_status : 'Not Received' }}</b>
                                                </td>
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>{{ translate('Order Ammount') }}</h5>
                        <div class="score">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <strong>{{ translate('Subtotal') }}:</strong>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span>{{ single_price($order->orderDetails->sum('price')) }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <strong>{{ translate('Coupon') }}:</strong>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span>{{ single_price($order->coupon_discount) }}</span>
                                </div>
                            </div>
                            @if ($order->express_delivery)
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <strong>{{ translate('Express Delivery') }}:</strong>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span>{{ single_price($order->express_delivery) }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <strong>{{ translate('Total') }}:</strong>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span>{{ single_price($order->grand_total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($order->manual_payment && $order->manual_payment_data == null)
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button onclick="show_make_payment_modal({{ $order->id }})"
                                class="btn btn-block btn-primary">{{ translate('Make Payment') }}</button>
                        </div>
                    </div>
                @endif
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
