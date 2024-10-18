@extends('backend.layouts.app')
@section('title', translate('Coupon Information Adding'))
@section('content')

    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="h6">{{ translate('Add new coupon') }}</h3>
                <a class="btn btn-primary" href="{{ route('emergency_coupon.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('emergency_coupon.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="coupon_code">{{ translate('Coupon code') }}</label>
                        <div class="col-lg-9">
                            <input type="text" placeholder="{{ translate('Coupon code') }}" value="{{ Str::random(10), 0, 10 }}"
                                name="coupon_code" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{ translate('Discount') }}</label>
                        <div class="col-lg-6">
                            <input type="number" lang="en" min="0" step="0.01" placeholder="{{ translate('Discount') }}"
                                name="discount" class="form-control" required>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-control aiz-selectpicker" name="discount_type">
                                <option value="amount">{{ translate('Amount') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="start_date">{{ translate('Date') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="Select Date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="start_date">{{ translate('Usage Limit') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" value="0" name="limit" required>
                        </div>
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
        $(document).ready(function() {
            $('.aiz-selectpicker').selectpicker();
            $('.aiz-date-range').daterangepicker();
        });
    </script>
@endsection
