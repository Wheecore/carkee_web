@extends('backend.layouts.app')
@section('title', translate('Reschedule Payments'))
@section('content')

    <div class="col-lg-12">
        <div class="card">
            <form class="" id="sort_merchants" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">{{ translate('Reschedule Payments') }}</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" id="search"
                                name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                                placeholder="{{ translate('Type order code & Enter') }}">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th width="20%">{{ translate('Order Code') }}</th>
                                <th data-breakpoints="sm">{{ translate('Customer Name') }}</th>
                                <th data-breakpoints="sm">{{ translate('Amount') }}</th>
                                <th data-breakpoints="sm">{{ translate('Date') }}</th>
                                <th data-breakpoints="sm">{{ translate('Transaction ID') }}</th>
                                <th data-breakpoints="sm">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $key => $payment)
                                <tr>                                  
                                    <td>{{ $payment->code }}</td>
                                    <td>{{ $payment->name }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->created_at ? convert_datetime_to_local_timezone($payment->created_at, user_timezone(Auth::id())) : '' }}</td>
                                    @php $details = json_decode($payment->details); @endphp
                                    <td>{{ ($details)?$details->transid:'' }}</td>
                                    <td>
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('reschedule.payment.destroy', $payment->id) }}" title="Delete">
                                           <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $payments->appends(request()->input())->links() }}
                    </div>
                </div>
                </from>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Delete Modal -->
    @include('modals.delete_modal')
@endsection
