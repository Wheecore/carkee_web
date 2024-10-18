@extends('backend.layouts.app')
@section('title', translate('Add Car Wash Order'))
@section('content')

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header row">
                    <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Add Car Wash Order') }}
                        <a class="btn btn-primary" href="{{ route('car-wash.memberships') }}" style="float: right"><i class="las la-arrow-left mr-1"></i>Back</a>
                    </h5>
                    </div>
                </div>
                <div class="card-body">
                    @include('backend.inc.error')
                    <form class="form-horizontal" action="{{ route('store-car-washes-order') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Select Customer') }}</label>
                            <div class="col-md-9">
                                <select name="user_id" id="user_id" class="form-control" onchange="get_user_carlist()" required>
                                    <option value="">{{ translate('Choose') }}</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} / {{ $user->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Select Customer Car') }}</label>
                            <div class="col-md-9">
                                <select name="carlist_id" id="carlist_id" class="form-control" onchange="get_carwash_products_on_carlist()" required>
                                    <option value="">{{ translate('Choose') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Select Car Wash') }}</label>
                            <div class="col-md-9">
                                <select name="car_wash_product_id" id="car_wash_product_id" class="form-control" onchange="get_carwash_products_attributes()" required>
                                    <option value="">{{ translate('Choose') }}</option>
                                </select>
                            </div>
                        </div>
                        <div id="extra-attributes" class="d-none">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Product Type') }}</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="p-type" disabled>
                                        <option value=""></option>
                                        <option value="S">{{ translate('Subscription') }}</option>
                                        <option value="M">{{ translate('Membership') }}</option>
                                        <option value="O">{{ translate('One Time') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Amount') }}</label>
                                <div class="col-md-9">
                                    <input type="text" value="" id="amount" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">{{ translate('Membership Fee') }}</label>
                                <div class="col-md-9">
                                    <input type="text" value="" id="membership-fee" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">{{ translate('Usage Limit') }}</label>
                            <div class="col-md-9">
                                <input type="number" step="any" placeholder="{{ translate('usage_limit') }}" value="{{ old('usage_limit') ?? 0 }}" id="usage_limit" name="usage_limit" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script>
        function get_user_carlist() {
            $('#extra-attributes').addClass('d-none');
            $.post(SITE_URL + '/get-user-carlist', {
                _token: CSRF,
                user_id: $('#user_id').find(":selected").val()
            }, function(data) {
                $('#carlist_id').html('');
                $('#carlist_id').html(data);
            });
        }
        function get_carwash_products_on_carlist() {
            $('#extra-attributes').addClass('d-none');
            $.post(SITE_URL + '/get-carwash-products-on-carlist', {
                _token: CSRF,
                brand_id: $('#carlist_id').find(":selected").data('brand'),
                model_id: $('#carlist_id').find(":selected").data('model'),
            }, function(data) {
                $('#car_wash_product_id').html('');
                $('#car_wash_product_id').html(data);
            });
        }
        function get_carwash_products_attributes() {
            $('#extra-attributes').removeClass('d-none');
            $('#p-type option[value="' + $('#car_wash_product_id').find(":selected").data('ptype') + '"]').attr("selected", "selected");
            $('#amount').val($('#car_wash_product_id').find(":selected").data('amount'));
            $('#membership-fee').val($('#car_wash_product_id').find(":selected").data('membership'));
            $('#usage_limit').val($('#car_wash_product_id').find(":selected").data('usage'));
        }
    </script>

@endsection
