@extends('backend.layouts.app')
@section('title', translate('Car Wash Usage Log'))
@section('content')

    <div class="card">
        <form action="">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Car Wash Usage Log') }}</h5>
                </div>
                <div class="col-md-2 ml-auto">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm" id="search" name="search"
                            value="{{ $search }}" placeholder="{{ translate('Type & Enter') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="rating">
                        <option value="">{{ translate('Filter By Rating') }}</option>
                        <option value="5" {{ $rating == 5 ? 'selected' : '' }}>{{ translate('High Rating') }}</option>
                        <option value="0" {{ $rating == 0 ? 'selected' : '' }}>{{ translate('Low Rating') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-md btn-block btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>{{ translate('ID') }}</th>
                        <th>{{ translate('Product') }}</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Email') }}</th>
                        <th>{{ translate('Car Plate') }}</th>
                        <th>{{ translate('Car Model') }}</th>
                        <th>{{ translate('Rating') }}</th>
                        <th>{{ translate('Review') }}</th>
                        <th>{{ translate('Date') }}</th>
                        {{-- <th>{{ translate('Options') }}</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usages as $usage)
                        <tr>
                            <td>{{ $usage->id }}</td>
                            <td>{{ $usage->product }}</td>
                            <td>{{ $usage->name }}</td>
                            <td>{{ $usage->email }}</td>
                            <td>{{ $usage->car_plate }}</td>
                            <td>{{ $usage->model_name }}</td>
                            <td>{{ $usage->rating }}</td>
                            <td>{{ $usage->review ?? '-' }}</td>
                            <td>{{ convert_datetime_to_local_timezone($usage->created_at, user_timezone(Auth::id())) }}</td>
                            {{-- <td>
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{ route('car-washes.destroy', $usage->id) }}"
                                    title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div class="aiz-pagination">
                {{ $usages->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection
