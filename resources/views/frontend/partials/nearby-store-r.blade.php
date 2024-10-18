@php
    $count = 0;
@endphp
@if (count($sellers['vendors']) > 0)
    <div class="row">
        @foreach ($sellers['vendors'] as $key => $value)
            @if ($count < 20)
                @php
                    $count ++;
                    $seller = \App\Seller::find($value->id);
                    $total = 0;
                    $rating = 0;
                    $shop = $seller->user->shop;
                    foreach ($seller->user->products as $key => $seller_product) {
                        $total += $seller_product->reviews->count();
                        $rating += $seller_product->reviews->sum('rating');
                    }
                @endphp
                    <div class="col-lg-2 col-md-2 mt-3 ml-3 mb-3 mr-3">
                        <div id="highlight{{$shop->id}}" class="removehighlight card-r" style="border: 2px solid #8080803d;">
                            <a href="javascript:void(0)" class="d-block p-3" onclick="activeWorkshop({{ $shop->id }})">
                                <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="@if ($seller->user->shop->logo !== null) {{ uploaded_asset($shop->logo) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                                        alt="{{ $shop->name }}"
                                        class="img-fluid lazyload card-r"
                                >
                            </a>
                            <div class="p-3 text-left">
                                <h2 class="h6 fw-600 text-truncate">
                                    <a href="javascript:void(0)" class="text-reset">
                                        {{ $shop->name }}
                                    </a>
                                </h2>


                            </div>

                        </div>
                    </div>
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
