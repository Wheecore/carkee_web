@extends('backend.layouts.app')
@section('title', translate('Car Wash Active Packages'))
@section('content')

    <style>
        .badge-danger,.badge-success,.badge-warning {width: auto;}
    </style>
    <div class="card">
        <div class="card-header row">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('Car Wash Membership') }}</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label>{{ translate('Name') }}</label>
                    <p>{{ $membership->name }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="">{{ translate('Email') }}</label>
                    <p>{{ $membership->email }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="">{{ translate('Phone') }}</label>
                    <p>{{ $membership->phone }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="">{{ translate('Car Plate') }}</label>
                    <p>{{ $membership->car_plate }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="">{{ translate('Membership Fee') }}</label>
                    <p>{{ format_price($membership->amount) }}</p>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="">{{ translate('Date') }}</label>
                    <p>{{ convert_datetime_to_local_timezone($membership->created_at, user_timezone(Auth::id())) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header row">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('Car Wash Active Packages') }}</h5>
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>{{ translate('Product') }}</th>
                        <th>{{ translate('Usage Limit') }}</th>
                        <th>{{ translate('Usage') }}</th>
                        <th>{{ translate('Warranty') }}</th>
                        <th>{{ translate('Amount') }}</th>
                        <th>{{ translate('Membership Fee') }}</th>
                        <th>{{ translate('Car Plate') }}</th>
                        <th>{{ translate('Car Model') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th>{{ translate('Date') }}</th>
                        <th>{{ translate('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->product }}</td>
                            <td>
                                @if ($payment->ptype == 'M')
                                    {{ translate('Unlimited') }}
                                @else
                                    {{ $payment->usage_limit }}
                                @endif
                            </td>
                            <td>
                                @if ($payment->ptype == 'M')
                                    {{ translate('Unlimited') }}
                                @else
                                    {{ $payment->used_usage_limit }}
                                @endif
                            </td>
                            <td>
                                @if ($payment->created_at != $payment->updated_at && $payment->warranty)
                                    {{ $payment->warranty }} {{ ($payment->warranty <= 1) ? translate('year') : translate('years') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ format_price($payment->amount) }}</td>
                            <td>{{ format_price($payment->membership_fee) }}</td>
                            <td>{{ $payment->car_plate }}</td>
                            <td>{{ $payment->model_name }}</td>
                            <td><span class="badge badge-success">{{ translate('Paid') }}</span></td>
                            <td>{{ convert_datetime_to_local_timezone($payment->created_at, user_timezone(Auth::id())) }}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-info btn-circle btn-sm btn-update-usage" data-toggle="modal" data-target="#update-modal" data-id="{{ $payment->id }}" data-usage="{{ $payment->usage_limit }}">
                                    {{ translate('Update') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="update-modal" class="modal fade">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{translate('Update Car Wash')}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('car-washes-usage.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">{{ translate('Usage Limit') }}</label>
                            <span class="text-danger"> *</span>
                            <input type="number" step="any" id="usage_limit" name="usage_limit" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary mt-2">{{ translate('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')

    <script>
        $(document).on('click', '.btn-update-usage', function () {
            $("#id").val($(this).data("id"));
            $("#usage_limit").val($(this).data("usage"));
        });
    </script>

@endsection
