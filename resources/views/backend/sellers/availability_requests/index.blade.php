@extends('backend.layouts.app')
@section('title', translate('Workshops Availability Requests'))
@section('content')

    <div class="card">
        <form class="" id="sort_requests" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Workshops Availability Requests') }}</h5>
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

                <div class="col-md-3 ml-auto">
                    <select class="form-control aiz-selectpicker" name="status" id="approved_status"
                        onchange="sort_requests()">
                        <option value="">{{ translate('Filter by status') }}</option>
                        <option value="Pending"
                            @isset($status) @if ($status == 'Pending') selected @endif @endisset>
                            {{ translate('Pending') }}</option>
                        <option value="Approved"
                            @isset($status) @if ($status == 'Approved') selected @endif @endisset>
                            {{ translate('Approved') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type date, month or year') }}">
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
                            <th>{{ translate('Workshop Name') }}</th>
                            <th>{{ translate('Date') }}</th>
                            <th data-breakpoints="lg">{{ translate('previous From Time') }}</th>
                            <th data-breakpoints="lg">{{ translate('previous To Time') }}</th>
                            <th data-breakpoints="lg">{{ translate('New From Time') }}</th>
                            <th data-breakpoints="lg">{{ translate('New To Time') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th width="10%">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $key => $request)
                            <tr>
                                <!--<td>{{ $key + 1 + ($requests->currentPage() - 1) * $requests->perPage() }}</td>-->
                                <td>
                                    <div class="form-group">
                                        <div class="aiz-checkbox-inline">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" class="check-one" name="id[]"
                                                    value="{{ $request->id }}">
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                @php
                                    $shop = \DB::table('shops')
                                        ->where('id', $request->shop_id)
                                        ->select('name')
                                        ->first();
                                @endphp
                                <td>{{ $shop ? $shop->name : '' }}</td>
                                <td>{{ $request->date }}</td>
                                <td>{{ $request->previous_from_time ? \Carbon\Carbon::parse($request->previous_from_time)->format('h: i a') : '' }}
                                </td>
                                <td>{{ $request->previous_to_time ? \Carbon\Carbon::parse($request->previous_to_time)->format('h: i a') : '' }}
                                </td>
                                <td>{{ $request->from_time ? \Carbon\Carbon::parse($request->from_time)->format('h: i a') : '-' }}
                                </td>
                                <td>{{ $request->to_time ? \Carbon\Carbon::parse($request->to_time)->format('h: i a') : '-' }}
                                </td>
                                <td>
                                    @if ($request->status == 'Pending')
                                        <button class="btn btn-sm btn-info">Pending</button>
                                    @else
                                        <button class="btn btn-sm btn-success">Approved</button>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                            data-toggle="dropdown" href="javascript:void(0);" role="button"
                                            aria-haspopup="false" aria-expanded="false">
                                            <i class="las la-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                            @if ($request->status == 'Pending')
                                                <a data-toggle="modal" data-target="#approve-request" href="#"
                                                    onclick="approveRequest('{{ $request->id }}')" class="dropdown-item">
                                                    {{ translate('Approve') }}
                                                </a>
                                            @endif
                                            <a href="#" class="dropdown-item confirm-delete"
                                                data-href="{{ route('bulk-request-delete', $request->id) }}"
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
                    {{ $requests->appends(request()->input())->links() }}
                </div>
            </div>
        </form>
    </div>
@endsection

@section('modal')
    <!-- Delete Modal -->
    @include('modals.delete_modal')

    <!-- approve request Modal -->
    <div class="modal fade" id="approve-request">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                    </button>
                </div>
                <form action="{{ route('request-approval') }}" method="post">
                    @csrf
                    <input type="hidden" name="request_id" id="request_id" value="">
                    <div class="modal-body">
                        <p>{{ translate('Do you really want to approve this time?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button class="btn btn-primary" type="submit">{{ translate('Proceed!') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        function sort_requests(el) {
            $('#sort_requests').submit();
        }

        function approveRequest(id) {
            $('#request_id').val(id);
        }

        function bulk_delete() {
            var data = new FormData($('#sort_requests')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('bulk-requests-delete') }}",
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
