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
                <div class="card card-r mt-4">
                    <form action="" method="GET" id="transaction_history">
                        <div class="card-header mr-0 row">
                        <div class="col-md-3 col-12">
                            <h5 class="mb-0 h6">{{ translate('Transaction History') }}</h5>
                        </div>
                        <div class="col-md-4 col-12">
                            <select name="completed" id="completed" class="form-control" onchange="t_history()">
                                <option value="">Filter By Completed</option>
                                <option value="Confirmd">Completed History</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-8">
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
                    </form>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table aiz-table">
                                <thead>
                                <tr>
                                    <th>{{ translate('Code')}}</th>
                                    <th>{{ translate('Car Model')}}</th>
                                    <th>{{ translate('Car Plate')}}</th>
                                    <th data-breakpoints="md">{{ translate('Date')}}</th>
                                    <th>{{ translate('Amount')}}</th>
                                    <th data-breakpoints="md">{{ translate('Status')}}</th>
                                    <th data-breakpoints="md">{{ translate('Remarks')}}</th>
                                    <th class="pl-lg-5">{{ translate('Options')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($orders as $key => $order)
                                    @if (count($order->orderDetails) > 0)
                                        <?php
                                        $model = DB::table('car_models')->where('id', $order->model_id)->first();
                                        ?>
                                        <tr>
                                            <td>
                                                <a href="#{{ $order->code }}" onclick="show_purchase_history_details({{ $order->id }})">{{ $order->code }}</a>
                                            </td>
                                            <td>
                                                {{ $model?$model->name:'' }}
                                            </td>
                                            <td>
                                                {{ $order->car_plate }}
                                            </td>
                                            <td>{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
                                            <td>
                                                {{ single_price($order->grand_total) }}
                                            </td>
                                            <td>
                                                {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}
                                            </td>

                                            <td>
                                                @if($order->reassign_status == 1)
                                                    <form action="{{ route('checkout.reschedule') }}" method="get">
                                                        <input type="hidden" value="{{ $order->id }}" name="order_id">
                                                        <button class="btn-sm btn-primary mt-2 w-110px" type="submit">Reassign Shop</button>
                                                    </form>
                                                @else
                                                    <span class="">Already Scheduled</span>
                                                @endif
                                            </td>
                                            <td class="pl-5" style="white-space: nowrap">
                                                @if(isset($_GET['installation']) && $_GET['installation'])
                                                    @if($order->done_installation_status == 1 || $order->done_installation_status == 2)
                                                    @else
                                                        <a href=" {{ url('order-review',$order->id) }}" class="btn btn-success btn-sm" title="{{ translate('Order Details') }}">
                                                            Rate it
                                                        </a>
                                                    @endif
                                                @endif
                                                @if ($order->delivery_status == 'pending' && $order->payment_status == 'unpaid')
                                                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Cancel') }}">
                                                        <i class="las la-trash"></i>
                                                    </a>
                                                @endif
                                                <a href="javascript:void(0)" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="show_purchase_history_details({{ $order->id }})" title="{{ translate('Order Details') }}">
                                                    <i class="las la-eye"></i>
                                                </a>
                                                <a class="btn btn-soft-warning btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                                    <i class="las la-download"></i>
                                                </a>
                                                @if($order->delivery_status != 'Confirmed' && $order->delivery_status != 'Rejected' && $order->delivery_status != 'Done')
                                                    <a class="btn btn-soft-success" href="{{ route('front.user.change.date', $order->id) }}" title="{{ translate('Reschedule Appointment') }}">
                                                        Reschedule Appointment
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            <div class="ml-4">
                                {{ $orders->links() }}
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div id="payment_modal_body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('#order_details').on('hidden.bs.modal', function () {
            location.reload();
        })

        function t_history(){
            $('#transaction_history').submit();
        }
    </script>

@endsection
