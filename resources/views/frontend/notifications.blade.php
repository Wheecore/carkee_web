@extends('frontend.layouts.user_panel')
@section('panel_content')

    <style>
        .badge {width: auto;}
        .seen-tr {background: #f2f3f8;}
        .dropdown-list-image img {height: 2.5rem; width: 2.5rem;}
    </style>
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
                                            $html = '';
                                            $url = '';
                                            switch ($notification->type) {
                                                // workshop notifications    
                                                case 'order_reassigned':
                                                    $url = url('notification-orders-details',['order_id' => $notification->order_id, 'notification_id' => $notification->id]);
                                                    break;  
                                                case 'return_products':
                                                    $url = url('notification-orders-details',['order_id' => $notification->order_id, 'notification_id' => $notification->id]);
                                                    break;
                                                case 'order_reschedule':
                                                    $url = url('notification-orders-details',['order_id' => $notification->order_id, 'notification_id' => $notification->id]);
                                                    break;
                                                case 'availability_request':
                                                    $url = route('workshop.daterequest.statuschange', $notification->id);
                                                    break;

                                                // customer notifications
                                                case 'order_reschedule_approve':
                                                    $url = url('order-review', $notification->order_id);
                                                    break;
                                                case 'review_car':
                                                    $url = url('installation_history1', $notification->order_id);
                                                    break;
                                                case 'done_installation':
                                                    $url = url('order-review', $notification->order_id);
                                                    break;
                                                case 'notify_address':
                                                    $url = url('order-user-address', $notification->order_id);
                                                    break;
                                                case 'notify_user':
                                                    $url = url('order-user-notify', $notification->order_id);
                                                    break;
                                                case 'reassign':
                                                    $chk_time = DB::table('availability_requests')->select('from_time', 'to_time', 'previous_from_time', 'previous_to_time')->where('date', date('Y/m/d', strtotime($notification->workshop_date)))->orderBy('id', 'desc')->first();
                                                    if($chk_time && $chk_time->from_time && $chk_time->to_time) {
                                                        $html .= '<span>(Shop Time is Changed From' . \Carbon\Carbon::parse($chk_time->previous_from_time)->format('h: i a') . '--' . \Carbon\Carbon::parse($chk_time->previous_to_time)->format('h: i a') . ' to ' . \Carbon\Carbon::parse($chk_time->from_time)->format('h: i a') . '--' . \Carbon\Carbon::parse($chk_time->to_time)->format('h: i a') . ')</span>';
                                                        $html .= '<span><form action="' . route('checkout.reschedule') . '" method="get"><input type="hidden" value="' . $notification->order_id . '" name="order_id"><button class="btn-sm btn-primary mt-2" type="submit">Reassign Shop</button></form></span>';
                                                    } else {
                                                        $html .= '<span class="">(Shop Will be Closed on ' . $notification->workshop_date . ')</span>';
                                                    }
                                                    break;
                                                case 'reminder_hour_status':
                                                    $url = url('order-user-hour-alert', $notification->order_id);
                                                    break;
                                                case 'reminder_day_status':
                                                    $url = url('order-user-day-alert', $notification->order_id);
                                                    break;
                                                case 'installation_alert':
                                                    $url = url('alert-list-order', $notification->order_id);
                                                    break;

                                                //  combined notifications   
                                                case 'order':
                                                    if($notification->is_admin == 2){
                                                        $url = url('view-order', ['order_id' => $notification->order_id, 'notification_id' => $notification->id]);
                                                    }
                                                    else{
                                                        $url = '';
                                                    }
                                                    break;
                                                case 'view_order':
                                                    if($notification->is_admin == 2){
                                                        $url = url('view-order', ['order_id' => $notification->order_id, 'notification_id' => $notification->id]);
                                                    }
                                                    else{
                                                        $url = '';
                                                    }
                                                    break;
                                            }
                                        @endphp
                                            <a href="{{ $url }}">View</a>
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
