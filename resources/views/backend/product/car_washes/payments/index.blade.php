@extends('backend.layouts.app')
@section('title', translate('Car Wash Payments'))
@section('content')

    <style>
        .badge-danger,.badge-success,.badge-warning {width: auto;}
    </style>
    <div class="card">
        <form action="" method="GET">
        <div class="card-header row">
            <div class="col">
                <h5 class="mb-0 h6">{{ translate('Car Wash Payments') }}</h5>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search"
                        name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                        placeholder="{{ translate('Type & Enter') }}">
                </div>
            </div>
        </div>
    </form>

        <div class="card-body">
        <div class="table-responsive">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>{{ translate('ID') }}</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Email') }}</th>
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
                        <th>{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->name }}</td>
                            <td>{{ $payment->email }}</td>
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
                            <td>
                                @if ($payment->status == 1)
                                    <span class="badge badge-success">{{ translate('Paid') }}</span>
                                @elseif ($payment->status == 2)
                                    <span class="badge badge-warning">{{ translate('Expired') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ translate('Unpaid') }}</span>
                                @endif
                            </td>
                            <td>{{ convert_datetime_to_local_timezone($payment->created_at, user_timezone(Auth::id())) }}</td>
                            <td>
                                @if ($payment->created_at != $payment->updated_at)
                                    <a href="{{ route('car-wash-warranty-card', encrypt($payment->id)) }}" class="btn btn-primary btn-circle btn-sm">
                                        {{ translate('Warranty Card') }}
                                    </a>
                                @endif
                                {{-- <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('car-washes.destroy', $payment->id) }}"
                                    title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            <div class="aiz-pagination">
                {{ $payments->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection
