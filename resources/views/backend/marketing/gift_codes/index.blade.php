@extends('backend.layouts.app')
@section('title', translate('Gift Codes'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-md-right">
                <button onclick="export_data()" class="btn btn-circle btn-info">
                    <span id="btn_span">{{ translate('Export Excel') }}</span>
                </button>
                <a href="{{ route('gift-codes.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Gift Code') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form action="" method="GET">
        <div class="card-header row">
            <div class="col-md-5 col-12">
                <h5 class="mb-0 h6">{{ translate('Gift Codes') }}</h5>
            </div>
            <div class="col-md-3 col-5">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}"
                        name="date" id="date" placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y"
                        data-separator=" to " data-advanced-range="true" autocomplete="off">
            </div>
            <div class="col-md-3 col-5">
                    <div class="box-inline pad-rgt pull-left">
                            <input type="text" class="form-control" id="search" name="search"
                                @isset($sort_search) value="{{ $sort_search }}" @endisset
                                placeholder="{{ translate('Type code & Enter') }}">
                    </div>
            </div>
            <div class="col-md-1 col-2" style="right: 8px;">
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
                            <th width="10%">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $key => $coupon)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td> {{ ucfirst(str_replace("_"," ",$coupon->category)) }}</td>
                                <td>{{ date(env('DATE_FORMAT'), $coupon->start_date) }}</td>
                                <td>{{ date(env('DATE_FORMAT'), $coupon->end_date) }}</td>
                                <td>{{ format_price($coupon->discount_amount) }}</td>
                                <td class="text-right d-flex">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm mr-1"
                                        href="{{ route('gift-codes.edit', encrypt($coupon->id)) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('gift-codes.destroy', $coupon->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $coupons->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
@section('script')
<script>
    function export_data()
    {
        $("#btn_span").html("Loading...");
        var date = $("#date").val();
        $.ajax({
            xhrFields: {
                responseType: 'blob',
            },
            type: 'get',
            url: '{{ url('admin/export-gift-codes') }}',
            data: {
                date: date
            },
            success: function(result, status, xhr) {

                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'gift_codes.xlsx');

                // The actual download
                var blob = new Blob([result], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;

                document.body.appendChild(link);

                link.click();
                document.body.removeChild(link);
                $("#btn_span").html("Export Excel");
            }
        });
    }
</script>
@endsection
