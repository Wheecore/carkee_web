@extends('backend.layouts.app')
@section('title', translate('All Notifications'))
@section('css')

    <style>
        .badge {width: auto;}
        .seen-tr {background: #f2f3f8;}
    </style>

@endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="fw-600 h4">{{ translate('All Notifications') }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>S.No</th>
                                <th>Notification</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($notifications as $key => $notification)
                                    <tr class="{{ ($notification->is_viewed) ? '' : 'seen-tr' }}">
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $notification->body }}</td>
                                        <td>{!! ($notification->is_viewed) ? '<span class="badge badge-success">Seen</span>' : '<span class="badge badge-danger">New</span>' !!}</td>
                                        <td>{{ convert_datetime_to_local_timezone($notification->created_at, user_timezone(Auth::id())) }}</td>
                                        <td>
                                            @php
                                            $show_route = route('wallet.recharge-details', encrypt($notification->notification_id));
                                            if($notification->order_type == 'B'){
                                                $show_route = route('battery_orders.show', encrypt($notification->id));
                                            }
                                            if($notification->order_type == 'P'){
                                                $show_route = route('petrol_orders.show', encrypt($notification->id));
                                            }
                                            if($notification->order_type == 'T'){
                                                $show_route = route('tyre_orders.show', encrypt($notification->id));
                                            }
                                            if($notification->order_type == 'CW'){
                                                $show_route = route('car-washes.orders.show', encrypt($notification->id));
                                            }
                                            if($notification->order_type == 'N'){
                                            $show_route = route('all_orders.show', encrypt($notification->id));
                                            }
                                            @endphp
                                            <a href="{{ $show_route }}">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">{{ translate('Nothing found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
