@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-r mt-4">
                    <div class="card-header">
                    <form action="" method="GET" id="transaction_history" class="w-100">
                        <div class="row p-2">
                            <div class="col-md-7 col-12">
                                <h5 class="mb-0 h6">{{ translate('Installation History') }}</h5>
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
                    </div>
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
                                    <th class="text-right">{{ translate('Options')}}</th>
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
                                            <td class="text-right">
                                                @if($order->done_installation_status != 1 && $order->done_installation_status != 2)
                                                    <a href=" {{ url('order-review',$order->id) }}" class="btn btn-success btn-sm" title="{{ translate('Order Details') }}">
                                                        Rate it
                                                    </a>
                                                @endif
                                                @if ($order->delivery_status == 'pending' && $order->payment_status == 'unpaid')
                                                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Cancel') }}">
                                                        <i class="las la-trash"></i>
                                                    </a>
                                                @endif
                                                <a href="javascript:void(0)" class="btn btn-soft-info btn-icon btn-circle btn-sm" onclick="show_purchase_history_details({{ $order->id }})" title="{{ translate('Order Details') }}">
                                                    <i class="las la-eye"></i>
                                                </a>
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
