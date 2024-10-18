@if(count($m_vouchers) > 0)
@foreach($m_vouchers as $m_voucher)
<div class="row">
        <div class="col-md-12 mt-3">
            <div class="row category-card">
                <div class="col-6">
                    <a href="{{route('voucher.details',$m_voucher->id)}}" target="_blank">
                    <img class="img-fluid lazyload" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                         data-src="@if ($m_voucher->image !== null) {{ uploaded_asset($m_voucher->image) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                         alt="">
                    </a>
                </div>
                <div class="col-6" style="margin-left: -20px;">
                    <h5><a href="{{route('voucher.details',$m_voucher->id)}}" style="color: black" target="_blank">{{$m_voucher->voucher_code }}</a></h5>
                    <h6>{{single_price($m_voucher->amount)}} OFF</h6>
                    <p class="fs-13">{{$shop_name}}</p>
                </div>
            </div>
        </div>
    </div>
@if(!$loop->last)
    <hr style="border-top: 2px solid rgba(0,0,0,.1);">
@endif
@endforeach
@else
    <div class="mt-4">
        <span class="alert alert-info" style="color: black;font-size: 14px;">No vouchers found</span>
    </div>
@endif
