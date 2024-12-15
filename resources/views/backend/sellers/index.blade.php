@extends('backend.layouts.app')
@section('title', translate('All Workshops'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('All Workshops') }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('sellers.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Workshop') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_sellers" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('All Workshops') }}</h5>
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
                    <select class="form-control aiz-selectpicker" name="approved_status" id="approved_status"
                        onchange="sort_sellers()">
                        <option value="">{{ translate('Filter by Approval') }}</option>
                        <option value="1"
                            @isset($approved) @if ($approved == 'paid') selected @endif @endisset>
                            {{ translate('Approved') }}</option>
                        <option value="0"
                            @isset($approved) @if ($approved == 'unpaid') selected @endif @endisset>
                            {{ translate('Non-Approved') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type name or email & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
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
                            <th>{{ translate('PIC Phone') }}</th>
                            <th>{{ translate('PIC Email Address') }}</th>
                            <th data-breakpoints="lg">{{ translate('Workshop Address') }}</th>
                            <th width="10%">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellers as $key => $seller)
                            @if ($seller->user != null && $seller->user->shop != null)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $seller->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($seller->user->banned == 1)
                                            <i class="las la-ban text-danger" aria-hidden="true"></i>
                                        @endif {{ $seller->user->shop->name }}
                                    </td>
                                    <td>{{ $seller->user->phone }}</td>
                                    <td>{{ $seller->user->email }}</td>
                                    <td>{{ $seller->user->shop->address }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                                data-toggle="dropdown" href="javascript:void(0);" role="button"
                                                aria-haspopup="false" aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                <a href="{{ route('sub_sellers.index',$seller->user_id) }}" class="dropdown-item"
                                                    style="padding: 0.5rem 0.5rem;">
                                                    {{ translate('Sub Accounts') }}
                                                </a>
                                                <a href="#" onclick="show_seller_profile('{{ $seller->id }}');"
                                                    class="dropdown-item" style="padding: 0.5rem 0.5rem;">
                                                    {{ translate('Profile') }}
                                                </a>
                                                <a href="{{ route('sellers.login', encrypt($seller->id)) }}"
                                                    class="dropdown-item" style="padding: 0.5rem 0.5rem;">
                                                    {{ translate('Login as this Workshop') }}
                                                </a>
                                                <a href="{{ route('sellers.edit', encrypt($seller->id)) }}"
                                                    class="dropdown-item" style="padding: 0.5rem 0.5rem;">
                                                    {{ translate('Edit') }}
                                                </a>
                                                <a href="#" class="dropdown-item confirm-delete"
                                                    data-href="{{ route('sellers.destroy', $seller->id) }}" class=""
                                                    style="padding: 0.5rem 0.5rem;">
                                                    {{ translate('Delete') }}
                                                </a>
                                                @if ($seller->user->banned != 1)
                                                <a href="#" class="dropdown-item" style="padding: 0.5rem 0.5rem;"
                                                    onclick="confirm_ban('{{ route('sellers.ban', $seller->id) }}');">
                                                    {{ translate('Ban this Workshop') }}
                                                </a>
                                                @else
                                                <a href="#" class="dropdown-item" style="padding: 0.5rem 0.5rem;"
                                                    onclick="confirm_unban('{{ route('sellers.ban', $seller->id) }}');">
                                                    {{ translate('Unban this Workshop') }}
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
                <div class="aiz-pagination">
                    {{ $sellers->appends(request()->input())->links() }}
                </div>
            </div>
        </form>
    </div>
@endsection
@section('modal')
    <!-- Delete Modal -->
    @include('modals.delete_modal')

    <!-- Workshop Profile Modal -->
    <div class="modal fade" id="profile_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="profile-modal-content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm-ban">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h6">{{ translate('Confirmation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ translate('Do you really want to ban this Workshop?') }}</p>
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
                    <p>{{ translate('Do you really want to unban this Workshop?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">{{ translate('Cancel') }}</button>
                    <a type="button" id="confirmationunban" class="btn btn-primary">{{ translate('Proceed!') }}</a>
                </div>
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

        function show_seller_profile(id) {
            $.post('{{ route('sellers.profile_modal') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function(data) {
                $('#profile_modal #profile-modal-content').html(data);
                $('#profile_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }

        function sort_sellers(el) {
            $('#sort_sellers').submit();
        }

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
            var data = new FormData($('#sort_sellers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('bulk-seller-delete') }}",
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
