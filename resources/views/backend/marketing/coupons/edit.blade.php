@extends('backend.layouts.app')
@section('title', translate('Coupon Information'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Coupon Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('coupon.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <form action="{{ route('coupon.update', $coupon->id) }}" method="POST">
                <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $coupon->id }}" id="id">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="name">{{ translate('Coupon Type') }}</label>
                        <div class="col-lg-9">
                            <select name="coupon_type" id="coupon_type" class="form-control aiz-selectpicker"
                                onchange="coupon_form()" required>
                                @if ($coupon->type == 'product_base')
                                    )
                                    <option value="product_base" selected>{{ translate('For Products') }}</option>
                                @elseif ($coupon->type == 'cart_base')
                                    <option value="cart_base">{{ translate('For Total Orders') }}</option>
                                @elseif ($coupon->type == 'gift_base')
                                    <option value="gift_base">{{ translate('For Products as Gift') }}</option>
                                @elseif ($coupon->type == 'warranty_reward')
                                    <option value="warranty_reward">{{ translate('For Warranty Rewards') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div id="coupon_form">

                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
            </form>

        </div>
    </div>


@endsection
@section('script')

    <script type="text/javascript">
        function coupon_form() {
            var coupon_type = $('#coupon_type').val();
            var id = $('#id').val();
            $.post('{{ route('coupon.get_coupon_form_edit') }}', {
                _token: '{{ csrf_token() }}',
                coupon_type: coupon_type,
                id: id
            }, function(data) {
                $('#coupon_form').html(data);
            });
        }

        $(document).ready(function() {
            coupon_form();
        });
    </script>

@endsection
