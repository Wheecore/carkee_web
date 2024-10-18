@if (count($merchants['merchants']) > 0)
    <div class="row">
        <div class="col-md-12 m_b_vie">
                <div class="recomed">
                    <div class="recom">
                        <p>Recommended Stores</p>
                    </div>
                    <div class="owl-carousel owl-theme products_caresoul_owl mt-4">
                        @php
                            $first_loop = false;
                        @endphp
                        @foreach ($merchants['merchants'] as $key => $value)
                            @php
                                $merchant = \App\User::find($value->id);
                                $shop = $merchant->shop;
                            @endphp
                        @if($merchant->is_recommended == 1)
                        @php $first_loop = true; @endphp
                        <div class="item">
                            <div class="card voucher_btn" data-shop_name="{{$shop->name}}" data-merchant_id="{{$shop->user_id}}">
                                <img class="card-img-top lazyload" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                     data-src="@if ($merchant->shop->logo !== null) {{ uploaded_asset($shop->logo) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                                     alt="{{ $shop->name }}">
                                <div class="card-block">
                                    <h6 class="card-title font-weight-bold" style="text-align: left;cursor: pointer">{{ $shop->name }}</h6>
                                    <p class="fs-12">{{$shop->address}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @if(!$first_loop)
                        <table class="table aiz-table footable footable-1 breakpoint-xl">
                            <tbody>
                            <tr class="footable-empty">
                                <td colspan="8">
                                    {{__('Nothing found')}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
              <hr style="border-top: 8px solid rgba(0,0,0,.1);">
                <div class="hot">
                    <div class="mt-3 hot_d">
                        <p>Normal Stores</p>
                    </div>
                    <div class="owl-carousel owl-theme products_caresoul_owl mt-4">
                        @php
                            $second_loop = false;
                        @endphp
                        @foreach ($merchants['merchants'] as $key => $value)
                            @php
                                $merchant = \App\User::find($value->id);
                                $shop = $merchant->shop;
                            @endphp
                        @if($merchant->is_recommended == 0)
                        @php $second_loop = true; @endphp
                        <div class="item">
                            <div class="card voucher_btn" data-shop_name="{{$shop->name}}" data-merchant_id="{{$shop->user_id}}">
                                <img class="card-img-top lazyload" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                     data-src="@if ($merchant->shop->logo !== null) {{ uploaded_asset($shop->logo) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                                     alt="{{ $shop->name }}">
                                <div class="card-block">
                                    <h6 class="card-title font-weight-bold" style="text-align: left;cursor: pointer">{{ $shop->name }}</h6>
                                    <p class="fs-12">{{$shop->address}}</p>
                                </div>
                            </div>
                        </div>
                       @endif
                     @endforeach
                    @if(!$second_loop)
                        <table class="table aiz-table footable footable-1 breakpoint-xl">
                            <tbody>
                            <tr class="footable-empty">
                                <td colspan="8">
                                    {{__('Nothing found')}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    <center>
        <table class="table aiz-table footable footable-1 breakpoint-xl">
            <tbody>
            <tr class="footable-empty">
                <td colspan="8">
                    {{__('Nothing found')}}
                </td>
            </tr>
            </tbody>
        </table>
    </center>
@endif
<!-- owl-carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    if($(".products_caresoul_owl").length) {
        $('.products_caresoul_owl').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            dots: false,
            smartSpeed: 900,
            navText: ['<div class="nav-btn prev-slide"><i class="las la-angle-left"></i></div>', '<div class="nav-btn next-slide"><i class="las la-angle-right"></i></div>'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });
    }
</script>

