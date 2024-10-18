@extends('frontend.layouts.custom_layout')
@section('content')
<style>
.checked {
  color: #FFBC10;
}
.ratingg > label {
color: #FFBC10;
font-size: 21px;
margin-top: -4px;
}
.ratingg > label::before{
content: "\2605";
position: absolute;
opacity: 0;
}
</style>
    @php
        $order = DB::table('orders')->where('orders.id', $order->id)
        ->leftJoin('car_lists as cl', 'cl.id','orders.carlist_id')
        ->leftJoin('shops', 'shops.id','orders.seller_id')
        ->select('orders.id','orders.code','shops.name as shop_name','shops.rating as shop_rating','orders.workshop_date',
        'orders.workshop_time','cl.image as car_image','cl.car_plate','orders.order_type','orders.order_schedule_time','orders.battery_type')
        ->first();
    @endphp
            <div class="row">
                <div class="col-md-12 col-12">
                            <div class="text-center py-4">
                                <img src="{{ static_asset('front_assets/img/success_image.png') }}" style="width: 25%">
                                <h1 class="h5 fw-700 mt-4" style="color: #000693">{{ translate('Thank You! Your order has been rescheduled successfully') }}</h1>
                            </div>
                                <div class="row pl-3 pr-3">
                                  <div class="col-md-12">
                                      <div class="card card-body" style="border-radius: 15px;">
                                          <div class="row">
                                              <div class="col-md-7 col-7">
                                                  <h1 class="h6 fw-700" style="margin-bottom: 0px;">
                                                    Reschedule Service
                                                  </h1>
                                                  <span style="color: #747474;font-size: 10px">Booking ID: <span class="ml-2">{{ $order->code }}</span></span>
                                                  <h1 class="h6 mt-2 fw-600">{{ $order->shop_name }}</h1>
                                                   <div class="ratingg">
                                                        @for ($i = 0; $i < $order->shop_rating; $i++)
                                                            <span class="fa fa-star checked"></span>
                                                        @endfor
                                                        @for ($i = 0; $i < 5 - $order->shop_rating; $i++)
                                                            <label>☆</label>
                                                        @endfor
                                                   </div>
                                                   <h1 class="h6 fw-600">SLOT</h1>
                                                   <span style="color: #747474; font-size: 14px">{{ $order->workshop_date ? date(env('DATE_FORMAT'), strtotime($order->workshop_date)) : ''}} {{$order->workshop_time}}</span>
                                              </div>
                                              <div class="col-md-5 col-5" style="text-align: center">
                                                  <img class="mt-3" style="max-width: 110px;max-height: 86px;" src="{{ ($order->car_image) ? uploaded_asset($order->car_image) : static_asset('front_assets/img/car-transparent.png') }}" alt="">
                                                  <h1 class="h6 fw-600 mt-1" style="color: #747474">{{ $order->car_plate }}</h1>
                                              </div>
                                          </div>
                                      </div>
                                      <div style="text-align: center">
                                        <a class="btn" href="https://carkee.my/block" style="background: #000693; color: white;border-radius: 8px;font-weight: 600;font-size: 14px;width: 214px;">GO BACK</a>
                                      </div>
                                  </div>
                                </div>
                </div>
            </div>
        </div>

@endsection

