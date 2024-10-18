@extends('frontend.layouts.user_panel')
@section('panel_content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="row w-100">
                            <div class="col-md-8 col-12">
                                <h1 class="h2 fs-16 mb-0">{{ translate('Car Profile') }}</h1>
                            </div>
                            <div class="col-md-4 col-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-10 col-10 ml-auto">
                                            <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="category_id" name="category_id">
                                                <option value="">{{translate('Search Category')}}</option>
                                                @foreach(\AppModels\Category::all() as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-2">
                                            <button class="btn btn-primary p-2 btn-sm" type="submit">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr class="new-section-sm bord-no">
                        <div class="row">
                            <div class="col-lg-12 table-responsive">
                                <table class="table aiz-table invoice-summary">
                                    <thead>
                                    <tr class="bg-trans-dark">
                                        <th class="min-col">#</th>
                                        <th>{{translate('Photo')}}</th>
                                        <th class="text-uppercase">{{translate('Description')}}</th>
                                        <th class="min-col text-center text-uppercase">{{translate('Qty')}}</th>
                                        <th class="min-col text-center text-uppercase">{{translate('Price')}}</th>
                                        <th class="min-col text-center text-uppercase">{{translate('Total')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($existing_car_lists as $key => $existing_car_list)
                                        <?php
                                        $order = \App\Models\Order::where('id', $existing_car_list->order_id)->first();
                                        ?>
                                        @if($order)
                                        @foreach ($order->orderDetails as $key => $orderDetail)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>
                                                    @if ($orderDetail->product != null)
                                                        <a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank"><img height="50" src="{{ uploaded_asset($orderDetail->product->thumbnail_img) }}"></a>
                                                    @else
                                                        <strong>{{ translate('N/A') }}</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($orderDetail->product != null)
                                                        <strong><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank" class="text-muted">{{ $orderDetail->product->getTranslation('name') }}</a></strong>
                                                        <small>{{ $orderDetail->variation }}</small>
                                                    @else
                                                        <strong>{{ translate('Product Unavailable') }}</strong>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $orderDetail->quantity }}</td>
                                                <td class="text-center">{{ single_price($orderDetail->price/$orderDetail->quantity) }}</td>
                                                <td class="text-center">{{ single_price($orderDetail->price) }}</td>
                                            </tr>
                                        @endforeach
                                        @endif
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

@endsection
