@php
    $count = 0;
    $cat_array = [];
$carts = \App\Cart::where('user_id', Auth::user()->id)->get();
if ($carts && count($carts) > 0) {
    foreach ($carts as $key => $cartItem){
        $product = \App\Product::where('id', $cartItem['product_id'])->first();
        $cat_array[] = $product->category_id;
    }
}
$filter_cats = array_unique($cat_array);
@endphp
@if (count($sellers) > 0)
    <div class="row">
        @foreach ($sellers as $key => $value)
            @if ($count < 20)
                @php
                    $count ++;
                    $seller = \App\Seller::find($value->id);
                    $rating_by_orders = 0;
                    $shop = $seller->user->shop;
                   $orders = \App\Models\Order::where('seller_id', $shop->id)->get();
               foreach ($orders as $order) {
                   $t_rating = \DB::table('rating_orders')->where('order_id', $order->id)->get();
                   $rating_orders = \DB::table('rating_orders')->where('order_id', $order->id)->sum('score');
                   if ($rating_orders) {
                       $rating_by_orders = round($rating_orders / count($t_rating));
                       }
                }

$map_shop = DB::table("shops")->where('id', $shop->id)->first();
$result = array_intersect($filter_cats,json_decode($map_shop->category_id));
asort($filter_cats);
$mas = json_decode($map_shop->category_id);
asort($mas);

 $filter_cats = array_values($filter_cats);
 $mas = array_values($mas);
                @endphp
                 @if($result)
                <div class="col-md-12">
                    <div class="removehighlight card" id="highlight{{$shop->id}}">
                        <div class="card-body">
                            <a class="store_a" href="javascript:void(0)" onclick="activeWorkshop({{ $shop->id }})">
                                <div class="row">
                                    <div class="col-md-7">
                                        <h5>{{ $shop->name }}</h5>
                                        <p><span class="material-icons">location_on</span> {{$map_shop->address}}</p>
                                        <p>
                                            @if(isset($rating_by_orders))
                                                @for ($i=0; $i < $rating_by_orders; $i++)
                                                    <i class="las la-star active" style="color: #f37539;"></i>
                                                @endfor
                                                @for ($i=0; $i < 5-$rating_by_orders; $i++)
                                                    <i class="las la-star"></i>
                                                @endfor
                                            @else
                                                @for ($i=0; $i < 5; $i++)
                                                    <i class="las la-star"></i>
                                                @endfor
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-5" style="text-align: center;">
                                                <h5><span class="material-icons">place</span></h5>
                                                <p>{{number_format($value->distance,1)}} KM</p>
                                            </div>
                                            <div class="col-7" style="text-align: center;">
                                                <h5><span class="material-icons">imagesearch_roller</span></h5>
                                                <p>More Info</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                @endif
        @endforeach
    </div>

@else
    <center>
        <table class="table aiz-table footable footable-1 breakpoint-xl" style="">
            <tbody>
            <tr class="footable-empty">
                <td colspan="8">
                    Nothing found
                </td>
            </tr>
            </tbody>
        </table>
    </center>
@endif
