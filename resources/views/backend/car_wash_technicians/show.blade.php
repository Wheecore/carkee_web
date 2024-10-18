@extends('backend.layouts.app')
@section('title', translate('Car Wash Technician Details'))
@section('content')

<div class="row mb-2">
<div class="col-md-10"></div>
<div class="col-md-2 text-right">
    <a class="btn btn-primary" href="{{ route('car-wash-technicians.index') }}"><i class="las la-arrow-left mr-1"></i>Back</a>
</div>
</div>
<div class="row">
        <div class="col-lg-9">
            <div class="card">
                <form action="" method="GET">
                    <div class="card-header row gutters-5">
                        <div class="col">
                            <h5 class="mb-0 h6">{{ translate('Car Washes') }} (<strong>Total:</strong> <span>{{ count($usages) }}</span>)</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" id="search"
                                    name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                                    placeholder="{{ translate('Type & hit Enter') }}">
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
                                <th>{{ translate('Date') }}</th>
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
                                    <td>{{ convert_datetime_to_local_timezone($usage->created_at, user_timezone(Auth::id())) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="aiz-pagination">
                        {{ $usages->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Car Wash Technician Details') }}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="col-from-label">{{ translate('Name') }}</label>
                        <p><strong>{{ $technician->name }}</strong></p>
                    </div>
                    <div class="form-group">
                        <label class="col-from-label">{{ translate('Email Address') }}</label>
                        <p><strong>{{ $technician->email }}</strong></p>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{ translate('Contact No') }}</label>
                        <p><strong>{{ $technician->phone }}</strong></p>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{ translate('Shop Name') }}</label>
                        <p><strong>{{ $technician->shop_name }}</strong></p>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{ translate('Shop Address') }}</label>
                        <p><strong>{{ $technician->address }}</strong></p>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{ translate('Shop Logo') }}</label>
                        <p><img src="{{ uploaded_asset($technician->logo) }}" alt="" style="width: 200px;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
