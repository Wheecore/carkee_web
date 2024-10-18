@extends('backend.layouts.app')
@section('title', translate('Petrol Orders'))
@section('content')

    <div class="card">
        <form class="" action="" id="sort_orders" method="GET">
            <div class="card-header row gutters-5">
                <div class="col">
                    <h5 class="mb-md-0 h6">{{ translate('Petrol Orders') }}</h5>
                </div>

                <div class="dropdown mb-2 mb-md-0">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                        {{ translate('Bulk Action') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" onclick="bulk_order_delete()">
                            {{ translate('Delete selection') }}</a>
                    </div>
                </div>

                <div class="col-lg-2 ml-auto">
                    <select class="form-control aiz-selectpicker" name="delivery_status" id="delivery_status">
                        <option value="">{{ translate('--Select--') }}</option>
                        <option value="pending" @if ($delivery_status == 'pending') selected @endif>
                            {{ translate('Pending') }}</option>
                        <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>
                            {{ translate('On The Way') }}</option>
                        </option>
                        <option value="completed" @if ($delivery_status == 'completed') selected @endif>
                            {{ translate('Completed') }}</option>
                        <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>
                                {{ translate('Cancelled') }}</option>
                    </select>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date"
                            placeholder="{{ translate('Filter by date') }}" data-format="DD-MM-Y" data-separator=" to "
                            data-advanced-range="true" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="search"
                            name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Order code & hit Enter') }}">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
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
                                <th>{{ translate('Order Code') }}</th>
                                <th>{{ translate('Order Date') }}</th>
                                <th>{{ translate('Order Schedule Time') }}</th>
                                <th>{{ translate('Car Model') }}</th>
                                <th data-breakpoints="md">{{ translate('Customer') }}</th>
                                <th data-breakpoints="md">{{ translate('Amount') }}</th>
                                <th data-breakpoints="md">{{ translate('Order Status') }}</th>
                                <th>{{ translate('options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <div class="aiz-checkbox-inline">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" class="check-one" name="id[]"
                                                        value="{{ $order->id }}">
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $order->code }}</td>
                                    <td>{{ convert_datetime_to_local_timezone($order->created_at, user_timezone(Auth::id())) }}</td>
                                    <td>{{ date(env('DATE_FORMAT').' h:i a', strtotime($order->order_schedule_time)) }}</td>
                                    <td>{{ $order->model_name }}</td>
                                    <td>{{ $order->username }}</td>
                                    <td>{{ single_price($order->grand_total) }}</td>
                                    <td width="14%">
                                        @php
                                            $class = 'btn-info';
                                            if ($order->delivery_status == 'completed') {
                                                $class = 'btn-success';
                                            }
                                            else if ($order->delivery_status == 'cancelled') {
                                                $class = 'btn-danger';
                                            }
                                        @endphp
                                        <button type="button" class="btn btn-xs {{ $class }}">{{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}</button>
                                    </td>
                                    <td style="white-space: nowrap;">
                                        @if ($order->delivery_status != 'completed' && $order->delivery_status != 'cancelled')
                                            <button type="button" class="btn btn-primary btn-xs"
                                                onclick="change_emergency_order_status({{ $order->id }},'{{ $order->delivery_status }}', '{{ $order->arrival_minutes }}')"
                                                data-toggle="modal" data-target="#changeStatusModal">Change Status</button>
                                        @endif
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('petrol_orders.show', encrypt($order->id)) }}"
                                            title="{{ translate('View') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('invoice.emergency-order', ['order_id' => $order->id, 'type' => 'petrol']) }}"
                                            title="{{ translate('Download Invoice') }}">
                                            <i class="las la-download"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('orders.destroy', $order->id) }}"
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
                    {{ $orders->appends(request()->input())->links() }}
                </div>
            </div>
        </form>
    </div>

@endsection
@section('modal')
    @include('modals.delete_modal')
    @include('modals.emergency_order_status_modal')
@endsection
@section('script')

    <script type="text/javascript">
        var some_error_notify = "{{ translate('Some error occurs') }}";
        var order_status_notify = "{{ translate('Order status has been updated') }}";
    </script>

@endsection
