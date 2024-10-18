@extends('backend.layouts.app')
@section('title', translate('All Merchants'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-md-right">
                <a href="{{ route('merchants.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Merchant') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <form class="" id="sort_merchants" action="" method="GET">
                <div class="card-header row gutters-5">
                    <div class="col">
                        <h5 class="mb-md-0 h6">{{ translate('All Merchants') }}</h5>
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
                                <th width="20%">{{ translate('Name') }}</th>
                                <th data-breakpoints="sm">{{ translate('Phone') }}</th>
                                <th data-breakpoints="sm">{{ translate('Email Address') }}</th>
                                <th data-breakpoints="sm">{{ translate('Recommended') }}</th>
                                <th data-breakpoints="sm">{{ translate('Category') }}</th>
                                <th data-breakpoints="sm">{{ translate('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($merchants as $key => $merchant)
                                @php
                                    $m_category = \DB::table('merchant_categories')
                                        ->where('id', $merchant->merchant_category)
                                        ->first();
                                @endphp
                                <tr>
                                    <!--<td>{{ $key + 1 + ($merchants->currentPage() - 1) * $merchants->perPage() }}</td>-->
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $merchant->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $merchant->name }}</td>
                                    <td>{{ $merchant->phone }}</td>
                                    <td>{{ $merchant->email }}</td>
                                    <td>{{ $merchant->is_recommended == 1 ? 'Yes' : 'No' }}</td>
                                    <td>{{ $m_category ? $m_category->name : '' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-sm btn-circle btn-soft-primary btn-icon dropdown-toggle no-arrow"
                                                data-toggle="dropdown" href="javascript:void(0);" role="button"
                                                aria-haspopup="false" aria-expanded="false">
                                                <i class="las la-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                <a href="#" onclick="show_seller_profile('{{ $merchant->id }}');"
                                                    class="dropdown-item">
                                                    {{ translate('Profile') }}
                                                </a>
                                                {{-- <a href="{{route('merchants.login', encrypt($merchant->id))}}" class="dropdown-item">
                                                    {{translate('Login as this Merchant')}}
                                                </a> --}}
                                                <a href="{{ route('merchants.edit', encrypt($merchant->id)) }}"
                                                    class="dropdown-item">
                                                    {{ translate('Edit') }}
                                                </a>
                                                <a href="#" class="dropdown-item confirm-delete"
                                                    data-href="{{ route('merchants.destroy', $merchant->id) }}">
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
                        {{ $merchants->appends(request()->input())->links() }}
                    </div>
                </div>
                </from>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Delete Modal -->
    @include('modals.delete_modal')

    <!-- Seller Profile Modal -->
    <div class="modal fade" id="profile_modal">
        <div class="modal-dialog">
            <div class="modal-content" id="profile-modal-content">

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
            $.post('{{ route('merchants.profile_modal') }}', {
                _token: '{{ @csrf_token() }}',
                id: id
            }, function(data) {
                $('#profile_modal #profile-modal-content').html(data);
                $('#profile_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }

        function bulk_delete() {
            var data = new FormData($('#sort_merchants')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('bulk-merchant-delete') }}",
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
