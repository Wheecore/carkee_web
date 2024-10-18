@extends('backend.layouts.app')
@section('title', translate('Order Details'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
            <a class="btn btn-primary" href="{{ route('petrol_orders.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
        </div>
        <div class="card-body">
            <div class="row gutters-5">
                <div class="col-md-4 col-12 ml-auto">
                    <div class="form-group">
                        <label for="delivery_type">{{ translate('Delivery Type') }}</label>
                        <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity"
                            id="delivery_type">
                            <option value="">{{ translate('Select') }}</option>
                            <option value="self delivery" {{ $order->delivery_type == 'self delivery' ? 'selected' : '' }}>
                                {{ translate('Self delivery') }}</option>
                            <option value="delivery company" {{ $order->delivery_type == 'delivery company' ? 'selected' : '' }}>
                                {{ translate('Delivery company') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="emergency_update_delivery_status">{{ translate('Order Status') }}</label>
                        @if ($order->delivery_status != 'completed' && $order->delivery_status != 'cancelled')
                            <select class="form-control aiz-selectpicker" data-minimum-results-for-search="Infinity" id="emergency_update_delivery_status">
                                <option value="pending" @if ($order->delivery_status == 'pending') selected @endif>
                                    {{ translate('Pending') }}</option>
                                <option value="on_the_way" @if ($order->delivery_status == 'on_the_way') selected @endif>
                                    {{ translate('On The Way') }}</option>
                                <option value="completed" @if ($order->delivery_status == 'completed') selected @endif>
                                    {{ translate('Completed') }}</option>
                            </select>
                        @else
                            <input type="text" class="form-control" value="{{ ucfirst($order->delivery_status) }}"
                                readonly>
                        @endif
                    </div>
                    <div class="form-group" id="minutes-remaining">
                        <label for="">{{ translate('Arrival Minutes') }}</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="minutes" name="minutes" value="{{ $order->arrival_minutes ?? 0 }}">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon2">{{ translate('minutes') }}</span>
                            </div>
                        </div>
                        <button class="btn btn-md btn-success btn-submit-minutes-remaining">{{ translate('Save') }}</button>
                    </div>
                </div>
                <div class="col-md-4 col-12 ml-auto">
                    <div class="form-group">
                        <table class="mx-auto">
                            <tbody>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                    <td class="text-right text-info text-bold"> {{ $order->code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Car Model') }}</td>
                                    <td class="text-right text-info text-bold"> {{ $order->model_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order Status') }}</td>
                                    <td class="text-right">
                                        @if ($order->delivery_status == 'completed')
                                            <span
                                                class="badge badge-inline badge-success">{{ translate(ucfirst($order->delivery_status)) }}</span>
                                        @else
                                            <span
                                                class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order Date') }}</td>
                                    <td class="text-right">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order Schedule Time') }}</td>
                                    <td class="text-right">{{ date(env('DATE_FORMAT').' h:i a', strtotime($order->order_schedule_time)) }}</td>
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
                <div class="col-md-4 col-12 ml-auto">
                    <div class="form-group">
                        @php
                            $address = json_decode($order->location);
                        @endphp
                        @if ($address)
                            <div class="form-group">
                                <label for="delivery_type">{{ translate('Location') }}</label>
                                <p>{{ translate('Address') }}: {{ $address->loc }}</p>
                                <iframe src="https://www.google.com/maps?q={{ $address->lat }},{{ $address->long }}&hl=en&z=14&output=embed" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        @endif
                    </div>
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
                                        @if ($orderDetail->petrolProduct != null)
                                            <strong><a href="#"
                                                    class="text-muted">{{ $orderDetail->petrolProduct->name }}</a></strong>
                                        @else
                                            <strong>Petrol</strong>
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
                    <a href="{{ route('invoice.emergency-order', ['order_id' => $order->id, 'type' => 'petrol']) }}"
                        type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script type="text/javascript">
        var order_id = {{ $order->id }};
        var order_update_success_notify = "{{ translate('Order status has been updated') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
    </script>

@endsection
