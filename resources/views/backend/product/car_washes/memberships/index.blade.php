@extends('backend.layouts.app')
@section('title', translate('Car Wash Membership'))
@section('content')

    @php
        $user = Auth::user();
        $permissions = ($user->staff) ? $user->staff->role->permissions : '';
        $permissions = json_decode($permissions);
    @endphp
    @if ($user->user_type == 'admin' || in_array(51, $permissions))
        <div class="aiz-titlebar text-left mt-2 mb-3">
            <div class="row align-items-center">
                <div class="col text-right">
                    <a href="{{ route('add-car-washes-order') }}" class="btn btn-circle btn-info">
                        {{ translate('Add Car Wash Order') }}
                    </a>
                </div>
            </div>
        </div>
        <br>
    @endif
    <div class="card">
        <div class="card-header row">
            <div class="col">
            <h5 class="mb-md-0 h6">
                {{ translate('Car Wash Membership') }}
            </h5>
            </div>
            <div class="col-md-4">
                <form action="" id="sort_orders" method="GET">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & hit Enter') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>{{ translate('ID') }}</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Email') }}</th>
                        <th>{{ translate('Phone') }}</th>
                        <th>{{ translate('Car Plate') }}</th>
                        <th>{{ translate('Membership Fee') }}</th>
                        <th>{{ translate('Date') }}</th>
                        <th>{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($memberships as $membership)
                        <tr>
                            <td>{{ $membership->id }}</td>
                            <td>{{ $membership->name }}</td>
                            <td>{{ $membership->email }}</td>
                            <td>{{ $membership->phone }}</td>
                            <td>{{ $membership->car_plate }}</td>
                            <td>{{ format_price($membership->amount) }}</td>
                            <td>{{ convert_datetime_to_local_timezone($membership->created_at, user_timezone(Auth::id())) }}</td>
                            <td>
                                <a href="{{ route('car-washes.membership.details', encrypt($membership->id)) }}" class="btn btn-soft-primary btn-circle btn-sm">
                                    {{ translate('Active Packages') }}
                                </a>
                                {{-- <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('car-washes.destroy', $membership->id) }}"
                                    title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $memberships->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection
