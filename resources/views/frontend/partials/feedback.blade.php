<section class="mb-4">
    {{--<div class="container">--}}
    <div class="px-2 py-4 px-md-4 py-md-3 shadow-sm rounded">
        <div class="d-flex mb-3 align-items-baseline border-bottom">
            <h3 class="h5 fw-700 mb-0">
                <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Orders Feedback') }}</span>
            </h3>
        </div>
        <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
            @foreach(DB::table('rating_orders')->get() as $order)
                <?php
                $user = \App\User::where('id', $order->user_id)->first();
                ?>
             <div class="carousel-box">
                 <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                     <div class="position-relative">
                         @if ($user->avatar_original != null)
                             <img src="{{ uploaded_asset($user->avatar_original) }}"
                                  onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                             >
                         @else
                             <img src="{{ static_asset('assets/img/avatar-place.png') }}"
                                  class="image rounded-circle"
                                  onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                             >
                         @endif
                     </div>
                     <div class="p-md-3 p-2 text-left">

                             <h3>{{ $user->name }}</h3>

                             @for($i=0; $i<5; $i++)
                                 @if($order)
                                     @if($order->score >$i)

                                         <span class="la la-star-o" data-rating="1"
                                               style="color: yellow;font-size: 20px"></span>
                                     @else
                                         <span class="la la-star-o" data-rating="1"
                                               style="font-size: 20px"></span>
                                     @endif
                                 @else
                                     <span class="la la-star-o" data-rating="1"
                                           style="font-size: 20px"></span>
                                 @endif
                             @endfor

                             @if($order)
                                 <p style="padding: 2px;font-size: 15px; font-family: cursive">{!! $order->description !!}</p>
                             @endif
                             <br>

                     </div>
                 </div>

             </div>
            @endforeach
        </div>
    </div>
    {{--</div>--}}
</section>
