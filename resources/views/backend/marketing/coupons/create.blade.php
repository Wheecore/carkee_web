@extends('backend.layouts.app')
@section('title', translate('Coupon Information'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Coupon Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('coupon.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('coupon.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="name">{{ translate('Coupon Type') }}</label>
                        <div class="col-lg-9">
                            <select name="coupon_type" id="coupon_type" class="form-control aiz-selectpicker"
                                onchange="coupon_form()" required>
                                <option value="">{{ translate('Select One') }}</option>
                                <option value="product_base">{{ translate('For Products') }}</option>
                                <option value="cart_base">{{ translate('For Total Orders') }}</option>
                                <option value="gift_base">{{ translate('For Products as Gift') }}</option>
                                <option value="warranty_reward">{{ translate('For Warranty Rewards') }}</option>
                            </select>
                        </div>
                    </div>

                    <div id="coupon_form">

                    </div>
                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                    </from>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script type="text/javascript">
        function coupon_form() {
            var coupon_type = $('#coupon_type').val();
            $.post('{{ route('coupon.get_coupon_form') }}', {
                _token: '{{ csrf_token() }}',
                coupon_type: coupon_type
            }, function(data) {
                $('#coupon_form').html(data);
            });
        }
    </script>

@endsection
