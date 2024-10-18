@extends('backend.layouts.app')
@section('title', translate('Refferal Coupons'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Refferal Coupons') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Coupon Code') }}</th>
                        <th>{{ translate('User Name') }}</th>
                        <th>{{ translate('Amount') }}</th>
                        <th>{{ translate('Created Date') }}</th>
                        <th>{{ translate('End Date') }}</th>
                        <th>{{ translate('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($refferal_coupons as $key => $refferal_coupon)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $refferal_coupon->code }}</td>
                            <td>{{ $refferal_coupon->name }}</td>
                            <td>{{ single_price($refferal_coupon->discount) }}</td>
                            <td>{{ date(env('DATE_FORMAT'), $refferal_coupon->start_date) }}</td>
                            <td>{{ date(env('DATE_FORMAT'), $refferal_coupon->end_date) }}</td>
                            <td>
                            <span class="alert alert-info">{{ ($refferal_coupon->limit > 0)?'Not Used':'Used' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $refferal_coupons->links() }}
            </div>
        </div>
    </div>

@endsection
