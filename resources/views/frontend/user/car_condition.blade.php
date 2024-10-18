@extends('frontend.layouts.user_panel')
@section('panel_content')
    <style>
        .metismenu li {
            background-color: #434b55 !important;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
               <form class="" action="" id="sort_orders" method="GET">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-8 col-12">
                            <h5>{{translate('Customer Car Condition List')}}</h5>
                        </div>
                        <div class="col-md-3 col-8">
                              <div class="form-group mb-0">
                                <input style="height: calc(1.3125rem + 1.2rem + 2px);" type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & hit Enter') }}">
                            </div>
                        </div>
                        <div class="col-md-1 col-4">
                              <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table aiz-table">
                            <thead>
                            <tr>
                                <!--<th data-breakpoints="lg">#</th>-->
                                <th>{{translate('Car Model')}}</th>
                                <th>{{translate('Car Plate')}}</th>
                                <th>{{translate('Workshop Name')}}</th>
                                <th>{{translate('Options')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($conditions as $key => $data)
                                <?php
                                $user = \App\User::where('id', $data->user_id)->first();
                                $shop = \App\Models\Shop::where('id', $data->workshop_id)->first();
                                ?>
                                <tr>
                                    <td>{{ $data->model }}</td>
                                    <td>{{ $data->number_plate }}</td>
                                    <td>{{$shop?$shop->name:'--'}}</td>
                                    <td><a  href="{{ url('customer-condition-list-details', $data->id) }}" class="btn btn-primary">View</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $conditions->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

