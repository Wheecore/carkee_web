@extends('backend.layouts.app')
@section('title', translate('Coupon Information Update'))
@section('content')

    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h6 class="h6 mb-md-0">{{ translate('Edit Coupon') }}</h6>
                <a class="btn btn-primary" href="{{ route('emergency_coupon.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('emergency_coupon.update', $coupon->id) }}" method="POST">
                    @csrf
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label" for="coupon_code">{{ translate('Coupon code') }}</label>
                    <div class="col-lg-9">
                        <input type="text" value="{{ $coupon->code }}" id="coupon_code" name="coupon_code" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-from-label">{{ translate('Discount') }}</label>
                    <div class="col-lg-6">
                        <input type="number" lang="en" min="0" step="0.01" placeholder="{{ translate('Discount') }}"
                            name="discount" class="form-control" value="{{ $coupon->discount }}" required>
                    </div>
                    <div class="col-lg-3">
                        <select class="form-control aiz-selectpicker" name="discount_type">
                            <option value="amount">{{ translate('Amount') }}</option>
                        </select>
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
                
                <div class="form-group row">
                    <label class="col-sm-3 control-label" for="start_date">{{ translate('Usage Limit') }}</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="limit" placeholder="" value="{{ $coupon->limit }}" required>
                    </div>
                </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                </div>
            </form>
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
