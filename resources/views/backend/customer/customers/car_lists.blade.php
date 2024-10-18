@extends('backend.layouts.app')
@section('title', translate('Car Lists'))
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ $user->name }} {{ translate('Car Lists') }}</h1>
        </div>
    </div>
</div>
    <div class="card">
        <form action="" id="sort_carlists" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-0 h6">{{ $user->name }} {{ translate('Car Lists') }}</h5>
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
                            placeholder="{{ translate('Type & Enter') }}">
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
                            <th>{{ translate('Image') }}</th>
                            <th>{{ translate('Car Plate') }}</th>
                            <th>{{ translate('Mileage') }}</th>
                            <th>{{ translate('Chassis Number') }}</th>
                            <th>{{ translate('Insurance') }}</th>
                            <th>{{ translate('Brand') }}</th>
                            <th>{{ translate('Model') }}</th>
                            <th>{{ translate('Year') }}</th>
                            <th>{{ translate('Variant') }}</th>
                            <th>{{ translate('Size Alternative') }}</th>
                            <th>{{ translate('Created') }}</th>
                            <th>{{ translate('Membership Status') }}</th>
                            <th>{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($car_lists as $car_list)
                        @php
                        $check_membership = DB::table('car_wash_memberships')->select('id')->where('user_id', $car_list->user_id)->where('car_plate', $car_list->car_plate)->first();
                        @endphp
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $car_list->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ uploaded_asset($car_list->image) }}" alt="" style="width: 90px;max-height: 60px;">
                                    </td>
                                    <td>{{ $car_list->car_plate }}</td>
                                    <td>{{ $car_list->mileage }}</td>
                                    <td>{{ $car_list->chassis_number }}</td>
                                    <td>{{ $car_list->insurance?date(env('DATE_FORMAT'), strtotime($car_list->insurance)):'' }}</td>
                                    <td>{{ $car_list->brand_name }}</td>
                                    <td>{{ $car_list->model_name }}</td>
                                    <td>{{ $car_list->year_name }}</td>
                                    <td>{{ $car_list->variant_name }}</td>
                                    <td>{{ $car_list->size_alternative }}</td>
                                    <td>{{ ($car_list->created_at)?convert_datetime_to_local_timezone($car_list->created_at, $timezone):'' }}</td>
                                    <td>@if($check_membership) <button class="btn btn-sm btn-success" type="button">Enabled</button> @endif</td>
                                    <td style="white-space: nowrap">
                                        @if(!$check_membership)
                                        <a href="{{ route('buy-car_list-membership',$car_list->id) }}" class="btn btn-primary btn-sm mr-1">Buy Membership</a>
                                        @endif
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('customers.car_list.destroy', $car_list->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                <div class="aiz-pagination">
                    {{ $car_lists->appends(request()->input())->links() }}
                </div>
            </div>
        </form>
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

        function bulk_delete() {
            var data = new FormData($('#sort_carlists')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('customers.bulk_carlist.destroy') }}",
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
