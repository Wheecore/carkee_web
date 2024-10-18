@extends('backend.layouts.app')
@section('title', translate('Gift Code Information'))
@section('content')

    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Gift Code Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('gift-codes.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('gift-codes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="name">{{ translate('Category') }}</label>
                        <div class="col-lg-9">
                            <select name="category" class="form-control aiz-selectpicker" required>
                                <option value="">{{ translate('Select One') }}</option>
                                <option value="event">{{ translate('Event') }}</option>
                                <option value="customer">{{ translate('Customer') }}</option>
                                <option value="workshop">{{ translate('Workshop') }}</option>
                                <option value="mall">{{ translate('Mall') }}</option>
                                <option value="car_wash_center">{{ translate('Car Wash Center') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="name">{{ translate('Code Start Letter') }}</label>
                        <div class="col-lg-9">
                            <select name="first_letter" class="form-control aiz-selectpicker" required>
                                <option value="">{{ translate('Select One') }}</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="coupon_code">{{ translate('No Of Zeros In Start Of Code') }} (<small>Like 1, 2, 3</small>)</label>
                        <div class="col-lg-9">
                            <input type="number" placeholder="{{ translate('No Of Zeros In Start Of Code') }}"
                                name="zeros" class="form-control" required>
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label" for="coupon_code">{{ translate('No Of Codes') }}(<small>Like 10, 50, 100</small>)</label>
                        <div class="col-lg-9">
                            <input type="number" placeholder="{{ translate('No Of Codes') }}" 
                                name="no_of_codes" class="form-control" required>
                                {{-- <input type="number" placeholder="{{ translate('Last No') }}"
                                name="last_no" class="form-control" required style="width: 50%; display: inline"> --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-from-label">{{ translate('Discount Amount') }}</label>
                        <div class="col-lg-7">
                            <input type="number" lang="en" min="0" step="0.01" placeholder="{{ translate('Discount Amount') }}"
                                name="amount" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="start_date">{{ translate('Date') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="Select Date">
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
