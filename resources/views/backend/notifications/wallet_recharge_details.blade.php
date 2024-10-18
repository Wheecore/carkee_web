@extends('backend.layouts.app')
@section('title', translate('Transaction Details'))
@section('content')

    <div class="card">
        <div class="card-header">
            <h1 class="h2 fs-16 mb-0">{{ translate('Transaction Details') }}</h1>
        </div>
        <div class="card-body">
            <hr class="new-section-sm bord-no">
            <div class="row">
                <div class="col-lg-12 table-responsive">
                    <h6>Transaction Details</h6>
                        <table class="table table-bordered aiz-table invoice-summary">
                            <thead>
                                <tr class="bg-trans-dark">
                                    <th width="10%">{{ translate('Amount') }}</th>
                                    <th width="10%">{{ translate('User Name') }}</th>
                                    <th class="text-uppercase">{{ ($details->type == 'add')?translate('Recharge By'):translate('Deduct By') }}</th>
                                    @if($details->type == 'add')
                                    <th class="min-col text-center text-uppercase">{{ translate('Transaction ID') }}</th>
                                    <th class="min-col text-center text-uppercase">{{ translate('Payment Method') }}</th>
                                    @endif
                                    <th class="min-col text-center text-uppercase">{{ translate('Remarks') }}</th>
                                    <th class="min-col text-center text-uppercase">{{ translate('Created') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $payment_data = json_decode($details->payment_details);
                                @endphp
                                    <tr>
                                        <td>{{ format_price($details->amount) }}</td>
                                        <td>{{ $details->receiver_name }} ({{ $details->receiver_email }})</td>
                                        <td>{{ ($details->user_id != $details->charge_by)?$details->name.' ('.$details->email.')':'self' }}</td>
                                        @if($details->type == 'add')
                                        <td class="text-center">{{ (isset($payment_data->transid))?$payment_data->transid:'' }}</td>
                                        <td class="text-center">{{ $details->payment_method }}</td>
                                        @endif
                                        <td class="text-center">{{ $details->remarks }}</td>
                                        <td class="text-center">{{ $details->created_at ? convert_datetime_to_local_timezone($details->created_at, user_timezone(Auth::id())) : '' }}</td>
                                    </tr>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

@endsection
