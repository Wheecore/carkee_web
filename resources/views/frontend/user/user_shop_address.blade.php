@extends('frontend.layouts.user_panel')
@section('panel_content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h1 class="h2 fs-16 mb-0">{{ translate('Shop Order Details') }}</h1>
                </div>
                <div class="card-body">

                    <div class="row gutters-5">

                        <div class="col-md-6">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="text-main text-bold">{{translate('Workshop Name')}}</td>
                                    <td class="text-right text-info text-bold">	{{ $shop->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{translate('Workshop Address')}}</td>
                                    <td class="text-right text-info text-bold">	{{ $shop->address }}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table>
                                <tbody>
                                <tr>
                                    <td class="text-main text-bold">{{translate('User Name')}}</td>
                                    <td class="text-right text-info text-bold">	{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-main text-bold">{{translate('User Email')}}</td>
                                    <td class="text-right text-info text-bold">	{{ $user->email }}</td>
                                </tr>
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
                    {{--@if($user_nf == 1)--}}
                    @if(Auth::user()->user_type == 'seller')
                        <div class="row">
                            <div class="col-6">
                                <form action="{{ route('save_car_condition',$order->id) }}" method="post">
                                    @csrf
                                    <div class="form-group">

                                        <label for="conditon">Your Car Condition is Good?</label>
                                        <select name="condition" id="condition" class="form-control">
                                            <option value="Yes" {{ isset($cc)?$cc->car_condition == 'Yes' ? 'selected' : '' : '' }}>Yes</option>
                                            <option value="No" {{ isset($cc)?$cc->car_condition == 'No' ? 'selected' : '' : '' }}>No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>


                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
