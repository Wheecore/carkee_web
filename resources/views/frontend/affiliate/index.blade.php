@extends('frontend.layouts.user_panel')
@section('panel_content')
<section>
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-md-12">
                <div class="main-content">
                    @if (\App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && \App\Models\AffiliateConfig::where('status', 1)->first()->status)
                    <div class="row">
                        @php
                        if(Auth::user()->referral_code == null){
                        Auth::user()->referral_code = substr(Auth::user()->id.Str::random(10), 0, 10);
                        Auth::user()->save();
                        }
                        $referral_code = Auth::user()->referral_code;
                        $referral_code_url = URL::to('/users/registration')."?referral_code=$referral_code";
                        @endphp
                        <div class="col">
                            <div class="form-box bg-white mt-4 card-r">
                                <div class="form-box-content p-3">
                                    <div class="form-group">
                                        <textarea id="referral_code_url" class="form-control" readonly type="text">{{$referral_code_url}}</textarea>
                                    </div>
                                    <button type=button id="ref-cpurl-btn" class="btn btn-primary" data-attrcpy="{{__('Copied')}}" onclick="copyToClipboard('url')">{{__('Copy Url')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
<script>
    function copyToClipboard(btn) {
        var el_url = document.getElementById('referral_code_url');
        var c_u_b = document.getElementById('ref-cpurl-btn');
        if (btn == 'url') {
            if (el_url != null && c_u_b != null) {
                el_url.select();
                document.execCommand('copy');
                c_u_b.innerHTML = c_u_b.dataset.attrcpy;
            }
        }
    }
</script>
@endsection
