@extends('frontend.layouts.user_panel')
@section('panel_content')

@foreach ($order->orderDetails as $key => $orderDetail)
@php
$orderDetails[] = $orderDetail->received_status;
@endphp
@endforeach
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h1 class="h2 fs-16 mb-0">{{ translate('Order Details') }}</h1>
                </div>
                <div class="card-body">
                    <div class="row gutters-5">
                        <div class="col mt-2">
                            @if($order->delivery_status != 'Confirmed' && $order->delivery_status != 'Rejected' && $order->delivery_status != 'Done')
                                @if(!in_array(null, $orderDetails))
                                    <a href="{{ route('confirm.order',$order->id) }}" class="btn btn-primary">Notify user to Workshop</a>
                                @endif
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#reject">Reject</button>
                            @endif
                        </div>
                        <div class="col-md-4 ml-auto">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="text-main text-bold">{{translate('Order #')}}</td>
                                    <td class="text-right text-info text-bold">	{{ $order->code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{translate('Order Status')}}</td>
                                    @php
                                        $status = $order->delivery_status;
                                    @endphp
                                    <td class="text-right">
                                        @if($status == 'delivered')
                                            <span class="badge badge-inline badge-success">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                        @else
                                            <span class="badge badge-inline badge-info">{{ translate(ucfirst(str_replace('_', ' ', $status))) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{translate('Order Date')}}	</td>
                                    <td class="text-right">{{ convert_datetime_to_local_timezone(date('Y-m-d h:i:s', $order->date), user_timezone(Auth::id())) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{translate('Payment method')}}</td>
                                    <td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="new-section-sm bord-no">
                    @php
                        $tyre_products = DB::table('order_details')
                        ->where('order_details.order_id', $order->id)
                        ->where('order_details.type', 'T')
                        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
                        ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
                        ->select('product_translations.name', 'order_details.quantity','products.thumbnail_img', 'order_details.id','order_details.received_status')
                        ->get(); 
                        $package_products = DB::table('order_details')
                        ->where('order_details.order_id', $order->id)
                        ->where('order_details.type', 'P')
                        ->leftJoin('products', 'products.id', '=', 'order_details.product_id')
                        ->leftJoin('product_translations', 'product_translations.product_id', '=', 'products.id')
                        ->select('product_translations.name','products.thumbnail_img', 'order_details.quantity','order_details.received_status','order_details.id')
                        ->get();
                    @endphp
                    @if(count($tyre_products) > 0)
                    <div class="row">
                        <h6>Tyre Products</h6>
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-bordered invoice-summary">
                                <thead>
                                <tr class="bg-trans-dark">
                                    <th class="min-col">#</th>
                                    <th width="10%">{{translate('Photo')}}</th>
                                    <th class="text-uppercase">{{translate('Description')}}</th>
                                    <th class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
                                    <th  class="min-col text-center text-uppercase">{{translate('Status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tyre_products as $key => $orderDetail)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if ($orderDetail->thumbnail_img)
                                                <a href="#" target="_blank"><img height="50" src="{{ uploaded_asset($orderDetail->thumbnail_img) }}"></a>
                                            @else
                                                <strong>{{ translate('N/A') }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($orderDetail->name)
                                                <strong><a href="#" target="_blank" class="text-muted">{{ $orderDetail->name }}</a></strong>
                                            @else
                                                <strong>{{ translate('Product Unavailable') }}</strong>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                                        <td class="text-center">
                                            @if($orderDetail->received_status == 'Received')
                                                <h6 class="btn btn-success">{{ $orderDetail->received_status }}</h6>
                                            @elseif($order->delivery_status == 'Rejected')
                                                <h6 class="btn btn-danger">{{ $order->delivery_status }}</h6>
                                            @else
                                                <a href="{{ url('received-order-item',$orderDetail->id ) }}" class="btn btn-info">Receive Now</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    @if(count($package_products) > 0)
                    <div class="row mt-5">
                        <h6>Package Products</h6>
                        <div class="col-lg-12 table-responsive">
                            <table class="table table-bordered invoice-summary">
                                <thead>
                                <tr class="bg-trans-dark">
                                    <th class="min-col">#</th>
                                    <th width="10%">{{translate('Photo')}}</th>
                                    <th class="text-uppercase">{{translate('Description')}}</th>
                                    <th class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
                                    <th class="min-col text-center text-uppercase">{{translate('Package')}}</th>
                                    <th  class="min-col text-center text-uppercase">{{translate('Status')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($package_products as $key => $orderDetail)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if ($orderDetail->thumbnail_img != null)
                                                <a href="#" target="_blank"><img height="50" src="{{ uploaded_asset($orderDetail->thumbnail_img) }}"></a>
                                            @else
                                                <strong>{{ translate('N/A') }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($orderDetail->name != null)
                                                <strong><a href="#" target="_blank" class="text-muted">{{ $orderDetail->name }}</a></strong>
                                            @else
                                                <strong>{{ translate('Product Unavailable') }}</strong>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                                        <td class="text-center">{{ translate('Package') }}</td>
                                        <td class="text-center">
                                            @if($orderDetail->received_status == 'Received')
                                                <h6 class="btn btn-success">{{ $orderDetail->received_status }}</h6>
                                            @elseif($order->delivery_status == 'Rejected')
                                                <h6 class="btn btn-danger">{{ $order->delivery_status }}</h6>
                                            @else
                                                <a href="{{ url('received-order-item',$orderDetail->id ) }}" class="btn btn-info">Receive Now</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="reject" tabindex="-1" role="dialog" aria-labelledby="reject" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <form class="form-horizontal" action="{{ route('reject.order', $order->id) }}" method="post">
      <div class="modal-body">

                    @csrf
                 <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
