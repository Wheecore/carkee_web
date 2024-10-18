@extends('backend.layouts.app')
@section('title', translate('Wallet Payments'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-right">
                <a href="javascript:void(0);" class="btn btn-circle btn-info" data-toggle="modal" data-target="#add-modal">
                    <span>{{ translate('Add New Amount') }}</span>
                </a>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="GET">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-md-0 h6">{{ translate('Wallet Payments') }}</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type order code & Enter') }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                    <th width="20%">{{ translate('ID') }}</th>
                                    <th data-breakpoints="sm">{{ translate('Amount') }}</th>
                                    <th data-breakpoints="sm">{{ translate('Free Amount') }}</th>
                                    <th data-breakpoints="sm">{{ translate('Date') }}</th>
                                    <th data-breakpoints="sm">{{ translate('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->amount }}</td>
                                        <td>{{ $payment->free_amount }}</td>
                                        <td>{{ $payment->created_at ? convert_datetime_to_local_timezone($payment->created_at, user_timezone(Auth::id())) : '' }}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-soft-primary btn-icon btn-circle btn-sm btn-update" data-amount="{{ $payment->amount }}" data-free_amount="{{ $payment->free_amount }}" data-href="{{ route('wallet-amount.update', $payment->id) }}" title="{{ translate('Edit') }}" data-toggle="modal" data-target="#edit-modal">
                                                <i class="las la-edit"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{ route('wallet-amount.destroy', $payment->id) }}" title="Delete" data-toggle="modal" data-target="#delete-modal">
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
                </form>
            </div>
        </div>
    </div>

@endsection
@section('modal')

    <div id="add-modal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Add Amount') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('wallet-amount.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Amount') }} <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="number" min="0" step="0.01" name="amount" value="0" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Free Amount') }} <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="number" min="0" step="0.01" name="free_amount" value="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary mt-2">{{ translate('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="modal fade">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('Update Amount') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="" id="update-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Amount') }} <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="number" min="0" step="0.01" name="amount" id="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-from-label">{{ translate('Free Amount') }} <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input type="number" min="0" step="0.01" name="free_amount" id="free_amount" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger mt-2" data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary mt-2">{{ translate('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('modals.delete_modal')

@endsection
@section('script')

    <script>
        $(document).on('click', ".btn-update", function (e) {
            $("#amount").val($(this).data("amount"));
            $("#free_amount").val($(this).data("free_amount"));
            $("#update-form").attr("action", $(this).data("href"));
        });
    </script>

@endsection
