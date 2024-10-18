@extends('frontend.layouts.user_panel')
@section('panel_content')

   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="card mt-4">
                       <div class="card-header">
                           <div class="row w-100">
                               <div class="col-md-7 col-12">
                                    <h5 class="mb-md-0 h6">{{ translate('Order Details') }}</h5>
                               </div>
                           </div>
                         </div>
                           <div class="card-body p-3">
                            <div class="modal-header">
                                <h6 class="modal-title">{{ translate('Order id')}}: {{ $order->code }}</h6>
                            </div>
                            @php
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
                            @endphp
                            <div class="modal-body gry-bg px-3 pt-0">
                            
                                <div class="card mt-4">
                                    <div class="card-header">
                                      <b class="fs-15">{{ translate('Order Summary') }}</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Order Code')}}:</td>
                                                        <td>{{ $order->code }}</td>
                                                    </tr>
                                                    @if($order->user_date_update == 1)
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Old Appointment Date')}}:</td>
                                                        <td>{{ date(env('DATE_FORMAT'), strtotime($order->old_workshop_date)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Old Appointment Time')}}:</td>
                                                        <td>{{ $order->old_workshop_time }}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Appointment Date')}}:</td>
                                                        <td>{{ date(env('DATE_FORMAT'), strtotime($order->workshop_date)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Appointment Time')}}:</td>
                                                        <td>{{ $order->workshop_time }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('User Email')}}:</td>
                                                        @if ($order->user_id != null)
                                                            <td>{{ $order->user->email }}</td>
                                                        @endif
                                                    </tr>
                            
                                                    @if($order->model_id)
                                                    @php $model = \App\Models\CarModel::where('id', $order->model_id)->first(); @endphp
                                                     <tr>
                                                          <td class="w-50 fw-600">{{ translate('Car Model')}}:</td>
                                                                  <td>
                                                                      {{ (isset($model))?$model->name:''}}
                                                                  </td>
                                                     </tr>
                                                    @endif
                                                    @if($order->car_plate)
                                                     <tr>
                                                          <td class="w-50 fw-600">{{ translate('Car Plate')}}:</td>
                                                                  <td>{{ $order->car_plate}}</td>
                                                     </tr>
                                                    @endif
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Order date')}}:</td>
                                                        <td>{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Delivery status')}}:</td>
                                                        <td>
                                                            @php
                                                                $status = $order->delivery_status;
                                                            @endphp
                                                            {{ translate(ucfirst(str_replace('_', ' ', $status))) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Total order amount')}}:</td>
                                                        <td>{{ single_price($order->grand_total) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Payment method')}}:</td>
                                                        <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                                    </tr>
                                                    @if ($order->reassign_date)
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Reassign Date') }}</td>
                                                        <td>{{ convert_datetime_to_local_timezone($order->reassign_date, user_timezone(Auth::id())) }}</td>
                                                    </tr>
                                                @endif
                                                @if ($order->old_workshop_id)
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Old Workshop Name') }}</td>
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
                                                        <td>{{ $old_shop && $old_shop->name ? $old_shop->name : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Old Workshop Appointment Date') }}</td>
                                                        <td>{{ $old_shop_app_date }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="w-50 fw-600">{{ translate('Old Workshop Appointment Time') }}</td>
                                                        <td>{{ $old_shop_app_time }}</td>
                                                    </tr>
                                                @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-lg-9">
                                        @if(count($tyre_products) > 0)
                                        <div class="card mt-4">
                                            <div class="card-header">
                                              <b class="fs-15">{{ translate('Tyre Products') }}</b>
                                            </div>
                                            <div class="card-body pb-0">
                                                <table class="table table-borderless table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th width="40%">{{ translate('Product')}}</th>
                                                            <th>{{ translate('Quantity')}}</th>
                                                            <th>{{ translate('Price')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tyre_products as $key => $orderDetail)
                                                            <tr>
                                                            @php $product_name_with_choice = ($orderDetail->name != null) ? $orderDetail->name : translate('Product Unavailable');
                                                            @endphp
                                                                <td>{{ $key+1 }}</td>
                                                                <td>
                                                                 <a href="" target="_blank">{{ $product_name_with_choice }}</a>
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
                                        @endif
                                         @if(count($package_products) > 0)
                                        <div class="card mt-4">
                                            <div class="card-header">
                                              <b class="fs-15">{{ translate('Package Products') }}</b>
                                            </div>
                                            <div class="card-body pb-0">
                                                <table class="table table-borderless table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th width="40%">{{ translate('Product')}}</th>
                                                            <th>{{ translate('Quantity')}}</th>
                                                            <th>{{ translate('Price')}}</th>
                                                            <th>{{translate('Package Name')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($package_products as $key => $orderDetail)
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>
                                                                 <a href="" target="_blank">{{ $orderDetail->name != null ? $orderDetail->name: translate('Product Unavailable')}}</a>
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
                                        @endif
                                        @if($order->is_gift_product_availed)
                                          <div class="card mt-4">
                                            <div class="card-header">
                                              <b class="fs-15">{{ translate('Discount Gift') }}</b>
                                            </div>
                                            <div class="card-body pb-0">
                                                <table class="table table-borderless table-responsive">
                                                    <thead>
                                                        <tr>
                                                        <th>#</th>
                                                        <th width="40%">{{ translate('Discount Title') }}</th>
                                                        <th width="30%">{{ translate('Gift Name') }}</th>
                                                        <th>{{ translate('Gift Image') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @php $gift_datas = json_decode($order->gift_product_data); @endphp
                                                        <tr>
                                                            <td>1</td>
                                                            <td width="40%">{{ $gift_datas->discount_title }}</td>
                                                            <td width="30%">{{ $gift_datas->gift_name }}</td>
                                                            <td><img src="{{ uploaded_asset($gift_datas->gift_image) }}" alt="" height="50"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-3">
                                         <div class="card mt-4">
                                            <div class="card-header">
                                              <b class="fs-15">{{ translate('Order Ammount') }}</b>
                                            </div>
                                            <div class="card-body pb-0" style="padding: 0;">
                                                <table class="table table-borderless table-responsive">
                                                    <tbody>
                                                            <tr>
                                                                <td>{{ translate('Subtotal')}}:</td>
                                                                <td><span>{{ single_price($order->orderDetails->sum('price')) }}</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ translate('Coupon')}}:</td>
                                                                <td><span>{{ single_price($order->coupon_discount) }}</span></td>
                                                            </tr>
                                                                @if($order->is_gift_discount_applied)
                                                                @php $gift_discount_data = json_decode($order->gift_discount_data); @endphp
                                                                <tr>
                                                                    <td>{{ translate('Gift Discount') }} ({{ $gift_discount_data->title }}):</td>
                                                                    <td><span>{{ single_price($gift_discount_data->discount) }}</span></td>
                                                                </tr>
                                                                @endif
                                                             @if($order->express_delivery)
                                                            <tr>
                                                                <td>{{ translate('Express Delivery')}}:</td>
                                                                <td><span>{{ single_price($order->express_delivery) }}</span></td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td><strong>{{ translate('Total')}}:</strong></td>
                                                                <td><strong>{{ single_price($order->grand_total) }}</strong></td>
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
       </div>
   </div>

@endsection
