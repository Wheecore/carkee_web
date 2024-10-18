@extends('backend.layouts.app')
@section('title', translate('Order Details'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
            <a class="btn btn-primary" href="{{ route('car-washes.orders') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-12 ml-auto">
                    <table>
                        <tbody>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                <td class="text-right text-info text-bold"> {{ $order->code }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Service Type') }}</td>
                                <td class="text-right text-bold">{{ translate('Car Wash') }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Car Model') }}</td>
                                <td class="text-right text-info text-bold"> {{ $order->model_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-main text-bold">{{ translate('Order Date') }}</td>
                                <td class="text-right">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
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
                    <table class="table table-bordered aiz-table invoice-summary">
                        <thead>
                            <tr class="bg-trans-dark">
                                <th class="min-col">#</th>
                                <th class="text-uppercase">{{ translate('Description') }}</th>
                                <th class="min-col text-center text-uppercase">{{ translate('Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($orderDetail->carwashProduct != null)
                                                {{ $orderDetail->carwashProduct->name }}
                                            @else
                                                Car Wash
                                            @endif
                                        </td>
                                    <td class="text-center">{{ single_price($orderDetail->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
                    <a href="{{ route('invoice.emergency-order', ['order_id' => $order->id, 'type' => 'car_wash']) }}"
                        type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#update_delivery_status').on('change', function() {
            var order_id = {{ $order->id }};
            var status = $('#update_delivery_status').val();
            $.post('{{ route('orders.update_delivery_status') }}', {
                _token: '{{ @csrf_token() }}',
                order_id: order_id,
                status: status
            }, function(data) {
                AIZ.plugins.notify('success', '{{ translate('Order status has been updated') }}');
                location.reload();
            });
        });

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
    </script>
@endsection
