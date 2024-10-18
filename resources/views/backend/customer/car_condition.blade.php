@extends('backend.layouts.app')
@section('title', translate('Customer Car Condition List'))
@section('content')

    <div class="card">
        <div class="card-header row">
        <div class="col">
            <h5 class="mb-0 h6">{{ translate('Customer Car Condition List') }}</h5>
        </div>
        <div class="col">
        <form action="" id="sort_orders" method="GET">
            <div class="row mb-2">
                <div class="col-auto ml-auto">
                    <div class="form-group mb-0">
                        <input style="height: calc(1.3125rem + 1.2rem + 2px);" type="text" class="form-control"
                            id="search"
                            name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type & hit Enter') }}">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                    </div>
                </div>
            </div>
        </form>
          </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <!--<th data-breakpoints="lg">#</th>-->
                        <th>{{ translate('Customer Name') }}</th>
                        <th>{{ translate('Car Model') }}</th>
                        <th>{{ translate('Car Plate') }}</th>
                        <th>{{ translate('Workshop Name') }}</th>
                        <th>{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ccs as $key => $data)
                        <?php
                        $user = \App\User::where('id', $data->user_id)->first();
                        $shop = \App\Models\Shop::where('id', $data->workshop_id)->first();
                        ?>
                        <tr>
                            <td>{{ $data->customer }}</td>
                            <td>{{ $data->model }}</td>
                            <td>{{ $data->number_plate }}</td>
                            <td>{{ $shop->name }}</td>
                            <td><a href="{{ route('customer.car.condition.details', $data->id) }}" class="btn btn-primary">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $ccs->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection
