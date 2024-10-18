@extends('backend.layouts.app')
@section('title', translate('Sub Accounts'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <span>{{ translate('Workshop Name') }}:</span>
                <h1 class="h3">{{ $shop_data->name }}</h1>
            </div>
            <div class="col-md-6 text-md-right">
                <a class="btn btn-primary" href="{{ route('sellers.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
                <a href="{{ route('sub_sellers.create', $seller_id) }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Sub Account') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <form class="" id="sort_sellers" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Sub Accounts') }}</h5>
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
                            placeholder="{{ translate('Type name or email & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
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
                            <th>{{ translate('Image') }}</th>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Phone') }}</th>
                            <th>{{ translate('Email Address') }}</th>
                            <th width="10%">{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sub_sellers as $key => $sub_seller)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $sub_seller->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td><img class="avatar avatar-sm" src="{{ ($sub_seller->avatar_original)?uploaded_asset($sub_seller->avatar_original):static_asset('assets/img/avatar-place.png') }}" alt=""></td>
                                    <td>
                                        @if ($sub_seller->banned == 1)
                                            <i class="las la-ban text-danger" aria-hidden="true"></i>
                                        @endif {{ $sub_seller->name }}
                                    </td>
                                    <td>{{ $sub_seller->phone }}</td>
                                    <td>{{ $sub_seller->email }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                                data-toggle="dropdown" href="javascript:void(0);" role="button"
                                                aria-haspopup="false" aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                <a href="{{ route('sub_sellers.edit',$sub_seller->id) }}"
                                                    class="dropdown-item" style="padding: 0.5rem 0.5rem;">
                                                    {{ translate('Edit') }}
                                                </a>
                                                <a href="#" class="dropdown-item confirm-delete"
                                                    data-href="{{ route('sub_sellers.destroy', $sub_seller->id) }}" class=""
                                                    style="padding: 0.5rem 0.5rem;">
                                                    {{ translate('Delete') }}
                                                </a>
                                                @if ($sub_seller->banned != 1)
                                                <a href="#" class="dropdown-item" style="padding: 0.5rem 0.5rem;"
                                                    onclick="confirm_ban('{{ route('sub_sellers.ban', $sub_seller->id) }}');">
                                                    {{ translate('Ban this Account') }}
                                                </a>
                                                @else
                                                <a href="#" class="dropdown-item" style="padding: 0.5rem 0.5rem;"
                                                    onclick="confirm_unban('{{ route('sub_sellers.ban', $sub_seller->id) }}');">
                                                    {{ translate('Unban this Account') }}
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $sub_sellers->appends(request()->input())->links() }}
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
                    <p>{{ translate('Do you really want to ban this account?') }}</p>
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
                    <p>{{ translate('Do you really want to unban this account?') }}</p>
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
                url: "{{ route('bulk-sub_seller-delete') }}",
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
