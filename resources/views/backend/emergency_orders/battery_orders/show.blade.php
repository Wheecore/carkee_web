@extends('backend.layouts.app')
@section('title', translate('Order Details'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
            <a class="btn btn-primary" href="{{ route('battery_orders.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
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
                            <option value="delivery company"
                                {{ $order->delivery_type == 'delivery company' ? 'selected' : '' }}>
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
                @if($order->order_type == 'B' && $order->battery_type == 'N')
                <div class="form-group mb-3">
                    <div id="elem">
                        {!! QrCode::size(235)->generate($order->id) !!}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-2">
                        <button class="btn btn-success" type="button"
                            onclick="PrintElem('elem')">Print</button>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <a href="{{ route('battery.qrcode.download', ['type' => 'png', 'order_id' => $order->id]) }}"
                            class="align-middle btn btn-outline-primary" style="margin-left: 37px;">
                            <i class="fas fa-fw fa-download"></i>
                            Download
                        </a>
                    </div>
                </div>
                @endif
                </div>
                <div class="col-md-4 col-12 ml-auto">
                    <div class="form-group">
                        @php
                            $address = json_decode($order->location);
                        @endphp
                        @if ($address)
                            <div class="form-group">
                                <label>{{ translate('Location') }}</label>
                                <p>{{ translate('Address') }}: {{ $address->loc }}</p>
                                <iframe src="https://www.google.com/maps?q={{ $address->lat }},{{ $address->long }}&hl=en&z=14&output=embed" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-12"></div>
                <div class="col-md-4 col-12 ml-auto">
                    <div class="form-group">
                        <table class="mx-auto">
                            <tbody>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Order #') }}</td>
                                    <td class="text-right text-info text-bold"> {{ $order->code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{ translate('Service Type') }}</td>
                                    <td class="text-right text-bold">
                                        {{ $order->battery_type == 'N' ? 'New Battery' : 'Jumpstart' }}</td>
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
            </div>
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-bordered aiz-table invoice-summary">
                        <thead>
                            <tr class="bg-trans-dark">
                                <th class="min-col">#</th>
                                @if ($order->battery_type == 'N')
                                    <th width="10%">{{ translate('Photo') }}</th>
                                @endif
                                <th class="text-uppercase">{{ translate('Description') }}</th>
                                <th class="min-col text-center text-uppercase">{{ translate('Price') }}</th>
                                @if ($order->battery_type == 'N' && $order->warranty_activation_date)
                                    <th>{{ translate('Warranty Start Date') }}</th>
                                    <th>{{ translate('Warranty End Date') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails as $key => $orderDetail)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    @if ($order->battery_type == 'N')
                                        <td>
                                            @if ($orderDetail->batteryProduct != null)
                                                <img height="50"
                                                    src="{{ uploaded_asset($orderDetail->batteryProduct->attachment_id) }}">
                                            @else
                                                No Image Available
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        @if ($order->battery_type == 'N')
                                            @if ($orderDetail->batteryProduct != null)
                                                <strong>
                                                    <a href="#" class="text-muted">{{ $orderDetail->batteryProduct->name }}</a>
                                                </strong>
                                            @else
                                                <strong>{{ translate('Battery Unavailable') }}</strong>
                                            @endif
                                        @else
                                            Jumpstart
                                        @endif
                                    </td>
                                    <td class="text-center">{{ single_price($orderDetail->price) }}</td>
                                    @if ($order->battery_type == 'N' && $order->warranty_activation_date)
                                        @php 
                                        $timezone = user_timezone(Auth::id());
                                        $end_date = $order->battery_expiry_months && $order->warranty_activation_date ? date(env('DATE_FORMAT'), strtotime('+' . $order->battery_expiry_months . ' months', strtotime($order->warranty_activation_date))) : '';
                                        @endphp
                                        <td>{{ $order->warranty_activation_date ? convert_datetime_to_local_timezone(date('Y-m-d H:i:s', strtotime($order->warranty_activation_date)), $timezone) : '' }}
                                        </td>
                                        <td>{{ ($end_date != '') ? convert_datetime_to_local_timezone(date('Y-m-d H:i:s', strtotime($end_date)), $timezone) : '' }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($activation_image)
            <div class="row mt-4">
                <div class="col-lg-12 table-responsive">
                    <h6>Battery Activation Photo</h6>
                    <table class="table table-bordered aiz-table invoice-summary">
                        <thead>
                            <tr class="bg-trans-dark">
                                <th>#</th>
                                <th>{{ translate('Photo') }}</th>
                                <th>{{ translate('Uploaded By') }}</th>
                            </tr>
                        </thead>
                        @php $user = DB::table('users')->where('id', $activation_image->user_id)->select('name','email')->first(); @endphp
                        <tbody>
                                <tr>
                                    <td>1</td>
                                        <td>
                                            <img data-toggle="modal" data-target="#activation_image" onclick="showImage(this)" style="height: 50px; width: 50px;" src="{{ uploaded_asset($activation_image->image) }}">
                                        </td>
                                        <td>{{ $user->name }} ({{ $user->email }})</td>
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
                    <a href="{{ route('invoice.emergency-order', ['order_id' => $order->id, 'type' => 'battery']) }}"
                        type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
                </div>
            </div>
        </div>
    </div>

<!-- Millage Photo Modal -->
<div class="modal fade" id="activation_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <img src="" class="activation_image" alt="" style="width: 100%; height: 100%">
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

        function showImage(el){
            $(".activation_image").prop("src", el.src);
        }

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
