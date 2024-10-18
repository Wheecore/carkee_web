@extends('frontend.layouts.app')

@section('content')

    <section class="pt-4 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-600 h4">{{ translate('Vehicle Details') }}</h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item opacity-50">
                            <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div id="about">
            <div class="container">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card card-r">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Car List Details') }}</h5>
                            </div>
                            <div class="card-body">
                                <table class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            {{--                        <th>{{ translate('Category')}}</th> --}}
                                            <th data-breakpoints="md">{{ translate('Car Plate') }}</th>
                                            <th data-breakpoints="md">{{ translate('Mileage') }}</th>
                                            <th data-breakpoints="md">{{ translate('Chassis Number') }}</th>
                                            <th data-breakpoints="md">{{ translate('Vehicle Size') }}</th>
                                            <th data-breakpoints="md">{{ translate('Insurance') }}</th>
                                            <th>{{ translate('Brand') }}</th>
                                            <th>{{ translate('Model') }}</th>
                                            <th data-breakpoints="md">{{ translate('Details') }}</th>
                                            <th data-breakpoints="md">{{ translate('Year') }}</th>
                                            <th>{{ translate('Varients') }}</th>
                                            <th class="text-right">{{ translate('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $brand = \App\Models\Brand::where('id', $list->brand_id)->first();
                                        $model = \App\CarModel::where('id', $list->model_id)->first();
                                        $details = \App\CarDetail::where('id', $list->details_id)->first();
                                        $year = \App\CarYear::where('id', $list->year_id)->first();
                                        $type = \App\CarType::where('id', $list->type_id)->first();
                                        // $carlist = \App\CarList::where('model_id', $model->id)->first();
                                        ?>
                                        <tr>
                                            <td>{{ $list->car_plate ? $list->car_plate : '--' }}</td>
                                            <td>{{ $list->mileage ? $list->mileage : '--' }}</td>
                                            <td>{{ $list->chassis_number ? $list->chassis_number : '--' }}</td>
                                            <td>{{ $list->vehicle_size ? $list->vehicle_size : '--' }}</td>
                                            <td>{{ $list->insurance ? $list->insurance : '--' }}</td>
                                            <td>{{ $brand ? $brand->name : '--' }}</td>
                                            <td>{{ $model ? $model->name : '--' }}</td>
                                            <td>{{ $details ? $details->name : '--' }}</td>
                                            <td>{{ $year ? $year->name : '--' }}</td>
                                            <td>{{ $type ? $type->name : '--' }}</td>

                                            <td class="text-right">
                                                <a href="{{ route('carlist.edit', $list->id) }}"
                                                    class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                                    title="{{ translate('Edit') }}">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                {{-- <a href="{{route('carlist.orders', $list->id)}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm" title="{{ translate('view') }}"> --}}
                                                {{-- <i class="las la-eye"></i> --}}
                                                {{-- </a> --}}
                                                {{-- <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('carlist.destroy', $list->id)}}" title="{{ translate('Cancel') }}"> --}}
                                                {{-- <i class="las la-trash"></i> --}}
                                                {{-- </a> --}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="aiz-pagination">
                                    {{--                    {{ $lists->links() }} --}}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- <section class="mb-4">
        <div id="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-r">
                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Notifications') }}</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                // $brand = \App\Models\Brand::where('id', $list->brand_id)->first();
                                // $model = \App\CarModel::where('id', $list->model_id)->first();
                                // $details = \App\CarDetail::where('id', $list->details_id)->first();
                                // $year = \App\CarYear::where('id', $list->year_id)->first();
                                // $type = \App\CarType::where('id', $list->type_id)->first();
                                // $carlist = \App\CarList::where('model_id', $model->id)->first();
                                // $monthly_package_reminds = DB::table('package_reminds')->where('monthly_status', 1)->where('package_id', '!=', 0)->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                // $weekly_package_reminds = DB::table('package_reminds')->where('weekly_status', 1)->where('package_id', '!=', 0)->where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                                ?>
                                <div class="row">
                                    <style>
                                        .dropdown-list-image {
                                            position: relative;
                                            height: 2.5rem;
                                            width: 2.5rem;
                                        }

                                        .dropdown-list-image img {
                                            height: 2.5rem;
                                            width: 2.5rem;
                                        }

                                        .btn-light {
                                            color: #2cdd9b;
                                            background-color: #e5f7f0;
                                            border-color: #d8f7eb;
                                        }
                                    </style>
                                    <div class="col-lg-12 right">
                                        <div class="box shadow-sm rounded bg-white mb-3">
                                            <div class="box-body p-0">
                                                <b style="color: #E52E05" class="box-title border-bottom p-3">Package Reminders</b>
                                                @if (count($monthly_package_reminds) > 0)
                                                    @foreach ($monthly_package_reminds as $data)
                                                        <?php
                                                        $package = \App\Package::where('id', $data->package_id)
                                                            ->whereJsonContains('brand_id', json_encode($brand->id))
                                                            ->whereJsonContains('model_id', json_encode($model->id))
                                                            ->whereJsonContains('details_id', $details ? json_encode($details->id) : null)
                                                            ->whereJsonContains('year_id', $year ? json_encode($year->id) : null)
                                                            ->whereJsonContains('type_id', $type ? json_encode($type->id) : null)
                                                            ->first();
                                                        $p_order = \App\Models\Order::where('id', $data->order_id)->first();
                                                        ?>
                                                        @if ($package)
                                                            <div
                                                                class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                                                                <div class="font-weight-bold mr-3">
                                                                    <b class="">Your <span
                                                                            style="color: #E62E04">"{{ $package->name }}"</span>
                                                                        for <span
                                                                            style="color: #E62E04">"{{ isset($model) ? $model->name : '' }}"</span>
                                                                        will be expired at {{ $data->monthly_date }}</b>



                                                                </div>
                                                                <span class="ml-auto">
                                                                    <div class="btn-group">
                                                                        <a href="{{ url('package/remind/' . $package->id . '/' . $p_order->user_id) }}"
                                                                            class="btn-sm btn-primary mt-2"
                                                                            type="submit">Buy Again</a>

                                                                    </div>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if (count($weekly_package_reminds) > 0)
                                                    @foreach ($weekly_package_reminds as $data)
                                                        <?php
                                                        $package = \App\Package::where('id', $data->package_id)
                                                            ->whereJsonContains('brand_id', json_encode($brand->id))
                                                            ->whereJsonContains('model_id', json_encode($model->id))
                                                            ->whereJsonContains('details_id', $details ? json_encode($details->id) : null)
                                                            ->whereJsonContains('year_id', $year ? json_encode($year->id) : null)
                                                            ->whereJsonContains('type_id', $type ? json_encode($type->id) : null)
                                                            ->first();
                                                        $pw_order = \App\Models\Order::where('id', $data->order_id)->first();
                                                        ?>
                                                        @if ($package)
                                                            <div
                                                                class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                                                                <div class="font-weight-bold mr-3">
                                                                    <b class="">Your <span
                                                                            style="color: #E62E04">"{{ $package->name }}"</span>
                                                                        for <span
                                                                            style="color: #E62E04">"{{ isset($model) ? $model->name : '' }}"</span>
                                                                        will be expired at {{ $data->weekly_date }}</b>


                                                                </div>
                                                                <span class="ml-auto">
                                                                    <div class="btn-group">
                                                                        <a href="{{ url('package/remind/weekly/' . $package->id . '/' . $p_order->user_id) }}"
                                                                            class="btn-sm btn-primary mt-2"
                                                                            type="submit">Buy Again</a>

                                                                    </div>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    @if (isset($order->id))
        <?php
        $order_details = \App\Models\OrderDetail::where('order_id', $order->id)
            // ->where('warranty_status', 1)
            ->get();
        ?>
        @if (count($order_details) > 0)
            <section>
                <div class="container mb-3">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">{{ translate('Your Warranty is going to Expired') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($order_details as $detail)
                                            <?php
                                            $product = \App\Product::where('id', $detail->product_id)->first();
                                            ?>
                                            <div class="col-lg-3 col-md-3 col-sm-4">
                                                <div
                                                    class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
                                                    <div class="position-relative">
                                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                            <img class="lazyload mx-auto h-100px h-md-100px"
                                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                alt="{{ $product->getTranslation('name') }}"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                        </a>

                                                    </div>
                                                    <div class="p-md-3 p-2 text-left">
                                                        <div class="fs-15">
                                                            @if (home_base_price($product) != home_discounted_base_price($product))
                                                                <del
                                                                    class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
                                                            @endif
                                                            <span
                                                                class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
                                                        </div>
                                                        <div class="rating rating-sm mt-1">
                                                        </div>
                                                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                            <a href="{{ route('product', $product->slug) }}"
                                                                class="d-block text-reset"
                                                                style="font-size: 14px !important;">{{ $product->getTranslation('name') }}</a>
                                                        </h3>

                                                    </div>
                                                </div>


                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if ($order)
        @if ($order->done_installation_status == 1 || $order->done_installation_status == 2)
        @else
            <section>

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">
                                        {{ translate('Please leave a feedback for this vehicle, not yet you rated!') }}
                                    </h5>
                                </div>
                                <div class="card-body">


                                    <a href=" {{ url('order-review', $order->id) }}" class="btn btn-success"
                                        title="{{ translate('Order Details') }}">
                                        Rate it
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if ($order)
        @if ($order->user_date_update == 1)
            <section>

                <div class="container mb-3">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0 h6">
                                        {{ translate(' You have updated this order to this time and date for this vehicle!') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div>

                                        <b>
                                            <label for="">Order Code</label>
                                            <a href="{{ url('order-user-notify-carlist', $order->id) }}">
                                                {{ $order->code }}</a>
                                        </b>
                                        <br>
                                        <span style="font-weight: 700; font-size: 17px">Workshop Date: &nbsp</span><span
                                            style="font-weight: 600;">{{ $order->workshop_date }}</span>
                                    </div>
                                    <div>
                                        <span style="font-weight: 700; font-size: 17px">Workshop Time: &nbsp</span><span
                                            style="font-weight: 600;">{{ $order->workshop_time }}</span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif

    @if ($order)
        @if ($order->reassign_status == 1)
            <section>
                <div class="container mb-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-header">
                                    <h5 class="mb-0 h6">
                                        {{ translate('Workshop Updated date for this vehicle please Reassign shop!') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <span style="font-weight: 600;">
                                            <form action="{{ route('checkout.reschedule') }}" method="get">
                                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                                <button class="btn-sm btn-primary mt-2" type="submit">Reassign
                                                    Shop</button>
                                            </form>
                                        </span>
                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    {{-- //car profile section --}}
    <section>

        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0 h6">{{ translate('Car Profile') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="row gutters-5">

                                    <div class="col-md-2 ml-auto">
                                        <label for=delivery_type"">{{ translate('Search Category') }}</label>
                                        <select class="form-control aiz-selectpicker"
                                            data-minimum-results-for-search="Infinity" id="category_id"
                                            name="category_id">
                                            <option value="">{{ translate('Select') }}</option>
                                            @foreach (\App\Models\Category::all() as $category)
                                                @if ($category->id == 1 || $category->id == 3)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>


                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-primary" type="submit"
                                            style="margin-top: 27px !important;">Filter</button>
                                    </div>
                                    {{-- <div class="col-md-2 ml-auto"> --}}
                                    {{-- <label for=update_payment_status"">{{translate('Payment Status')}}</label> --}}
                                    {{-- <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_payment_status"> --}}
                                    {{-- <option value="paid" @if ($payment_status == 'paid') selected @endif>{{translate('Paid')}}</option> --}}
                                    {{-- <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>{{translate('Unpaid')}}</option> --}}
                                    {{-- </select> --}}
                                    {{-- </div> --}}
                                    {{-- <div class="col-md-3 ml-auto"> --}}
                                    {{-- <label for=update_delivery_status"">{{translate('Delivery Status')}}</label> --}}
                                    {{-- @if ($delivery_status != 'delivered' && $delivery_status != 'cancelled') --}}
                                    {{-- <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_status"> --}}
                                    {{-- <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option> --}}
                                    {{-- <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option> --}}
                                    {{-- <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>{{translate('Picked Up')}}</option> --}}
                                    {{-- <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>{{translate('On The Way')}}</option> --}}
                                    {{-- <!--<option value="on_delivery" @if ($delivery_status == 'on_delivery') selected @endif>{{translate('On delivery')}}</option>--> --}}
                                    {{-- <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>{{translate('Delivered')}}</option> --}}
                                    {{-- <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>{{translate('Cancel')}}</option> --}}
                                    {{-- </select> --}}
                                    {{-- @else --}}
                                    {{-- <input type="text" class="form-control" value="{{ $delivery_status }}"> --}}
                                    {{-- @endif --}}
                                    {{-- </div> --}}
                                </div>
                            </form>
                            <hr class="new-section-sm bord-no">
                            <div class="row">
                                <div class="col-lg-12 table-responsive">
                                    <table class="table table-bordered aiz-table invoice-summary">
                                        <thead>
                                            <tr class="bg-trans-dark">
                                                <th data-breakpoints="lg" class="min-col">#</th>
                                                <th width="10%">{{ translate('Photo') }}</th>
                                                <th class="text-uppercase">{{ translate('Description') }}</th>
                                                <th data-breakpoints="lg" class="text-uppercase">
                                                    {{ translate('Delivery Type') }}</th>
                                                <th data-breakpoints="lg" class="min-col text-center text-uppercase">
                                                    {{ translate('Qty') }}</th>
                                                <th data-breakpoints="lg" class="min-col text-center text-uppercase">
                                                    {{ translate('Price') }}</th>
                                                <th data-breakpoints="lg" class="min-col text-center text-uppercase">
                                                    {{ translate('Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($existing_car_lists as $key => $existing_car_list)
                                                <?php
                                                $order = \App\Order::where('id', $existing_car_list->order_id)->first();
                                                ?>
                                                @foreach ($order->orderDetails as $key => $orderDetail)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>
                                                            @if ($orderDetail->product != null)
                                                                <a href="{{ route('product', $orderDetail->product->slug) }}"
                                                                    target="_blank"><img height="50"
                                                                        src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                                                            @else
                                                                <strong>{{ translate('N/A') }}</strong>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($orderDetail->product != null)
                                                                <strong><a
                                                                        href="{{ route('product', $orderDetail->product->slug) }}"
                                                                        target="_blank"
                                                                        class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                                <small>{{ $orderDetail->variation }}</small>
                                                            @else
                                                                <strong>{{ translate('Product Unavailable') }}</strong>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($orderDetail->shipping_type != null && $orderDetail->shipping_type == 'home_delivery')
                                                                {{ translate('Home Delivery') }}
                                                            @elseif ($orderDetail->shipping_type == 'pickup_point')
                                                                @if ($orderDetail->pickup_point != null)
                                                                    {{ $orderDetail->pickup_point->getTranslation('name') }}
                                                                    ({{ translate('Pickup Point') }})
                                                                @else
                                                                    {{ translate('Pickup Point') }}
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{ $orderDetail->quantity }}</td>
                                                        <td class="text-center">
                                                            {{ single_price($orderDetail->price / $orderDetail->quantity) }}
                                                        </td>
                                                        <td class="text-center">{{ single_price($orderDetail->price) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (count($orders) > 0)
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="mb-0 h6">{{ translate('Customer Car Condition Alert List Details') }}</h5>
                            </div>

                            @foreach ($orders as $key => $order)
                                <?php
                                $condition = DB::table('user_car_conditions')
                                    ->where('order_id', $order->id)
                                    ->first();
                                ?>
                                @if ($condition)
                                    @if ($key == 0)
                                        <h5 class="mb-0 h6 p-3 ml-2">First Latest Car Condition List</h5>
                                    @else
                                        <h5 class="mb-0 h6 p-3 ml-2">Second Latest Car Condition List</h5>
                                    @endif

                                    <div class="card">

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    {{-- <form action="" method="get" id="sort_reds" style="width: 326px;"> --}}
                                                    {{-- <select id="sort_by_red" name="sort_by_red" class="form-control" onchange="sort_reds()"> --}}
                                                    {{-- <option value="">Filter By</option> --}}
                                                    {{-- <option value="">All</option> --}}
                                                    {{-- <option value="Red">Red</option> --}}
                                                    {{-- <option value="Yellow">Yellow</option> --}}
                                                    {{-- </select> --}}
                                                    {{-- </form> --}}
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="row">
                                                        <div class="col-6 mt-2"><strong>Customer: </strong> </div>
                                                        <div class="col-6 mt-2">{{ $condition->customer }}</div>
                                                        <div class="col-6 mt-2"><strong>Contact Number: </strong> </div>
                                                        <div class="col-6 mt-2">{{ $condition->contact_number }}</div>
                                                        <div class="col-6 mt-2"><strong>Model: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->model }}</div>
                                                        <div class="col-6 mt-2"><strong>Number Plate: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->number_plate }}</div>
                                                        <div class="col-6 mt-2"><strong>Mileage: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->mileage }}</div>
                                                        <div class="col-6 mt-2"><strong>Vin: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->vin }}</div>
                                                        <div class="col-6 mt-2"><strong>Service Adviser: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->service_advisor }}</div>
                                                        <div class="col-6 mt-2"><strong>Techician: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->techician }}</div>
                                                        <div class="col-6 mt-2"><strong>Car Condition Date: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->car_condition_date }}</div>
                                                        <div class="col-6 mt-2"><strong>Car Condition Time: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->car_condition_time }}</div>


                                                        <div class="col-6 mt-2"><strong>Front End Body : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->front_end_body ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Rear End Body : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->rear_end_body ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Driver Side Body : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->driver_side_body ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Pass Side Body : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->pass_side_body ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Roof : </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->roof ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Wind Shield : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->windshield ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Window / Glass : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->window_glass ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Wheels / Rim : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->wheels_rim ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Fuel Tank Cover : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->fuel_tank_cover ? 'ok' : 'not ok' }}</div>
                                                        <div class="col-6 mt-2"><strong>Wing Mirror : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->wing_cover ? 'ok' : 'not ok' }}</div>
                                                        <hr>

                                                        <h5 style="font-weight: 700">GUIDE FOR INTERIOR / EXTERIOR, UNDER
                                                            HOOD, UNDER VEHICLE, BRAKE CONDITION </h5>

                                                        <div class="row">
                                                            <div class="col-3">
                                                                <div
                                                                    style="height:30px;width: 30px;background:green;border:1px solid blue">
                                                                </div><b>CHECKED AND OK AT THIS TIME</b>
                                                            </div>
                                                            <div class="col-3">
                                                                <div
                                                                    style="height:30px;width: 30px;background:yellow;border:1px solid blue">
                                                                </div><b>MAY NEED FUTURE ATTENTION</b>
                                                            </div>
                                                            <div class="col-3">
                                                                <div
                                                                    style="height:30px;width: 30px;background:red;border:1px solid blue">
                                                                </div><b>REQUIRES IMMEDIATE ATTENTION</b>
                                                            </div>
                                                            <div class="col-3">
                                                                <div
                                                                    style="height:30px;width: 30px;background:white;border:1px solid blue">
                                                                </div><b>NOT INSPECTED</b>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-2">
                                                            <h5>INTERIOR / EXTERIOR</h5>
                                                        </div>
                                                        @if ($condition->horn_operation == 'Red' || $condition->horn_operation == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Horn Operation : </strong>
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->horn_operation }}; height:30px; width:30px">
                                                                </div>

                                                            </div>
                                                        @endif

                                                        @if ($condition->headlights == 'Red' || $condition->headlights == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Headlights / Turn Signals /
                                                                    High Beams / Fog Lights : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->headlights }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($condition->front_wiper_blades == 'Red' || $condition->front_wiper_blades == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Front Wiper Blades : </strong>
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->front_wiper_blades }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->rear_wiper_blade == 'Red' || $condition->rear_wiper_blade == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Rear Wiper Blade : </strong>
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->rear_wiper_blade }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->tail_lights == 'Red' || $condition->tail_lights == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Tail Lights / Brake Lights /
                                                                    Turn Signals / Reverse Lights : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->tail_lights }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->in_cabin == 'Red' || $condition->in_cabin == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>In-cabin Icrofilter / Interior
                                                                    Lights : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->in_cabin }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->system_check_lights == 'Red' || $condition->system_check_lights == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>System Check Lights / Faulty
                                                                    Massages : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->system_check_lights }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-6 mt-2"><strong> Comment: </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->interior_comment }}</div>




                                                        <div class="col-12 mt-2">
                                                            <h5> UNDER HOOD</h5>
                                                        </div>
                                                        @if ($condition->engine_oil == 'Red' || $condition->engine_oil == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Engine Oil : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->engine_oil }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->coolant == 'Red' || $condition->coolant == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Coolant : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->coolant }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->power == 'Red' || $condition->power == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Power Steering Fluid :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->power }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->brake_fluid == 'Red' || $condition->brake_fluid == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Brake Fluid : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->brake_fluid }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->windscreen == 'Red' || $condition->windscreen == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Windscreen Washer Fluid :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->windscreen }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->automatic == 'Red' || $condition->automatic == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Automatic Transmission Fluid :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->automatic }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->cooling_system == 'Red' || $condition->cooling_system == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Cooling System Hoses / Parts :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->cooling_system }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->radiator_case == 'Red' || $condition->radiator_case == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Radiator Case / Core / Cap :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->radiator_case }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->engine_air == 'Red' || $condition->engine_air == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Engine Air Filter : </strong>
                                                            </div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->engine_air }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->driver_belt == 'Red' || $condition->driver_belt == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Drive Belts : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->driver_belt }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->under_hood_comment }}
                                                        </div>


                                                        <div class="col-12 mt-2">
                                                            <h5> UNDER VEHICLE</h5>
                                                        </div>

                                                        @if ($condition->front_shocks == 'Red' || $condition->front_shocks == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Front Shocks / Suspension /
                                                                    Stabalizer / Bushes : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->front_shocks }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->drivershaft == 'Red' || $condition->drivershaft == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Driveshaft / Cv Boots :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->drivershaft }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->subframe == 'Red' || $condition->subframe == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Subframe / Steering System /
                                                                    Tie Rods : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->subframe }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->fluid_leaks == 'Red' || $condition->fluid_leaks == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Fluid Leaks (oil / Transmission
                                                                    / Coolant) : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->fluid_leaks }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->brake_hose == 'Red' || $condition->brake_hose == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Brake Hose / Linings / Cables :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->brake_hose }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->real_shocks == 'Red' || $condition->real_shocks == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Rear Shocks / Suspension /
                                                                    Stabalizer / Bushes : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->real_shocks }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->differential == 'Red' || $condition->differential == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Differential / Axle (check
                                                                    Condition & Leaks) : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->differential }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->exhuast == 'Red' || $condition->exhuast == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Exhuast / Muffler / Mountings :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->exhuast }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->wheel_bearing == 'Red' || $condition->wheel_bearing == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Wheel Bearings / Sensors /
                                                                    Harness : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->wheel_bearing }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->under_vehicle_comment }}
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="row">

                                                        <div class="col-12 mt-2">
                                                            <h5> All Images</h5>
                                                        </div>
                                                        @php
                                                            $photos = explode(',', $condition->photos);
                                                        @endphp
                                                        @foreach ($photos as $key => $photo)
                                                            <div class="col-12 mt-2">
                                                                <img style="height:300px; width: 100%;margin-left: -16px;"
                                                                    class="" src="{{ uploaded_asset($photo) }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                            </div>
                                                        @endforeach




                                                        @if ($condition->battery_terminals == 'Red' || $condition->battery_terminals == 'Yellow')
                                                            <div class="row">
                                                                <div class="col-12 mt-2">
                                                                    <h5> BATTERY PERFORMANCE </h5>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div
                                                                        style="height:30px;width: 30px;background:green;border:1px solid blue">
                                                                    </div><b>PASS</b>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div
                                                                        style="height:30px;width: 30px;background:yellow;border:1px solid blue">
                                                                    </div><b>RECHARGE</b>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div
                                                                        style="height:30px;width: 30px;background:red;border:1px solid blue">
                                                                    </div><b>FAIL</b>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div
                                                                        style="height:30px;width: 30px;background:white;border:1px solid blue">
                                                                    </div><b>NOT INSPECTED</b>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 mt-2"><strong>Battery Terminals / Cables /
                                                                    Mounting : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->battery_terminals }}; height:30px; width:30px">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-6 mt-2"><strong>Battery Capacity Test : </strong>
                                                        </div>
                                                        <div class="col-6 mt-2">{{ $condition->battery_capacity_test }}
                                                        </div>

                                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->battery_performance_comment }}</div>


                                                        <div class="row">
                                                            <div class="col-12 mt-2">
                                                                <h5> TYRES </h5>
                                                            </div>
                                                            <div class="col-6">
                                                                <div
                                                                    style="height:30px;width: 30px;background:green;border:1px solid blue">
                                                                </div><b>8-6 MM</b>
                                                            </div>
                                                            <div class="col-6">
                                                                <div
                                                                    style="height:30px;width: 30px;background:yellow;border:1px solid blue">
                                                                </div><b>5-3 MM</b>
                                                            </div>
                                                            <div class="col-6">
                                                                <div
                                                                    style="height:30px;width: 30px;background:red;border:1px solid blue">
                                                                </div><b>2MM or LESS</b>
                                                            </div>
                                                            <div class="col-6">
                                                                <div
                                                                    style="height:30px;width: 30px;background:white;border:1px solid blue">
                                                                </div><b>NOT INSPECTED</b>
                                                            </div>
                                                        </div>
                                                        @if ($condition->tyre_left_front == 'Red' || $condition->tyre_left_front == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Left Front : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->tyre_left_front }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->tyre_right_front == 'Red' || $condition->tyre_right_front == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Right Front : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->tyre_right_front }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->tyre_left_rear == 'Red' || $condition->tyre_left_rear == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Left Rear : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->tyre_left_rear }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->tyre_right_rear == 'Red' || $condition->tyre_right_rear == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Right Rear : </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->tyre_right_rear }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                                        <div class="col-6 mt-2">
                                                            {{ $condition->tyre_comment }}</div>

                                                        <div class="col-12 mt-2">
                                                            <h5> BRAKE CONDITION </h5>
                                                        </div>

                                                        @if ($condition->front_left_brake == 'Red' || $condition->front_left_brake == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Front Left Brake Pads :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->front_left_brake }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->right_left_brake == 'Red' || $condition->right_left_brake == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Rear Left Brake Pads :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->right_left_brake }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->front_brake_disc == 'Red' || $condition->front_brake_disc == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Front Brake Disc Rotors :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->front_brake_disc }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->front_right_brake == 'Red' || $condition->front_right_brake == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Front Right Brake Pads :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->front_right_brake }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->rear_right_brake_pads == 'Red' || $condition->rear_right_brake_pads == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Rear Right Brake Pads :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->rear_right_brake_pads }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->rear_brake_disc == 'Red' || $condition->rear_brake_disc == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Rear Brake Disc Rotors :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->rear_brake_disc }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->rear_right_brake_shoes == 'Red' || $condition->rear_right_brake_shoes == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Rear Right Brake Shoes :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->rear_right_brake_shoes }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if ($condition->rear_right_brake_cylinders == 'Red' || $condition->rear_right_brake_cylinders == 'Yellow')
                                                            <div class="col-6 mt-2"><strong>Rear Right Brake Cylinders :
                                                                </strong></div>
                                                            <div class="col-6 mt-2">
                                                                <div
                                                                    style="background: {{ $condition->rear_right_brake_cylinders }}; height:30px; width:30px;border:1px solid blue">
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-6 mt-2"><strong>Comment : </strong></div>
                                                        <div class="col-6 mt-2">{{ $condition->brake_condition_comment }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </section>
    @endif


@endsection
