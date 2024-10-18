@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <form id="sort_orders" action="" method="GET">
                        <div class="card-header">
                            <div class="row w-100">
                                <div class="col-md-4 col-12">
                                    <h5 class="mb-md-0 h6">{{ translate('Reschedule Date Orders') }}</h5>
                                </div>
                                 <div class="col-md-4 col-12">
                                   <select class="form-control aiz-selectpicker" data-placeholder="{{ translate('Filter by Payment Status')}}" name="approve_status" onchange="sort_orders()">
                                    <option value="">{{ translate('Filter by Approve Status')}}</option>
                                    <option value="1" @isset($approve_status) @if($approve_status == '1') selected @endif @endisset>{{ translate('Approved')}}</option>
                                    <option value="0" @isset($approve_status) @if($approve_status == '0') selected @endif @endisset>{{ translate('Un-Approved')}}</option>
                                </select>
                                 </div>
                                  <div class="col-md-4 col-12">
                                         <div class="from-group mb-0">
                                    <input type="text" class="form-control" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type Order code & hit Enter') }}">
                                </div>
                                  </div>
                            </div>
                        </div>
                    </form>
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                <table class="table aiz-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ translate('Car Model')}}</th>
                                        <th>{{ translate('Car Plate')}}</th>
                                        <th>{{ translate('Order Code')}}</th>
                                        <th data-breakpoints="lg">{{ translate('Customer')}}</th>
                                        <th data-breakpoints="md">{{ translate('Amount')}}</th>
                                        <th data-breakpoints="md">{{ translate('Booking Date')}}</th>
                                        <th data-breakpoints="md">{{ translate('Booking Time')}}</th>
                                        <th class="text-right">{{ translate('Options')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orders as $key => $order)
                                            <tr>
                                                <td> {{ $key+1 }} </td>
                                                <td>{{ $order->model_name }}</td>
                                                <td>{{ $order->car_plate }}</td>
                                                <td>
                                                    <a href="#{{ $order->code }}" onclick="show_order_details({{ $order->id }})">{{ $order->code }}</a>
                                                </td>
                                                <td>
                                                    @if ($order->user_id != null)
                                                        {{ $order->user->name }}
                                                    @else
                                                        Guest
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ single_price($order->grand_total) }}
                                                </td>
                                                <td>
                                                    {{ $order->workshop_date }}
                                                </td>
                                                <td>
                                                    {{ $order->workshop_time }}
                                                </td>
                                                <td class="text-right">
                                                    @if($order->workshop_date_approve_status != 1)
                                                    <a href="{{ route('update_date_workshop_order.approved', $order->id) }}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('Approve') }}">
                                                        <i class="las la-check"></i>
                                                    </a>
                                                    @endif
                                                    <a href="javascript:void(0)" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="show_order_details({{ $order->id }})" title="{{ translate('Order Details') }}">
                                                        <i class="las la-eye"></i>
                                                    </a>
                                                    <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-soft-warning btn-icon btn-circle btn-sm" title="{{ translate('Download Invoice') }}">
                                                        <i class="las la-download"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                </div>
                                <div class="aiz-pagination">
                                    {{ $orders->links() }}
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el){
            $('#sort_orders').submit();
        }

    </script>
@endsection
