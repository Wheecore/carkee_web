@extends('backend.layouts.app')
@section('title', translate('Gift Codes History'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-md-right">
                <a href="#" data-toggle="modal" data-target="#assign-codes" class="btn btn-circle btn-info">
                    <span>{{ translate('Assign Gift Codes') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">

        <form class="" id="sort_deals" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('Gift Codes History') }}</h5>
            </div>
            <div class="col-lg-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="redeem_status">
                    <option value="">{{ translate('--Status Filter--') }}</option>
                    <option value="redeem" @if ($redeem_status == 'redeem') selected @endif>
                        {{ translate('Redeemed') }}</option>
                    <option value="non_redeem" @if ($redeem_status == 'non_redeem') selected @endif>
                        {{ translate('Non Redeemed') }}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search"
                        name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                        placeholder="{{ translate('Type & hit Enter') }}">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>
        </form>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table p-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Code') }}</th>
                            <th>{{ translate('Category') }}</th>
                            <th>{{ translate('Start Date') }}</th>
                            <th>{{ translate('End Date') }}</th>
                            <th>{{ translate('Discount Amount') }}</th>
                            <th>{{ translate('Given To') }}</th>
                            <th>{{ translate('Redeem By') }}</th>
                            <th>{{ translate('Given Date') }}</th>
                            <th>{{ translate('Redeem Date') }}</th>
                            <th width="10%">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons_history as $key => $coupon)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td> {{ ucfirst(str_replace("_"," ",$coupon->category)) }}</td>
                                <td>{{ date(env('DATE_FORMAT'), $coupon->start_date) }}</td>
                                <td>{{ date(env('DATE_FORMAT'), $coupon->end_date) }}</td>
                                <td>{{ format_price($coupon->discount_amount) }}</td>
                                <td>@if($coupon->given_user_email) {{ $coupon->given_user_name }} ({{ $coupon->given_user_email }}) @endif</td>
                                <td>@if($coupon->reedemer_user_email) {{ $coupon->reedemer_user_name }} ({{ $coupon->reedemer_user_email }}) @endif</td>
                                <td>{{ $coupon->created_at ? convert_datetime_to_local_timezone($coupon->created_at, $timezone) : '' }}</td>
                                <td>{{ $coupon->redeem_date ? convert_datetime_to_local_timezone($coupon->redeem_date, $timezone) : '' }}</td>
                                <td class="text-right d-flex">
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('gift-codes-history.destroy', $coupon->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $coupons_history->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
    <div class="modal fade" id="assign-codes">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Assign Gift Codes') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <form action="{{ route('gift-code.assign') }}" method="post">
                    @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label>User Email</label>
                            <input type="email" class="form-control" name="email" placeholder="{{ translate('Enter user email here') }}" required>
                        </div>
                        <div class="form-group mb-5">
                            <label>Gift Codes</label>
                            <select name="gift_codes[]" class="form-control aiz-selectpicker"
                            data-placeholder="{{ translate('Choose Codes') }}" data-live-search="true"
                            data-selected-text-format="count" multiple required>
                            @foreach($coupons as $coupon)
                            <option value="{{ $coupon->id }}">{{ $coupon->code }} (From {{ date(env('DATE_FORMAT'), $coupon->start_date) }} To {{ date(env('DATE_FORMAT'), $coupon->end_date) }})</option>
                            @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ translate('Proceed') }}</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function assign_codes(id) {
            $('#wallet-adjustment').modal('show', {
                backdrop: 'static'
            });
            $('#user_id').val(id);
    }
</script>
@endsection
