@extends('backend.layouts.app')
@section('title', translate('Car Wash Products'))
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col text-right">
                <a href="{{ route('car-washes.create') }}" class="btn btn-circle btn-info">
                    <span>{{ translate('Add New Car Wash Product') }}</span>
                </a>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <form class="" id="sort_batteries" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Car Wash Products') }}</h5>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"
                            @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Image') }}</th>
                            {{-- <th>{{ translate('Product Type') }}</th> --}}
                            <th>{{ translate('Type') }}</th>
                            <th>{{ translate('Description') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th>{{ translate('Membership Fee') }}</th>
                            <th>{{ translate('Usage Limit') }}</th>
                            <th>{{ translate('Warranty') }}</th>
                            <th>{{ translate('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($car_washes as $car_wash)
                            <tr>
                                <td>{{ $car_wash->name }}</td>
                                <td><img src="{{ my_asset($car_wash->file_name) }}" width="50px" alt=""></td>
                                {{-- <td>{{ car_wash_type($car_wash->ptype) }}</td> --}}
                                <td>{{ str_replace("_"," ", rtrim(implode(', ', (array) (json_decode($car_wash->type) ?? [])), ", ")) }}</td>
                                <td>{{ $car_wash->description }}</td>
                                <td>{{ format_price($car_wash->amount) }}</td>
                                <td>{{ format_price($car_wash->membership_fee) }}</td>
                                <td>{{ $car_wash->usage_limit }}</td>
                                <td>
                                    @if ($car_wash->warranty)
                                        {{ $car_wash->warranty }} {{ ($car_wash->warranty <= 1) ? translate('year') : translate('years') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('car-washes.edit', encrypt($car_wash->id)) }}" title="{{ translate('Edit') }}">
                                        <i class="las la-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('car-washes.show', $car_wash->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                    {{ $car_washes->appends(request()->input())->links() }}
                </div>
            </div>
        </form>
    </div>

@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection
