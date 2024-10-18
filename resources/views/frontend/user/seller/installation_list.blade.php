@extends('frontend.layouts.user_panel')
@section('panel_content')

   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="card mt-4">
                   <form id="sort_orders" action="" method="GET">
                       <div class="card-header">
                           <form class="" action="" id="sort_orders" method="GET">
                           <div class="row w-100">
                               <div class="col-md-7 col-12">
                                    <h5 class="mb-md-0 h6">{{ translate('Installation List') }}</h5>
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
                           <div class="card-body p-3">
                               <div class="table-responsive">
                               <table class="table aiz-table">
                                   <thead>
                                   <tr>
                                       <th>#</th>
                                       <th>{{ translate('Car Model')}}</th>
                                       <th>{{ translate('Car Plate')}}</th>
                                       <th>{{ translate('Order Code')}}</th>
                                       <th>{{ translate('Customer')}}</th>
                                       <th>{{ translate('Amount')}}</th>
                                       <th class="text-center">{{ translate('Options')}}</th>
                                   </tr>
                                   </thead>
                                   <tbody>
                                   @foreach ($orders as $key => $order)
                                           <tr>
                                               <td>
                                                   {{ $key+1 }}
                                               </td>
                                               <td>{{ $order->model_name }}</td>
                                               <td>{{ $order->car_plate }}</td>
                                               <td>
                                                   <a href="#{{ $order->code }}"
                                                      onclick="show_order_details({{ $order->id }})">{{ $order->code }}</a>
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
                                               <td class="text-right" style="white-space: nowrap">
                                                   @if(Auth::user()->user_type == 'seller')
                                                       @if($order->done_installation_status == 2 || $order->done_installation_status == 1)
                                                           <a href="javascript:void(0);" class="btn btn-success btn-sm" title="{{ translate('Already Done') }}">
                                                               Already Done
                                                           </a>
                                                       @else
                                                           @if($order->notify_user_come_to_workshop_to_review_car == 1 || $order->notify_user_come_to_workshop_to_review_car == 2)
                                                               <a href="javascript:void(0);" class="btn btn-success btn-sm" title="{{ translate('Notified') }}">
                                                                   Notified
                                                               </a>
                                                           @else
                                                               <a href="{{ route('notify.user.come.to.workshop',$order->id) }}" class="btn btn-info btn-sm" title="{{ translate('Order Details') }}">
                                                                   Notify user come to workshop to review car
                                                               </a>
                                                           @endif
                                                           <a href="javascript:void(0);" class="btn btn-primary btn-sm" title="{{ translate('Waiting for user to rate this order') }}">
                                                               Waiting for user to rate this order
                                                           </a>
                                                       @endif
                                                   @else
                                                       @if($order->done_installation_status == 1 || $order->done_installation_status == 2)
                                                           <a href="javascript:void(0);" class="btn btn-info btn-sm" title="{{ translate('Rated') }}">
                                                               Rated
                                                           </a>
                                                       @else
                                                           <a href=" {{ url('order-review',$order->id) }}" class="btn btn-success btn-sm" title="{{ translate('Rate it') }}">
                                                               Rate it
                                                           </a>
                                                       @endif
                                                   @endif
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
                   </form>
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
