@extends('backend.layouts.app')
@section('title', translate('Add New Voucher'))
@section('content')

    <style>
        /* Style the input container */
        .input-container {
            display: flex;
        }

        /* Style the form icons */
        .icon {
            padding: 10px;
            background: dodgerblue;
            color: white;
            max-width: 41px;
            text-align: center;
            cursor: pointer;
        }
    </style>
    <div class="col-lg-11 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Voucher Information') }}</h5>
                <a class="btn btn-primary" href="{{ route('merchants-vouchers.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('merchants-vouchers.store') }}" method="POST" enctype="multipart/form-data"
                    id="choice_form">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Select Merchant') }} *</label>
                        <div class="col-sm-9">
                            <select class="form-control aiz-selectpicker" name="merchant_id" id="merchant_id"
                                data-live-search="true" required>
                                @foreach ($merchants as $merchant)
                                    <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="name">{{ translate('Voucher Code') }} *</label>
                        <div class="col-sm-9 input-container">
                            <input type="text" placeholder="{{ translate('unique voucher code') }}" id="voucher_code"
                                name="voucher_code" class="form-control input-field" required>
                            <svg aria-hidden="true" focusable="false" title="Generate Code" data-prefix="fas"
                                data-icon="magic" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                class="svg-inline--fa fa-magic fa-w-16 icon" onClick="generatepass()">
                                <path fill="currentColor"
                                    d="M224 96l16-32 32-16-32-16-16-32-16 32-32 16 32 16 16 32zM80 160l26.66-53.33L160 80l-53.34-26.67L80 0 53.34 53.33 0 80l53.34 26.67L80 160zm352 128l-26.66 53.33L352 368l53.34 26.67L432 448l26.66-53.33L512 368l-53.34-26.67L432 288zm70.62-193.77L417.77 9.38C411.53 3.12 403.34 0 395.15 0c-8.19 0-16.38 3.12-22.63 9.38L9.38 372.52c-12.5 12.5-12.5 32.76 0 45.25l84.85 84.85c6.25 6.25 14.44 9.37 22.62 9.37 8.19 0 16.38-3.12 22.63-9.37l363.14-363.15c12.5-12.48 12.5-32.75 0-45.24zM359.45 203.46l-50.91-50.91 86.6-86.6 50.91 50.91-86.6 86.6z"
                                    class=""></path>
                            </svg>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label" for="email">{{ translate('Total No Of Usage') }} *</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="{{ translate('total no of usage like 10,5,4') }}"
                                id="total_limit" name="total_limit" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{ translate('Amount') }}
                            <span>({{ __('Currency is : RM') }})</span> *</label>
                        <div class="col-sm-9">
                            <input type="number" step="any" placeholder="{{ translate('discount to be given') }}"
                                name="amount" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-from-label">{{ translate('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea class="aiz-text-editor" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="signinSrEmail">{{ translate('Thumbnail Image') }}
                            <small>(300x300)</small></label>
                        <div class="col-sm-9">
                            <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse') }}</div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="thumbnail_img" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
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
        function generatepass() {
            var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$!*+';
            var result = '';
            var length = 10;
            for (var i = 0; i < length; i++) {
                result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
            }
            $("#voucher_code").val(result);
        }
    </script>

@endsection
