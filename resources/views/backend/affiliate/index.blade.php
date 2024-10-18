@extends('backend.layouts.app')
@section('title', translate('Referral'))
@section('content')

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 h6">{{ translate('Referral Configurations') }}</h6>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('affiliate.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('Referral Status') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input value="1" name="status" type="checkbox" {{ ($data && $data->status == 1)?'checked':'' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('Amount on First purchase after user registration') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="number" min="0" step="0.01" class="form-control"
                                    name="first_purchase_amount" value="{{ ($data)?$data->first_purchase_amount:0 }}" placeholder="Amount on First purchase after user registration" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('Minimum Order Amount') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="number" min="0" step="0.01" class="form-control"
                                name="minimum_purchase_amount" value="{{ ($data)?$data->minimum_purchase_amount:0 }}" placeholder="Minimum Order Amount"
                                required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label class="control-label">{{ translate('Coupon Expiry Months') }} (<small>e.g: 1 or 2</small>)</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="number" min="1" class="form-control"
                                name="expiry_months" value="{{ ($data && $data->expiry_months > 0)?$data->expiry_months:1 }}" placeholder="Coupon Expiry Months"
                                required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button type="submit" class="btn btn-sm btn-primary btn-circle">
                                {{ translate('Save') }}
                                <div class="spinner-border d-none" role="status"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
