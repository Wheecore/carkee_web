@extends('backend.layouts.app')
@section('title', translate('Merchants Vouchers'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-md-right">
                <a href="{{ route('merchants-vouchers.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Voucher') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <form id="sort_merchants" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">{{ translate('Merchants Vouchers') }}</h5>
                    </div>

                    <div class="dropdown mb-2 mb-md-0">
                        <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                            {{ translate('Bulk Action') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"
                                onclick="bulk_delete()">{{ translate('Delete selection') }}</a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" id="search"
                                name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                                placeholder="{{ translate('Type voucher code & Enter') }}">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <!--<th data-breakpoints="lg">#</th>-->
                                <th>
                                    <div class="form-group">
                                        <div class="aiz-checkbox-inline">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" class="check-all">
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </th>
                                <th width="20%">{{ translate('Merchant Name') }}</th>
                                <th data-breakpoints="sm">{{ translate('Voucher Code') }}</th>
                                <th data-breakpoints="sm">{{ translate('Used Limit') }}</th>
                                <th data-breakpoints="sm">{{ translate('No Of Used') }}</th>
                                <th data-breakpoints="sm">{{ translate('Amount') }}</th>
                                <th data-breakpoints="sm">{{ translate('Creation Date') }}</th>
                                <th data-breakpoints="sm">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($merchant_vouchers as $key => $voucher)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $voucher->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $voucher->merchant->name }}</td>
                                    <td>{{ $voucher->voucher_code }}</td>
                                    <td>{{ $voucher->total_limit }}</td>
                                    <td>{{ $voucher->used_count }}</td>
                                    <td>RM {{ $voucher->amount }}</td>
                                    <td>{{ convert_datetime_to_local_timezone($voucher->created_at, user_timezone(Auth::id())) }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                                data-toggle="dropdown" href="javascript:void(0);" role="button"
                                                aria-haspopup="false" aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                <a href="{{ route('merchants-vouchers.edit', encrypt($voucher->id)) }}"
                                                    class="dropdown-item">
                                                    {{ translate('Edit') }}
                                                </a>
                                                <a href="#" class="dropdown-item confirm-delete"
                                                    data-href="{{ route('merchants-vouchers.destroy', $voucher->id) }}"
                                                    class="">
                                                    {{ translate('Delete') }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $merchant_vouchers->appends(request()->input())->links() }}
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

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if (this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        function bulk_delete() {
            var data = new FormData($('#sort_merchants')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('bulk-merchant-vouchers-delete') }}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
