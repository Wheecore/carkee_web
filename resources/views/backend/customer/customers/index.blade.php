@extends('backend.layouts.app')
@section('title', translate('All Customers'))
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('All Customers') }}</h1>
        </div>
        <div class="col-md-6 text-md-right">
            <a href="{{ route('customers.create') }}" class="btn btn-circle btn-info">
                <span>{{ translate('Add New Customer') }}</span>
            </a>
        </div>
    </div>
</div>
    <div class="card">
        <form class="" id="sort_customers" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-0 h6">{{ translate('All Customers') }}</h5>
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
                            placeholder="{{ translate('Type email or name & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
            <div class="table-responsive">
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
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Email Address') }}</th>
                            <th>{{ translate('Primary Phone') }}</th>
                            <th>{{ translate('Secondary Phone') }}</th>
                            <th>{{ translate('Browse History') }}</th>
                            <th>{{ translate('Car Lists') }}</th>
                            <th>{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $customer)
                            @if ($customer->user != null)
                                <tr>
                                    <!--<td>{{ $key + 1 + ($customers->currentPage() - 1) * $customers->perPage() }}</td>-->
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $customer->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($customer->user->banned == 1)
                                            <i class="las la-ban text-danger" aria-hidden="true"></i>
                                        @endif {{ $customer->user->name }}
                                    </td>
                                    <td>{{ $customer->user->email }}</td>
                                    <td>{{ $customer->user->phone }}</td>
                                    <td>{{ $customer->user->phone2 }}</td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ route('admin.user.browse.history', $customer->user->id) }}"
                                            class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                            title="{{ translate('Browse History') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ route('customers.car_lists', $customer->user->id) }}"
                                            class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                            title="{{ translate('Car Lists') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                    </td>
                                    <td style="white-space: nowrap;">
                                        <a target="_blank" href="{{route('customers.family_members', encrypt($customer->user->id))}}" class="btn btn-soft-primary btn-sm" title="{{ translate('Edit Customer') }}">
                                            {{ translate('Family Members') }}
                                        </a>
                                        <a target="_blank" href="{{route('customers.wallet_history', encrypt($customer->user->id))}}" class="btn btn-soft-primary btn-sm" title="{{ translate('Edit Customer') }}">
                                            {{ translate('Wallet History') }}
                                        </a>
                                        <a href="{{route('customers.edit', encrypt($customer->id))}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Edit Customer') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        @if ($customer->user->banned != 1)
                                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                                onclick="confirm_ban('{{ route('customers.ban', $customer->id) }}');"
                                                title="{{ translate('Ban this Customer') }}">
                                                <i class="las la-user-slash"></i>
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                                onclick="confirm_unban('{{ route('customers.ban', $customer->id) }}');"
                                                title="{{ translate('Unban this Customer') }}">
                                                <i class="las la-user-check"></i>
                                            </a>
                                        @endif
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('customers.destroy', $customer->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
                <div class="aiz-pagination">
                    {{ $customers->appends(request()->input())->links() }}
                </div>
            </div>
        </form>
    </div>


    <div class="modal fade" id="confirm-ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Do you really want to ban this Customer?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a type="button" id="confirmation" class="btn btn-primary">{{ translate('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-unban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Do you really want to unban this Customer?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a type="button" id="confirmationunban" class="btn btn-primary">{{ translate('Proceed!') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
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

        function confirm_ban(url) {
            $('#confirm-ban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmation').setAttribute('href', url);
        }

        function confirm_unban(url) {
            $('#confirm-unban').modal('show', {
                backdrop: 'static'
            });
            document.getElementById('confirmationunban').setAttribute('href', url);
        }

        function bulk_delete() {
            var data = new FormData($('#sort_customers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('bulk-customer-delete') }}",
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
