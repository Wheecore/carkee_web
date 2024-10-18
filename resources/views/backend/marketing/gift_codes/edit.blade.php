@extends('backend.layouts.app')
@section('title', translate('Gift Code Information'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Gift Code Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('gift-codes.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <form action="{{ route('gift-codes.update', $coupon->id) }}" method="POST">
                <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ $coupon->id }}" id="id">
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="name">{{ translate('Category') }}</label>
                        <div class="col-lg-9">
                            <select name="category" class="form-control aiz-selectpicker" required>
                                <option value="">{{ translate('Select One') }}</option>
                                <option value="event" {{ ($coupon->category == 'event')?'selected':'' }}>{{ translate('Event') }}</option>
                                <option value="customer" {{ ($coupon->category == 'customer')?'selected':'' }}>{{ translate('Customer') }}</option>
                                <option value="workshop" {{ ($coupon->category == 'workshop')?'selected':'' }}>{{ translate('Workshop') }}</option>
                                <option value="mall" {{ ($coupon->category == 'mall')?'selected':'' }}>{{ translate('Mall') }}</option>
                                <option value="car_wash_center" {{ ($coupon->category == 'car_wash_center')?'selected':'' }}>{{ translate('Car Wash Center') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="coupon_code">{{ translate('Gift Code') }}</label>
                        <div class="col-lg-9">
                            <input type="text" value="{{ $coupon->code }}" name="code" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{ translate('Discount Amount') }}</label>
                        <div class="col-lg-7">
                            <input type="number" lang="en" min="0" step="0.01" placeholder="{{ translate('Discount Amount') }}"
                                name="amount" class="form-control" value="{{ $coupon->discount_amount }}" required>
                        </div>
                    </div>
                    @php
                        $start_date = date('m/d/Y', $coupon->start_date);
                        $end_date = date('m/d/Y', $coupon->end_date);
                    @endphp
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="start_date">{{ translate('Date') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control aiz-date-range" value="{{ $start_date . ' - ' . $end_date }}"
                                name="date_range" placeholder="Select Date">
                        </div>
                    </div>
                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
    $(document).ready(function() {
        $('.aiz-selectpicker').selectpicker();
        $('.aiz-date-range').daterangepicker();
    });
    </script>
@endsection
